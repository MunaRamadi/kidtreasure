<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class StoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        try {
            Log::info('Accessing stories admin dashboard', ['user_id' => auth()->id()]);
            
            $query = Story::query();
            $query->with(['user', 'reviewer']);
            
            // تصنيف القصص حسب النوع
            $storyType = $request->get('type', 'all'); // all, featured, user_submitted
            
            if ($storyType === 'featured') {
                $query->where('is_featured', true);
            } elseif ($storyType === 'user_submitted') {
                $query->where(function($q) {
                    $q->where('is_featured', false)->orWhereNull('is_featured');
                });
            }
            
            // البحث المتقدم
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('child_name', 'like', "%{$search}%")
                      ->orWhere('parent_name', 'like', "%{$search}%")
                      ->orWhere('title_ar', 'like', "%{$search}%")
                      ->orWhere('title_en', 'like', "%{$search}%")
                      ->orWhere('content_ar', 'like', "%{$search}%")
                      ->orWhere('content_en', 'like', "%{$search}%");
                });
            }

            // التصفية حسب الحالة
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // التصفية حسب التاريخ
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // ترتيب النتائج
            $sortBy = $request->get('sort', 'newest');
            switch ($sortBy) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'name':
                    $query->orderBy('child_name', 'asc');
                    break;
                case 'pending_first':
                    $query->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
                          ->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
            
            $stories = $query->paginate(12)->withQueryString();
            
            // إحصائيات مفصلة
            $stats = [
                'total' => Story::count(),
                'pending' => Story::where('status', 'pending')->count(),
                'approved' => Story::where('status', 'approved')->count(),
                'rejected' => Story::where('status', 'rejected')->count(),
                'featured' => Story::where('is_featured', true)->count(),
                'user_submitted' => Story::where(function($q) {
                    $q->where('is_featured', false)->orWhereNull('is_featured');
                })->count(),
                'today' => Story::whereDate('created_at', today())->count(),
                'this_week' => Story::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            ];

            return view('admin.stories.index', compact('stories', 'stats', 'storyType', 'sortBy'));
            
        } catch (\Exception $e) {
            Log::error('Error in stories admin dashboard', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            // إنشاء paginator فارغ في حالة الخطأ
            $stories = new LengthAwarePaginator(
                collect(),
                0,
                12,
                1,
                [
                    'path' => $request->url(),
                    'pageName' => 'page',
                ]
            );
            
            $stats = [
                'total' => 0, 'pending' => 0, 'approved' => 0, 'rejected' => 0,
                'featured' => 0, 'user_submitted' => 0, 'today' => 0, 'this_week' => 0
            ];
            
            $storyType = $request->get('type', 'all');
            $sortBy = $request->get('sort', 'newest');
            
            return view('admin.stories.index', compact('stories', 'stats', 'storyType', 'sortBy'))
                ->with('error', 'حدث خطأ في تحميل لوحة إدارة القصص: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.stories.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'child_name' => 'required|string|max:255',
            'child_age' => 'required|integer|min:1|max:18',
            'parent_name' => 'required|string|max:255',
            'parent_contact' => 'nullable|string|max:255',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'content_ar' => 'required|string',
            'content_en' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
            'is_featured' => 'boolean',
            'display_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mov,wmv|max:10240',
        ]);

        $data = $request->only([
            'child_name', 'child_age', 'parent_name', 
            'parent_contact', 'title_ar', 'title_en', 'content_ar', 
            'content_en', 'status'
        ]);

        $data['user_id'] = $request->user_id ?? auth()->id();
        $data['submission_date'] = now();
        $data['is_featured'] = $request->boolean('is_featured', false);
        $data['display_order'] = $request->display_order ?? 0;

        // إذا كانت قصة مميزة، تأكد من أنها معتمدة
        if ($data['is_featured']) {
            $data['status'] = 'approved';
            $data['reviewed_at'] = now();
            $data['reviewed_by'] = auth()->id();
        }

        // رفع الصورة مع تخزين المسار فقط (بدون URL كامل)
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('stories/images', 'public');
            $data['image_url'] = $imagePath; // نحفظ المسار فقط
        }

        // رفع الفيديو مع تخزين المسار فقط (بدون URL كامل)
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('stories/videos', 'public');
            $data['video_url'] = $videoPath; // نحفظ المسار فقط
        }

        $story = Story::create($data);
        
        Log::info('Story created by admin', [
            'story_id' => $story->id, 
            'admin_id' => auth()->id(),
            'is_featured' => $data['is_featured']
        ]);

        $message = $data['is_featured'] ? 'تم إضافة القصة المميزة بنجاح' : 'تم إضافة القصة بنجاح';
        
        return redirect()->route('admin.stories.index')
            ->with('success', $message);
    }

    public function show(Story $story)
    {
        $story->load('user', 'reviewer');
        
        // تسجيل عرض القصة للمراجعة
        if ($story->status === 'pending') {
            Log::info('Admin viewing pending story', [
                'story_id' => $story->id,
                'admin_id' => auth()->id()
            ]);
        }
        
        return view('admin.stories.show', compact('story'));
    }

    public function edit(Story $story)
    {
        $users = User::orderBy('name')->get();
        return view('admin.stories.edit', compact('story', 'users'));
    }

    public function update(Request $request, Story $story)
    {
        $request->validate([
            'child_name' => 'required|string|max:255',
            'child_age' => 'required|integer|min:1|max:18',
            'parent_name' => 'required|string|max:255',
            'parent_contact' => 'nullable|string|max:255',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'content_ar' => 'required|string',
            'content_en' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string',
            'is_featured' => 'boolean',
            'display_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mov,wmv|max:10240',
        ]);

        $data = $request->only([
            'child_name', 'child_age', 'parent_name', 
            'parent_contact', 'title_ar', 'title_en', 'content_ar', 
            'content_en', 'status', 'admin_notes'
        ]);

        $data['is_featured'] = $request->boolean('is_featured', false);
        $data['display_order'] = $request->display_order ?? $story->display_order ?? 0;

        // تحديث معلومات المراجعة إذا تم تغيير الحالة
        if ($story->status !== $request->status) {
            $data['reviewed_at'] = now();
            $data['reviewed_by'] = auth()->id();
        }

        // إذا تم تحويلها لقصة مميزة، تأكد من أنها معتمدة
        if ($data['is_featured'] && $story->status !== 'approved') {
            $data['status'] = 'approved';
            $data['reviewed_at'] = now();
            $data['reviewed_by'] = auth()->id();
        }

        // رفع الصورة الجديدة
        if ($request->hasFile('image')) {
            if ($story->image_url) {
                Storage::disk('public')->delete($story->image_url);
            }
            $imagePath = $request->file('image')->store('stories/images', 'public');
            $data['image_url'] = $imagePath; // نحفظ المسار فقط
        }

        // رفع الفيديو الجديد
        if ($request->hasFile('video')) {
            if ($story->video_url) {
                Storage::disk('public')->delete($story->video_url);
            }
            $videoPath = $request->file('video')->store('stories/videos', 'public');
            $data['video_url'] = $videoPath; // نحفظ المسار فقط
        }

        $story->update($data);
        
        Log::info('Story updated by admin', [
            'story_id' => $story->id, 
            'admin_id' => auth()->id(),
            'old_status' => $story->getOriginal('status'),
            'new_status' => $request->status,
            'is_featured' => $data['is_featured']
        ]);

        return redirect()->route('admin.stories.index')
            ->with('success', 'تم تحديث القصة بنجاح');
    }

    public function destroy(Story $story)
    {
        // حذف الملفات المرفقة
        if ($story->image_url) {
            Storage::disk('public')->delete($story->image_url);
        }
        
        if ($story->video_url) {
            Storage::disk('public')->delete($story->video_url);
        }

        $storyId = $story->id;
        $isFeatured = $story->is_featured;
        $story->delete();
        
        Log::info('Story deleted by admin', [
            'story_id' => $storyId, 
            'admin_id' => auth()->id(),
            'was_featured' => $isFeatured
        ]);

        $message = $isFeatured ? 'تم حذف القصة المميزة بنجاح' : 'تم حذف القصة بنجاح';
        
        return redirect()->route('admin.stories.index')
            ->with('success', $message);
    }

    // عمليات متعددة للقصص
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete,feature,unfeature',
            'story_ids' => 'required|array',
            'story_ids.*' => 'exists:stories,id'
        ]);

        $storyIds = $request->story_ids;
        $action = $request->action;

        switch ($action) {
            case 'approve':
                Story::whereIn('id', $storyIds)->update([
                    'status' => 'approved',
                    'reviewed_at' => now(),
                    'reviewed_by' => auth()->id()
                ]);
                Log::info('Bulk approve stories', ['story_ids' => $storyIds, 'admin_id' => auth()->id()]);
                return back()->with('success', 'تم اعتماد القصص المحددة بنجاح');

            case 'reject':
                Story::whereIn('id', $storyIds)->update([
                    'status' => 'rejected',
                    'reviewed_at' => now(),
                    'reviewed_by' => auth()->id()
                ]);
                Log::info('Bulk reject stories', ['story_ids' => $storyIds, 'admin_id' => auth()->id()]);
                return back()->with('success', 'تم رفض القصص المحددة بنجاح');

            case 'feature':
                Story::whereIn('id', $storyIds)->update([
                    'is_featured' => true,
                    'status' => 'approved', // القصص المميزة يجب أن تكون معتمدة
                    'reviewed_at' => now(),
                    'reviewed_by' => auth()->id()
                ]);
                Log::info('Bulk feature stories', ['story_ids' => $storyIds, 'admin_id' => auth()->id()]);
                return back()->with('success', 'تم تمييز القصص المحددة بنجاح');

            case 'unfeature':
                Story::whereIn('id', $storyIds)->update(['is_featured' => false]);
                Log::info('Bulk unfeature stories', ['story_ids' => $storyIds, 'admin_id' => auth()->id()]);
                return back()->with('success', 'تم إلغاء تمييز القصص المحددة بنجاح');

            case 'delete':
                $stories = Story::whereIn('id', $storyIds)->get();
                foreach ($stories as $story) {
                    if ($story->image_url) {
                        Storage::disk('public')->delete($story->image_url);
                    }
                    if ($story->video_url) {
                        Storage::disk('public')->delete($story->video_url);
                    }
                }
                Story::whereIn('id', $storyIds)->delete();
                Log::info('Bulk delete stories', ['story_ids' => $storyIds, 'admin_id' => auth()->id()]);
                return back()->with('success', 'تم حذف القصص المحددة بنجاح');
        }
        
    }

    // مراجعة سريعة للقصة
    public function quickReview(Request $request, Story $story)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $story->update([
            'status' => $request->action === 'approve' ? 'approved' : 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
            'admin_notes' => $request->admin_notes
        ]);

        Log::info('Quick story review', [
            'story_id' => $story->id,
            'action' => $request->action,
            'admin_id' => auth()->id()
        ]);

        $message = $request->action === 'approve' ? 'تم اعتماد القصة بنجاح' : 'تم رفض القصة';
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'new_status' => $story->status_label
        ]);
    }

    // تحديث حالة القصة منفرداً
    public function updateStatus(Request $request, Story $story)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $story->update([
            'status' => $request->status,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
            'admin_notes' => $request->admin_notes
        ]);

        Log::info('Story status updated', [
            'story_id' => $story->id,
            'new_status' => $request->status,
            'admin_id' => auth()->id()
        ]);

        return back()->with('success', 'تم تحديث حالة القصة بنجاح');
    }

    // إحصائيات مفصلة
    public function analytics()
    {
        $analytics = [
            'stories_by_status' => Story::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray(),
            
            'stories_by_month' => Story::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                ->where('created_at', '>=', now()->subMonths(12))
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get()
                ->map(function($item) {
                    return [
                        'date' => $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT),
                        'count' => $item->count
                    ];
                }),
            
            'pending_stories' => Story::where('status', 'pending')
                ->with('user')
                ->orderBy('created_at', 'asc')
                ->limit(5)
                ->get(),
            
            'featured_stories_count' => Story::where('is_featured', true)->count(),
            'user_submissions_count' => Story::where(function($q) {
                $q->where('is_featured', false)->orWhereNull('is_featured');
            })->count(),
        ];

        return view('admin.stories.analytics', compact('analytics'));
    }

    // تصدير القصص مع خيارات متقدمة
    public function export(Request $request)
    {
        $query = Story::with('user', 'reviewer');

        // تطبيق الفلاتر
        if ($request->filled('type')) {
            if ($request->type === 'featured') {
                $query->where('is_featured', true);
            } elseif ($request->type === 'user_submitted') {
                $query->where(function($q) {
                    $q->where('is_featured', false)->orWhereNull('is_featured');
                });
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('child_name', 'like', "%{$search}%")
                  ->orWhere('parent_name', 'like', "%{$search}%")
                  ->orWhere('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $stories = $query->orderBy('created_at', 'desc')->get();

        $filename = 'stories_export_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($stories) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            
            // Headers
            fputcsv($file, [
                'ID', 'اسم الطفل', 'عمر الطفل', 'اسم الوالد', 'معلومات التواصل',
                'العنوان بالعربية', 'العنوان بالإنجليزية', 'محتوى القصة', 'الحالة',
                'نوع القصة', 'ترتيب العرض', 'تاريخ الإنشاء', 'تاريخ المراجعة', 
                'المراجع', 'ملاحظات الإدارة'
            ]);

            // Data
            foreach ($stories as $story) {
                fputcsv($file, [
                    $story->id,
                    $story->child_name ?? '',
                    $story->child_age ?? '',
                    $story->parent_name ?? '',
                    $story->parent_contact ?? '',
                    $story->title_ar ?? '',
                    $story->title_en ?? '',
                    strip_tags($story->content_ar ?? ''),
                    $story->status_label ?? '',
                    $story->is_featured ? 'قصة مميزة' : 'مرسلة من مستخدم',
                    $story->display_order ?? 0,
                    $story->created_at ? $story->created_at->format('Y-m-d H:i:s') : '',
                    $story->reviewed_at ? $story->reviewed_at->format('Y-m-d H:i:s') : '',
                    $story->reviewer ? $story->reviewer->name : '',
                    $story->admin_notes ?? ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // دالة لإنشاء قصة تجريبية (للتطوير فقط)
    public function createTestStory()
    {
        if (!app()->environment('local')) {
            abort(404);
        }

        $story = Story::create([
            'user_id' => auth()->id(),
            'child_name' => 'أحمد محمد',
            'child_age' => 8,
            'parent_name' => 'محمد أحمد',
            'parent_contact' => 'test@example.com',
            'title_ar' => 'قصة تجريبية للاختبار',
            'title_en' => 'Test Story for Development',
            'content_ar' => 'هذه قصة تجريبية تم إنشاؤها لأغراض الاختبار والتطوير.',
            'content_en' => 'This is a test story created for testing and development purposes.',
            'submission_date' => now(),
            'status' => 'pending',
            'is_featured' => false,
            'display_order' => 0,
        ]);

        Log::info('Test story created', ['story_id' => $story->id, 'admin_id' => auth()->id()]);

        return redirect()->route('admin.stories.index')
            ->with('success', 'تم إنشاء قصة تجريبية بنجاح - ID: ' . $story->id);
    }
}