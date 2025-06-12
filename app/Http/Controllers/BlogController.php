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
        
        // Fixed: Changed from 'index' to 'blog' to match your blog.blade.php file
        return view('pages.blog', compact('posts'));
    }

    
    public function show($id) 
    {
        $post = BlogPost::where('id', $id)->where('is_published', true)->firstOrFail();
        
        return view('pages.blog.show', compact('post'));
    }
}