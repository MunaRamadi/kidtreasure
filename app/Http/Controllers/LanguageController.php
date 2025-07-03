<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application language
     *
     * @param string $lang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang($lang)
    {
        // Validate that the language is supported
        if (in_array($lang, ['en', 'ar'])) {
            Session::put('applocale', $lang);
            
            // Set the correct text direction
            if ($lang == 'ar') {
                Session::put('textDirection', 'rtl');
            } else {
                Session::put('textDirection', 'ltr');
            }
        }
        
        return redirect()->back();
    }
}
