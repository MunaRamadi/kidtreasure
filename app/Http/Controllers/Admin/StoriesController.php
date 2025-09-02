<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class StoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * عرض جميع القصص في لوحة الإدارة
     */
    public function index(Request $request)
    {
        $query = Story::with(['user', 'reviewer']);

        // فلترة حسب الحالة
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // فلترة حسب القصص المميزة
        if ($request->has('featured') && $request->featured !== '') {
            $query->where('is_featured', $request->featured == '1');
        }

        // البحث
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('child_name', 'like', "%{$search}%")
                  ->orWhere('content_ar', 'like', "%{$search}%")
                  ->orWhere('content_en', 'like', "%{$search}%");
            });
        }

        $stories = $query->orderBy('created_at', 'desc')->paginate(15);

        // إحصائيات سريعة
        $stats = [
            'total' => Story::count(),
            'pending' => Story::pending()->count(),
            'approved' => Story::approved()->count(),
            'rejected' => Story::rejected()->count(),
            'featured' => Story::featured()->count(),
        ];
        
        // Check if we need to highlight a specific story
        $highlightId = $request->query('highlight');
        
        // If we have a highlight ID from a notification, mark related notifications as read
        if ($highlightId) {
            // Mark notifications related to this story as read
            auth()->user()->notifications()
                ->where(function($query) use ($highlightId) {
                    $query->whereJsonContains('data->item_id', $highlightId)
                          ->orWhereJsonContains('data->id', $highlightId);
                })
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return view('admin.stories.index', compact('stories', 'stats', 'highlightId'));
    }

    /**
     * عرض نموذج إنشاء قصة جديدة من الإدارة
     */
    public function create()
    {
        return view('admin.stories.create');
    }

    /**
     * حفظ قصة جديدة من الإدارة
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'child_name' => 'required|string|max:255',
            'child_age' => 'nullable|integer|min:1|max:18',
            'parent_name' => 'nullable|string|max:255',
            'parent_contact' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:500',
            'title_en' => 'nullable|string|max:500',
            'content_ar' => 'required|string',
            'content_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'video' => 'nullable|mimes:mp4,mov,avi,wmv|max:51200',
            'lesson_learned' => 'nullable|string',
            'materials_used' => 'nullable|string|max:500',
            'duration' => 'nullable|string|max:100',
            'difficulty_level' => 'nullable|in:Easy,Medium,Hard',
            'status' => 'required|in:pending,approved,rejected',
            'is_featured' => 'boolean',
            'display_order' => 'nullable|integer|min:0',
            'admin_notes' => 'nullable|string',
        ]);

        // رفع الصورة
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('stories/images', 'public');
        }

        // رفع الفيديو
        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('stories/videos', 'public');
        }

        // إنشاء القصة
        $story = Story::create([
            'user_id' => Auth::id(), // الإدارة هي من أنشأت القصة
            'child_name' => $validated['child_name'],
            'child_age' => $validated['child_age'],
            'parent_name' => $validated['parent_name'],
            'parent_contact' => $validated['parent_contact'],
            'title_ar' => $validated['title_ar'],
            'title_en' => $validated['title_en'],
            'content_ar' => $validated['content_ar'],
            'content_en' => $validated['content_en'],
            'image_url' => $imagePath,
            'video_url' => $videoPath,
            'lesson_learned_ar' => $validated['lesson_learned'],
            'materials_used' => $validated['materials_used'],
            'duration' => $validated['duration'],
            'difficulty_level' => $validated['difficulty_level'],
            'submission_date' => now(),
            'status' => $validated['status'],
            'is_featured' => $request->boolean('is_featured'),
            'display_order' => $validated['display_order'] ?? 0,
            'admin_notes' => $validated['admin_notes'] ?? null,
            'reviewed_at' => $validated['status'] !== 'pending' ? now() : null,
            'reviewed_by' => $validated['status'] !== 'pending' ? Auth::id() : null,
        ]);

        return redirect()->route('admin.stories.index')
            ->with('success', 'تم إنشاء القصة بنجاح!');
    }

    /**
     * عرض تفاصيل القصة في لوحة الإدارة
     */
    public function show(Story $story)
    {
        $story->load(['user', 'reviewer']);
        
        // Mark notifications related to this story as read
        auth()->user()->notifications()
            ->whereJsonContains('data->type', 'story_request')
            ->whereJsonContains('data->id', $story->story_id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
            
        return view('admin.stories.show', compact('story'));
    }

    /**
     * عرض نموذج تعديل القصة
     */
    public function edit(Story $story)
     // Fetch all categories from the database
    {
        $categories = Category::all();

    // Pass both the story and the categories to the view
    return view('admin.stories.edit', compact('story', 'categories'));
    
        
    }

    /**
     * تحديث القصة
     */
    public function update(Request $request, Story $story)
    {
        $validated = $request->validate([
            'child_name' => 'required|string|max:255',
            'child_age' => 'nullable|integer|min:1|max:18',
            'parent_name' => 'nullable|string|max:255',
            'parent_contact' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:500',
            'title_en' => 'nullable|string|max:500',
            'content_ar' => 'required|string',
            'content_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'video' => 'nullable|mimes:mp4,mov,avi,wmv|max:51200',
            'lesson_learned' => 'nullable|string',
            'materials_used' => 'nullable|string|max:500',
            'duration' => 'nullable|string|max:100',
            'difficulty_level' => 'nullable|in:Easy,Medium,Hard',
            'status' => 'required|in:pending,approved,rejected',
            'is_featured' => 'boolean',
            'display_order' => 'nullable|integer|min:0',
            'admin_notes' => 'nullable|string',
            'remove_image' => 'boolean',
            'remove_video' => 'boolean',
        ]);

        // حذف الصورة إذا طُلب ذلك
        if ($request->boolean('remove_image') && $story->image_url) {
            Storage::disk('public')->delete($story->image_url);
            $validated['image_url'] = null;
        }

        // حذف الفيديو إذا طُلب ذلك
        if ($request->boolean('remove_video') && $story->video_url) {
            Storage::disk('public')->delete($story->video_url);
            $validated['video_url'] = null;
        }

        // تحديث الصورة إذا تم رفع واحدة جديدة
        if ($request->hasFile('image')) {
            if ($story->image_url) {
                Storage::disk('public')->delete($story->image_url);
            }
            $validated['image_url'] = $request->file('image')->store('stories/images', 'public');
        }

        // تحديث الفيديو إذا تم رفع واحد جديد
        if ($request->hasFile('video')) {
            if ($story->video_url) {
                Storage::disk('public')->delete($story->video_url);
            }
            $validated['video_url'] = $request->file('video')->store('stories/videos', 'public');
        }

        // تحديث معلومات المراجعة
        $oldStatus = $story->status;
        if ($validated['status'] !== $oldStatus && $validated['status'] !== 'pending') {
            $validated['reviewed_at'] = now();
            $validated['reviewed_by'] = Auth::id();
        } elseif ($validated['status'] === 'pending') {
            $validated['reviewed_at'] = null;
            $validated['reviewed_by'] = null;
        }

        $story->update($validated);

        return redirect()->route('admin.stories.show', $story)
            ->with('success', 'تم تحديث القصة بنجاح!');
    }

    /**
     * تحديث حالة القصة
     */
    public function updateStatus(Request $request, Story $story)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $story->update([
            'status' => $request->status,
            'reviewed_at' => $request->status !== 'pending' ? now() : null,
            'reviewed_by' => $request->status !== 'pending' ? Auth::id() : null,
            'admin_notes' => $request->admin_notes,
        ]);

        $statusLabels = [
            'pending' => 'في الانتظار',
            'approved' => 'مقبولة',
            'rejected' => 'مرفوضة'
        ];

        return back()->with('success', 'تم تحديث حالة القصة إلى: ' . $statusLabels[$request->status]);
    }

    /**
     * حذف القصة
     */
    public function destroy(Story $story)
    {
        // حذف الملفات المرفقة
        if ($story->image_url) {
            Storage::disk('public')->delete($story->image_url);
        }
        if ($story->video_url) {
            Storage::disk('public')->delete($story->video_url);
        }

        $story->delete();

        return redirect()->route('admin.stories.index')
            ->with('success', 'تم حذف القصة بنجاح.');
    }

    /**
     * تفعيل/إلغاء تفعيل القصة كمميزة
     */
    public function toggleFeatured(Story $story)
    {
        $story->update([
            'is_featured' => !$story->is_featured,
        ]);

        $message = $story->is_featured ? 'تم إضافة القصة للقصص المميزة!' : 'تم إزالة القصة من القصص المميزة.';
        
        return back()->with('success', $message);
    }

    /**
     * الإجراءات المجمعة
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete,feature,unfeature',
            'stories' => 'required|array|min:1',
            'stories.*' => 'exists:stories,story_id',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $stories = Story::whereIn('story_id', $request->stories);
        $count = $stories->count();

        switch ($request->action) {
            case 'approve':
                $stories->update([
                    'status' => 'approved',
                    'reviewed_at' => now(),
                    'reviewed_by' => Auth::id(),
                ]);
                $message = "تم اعتماد {$count} قصة بنجاح!";
                break;

            case 'reject':
                $stories->update([
                    'status' => 'rejected',
                    'reviewed_at' => now(),
                    'reviewed_by' => Auth::id(),
                    'admin_notes' => $request->admin_notes,
                ]);
                $message = "تم رفض {$count} قصة.";
                break;

            case 'delete':
                // حذف الملفات المرفقة
                $storyInstances = $stories->get();
                foreach ($storyInstances as $story) {
                    if ($story->image_url) {
                        Storage::disk('public')->delete($story->image_url);
                    }
                    if ($story->video_url) {
                        Storage::disk('public')->delete($story->video_url);
                    }
                }
                $stories->delete();
                $message = "تم حذف {$count} قصة بنجاح.";
                break;

            case 'feature':
                $stories->update(['is_featured' => true]);
                $message = "تم إضافة {$count} قصة للقصص المميزة!";
                break;

            case 'unfeature':
                $stories->update(['is_featured' => false]);
                $message = "تم إزالة {$count} قصة من القصص المميزة.";
                break;
        }

        return back()->with('success', $message);
    }

    /**
     * مراجعة سريعة
     */
    public function quickReview(Request $request, Story $story)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $story->update([
            'status' => $request->action === 'approve' ? 'approved' : 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
            'admin_notes' => $request->admin_notes,
        ]);

        $message = $request->action === 'approve' ? 'تم اعتماد القصة بنجاح!' : 'تم رفض القصة.';
        
        return response()->json(['success' => true, 'message' => $message]);
    }

    /**
     * تصدير القصص إلى CSV
     */
    public function export(Request $request)
    {
        $query = Story::with(['user', 'reviewer']);

        // تطبيق نفس الفلاتر
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        if ($request->has('featured') && $request->featured !== '') {
            $query->where('is_featured', $request->featured == '1');
        }

        $stories = $query->get();
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="stories_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($stories) {
            $file = fopen('php://output', 'w');
            
            // BOM for UTF-8
            fputs($file, "\xEF\xBB\xBF");
            
            // Headers
            fputcsv($file, [
                'ID', 'اسم الطفل', 'عمر الطفل', 'اسم الوالد', 'معلومات التواصل',
                'العنوان بالعربية', 'العنوان بالإنجليزية', 'المحتوى بالعربية', 'المحتوى بالإنجليزية',
                'الدرس المستفاد', 'المواد المستخدمة', 'المدة', 'مستوى الصعوبة',
                'الحالة', 'مميزة؟', 'ترتيب العرض', 'تاريخ الإرسال', 'تاريخ المراجعة', 'مراجع بواسطة', 'ملاحظات الإدارة'
            ]);

            // Data
            foreach ($stories as $story) {
                fputcsv($file, [
                    $story->story_id,
                    $story->child_name,
                    $story->child_age,
                    $story->parent_name,
                    $story->parent_contact,
                    $story->title_ar,
                    $story->title_en,
                    substr($story->content_ar, 0, 100) . '...', // اختصار المحتوى
                    substr($story->content_en ?? '', 0, 100) . '...',
                    $story->lesson_learned_ar,
                    $story->materials_used,
                    $story->duration,
                    $story->difficulty_level,
                    $story->status_label,
                    $story->is_featured ? 'نعم' : 'لا',
                    $story->display_order,
                    $story->submission_date?->format('Y-m-d H:i'),
                    $story->reviewed_at?->format('Y-m-d H:i'),
                    $story->reviewer?->name,
                    $story->admin_notes,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * إحصائيات القصص
     */
    public function analytics()
    {
        $stats = [
            'total_stories' => Story::count(),
            'pending_stories' => Story::pending()->count(),
            'approved_stories' => Story::approved()->count(),
            'rejected_stories' => Story::rejected()->count(),
            'featured_stories' => Story::featured()->count(),
            'stories_with_media' => Story::where(function($query) {
                $query->whereNotNull('image_url')->orWhereNotNull('video_url');
            })->count(),
            'monthly_submissions' => Story::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray(),
            'status_distribution' => Story::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray(),
        ];

        return view('admin.stories.analytics', compact('stats'));
    }

    /**
     * إنشاء قصة تجريبية للتطوير
     */
    public function createTestStory()
    {
        if (!app()->environment('local')) {
            abort(404);
        }

        $story = Story::create([
            'user_id' => Auth::id(),
            'child_name' => 'أحمد التجريبي',
            'child_age' => 8,
            'parent_name' => 'والد تجريبي',
            'parent_contact' => 'test@example.com',
            'title_ar' => 'قصة تجريبية - ' . now()->format('Y-m-d H:i:s'),
            'title_en' => 'Test Story - ' . now()->format('Y-m-d H:i:s'),
            'content_ar' => 'هذه قصة تجريبية تم إنشاؤها تلقائياً لأغراض التطوير والاختبار.',
            'content_en' => 'This is a test story created automatically for development and testing purposes.',
            'lesson_learned_ar' => 'درس تجريبي مستفاد',
            'materials_used' => 'مواد تجريبية',
            'duration' => '30 دقيقة',
            'difficulty_level' => 'Easy',
            'submission_date' => now(),
            'status' => 'pending',
            'is_featured' => false,
            'display_order' => 0,
        ]);

        return redirect()->route('admin.stories.show', $story)
            ->with('success', 'تم إنشاء قصة تجريبية بنجاح!');
    }
}