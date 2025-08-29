<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use App\Models\WorkshopEvent; 
use App\Models\WorkshopRegistration; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Session; 
use Illuminate\Support\Facades\ValidationException; 

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

        // Get the total count of featured workshops
        $featuredWorkshopsCount = Workshop::where('is_active', true)
            ->where(function($query) {
                $query->where('is_featured', true)
                      ->orWhereHas('events', function($q) {
                          $q->where('event_date', '>=', now());
                      });
            })
            ->count();

        // Get featured workshops (selecting those marked as featured or with most events/registrations)
        $featuredWorkshops = Workshop::where('is_active', true)
            ->where(function($query) {
                $query->where('is_featured', true)
                      ->orWhereHas('events', function($q) {
                          $q->where('event_date', '>=', now());
                      });
            })
            ->withCount(['events', 'events as registrations_count' => function($query) {
                $query->withCount('registrations');
            }])
            ->orderBy('is_featured', 'desc')
            ->orderByDesc('events_count')
            ->orderByDesc('registrations_count')
            ->with(['events' => function($query) {
                $query->where('event_date', '>=', now())
                      ->orderBy('event_date')
                      ->with('registrations');
            }])
            ->limit(3) // Limit to 3 featured workshops for display
            ->get();

        // Get a single featured workshop (for backward compatibility)
        $featuredWorkshop = $featuredWorkshops->first();

        return view('pages.workshop.workshop', compact('workshops', 'upcomingEvents', 'featuredWorkshop', 'featuredWorkshops', 'featuredWorkshopsCount'));
    }

    /**
     * Display a listing of all workshops with their events
     * 
     * @return \Illuminate\View\View
     */
    public function listAll()
    {
        $workshops = Workshop::with(['events' => function ($query) {
            $query->where('event_date', '>=', now())
                  ->where('is_open_for_registration', true)
                  ->orderBy('event_date', 'asc');
        }])->get();

        $userRegistrations = [];
        
        if (auth()->check()) {
            // Get all active registrations for the current user
            $userRegistrations = WorkshopRegistration::active()
                ->where('user_id', auth()->id())
                ->with('event')
                ->get()
                ->keyBy('event_id');
        }

        return view('pages.workshop.workshops-list', compact('workshops', 'userRegistrations'));
    }

    /**
     * Display the specified workshop with its upcoming events
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $workshop = Workshop::findOrFail($id)
            ->load(['events' => function ($query) {
                $query->where('event_date', '>=', now())
                      ->where('is_open_for_registration', true)
                      ->orderBy('event_date', 'asc');
            }]);
        
        $registeredEventIds = [];
        if (auth()->check()) {
            $registeredEventIds = WorkshopRegistration::active()
                ->where('user_id', auth()->id())
                ->pluck('event_id')
                ->toArray();
        } else {
            $registeredEventIds = session('registered_events', []);
        }
        
        return view('pages.workshop.workshop-show', compact('workshop', 'registeredEventIds'));
    }

 
    public function showRegistrationForm(WorkshopEvent $event)
    {
        // // مثال: التحقق مما إذا كانت الفعالية متاحة للتسجيل
        if (!$event->is_open_for_registration || $event->event_date < now()) {
            return redirect()->route('workshops.index')->with('error', 'هذه الورشة غير متاحة للتسجيل حالياً.');
        }
        return view('pages.workshop.register', compact('event'));
    }

    /**
     * Display registration form for a workshop event
     * This method is used by the workshops list page
     * 
     * @param \App\Models\WorkshopEvent $event
     * @return \Illuminate\View\View
     */
    public function registerForm(WorkshopEvent $event)
    {
        // Redirect to the existing registration form method
        return $this->showRegistrationForm($event);
    }

    /**
     * Display details for a specific workshop event
     * 
     * @param \App\Models\WorkshopEvent $event
     * @return \Illuminate\View\View
     */
    public function showEvent(WorkshopEvent $event)
    {
        // Load the workshop relationship
        $event->load('workshop');
        
        // Check if the current user is registered for this event
        $userRegistered = false;
        $registration = null;
        
        if (auth()->check()) {
            $registration = WorkshopRegistration::where('event_id', $event->id)
                ->where('user_id', auth()->id())
                ->first();
                
            $userRegistered = !is_null($registration);
        }
        
        return view('pages.workshop.event-show', compact('event', 'userRegistered', 'registration'));
    }

   
  
    public function register(Request $request, WorkshopEvent $event)
    {
        // Validate form data
        $request->validate([
            'attendee_name' => 'required|string|max:255|regex:/^[A-Za-z\s\-\.\']+$/',
            'parent_name' => 'required|string|max:255|regex:/^[A-Za-z\s\-\.\']+$/', 
            'parent_contact' => 'required|string|max:255|regex:/^[0-9\+\-\s]+$/',
            'special_requirements' => 'nullable|string|max:500',
        ]);

        // Check if the event is still open for registration
        if (!$event->is_open_for_registration || $event->event_date < now()) {
             return back()->withInput()->with('error', 'تعذر التسجيل. الورشة غير متاحة.');
        }
        
        // Check if the event has reached maximum capacity
        $activeRegistrationsCount = $event->registrations()->active()->count();
        if ($activeRegistrationsCount >= $event->max_attendees) {
            return back()->withInput()->with('error', 'عذراً، الورشة ممتلئة بالكامل.');
        }

        // Save registration data to database
        $registration = WorkshopRegistration::create([
            'user_id' => Auth::id() ?? null, // Use authenticated user ID if available
            'event_id' => $event->id,
            'attendee_name' => $request->attendee_name,
            'parent_name' => $request->parent_name, 
            'parent_contact' => $request->parent_contact, 
            'special_requirements' => $request->special_requirements,
            'registration_date' => now(),
            'status' => 'pending', 
            'payment_status' => ($event->price_jod > 0) ? 'pending' : 'not_applicable', 
        ]);
        
        // Update the event's current_attendees count
        $activeRegistrationsCount = $event->registrations()->active()->count();
        $event->current_attendees = $activeRegistrationsCount;
        $event->save();

        // Store registration in session for guest users
        if (!Auth::check()) {
            $registeredEvents = session('registered_events', []);
            $registeredEvents[] = $event->id;
            session(['registered_events' => $registeredEvents]);
        }

        // Redirect back to workshop details page with success message
        return redirect()->route('workshops.show', $event->workshop_id)->with('success', 'Registration successful! Thank you for registering for ' . $event->title . '.');
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
            'event_id' => 'required|exists:workshop_events,id',
            'parent_name' => 'required|string|max:255',
            'parent_contact' => 'required|string|max:255',
            'attendee_name' => 'required|string|max:255',
            'special_requirements' => 'nullable|string',
        ]);
        
        // Get the event
        $event = WorkshopEvent::findOrFail($validated['event_id']);
        
        // Check if the event has reached maximum capacity
        $activeRegistrationsCount = $event->registrations()->active()->count();
        if ($activeRegistrationsCount >= $event->max_attendees) {
            return back()->withInput()->with('error', 'عذراً، الورشة ممتلئة بالكامل.');
        }
        
        // Store registration in database
        $registration = WorkshopRegistration::create([
            'user_id' => Auth::id() ?? null, // Use authenticated user ID if available
            'event_id' => $validated['event_id'],
            'attendee_name' => $validated['attendee_name'],
            'parent_name' => $validated['parent_name'],
            'parent_contact' => $validated['parent_contact'],
            'registration_date' => now(),
            'status' => 'pending',
            'payment_status' => ($event->price_jod > 0) ? 'pending' : 'not_applicable',
        ]);
        
        // Update the event's current_attendees count
        $activeRegistrationsCount = $event->registrations()->active()->count();
        $event->current_attendees = $activeRegistrationsCount;
        $event->save();
        
        // Redirect with success message
        return redirect()->route('workshops.index')->with('success', 'Thank you for registering! Your registration has been received.');
    }

    /**
     * Display a listing of workshop registrations.
     */
    public function registrations()
    {
        // Check if user is authenticated and has admin role
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            return redirect()->route('workshops.list')->with('error', 'Unauthorized access.');
        }

        // Get all workshop registrations with user and event information
        $registrations = WorkshopRegistration::with(['user', 'event'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.workshop.registrations', compact('registrations'));
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
}