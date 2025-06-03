<?php

namespace App\Http\Controllers;

use App\Models\Product; 
use App\Models\Story;  
use App\Models\WorkshopEvent; 
use Illuminate\Http\Request;

class HomeController extends Controller
{
   
    public function index()
    {
     // مثال: جلب بيانات لعرضها في الصفحة الرئيسية
        $featuredProducts = Product::where('is_active', true)->limit(6)->get(); 
        $upcomingWorkshops = WorkshopEvent::where('event_date', '>=', now())->orderBy('event_date')->limit(3)->get(); 
        $latestStories = Story::where('status', 'approved')->orderByDesc('submission_date')->limit(4)->get(); 
        $latestBlogPosts = \App\Models\BlogPost::where('is_published', true)->orderByDesc('publication_date')->limit(3)->get(); 
        return view('pages.home', compact('featuredProducts', 'upcomingWorkshops', 'latestStories', 'latestBlogPosts'));  
    }

   
}