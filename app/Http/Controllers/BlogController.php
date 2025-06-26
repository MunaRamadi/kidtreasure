<?php

namespace App\Http\Controllers;
use App\Models\BlogPost; 
use Illuminate\Http\Request;

class BlogController extends Controller
{
    
    public function index()
    {
        $posts = BlogPost::where('is_published', true)
                        ->orderBy('publication_date', 'desc')
                        ->paginate(9);
        
        return view('pages.blog', compact('posts'));
    }

    
    public function show(BlogPost $post) 
    {
        // Check if the post is published
        if (!$post->is_published) {
            abort(404);
        }
        
        return view('pages.blog.show', compact('post'));
    }
}