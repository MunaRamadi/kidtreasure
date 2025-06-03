<?php

namespace App\Http\Controllers;

use App\Models\BlogPost; 
use Illuminate\Http\Request;

class BlogController extends Controller
{
    
    public function index()
    {
       
        $posts = BlogPost::where('is_published', true)->orderByDesc('publication_date') ->paginate(10); 
        return view('pages.blog.index', compact('posts'));
    }

    
    public function show($id) 
    {
        
        $post = BlogPost::where('id', $id)->where('is_published', true)->firstOrFail();
        if (!$post->is_published) {abort(404);}
        return view('pages.blog.show', compact('post'));

      
    }
}
