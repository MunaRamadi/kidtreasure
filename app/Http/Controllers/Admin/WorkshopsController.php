<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\WorkshopEvent;
use App\Models\WorkshopRegistration;
use Illuminate\Http\Request;

class WorkshopsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $workshops = WorkshopEvent::withCount('registrations')
            ->latest('event_date')
            ->paginate(15);

        return view('admin.workshops.index', compact('workshops'));
    }

    public function create()
    {
        return view('admin.workshops.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date|after:now',
            'duration_hours' => 'required|numeric|min:0.5',
            'max_attendees' => 'required|integer|min:1',
            'price_jod' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'age_group' => 'required|string|max:50',
            'is_open_for_registration' => 'boolean'
        ]);

        WorkshopEvent::create($request->all());

        return redirect()->route('admin.workshops.index')
            ->with('success', 'تم إضافة الورشة بنجاح');
    }

    public function show(WorkshopEvent $workshop)
    {
        $workshop->load(['registrations.user']);
        return view('admin.workshops.show', compact('workshop'));
    }

    public function edit(WorkshopEvent $workshop)
    {
        return view('admin.workshops.edit', compact('workshop'));
    }

    public function update(Request $request, WorkshopEvent $workshop)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'duration_hours' => 'required|numeric|min:0.5',
            'max_attendees' => 'required|integer|min:1',
            'price_jod' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'age_group' => 'required|string|max:50',
            'is_open_for_registration' => 'boolean'
        ]);

        $workshop->update($request->all());

        return redirect()->route('admin.workshops.index')
            ->with('success', 'تم تحديث الورشة بنجاح');
    }

    public function destroy(WorkshopEvent $workshop)
    {
        $workshop->delete();

        return redirect()->route('admin.workshops.index')
            ->with('success', 'تم حذف الورشة بنجاح');
    }

    public function registrations(WorkshopEvent $workshop)
    {
        $registrations = $workshop->registrations()
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('admin.workshops.registrations', compact('workshop', 'registrations'));
    }

    public function updateRegistrationStatus(Request $request, WorkshopRegistration $registration)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        $registration->update(['status' => $request->status]);

        return back()->with('success', 'تم تحديث حالة التسجيل بنجاح');
    }
}