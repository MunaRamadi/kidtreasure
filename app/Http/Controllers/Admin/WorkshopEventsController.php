<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workshop;
use App\Models\WorkshopEvent;
use App\Models\WorkshopRegistration;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        // Search by workshop name
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->whereHas('workshop', function($q) use ($searchTerm) {
                $q->where('name_en', 'like', $searchTerm)
                  ->orWhere('name_ar', 'like', $searchTerm);
            });
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
    public function create()
    {
        // Get all workshop templates for dropdown
        $workshopTemplates = Workshop::where('is_active', true)->get();
        return view('admin.workshop-events.create', compact('workshopTemplates'));
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
            'featured_image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $workshopData = $request->except(['image_path', 'featured_image_path', 'gallery_images']);
        
        // Set default value for is_open_for_registration if not provided
        if (!isset($workshopData['is_open_for_registration'])) {
            $workshopData['is_open_for_registration'] = false;
        }

        // Extract time from the datetime picker and set it separately
        if (!empty($request->event_date)) {
            $dateTime = new \DateTime($request->event_date);
            $workshopData['event_time'] = $dateTime->format('H:i:s');
            // Keep event_date as is - Laravel will handle the date conversion
        }

        $workshop = WorkshopEvent::create($workshopData);

        // Handle main image upload
        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('workshop-events', 'public');
            $workshop->image_path = $path;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image_path')) {
            $path = $request->file('featured_image_path')->store('workshop-events', 'public');
            $workshop->featured_image_path = $path;
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

        return redirect()->route('admin.workshop-events.index')
            ->with('success', 'Workshop event created successfully.');
    }

    /**
     * Display the specified workshop event
     */
    public function show(WorkshopEvent $workshop)
    {
        $workshop->loadCount(['registrations', 
            'registrations as confirmed_count' => function ($query) {
                $query->where('status', 'confirmed');
            },
            'registrations as pending_count' => function ($query) {
                $query->where('status', 'pending');
            }
        ]);
        
        // Get recent registrations for this event
        $recentRegistrations = $workshop->registrations()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
            
        return view('admin.workshop-events.show', compact('workshop', 'recentRegistrations'));
    }

    /**
     * Show the form for editing the specified workshop event
     */
    public function edit(WorkshopEvent $workshop)
    {
        $workshop->loadCount('registrations');
        
        // Get all workshop templates for dropdown
        $workshopTemplates = Workshop::where('is_active', true)->get();
        return view('admin.workshop-events.edit', compact('workshop', 'workshopTemplates'));
    }

    /**
     * Update the specified workshop event
     */
    public function update(Request $request, WorkshopEvent $workshop)
    {
        $request->validate([
            'workshop_id' => 'nullable|exists:workshops,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
            'price_jod' => 'required|numeric|min:0',
            'max_attendees' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'age_group' => 'required|string|max:50',
            'is_open_for_registration' => 'boolean',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_main_image' => 'nullable|boolean',
            'remove_featured_image' => 'nullable|boolean',
            'remove_gallery_images' => 'nullable|array',
            'remove_gallery_images.*' => 'nullable|integer',
        ]);

        $workshopData = $request->except([
            'image_path', 'featured_image_path', 'gallery_images', 
            'remove_main_image', 'remove_featured_image', 'remove_gallery_images'
        ]);
        
        // Set default value for is_open_for_registration if not provided
        if (!isset($workshopData['is_open_for_registration'])) {
            $workshopData['is_open_for_registration'] = false;
        }

        // Extract time from the datetime picker and set it separately
        if (!empty($request->event_date)) {
            $dateTime = new \DateTime($request->event_date);
            $workshopData['event_time'] = $dateTime->format('H:i:s');
            // Keep event_date as is - Laravel will handle the date conversion
        }

        $workshop->update($workshopData);

        // Handle main image upload
        if ($request->hasFile('image_path')) {
            // Delete old image if exists
            if ($workshop->image_path && Storage::disk('public')->exists($workshop->image_path)) {
                Storage::disk('public')->delete($workshop->image_path);
            }
            
            // Upload new image
            $path = $request->file('image_path')->store('workshop-events', 'public');
            $workshop->image_path = $path;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image_path')) {
            // Delete old image if exists
            if ($workshop->featured_image_path && Storage::disk('public')->exists($workshop->featured_image_path)) {
                Storage::disk('public')->delete($workshop->featured_image_path);
            }
            
            // Upload new image
            $path = $request->file('featured_image_path')->store('workshop-events', 'public');
            $workshop->featured_image_path = $path;
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $galleryPaths = $workshop->gallery_images ?? [];
            
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('workshop-events/gallery', 'public');
                $galleryPaths[] = $path;
            }
            
            $workshop->gallery_images = $galleryPaths;
        }

        // Remove main image if requested
        if ($request->boolean('remove_main_image') && $workshop->image_path) {
            if (Storage::disk('public')->exists($workshop->image_path)) {
                Storage::disk('public')->delete($workshop->image_path);
            }
            
            $workshop->image_path = null;
        }

        // Remove featured image if requested
        if ($request->boolean('remove_featured_image') && $workshop->featured_image_path) {
            if (Storage::disk('public')->exists($workshop->featured_image_path)) {
                Storage::disk('public')->delete($workshop->featured_image_path);
            }
            
            $workshop->featured_image_path = null;
        }

        // Remove selected gallery images if requested
        if ($request->has('remove_gallery_images') && is_array($request->remove_gallery_images)) {
            $galleryImages = $workshop->gallery_images ?? [];
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
            
            $workshop->gallery_images = $newGalleryImages;
        }

        $workshop->save();

        return redirect()->route('admin.workshop-events.show', $workshop)
            ->with('success', 'Workshop event updated successfully.');
    }

    /**
     * Remove the specified workshop event
     */
    public function destroy(WorkshopEvent $workshop)
    {
        // Check if there are any registrations
        if ($workshop->registrations()->exists()) {
            return redirect()->route('admin.workshop-events.index')
                ->with('error', 'Cannot delete workshop event with existing registrations. Please remove all registrations first.');
        }
        
        // Delete images if exists
        if ($workshop->image_path && Storage::disk('public')->exists($workshop->image_path)) {
            Storage::disk('public')->delete($workshop->image_path);
        }
        
        if ($workshop->featured_image_path && Storage::disk('public')->exists($workshop->featured_image_path)) {
            Storage::disk('public')->delete($workshop->featured_image_path);
        }
        
        if ($workshop->gallery_images) {
            foreach ($workshop->gallery_images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
        
        $workshop->delete();

        return redirect()->route('admin.workshop-events.index')
            ->with('success', 'Workshop event deleted successfully.');
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
            $query->where(function($q) use ($search) {
                // Search in guest fields
                $q->where('guest_name', 'like', "%{$search}%")
                  ->orWhere('guest_email', 'like', "%{$search}%")
                  ->orWhere('guest_phone', 'like', "%{$search}%")
                  // Search in user fields through relationship
                  ->orWhereHas('user', function($userQuery) use ($search) {
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
}
