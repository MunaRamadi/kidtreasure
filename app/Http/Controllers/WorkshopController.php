<?php

namespace App\Http\Controllers;

use App\Models\WorkshopEvent; 
use App\Models\WorkshopRegistration; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\ValidationException; 

class WorkshopController extends Controller
{
    
    public function index()
    {
        // مثال: جلب فعاليات الورش القادمة المتاحة للتسجيل
        $upcomingEvents = WorkshopEvent::where('event_date', '>=', now())->where('is_open_for_registration', true)->orderBy('event_date')->get();

        return view('pages.workshops.index', compact('upcomingEvents'));
    }

 
    public function showRegistrationForm(WorkshopEvent $event)
    {
        // // مثال: التحقق مما إذا كانت الفعالية متاحة للتسجيل
        if (!$event->is_open_for_registration || $event->event_date < now()) {
            return redirect()->route('workshops.index')->with('error', 'هذه الورشة غير متاحة للتسجيل حالياً.');
        }
        return view('pages.workshops.register', compact('event'));
    }

   
  
    public function register(Request $request, WorkshopEvent $event)
    {
        // مثال: التحقق من صحة بيانات النموذج
        $request->validate([
            'attendee_name' => 'required|string|max:255',
            'parent_name' => 'nullable|string|max:255', 
            'parent_contact' => 'nullable|string|max:255',
           
        ]);

        // مثال: التحقق مرة أخرى من حالة الفعالية قبل التسجيل النهائي
        if (!$event->is_open_for_registration || $event->event_date < now()) {
             return back()->withInput()->with('error', 'تعذر التسجيل. الورشة غير متاحة.');
        }

        // مثال: حفظ بيانات التسجيل في قاعدة البيانات
        $registration = WorkshopRegistration::create([
            'user_id' => Auth::id(), 
            'event_id' => $event->id,
            'attendee_name' => $request->attendee_name,
            'parent_name' => $request->parent_name ?? (Auth::user()->name ?? null), 
            'parent_contact' => $request->parent_contact ?? (Auth::user()->email ?? Auth::user()->phone ?? null), 
            'registration_date' => now(),
            'status' => 'pending', 
            'payment_status' => ($event->price_jod > 0) ? 'pending' : 'not_applicable', 
        ]);
        $event->increment('current_attendees');
        return redirect()->route('workshops.index')->with('success', 'تم تسجيلك في الورشة بنجاح!');

       
    }
}