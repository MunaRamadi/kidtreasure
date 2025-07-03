<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workshop;
use App\Models\WorkshopEvent;
use App\Models\WorkshopRegistration;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class WorkshopEventsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of workshop events
     */
    public function index(Request $request)
    {
        $query = WorkshopEvent::query()->withCount('registrations');

        // Search by event title
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where('title', 'like', $searchTerm);
        }

        // Filter by date
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('event_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('event_date', '<=', $request->date_to);
        }

        // Filter by registration status
        if ($request->has('status') && $request->status != 'all') {
            $status = $request->status === 'open' ? 1 : 0;
            $query->where('is_open_for_registration', $status);
        }

        // Filter by event status
        if ($request->has('event_status') && $request->event_status != 'all') {
            $query->where('status', $request->event_status);
        }

        // Sort results
        $sortField = 'event_date';
        $sortDirection = 'desc';

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'title_asc':
                    $sortField = 'title';
                    $sortDirection = 'asc';
                    break;
                case 'title_desc':
                    $sortField = 'title';
                    $sortDirection = 'desc';
                    break;
                case 'date_asc':
                    $sortField = 'event_date';
                    $sortDirection = 'asc';
                    break;
                case 'date_desc':
                    $sortField = 'event_date';
                    $sortDirection = 'desc';
                    break;
                case 'registrations':
                    $query->orderByDesc('registrations_count');
                    break;
            }
        }

        if ($request->sort !== 'registrations') {
            $query->orderBy($sortField, $sortDirection);
        }

        $workshops = $query->paginate(15)->withQueryString();

        return view('admin.workshop-events.index', compact('workshops'));
    }

    /**
     * Show the form for creating a new workshop event
     */
    public function create(Request $request)
    {
        // Get all workshop templates for dropdown
        $workshopTemplates = Workshop::where('is_active', true)->get();

        // Pre-select workshop if workshop_id is provided in the request
        $selectedWorkshopId = $request->input('workshop_id');

        return view('admin.workshop-events.create', compact('workshopTemplates', 'selectedWorkshopId'));
    }

    /**
     * Store a newly created workshop event
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'workshop_id' => 'nullable|exists:workshops,id', // Optional link to workshop template
            'event_date' => 'required|date|after:now',
            'duration_hours' => 'required|numeric|min:0.5',
            'max_attendees' => 'required|integer|min:1',
            'price_jod' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'age_group' => 'required|string|max:50',
            'is_open_for_registration' => 'boolean',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $workshopData = $request->except(['image_path', 'gallery_images']);

        // Set default value for is_open_for_registration if not provided
        if (!isset($workshopData['is_open_for_registration'])) {
            $workshopData['is_open_for_registration'] = false;
        }

        // Extract time from the datetime picker and set it separately
        if (!empty($request->event_date)) {
            $dateTime = new \DateTime($request->event_date);
            $workshopData['event_time'] = $dateTime->format('H:i:s');
            // Keep event_date as is - Laravel will handle the date conversion

            // Set initial status based on event date
            $now = now();
            if ($dateTime > $now) {
                $workshopData['status'] = 'upcoming';
            } else {
                // If somehow creating an event in the past
                $workshopData['status'] = 'in_progress';
            }
        }

        $workshop = WorkshopEvent::create($workshopData);

        // Handle main image upload
        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('workshop-events', 'public');
            $workshop->image_path = $path;
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('workshop-events/gallery', 'public');
                $galleryPaths[] = $path;
            }
            $workshop->gallery_images = $galleryPaths;
        }

        $workshop->save();

        // Check if we need to redirect back to the workshop page
        if ($request->has('redirect_to') && $request->redirect_to === 'workshop') {
            // Use the workshop_id from the request or from the created event
            $workshopId = $request->input('workshop_id') ?? $workshop->workshop_id;

            if ($workshopId) {
                return redirect()->route('admin.workshops.show', $workshopId)
                    ->with('success', 'Workshop event created successfully.');
            }
        }

        return redirect()->route('admin.workshop-events.index')
            ->with('success', 'Workshop event created successfully.');
    }

    /**
     * Display the specified workshop event
     */
    public function show(WorkshopEvent $event, Request $request)
    {
        $event->loadCount([
            'registrations',
            'registrations as confirmed_count' => function ($query) {
                $query->where('status', 'confirmed');
            },
            'registrations as pending_count' => function ($query) {
                $query->where('status', 'pending');
            }
        ]);

        // Get registrations for this event with filtering and pagination
        $registrationsQuery = WorkshopRegistration::where('event_id', $event->id)
            ->with('user');

        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $registrationsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Apply status filter if provided
        if ($request->has('status') && !empty($request->status)) {
            $registrationsQuery->where('status', $request->status);
        }

        // Apply type filter if provided
        if ($request->has('type') && !empty($request->type)) {
            if ($request->type == 'user') {
                $registrationsQuery->whereNotNull('user_id');
            } elseif ($request->type == 'guest') {
                $registrationsQuery->whereNull('user_id');
            }
        }

        // Get paginated results
        $registrations = $registrationsQuery->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.workshop-events.show', compact('event', 'registrations'));
    }

    /**
     * Show the form for editing the specified workshop event
     */
    public function edit(WorkshopEvent $event)
    {
        $event->loadCount('registrations');

        // Get all workshop templates for dropdown
        $workshopTemplates = Workshop::where('is_active', true)->get();
        return view('admin.workshop-events.edit', compact('event', 'workshopTemplates'));
    }

    /**
     * Update the specified workshop event
     */
    public function update(Request $request, WorkshopEvent $event)
    {
        $request->validate([
            'workshop_id' => 'nullable|exists:workshops,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'duration_hours' => 'required|numeric|min:0.5',
            'price_jod' => 'required|numeric|min:0',
            'max_attendees' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'age_group' => 'required|string|max:50',
            'is_open_for_registration' => 'boolean',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_main_image' => 'nullable|boolean',
            'remove_gallery_images' => 'nullable|array',
            'remove_gallery_images.*' => 'nullable|integer',
        ]);

        $workshopData = $request->except([
            'image_path',
            'gallery_images',
            'remove_main_image',
            'remove_gallery_images'
        ]);

        // Only set is_open_for_registration to false if the field is present in the form but unchecked
        // If the field is not present in the request at all, keep the existing value
        if ($request->has('is_open_for_registration')) {
            $workshopData['is_open_for_registration'] = $request->boolean('is_open_for_registration');
        }

        // Extract time from the datetime picker and set it separately
        if (!empty($request->event_date)) {
            $dateTime = new \DateTime($request->event_date);
            $workshopData['event_time'] = $dateTime->format('H:i:s');
            // Keep event_date as is - Laravel will handle the date conversion
        }

        $event->update($workshopData);

        // Handle main image upload
        if ($request->hasFile('image_path')) {
            // Delete old image if exists
            if ($event->image_path && Storage::disk('public')->exists($event->image_path)) {
                Storage::disk('public')->delete($event->image_path);
            }

            // Upload new image
            $path = $request->file('image_path')->store('workshop-events', 'public');
            $event->image_path = $path;
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $galleryPaths = $event->gallery_images ?? [];

            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('workshop-events/gallery', 'public');
                $galleryPaths[] = $path;
            }

            $event->gallery_images = $galleryPaths;
        }

        // Remove main image if requested
        if ($request->boolean('remove_main_image') && $event->image_path) {
            if (Storage::disk('public')->exists($event->image_path)) {
                Storage::disk('public')->delete($event->image_path);
            }

            $event->image_path = null;
        }

        // Remove selected gallery images if requested
        if ($request->has('remove_gallery_images') && is_array($request->remove_gallery_images)) {
            $galleryImages = $event->gallery_images ?? [];
            $newGalleryImages = [];

            foreach ($galleryImages as $index => $imagePath) {
                if (!in_array($index, $request->remove_gallery_images)) {
                    $newGalleryImages[] = $imagePath;
                } else {
                    // Delete the image file
                    if (Storage::disk('public')->exists($imagePath)) {
                        Storage::disk('public')->delete($imagePath);
                    }
                }
            }

            $event->gallery_images = $newGalleryImages;
        }

        $event->save();

        return redirect()->route('admin.workshop-events.index')
            ->with('success', 'Workshop event updated successfully.');
    }

    /**
     * Remove the specified workshop event
     */
    public function destroy(WorkshopEvent $event)
    {
        // Check if there are any registrations
        if ($event->registrations()->exists()) {
            return redirect()->route('admin.workshop-events.index')
                ->with('error', 'Cannot delete workshop event with existing registrations. Please remove all registrations first.');
        }

        // Delete images if exists
        if ($event->image_path && Storage::disk('public')->exists($event->image_path)) {
            Storage::disk('public')->delete($event->image_path);
        }

        if ($event->gallery_images) {
            foreach ($event->gallery_images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $event->delete();

        return redirect()->route('admin.workshop-events.index')
            ->with('success', 'Workshop event deleted successfully.');
    }

    /**
     * Display the registrations for a specific workshop event
     *
     * @param  \App\Models\WorkshopEvent  $event
     * @return \Illuminate\Http\Response
     */
    public function viewRegistrations(WorkshopEvent $event)
    {
        // Load the registrations with user data
        $registrations = WorkshopRegistration::where('event_id', $event->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.workshop-events.registrations', compact('event', 'registrations'));
    }

    /**
     * Toggle the registration status of a workshop event
     *
     * @param  \App\Models\WorkshopEvent  $event
     * @return \Illuminate\Http\Response
     */
    public function toggleRegistration(WorkshopEvent $event)
    {
        // Toggle the registration status
        $event->is_open_for_registration = !$event->is_open_for_registration;
        $event->save();

        $status = $event->is_open_for_registration ? 'opened' : 'closed';

        return redirect()->back()
            ->with('success', "Registration for this event has been {$status}.");
    }

    /**
     * Display registrations for a specific workshop event
     */
    public function registrations(Request $request, WorkshopEvent $workshop)
    {
        $query = $workshop->registrations()->with('user');

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                // Search in guest fields
                $q->where('guest_name', 'like', "%{$search}%")
                    ->orWhere('guest_email', 'like', "%{$search}%")
                    ->orWhere('guest_phone', 'like', "%{$search}%")
                    // Search in user fields through relationship
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by type (user or guest)
        if ($request->has('type') && !empty($request->type)) {
            if ($request->type === 'user') {
                $query->whereNotNull('user_id');
            } elseif ($request->type === 'guest') {
                $query->whereNull('user_id');
            }
        }

        $registrations = $query->latest()->paginate(20)->withQueryString();

        return view('admin.workshop-events.registrations', compact('workshop', 'registrations'));
    }

    /**
     * Update the status of a workshop registration
     */
    public function updateRegistrationStatus(Request $request, WorkshopRegistration $registration)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,attended'
        ]);

        $registration->update(['status' => $request->status]);

        return back()->with('success', 'Registration status updated successfully.');
    }

    /**
     * Toggle the registration status of a workshop event
     * 
     * @param  \App\Models\WorkshopEvent  $workshop
     * @return \Illuminate\Http\Response
     */
    public function toggleRegistrationStatus(WorkshopEvent $workshop)
    {
        $workshop->is_open_for_registration = !$workshop->is_open_for_registration;
        $workshop->save();

        $status = $workshop->is_open_for_registration ? 'opened' : 'closed';

        return back()->with('success', "Registration for this event has been {$status}.");
    }

    /**
     * Remove a workshop registration
     *
     * @param  \App\Models\WorkshopRegistration  $registration
     * @return \Illuminate\Http\Response
     */
    public function destroyRegistration(WorkshopRegistration $registration)
    {
        // Store event ID before deleting for redirect
        $eventId = $registration->event_id;

        // Get registration info for success message
        $registrationInfo = $registration->user_id
            ? $registration->user->name
            : $registration->attendee_name;

        // Get the associated workshop event
        $event = $registration->event;

        // Delete the registration
        $registration->delete();

        // Update the current_attendees count in the workshop_events table
        if ($event) {
            $event->current_attendees = $event->registrations()->count();
            $event->save();
        }

        return back()->with('success', "Registration for {$registrationInfo} has been removed successfully.");
    }

    /**
     * Remove a specific image from a workshop event
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkshopEvent  $event
     * @return \Illuminate\Http\Response
     */
    public function removeImage(Request $request, WorkshopEvent $event)
    {
        $request->validate([
            'type' => 'required|string|in:main,gallery',
            'index' => 'required_if:type,gallery|nullable|integer|min:0',
        ]);

        $type = $request->type;
        $index = $request->index;
        $success = false;

        // Log request data for debugging
        Log::info('Remove image request', [
            'type' => $type,
            'index' => $index,
            'event_id' => $event->id,
            'image_path' => $event->image_path,
            'image_exists' => $event->image_path ? Storage::disk('public')->exists($event->image_path) : false
        ]);

        if ($type === 'main') {
            if ($event->image_path) {
                // Remove main image
                if (Storage::disk('public')->exists($event->image_path)) {
                    Storage::disk('public')->delete($event->image_path);
                    Log::info('Deleted image file: ' . $event->image_path);
                } else {
                    Log::warning('Image file not found: ' . $event->image_path);
                }
                $event->image_path = null;
                $success = true;
                Log::info('Set image_path to null');
            } else {
                Log::warning('No image_path found for event ID: ' . $event->id);
                // Still return success if there was no image to begin with
                $success = true;
            }
        } elseif ($type === 'gallery' && $event->gallery_images && is_array($event->gallery_images) && isset($event->gallery_images[$index])) {
            // Remove gallery image
            $galleryImages = $event->gallery_images;
            $imagePath = $galleryImages[$index];

            // Delete the image file
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
                Log::info('Deleted image file: ' . $imagePath);
            } else {
                Log::warning('Image file not found: ' . $imagePath);
            }

            // Remove from array and reindex
            unset($galleryImages[$index]);
            $event->gallery_images = array_values($galleryImages);
            $success = true;
            Log::info('Updated gallery images');
        }

        if ($success) {
            $event->save();
            return response()->json(['success' => true, 'message' => 'Image removed successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Failed to remove image'], 400);
    }
}
