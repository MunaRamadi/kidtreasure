<?php

namespace App\Http\Controllers\Admin; // Add the correct namespace

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function __construct()
    {
        // Apply authentication and admin middleware to all methods in this controller.
        // This ensures only authenticated admin users can access these blog management functions.
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the blog posts.
     * Supports searching by title or content and filtering by publication status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Start a new query builder instance for BlogPost model.
        $query = BlogPost::query();

        // Handle search functionality.
        // If a 'search' parameter is present in the request, filter posts
        // where the title or content contains the search term.
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('content_ar', 'like', "%{$search}%")
                  ->orWhere('content_en', 'like', "%{$search}%");
            });
        }

        // Handle status filtering.
        // If a 'status' parameter is present, filter posts by their publication status.
        // 'published' maps to true (1), any other value implies false (0) for 'is_published'.
        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }

        // Order the results by publication date in descending order (latest first).
        // Paginate the results, showing 15 posts per page.
        // Append all current query string parameters to pagination links.
        $posts = $query->latest('publication_date')->paginate(15)->withQueryString();

        // Return the 'admin.blog.index' view, passing the paginated posts.
        return view('admin.blog.index', compact('posts'));
    }

    /**
     * Show the form for creating a new blog post.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Simply return the view for creating a new blog post.
        return view('admin.blog.create');
    }

    /**
     * Store a newly created blog post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:2048', // 2MB max
            'is_published' => 'boolean',
            'publication_date' => 'nullable|date'
        ]);

        // Prepare the post data for the actual database columns
        $postData = [
            'author_id' => auth()->id(), // Use the authenticated user's ID
            'author_name' => auth()->user()->name,
            'title_ar' => $request->title, // Store in Arabic column
            'content_ar' => $request->content, // Store in Arabic column
            'publication_date' => $request->publication_date ?: now(),
            'is_published' => $request->boolean('is_published', false),
        ];

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $postData['image_url'] = $request->file('featured_image')
                ->store('blog', 'public');
        }

        // Create a new BlogPost record in the database
        BlogPost::create($postData);

        // Redirect to the blog index page with a success message
        return redirect()->route('admin.blog.index')
            ->with('success', 'تم إضافة المقال بنجاح');
    }

    /**
     * Display the specified blog post.
     *
     * @param  \App\Models\BlogPost  $post
     * @return \Illuminate\View\View
     */
    public function show(BlogPost $post)
    {
        // Use Route Model Binding to automatically inject the BlogPost instance.
        // Return the 'admin.blog.show' view, passing the specific post.
        return view('admin.blog.show', compact('post'));
    }

    /**
     * Show the form for editing the specified blog post.
     *
     * @param  \App\Models\BlogPost  $post
     * @return \Illuminate\View\View
     */
    public function edit(BlogPost $post)
    {
        // Use Route Model Binding to automatically inject the BlogPost instance.
        // Return the 'admin.blog.edit' view, passing the specific post for editing.
        return view('admin.blog.edit', compact('post'));
    }

    /**
     * Update the specified blog post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogPost  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, BlogPost $post)
    {
        // Validate the incoming request data, similar to the store method.
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:2048', // 2MB max
            'is_published' => 'boolean',
            'publication_date' => 'nullable|date'
        ]);

        // Prepare the update data
        $postData = [
            'title_ar' => $request->title,
            'content_ar' => $request->content,
            'publication_date' => $request->publication_date ?: $post->publication_date,
            'is_published' => $request->boolean('is_published', false),
        ];

        // Handle new featured image upload.
        // If a new file for 'featured_image' is present:
        if ($request->hasFile('featured_image')) {
            // Delete the old featured image if it exists.
            if ($post->image_url) {
                Storage::disk('public')->delete($post->image_url);
            }
            // Store the new image.
            $postData['image_url'] = $request->file('featured_image')
                ->store('blog', 'public');
        }

        // Update the existing BlogPost record with the new data.
        $post->update($postData);

        // Redirect to the blog index page with a success message.
        return redirect()->route('admin.blog.index')
            ->with('success', 'تم تحديث المقال بنجاح');
    }

    /**
     * Remove the specified blog post from storage.
     *
     * @param  \App\Models\BlogPost  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(BlogPost $post)
    {
        // Delete the featured image from storage if it exists.
        if ($post->image_url) {
            Storage::disk('public')->delete($post->image_url);
        }

        // Delete the blog post record from the database.
        $post->delete();

        // Redirect to the blog index page with a success message.
        return redirect()->route('admin.blog.index')
            ->with('success', 'تم حذف المقال بنجاح');
    }

    /**
     * Toggle the publication status (published/draft) of a blog post.
     *
     * @param  \App\Models\BlogPost  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(BlogPost $post)
    {
        // Toggle the 'is_published' boolean field.
        $post->update(['is_published' => !$post->is_published]);

        // Determine the new status for the success message.
        $status = $post->is_published ? 'منشور' : 'مسودة';
        // Redirect back to the previous page with a success message.
        return back()->with('success', "تم تغيير حالة المقال إلى {$status}");
    }
}