<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; 

class ContactController extends Controller
{
   
    public function create()
    {
        return view('pages.contact.create');
    }

   
    public function store(Request $request)
    {
        // مثال: التحقق من صحة بيانات النموذج
        $request->validate([
            'sender_name' => 'required|string|max:255',
            'sender_email' => 'required|email|max:255',
            'sender_phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // مثال: حفظ الرسالة في قاعدة البيانات
        $contactMessage = ContactMessage::create([
            'sender_name' => $request->sender_name,
            'sender_email' => $request->sender_email,
            'sender_phone' => $request->sender_phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'submission_date' => now(),
            'is_read' => false, // افتراضياً الرسالة غير مقروءة
        ]);


        // إعادة التوجيه بعد النجاح
        return redirect()->route('contact.create')->with('success', 'شكراً لك! تم استلام رسالتك وسنتواصل معك قريباً.');

       
    }
}