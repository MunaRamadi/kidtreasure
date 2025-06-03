<?php

namespace App\Http\Controllers;

use App\Models\TeamMember; 
use Illuminate\Http\Request;

class AboutController extends Controller
{
   
    public function index()
    {
        // // مثال: جلب بيانات فريق العمل
        $teamMembers = TeamMember::where('is_active', true)->orderBy('display_order')->get();
        return view('pages.about', compact('teamMembers'));  
    }


}