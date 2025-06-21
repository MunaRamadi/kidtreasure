<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use App\Models\WorkshopEvent; 
use App\Models\WorkshopRegistration; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Validation\ValidationException; 

class WorkshopController extends Controller
{
    
    public function index()
    {
        // Get all active workshops with their events
        $workshops = Workshop::where('is_active', true)->with('events')->get();
        
        // Get upcoming workshop events that are open for registration
        $upcomingEvents = WorkshopEvent::with('workshop')
            ->where('event_date', '>=', now())
            ->where('is_open_for_registration', true)
            ->orderBy('event_date')
            ->get();

        return view('pages.workshop', compact('workshops', 'upcomingEvents'));
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

    /**
     * Display static workshops for testing purposes
     */
    public function staticWorkshops()
    {
        // Create static workshop data
        $workshops = [
            (object)[
                'id' => 1,
                'name_en' => 'Recycled Art Masterpieces',
                'name_ar' => 'روائع الفن المعاد تدويره',
                'description_en' => 'Children will learn to create beautiful art pieces from recycled materials, fostering creativity and environmental awareness.',
                'description_ar' => 'سيتعلم الأطفال كيفية إنشاء قطع فنية جميلة من المواد المعاد تدويرها، مما يعزز الإبداع والوعي البيئي.',
                'category' => 'Art & Craft',
                'duration' => 120,
                'is_active' => true,
                'image_url' => asset('images/workshops/recycled-art.jpg'),
            ],
            (object)[
                'id' => 2,
                'name_en' => 'Storytelling & Imagination',
                'name_ar' => 'رواية القصص والخيال',
                'description_en' => 'A workshop that encourages children to create and tell their own stories, developing language skills and imagination.',
                'description_ar' => 'ورشة عمل تشجع الأطفال على إنشاء وسرد قصصهم الخاصة، وتطوير مهارات اللغة والخيال.',
                'category' => 'Storytelling',
                'duration' => 90,
                'is_active' => true,
                'image_url' => asset('images/workshops/storytelling.jpg'),
            ],
            (object)[
                'id' => 3,
                'name_en' => 'Nature Explorers',
                'name_ar' => 'مستكشفو الطبيعة',
                'description_en' => 'An outdoor workshop where children connect with nature through exploration, observation, and nature-inspired art activities.',
                'description_ar' => 'ورشة عمل خارجية حيث يتواصل الأطفال مع الطبيعة من خلال الاستكشاف والمراقبة وأنشطة فنية مستوحاة من الطبيعة.',
                'category' => 'Nature & Science',
                'duration' => 150,
                'is_active' => true,
                'image_url' => asset('images/workshops/nature-explorers.jpg'),
            ],
        ];

        // Create static workshop events
        $upcomingEvents = [
            (object)[
                'id' => 1,
                'event_id' => 'WS-2025-001',
                'workshop' => $workshops[0],
                'event_date' => now()->addDays(7),
                'event_time' => '10:00 AM',
                'location' => 'Main Studio, Amman',
                'max_attendees' => 15,
                'current_attendees' => 8,
                'price_jod' => 25,
                'is_open_for_registration' => true,
            ],
            (object)[
                'id' => 2,
                'event_id' => 'WS-2025-002',
                'workshop' => $workshops[1],
                'event_date' => now()->addDays(14),
                'event_time' => '2:00 PM',
                'location' => 'Story Corner, Amman',
                'max_attendees' => 20,
                'current_attendees' => 5,
                'price_jod' => 15,
                'is_open_for_registration' => true,
            ],
            (object)[
                'id' => 3,
                'event_id' => 'WS-2025-003',
                'workshop' => $workshops[2],
                'event_date' => now()->addDays(21),
                'event_time' => '9:30 AM',
                'location' => 'Rainbow Park, Amman',
                'max_attendees' => 12,
                'current_attendees' => 10,
                'price_jod' => 30,
                'is_open_for_registration' => true,
            ],
        ];

        return view('pages.workshop', compact('workshops', 'upcomingEvents'));
    }

    /**
     * Handle the workshop interest registration form submission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerInterest(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'parent_name' => 'required|string|max:255',
            'parent_email' => 'required|email|max:255',
            'parent_phone' => 'required|string|max:20',
            'child_name' => 'required|string|max:255',
            'child_age' => 'required|integer|min:3|max:18',
            'preferred_day' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'special_requirements' => 'nullable|string',
            'privacy_policy' => 'required|accepted',
        ]);
        
        // Store interest registration in database
        // If you have a WorkshopInterest model, use it here
        // Otherwise, you can create a simple DB entry
        DB::table('workshop_interests')->insert([
            'parent_name' => $validated['parent_name'],
            'parent_email' => $validated['parent_email'],
            'parent_phone' => $validated['parent_phone'],
            'child_name' => $validated['child_name'],
            'child_age' => $validated['child_age'],
            'preferred_day' => $validated['preferred_day'],
            'special_requirements' => $validated['special_requirements'] ?? null,
            'created_at' => now(),
        ]);
        
        // Redirect with success message
        return redirect()->route('workshop')->with('success', 'Thank you for your interest! We will contact you about upcoming workshops.');
    }
}