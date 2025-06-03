<?php

namespace App\Http\Controllers;

use App\Models\Story; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage; 

class StoryController extends Controller
{

    public function index()
    {
        // مثال: جلب القصص المعتمدة للنشر
        $stories = Story::where('status', 'approved')->orderByDesc('submission_date')->paginate(10); 
        return view('pages.stories.index', compact('stories'));    
    }

 
    public function create()
    {
        return view('pages.stories.create');
    }

    public function store(Request $request)
    {
        // مثال: التحقق من صحة بيانات النموذج
        $request->validate([
            'child_name' => 'required|string|max:255',
            'child_age' => 'nullable|integer|min:1|max:18',
            'parent_name' => 'nullable|string|max:255',
            'parent_contact' => 'nullable|string|max:255', 
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'content_ar' => 'nullable|string',
            'content_en' => 'nullable|string',
            'image' => 'nullable|image|max:2048', 
            'video' => 'nullable|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:10240', // Max 10MB
        ]);

        // مثال: رفع الصورة والفيديو
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imageUrl = $request->file('image')->store('stories/images', 'public'); 
        }

        $videoUrl = null;
        if ($request->hasFile('video')) {
            $videoUrl = $request->file('video')->store('stories/videos', 'public'); 
        }


        // مثال: حفظ بيانات القصة في قاعدة البيانات
        $story = Story::create([
            'user_id' => Auth::id(), // يسجل ID المستخدم الحالي إذا كان مسجلاً، وإلا سيكون null
            'child_name' => $request->child_name,
            'child_age' => $request->child_age,
            'parent_name' => $request->parent_name ?? (Auth::user()->name ?? null),
            'parent_contact' => $request->parent_contact ?? (Auth::user()->email ?? Auth::user()->phone ?? null),
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'content_ar' => $request->content_ar,
            'content_en' => $request->content_en,
            'submission_date' => now(),
            'status' => 'pending', // تبدأ القصة كـ 'pending' للمراجعة
            'image_url' => $imageUrl ? Storage::url($imageUrl) : null, // استخدام Storage::url لعرض الملفات
            'video_url' => $videoUrl ? Storage::url($videoUrl) : null,
        ]);

        // إعادة التوجيه بعد النجاح
        return redirect()->route('stories.index')->with('success', 'شكراً لمساهمتك! ستتم مراجعة قصتك قريباً.');

      
       
    }

}
