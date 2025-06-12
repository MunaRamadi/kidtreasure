
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = BlogPost::query();

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // التصفية حسب الحالة
        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }

        $posts = $query->latest('publication_date')->paginate(15)->withQueryString();

        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'publication_date' => 'nullable|date'
        ]);

        $postData = $request->all();
        $postData['slug'] = Str::slug($request->title);
        $postData['author_id'] = auth()->id();

        // رفع الصورة المميزة
        if ($request->hasFile('featured_image')) {
            $postData['featured_image'] = $request->file('featured_image')
                ->store('blog', 'public');
        }

        // تحديد تاريخ النشر
        if (!$request->publication_date) {
            $postData['publication_date'] = now();
        }

        BlogPost::create($postData);

        return redirect()->route('admin.blog.index')
            ->with('success', 'تم إضافة المقال بنجاح');
    }

    public function show(BlogPost $post)
    {
        return view('admin.blog.show', compact('post'));
    }

    public function edit(BlogPost $post)
    {
        return view('admin.blog.edit', compact('post'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'publication_date' => 'nullable|date'
        ]);

        $postData = $request->all();

        // تحديث slug إذا تغير العنوان
        if ($request->title !== $post->title) {
            $postData['slug'] = Str::slug($request->title);
        }

        // رفع الصورة المميزة الجديدة
        if ($request->hasFile('featured_image')) {
            // حذف الصورة القديمة
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $postData['featured_image'] = $request->file('featured_image')
                ->store('blog', 'public');
        }

        $post->update($postData);

        return redirect()->route('admin.blog.index')
            ->with('success', 'تم تحديث المقال بنجاح');
    }

    public function destroy(BlogPost $post)
    {
        // حذف الصورة المميزة
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'تم حذف المقال بنجاح');
    }

    public function toggleStatus(BlogPost $post)
    {
        $post->update(['is_published' => !$post->is_published]);
        
        $status = $post->is_published ? 'منشور' : 'مسودة';
        return back()->with('success', "تم تغيير حالة المقال إلى {$status}");
    }
}
