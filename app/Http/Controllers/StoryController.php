<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * عرض جميع القصص للزوار
     */
    public function index()
    {
        $stories = Story::approved()
            ->with(['user', 'reviewer'])
            ->orderBy('is_featured', 'desc')
            ->orderBy('display_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('stories.index', compact('stories'));
    }

    /**
     * عرض نموذج إنشاء قصة جديدة
     */
    public function create()
    {
        return view('stories.create');
    }

    /**
     * حفظ قصة جديدة
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
            'video' => 'nullable|mimes:mp4,mov,avi,wmv|max:51200', // 50MB
            'lesson_learned' => 'nullable|string',
            'materials_used' => 'nullable|string|max:500',
            'duration' => 'nullable|string|max:100',
            'difficulty_level' => 'nullable|in:Easy,Medium,Hard',
            'privacy_consent' => 'required|boolean',
            'data_consent' => 'required|boolean',
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
            'user_id' => Auth::id(),
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
            'status' => 'pending',
            'is_featured' => false,
        ]);

        // Direct notification creation instead of using events
        try {
            Log::info('Creating story request notifications for admin users');
            
            // Get all admin users
            $adminUsers = User::where('is_admin', true)->get();
            
            if ($adminUsers->isEmpty()) {
                Log::warning('No admin users found, trying with role=admin');
                $adminUsers = User::where('role', 'admin')->get();
            }
            
            Log::info('Found ' . $adminUsers->count() . ' admin users');
            
            foreach ($adminUsers as $admin) {
                Log::info('Creating notification for admin: ' . $admin->id . ' - ' . $admin->name);
                
                // Create notification data
                $notificationData = [
                    'id' => $story->story_id,
                    'type' => 'story_request',
                    'title' => $story->title_en ?? $story->title_ar,
                    'child_name' => $story->child_name,
                    'parent_name' => $story->parent_name,
                    'created_at' => $story->created_at->toIso8601String(),
                    'message' => 'New story request from ' . $story->parent_name,
                    'url' => route('admin.stories.index', ['highlight' => $story->story_id]),
                    'item_id' => $story->story_id
                ];
                
                // Direct database insertion
                DB::table('notifications')->insert([
                    'id' => Str::uuid()->toString(),
                    'type' => 'App\\Notifications\\NewStoryRequestNotification',
                    'notifiable_type' => 'App\\Models\\User',
                    'notifiable_id' => $admin->id,
                    'data' => json_encode($notificationData),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                Log::info('Successfully created notification for admin: ' . $admin->id);
            }
        } catch (\Exception $e) {
            Log::error('Error creating story request notifications: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }

        return redirect()->route('stories.index')
            ->with('success', 'تم إرسال قصتك بنجاح! سيتم مراجعتها قبل النشر.');
    }

    /**
     * عرض قصة واحدة
     */
    public function show(Story $story)
    {
       

        $story->load(['user', 'reviewer']);
        return view('stories.show', compact('story'));
    }

    /**
     * عرض نموذج تعديل القصة
     */
    public function edit(Story $story)
    {
        // التأكد من الصلاحيات
        if (!Auth::check() || (Auth::id() !== $story->user_id && !Auth::user()->is_admin)) {
            abort(403);
        }

        return view('stories.edit', compact('story'));
    }

    /**
     * تحديث القصة
     */
    public function update(Request $request, Story $story)
    {
        // التأكد من الصلاحيات
        if (!Auth::check() || (Auth::id() !== $story->user_id && !Auth::user()->is_admin)) {
            abort(403);
        }

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
        ]);

        // تحديث الصورة إذا تم رفع واحدة جديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($story->image_url) {
                Storage::disk('public')->delete($story->image_url);
            }
            $validated['image_url'] = $request->file('image')->store('stories/images', 'public');
        }

        // تحديث الفيديو إذا تم رفع واحد جديد
        if ($request->hasFile('video')) {
            // حذف الفيديو القديم
            if ($story->video_url) {
                Storage::disk('public')->delete($story->video_url);
            }
            $validated['video_url'] = $request->file('video')->store('stories/videos', 'public');
        }

        // إذا كان المحرر ليس إدارياً، تعيين الحالة إلى pending
        if (!Auth::user()->is_admin) {
            $validated['status'] = 'pending';
            $validated['reviewed_at'] = null;
            $validated['reviewed_by'] = null;
        }

        $story->update($validated);

        return redirect()->route('stories.show', $story)
            ->with('success', 'تم تحديث القصة بنجاح!');
    }

    /**
     * حذف القصة
     */
    public function destroy(Story $story)
    {
        // التأكد من الصلاحيات
        if (!Auth::check() || (Auth::id() !== $story->user_id && !Auth::user()->is_admin)) {
            abort(403);
        }

        // حذف الملفات المرفقة
        if ($story->image_url) {
            Storage::disk('public')->delete($story->image_url);
        }
        if ($story->video_url) {
            Storage::disk('public')->delete($story->video_url);
        }

        $story->delete();

        return redirect()->route('stories.index')
            ->with('success', 'تم حذف القصة بنجاح.');
    }
}