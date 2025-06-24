<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Workshop;
use App\Models\WorkshopEvent;
use App\Models\WorkshopRegistration;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkshopsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of workshop templates/categories with search, filtering and pagination.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function indexWorkshops(Request $request)
    {
        $query = Workshop::query();

        // Search by name
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name_en', 'like', $searchTerm)
                  ->orWhere('name_ar', 'like', $searchTerm);
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('is_active', $status);
        }

        // Sort results
        $sortField = 'created_at';
        $sortDirection = 'desc';

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'name_asc':
                    $sortField = 'name_en';
                    $sortDirection = 'asc';
                    break;
                case 'name_desc':
                    $sortField = 'name_en';
                    $sortDirection = 'desc';
                    break;
                case 'oldest':
                    $sortField = 'created_at';
                    $sortDirection = 'asc';
                    break;
                case 'latest':
                default:
                    $sortField = 'created_at';
                    $sortDirection = 'desc';
                    break;
            }
        }

        $query->orderBy($sortField, $sortDirection);

        // Get workshops with their events count
        $workshops = $query->withCount('events')->paginate(10)->withQueryString();

        return view('admin.workshops.index', compact('workshops'));
    }

    /**
     * Show the form for creating a new workshop template.
     *
     * @return \Illuminate\Http\Response
     */
    public function createWorkshop()
    {
        return view('admin.workshops.create');
    }

    /**
     * Store a newly created workshop template in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeWorkshop(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'target_age_group' => 'required|string|max:50',
            'is_active' => 'boolean',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $workshopData = $request->except(['image_path', 'featured_image_path', 'gallery_images']);
        
        // Set default value for is_active if not provided
        if (!isset($workshopData['is_active'])) {
            $workshopData['is_active'] = false;
        }
        
        $workshop = Workshop::create($workshopData);
        
        // Handle main image upload
        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('workshops', 'public');
            $workshop->image_path = $path;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image_path')) {
            $path = $request->file('featured_image_path')->store('workshops', 'public');
            $workshop->featured_image_path = $path;
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('workshops/gallery', 'public');
                $galleryPaths[] = $path;
            }
            $workshop->gallery_images = $galleryPaths;
        }
        
        $workshop->save();

        return redirect()->route('admin.workshops.index')
            ->with('success', 'Workshop template created successfully.');
    }

    /**
     * Display the specified workshop template.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function showWorkshop(Workshop $workshop)
    {
        // Load the workshop with its events and recent registrations
        $workshop->load(['events' => function($query) {
            $query->orderBy('event_date', 'asc');
        }, 'events.registrations']);

        return view('admin.workshops.show', compact('workshop'));
    }

    /**
     * Show the form for editing the specified workshop template.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function editWorkshop(Workshop $workshop)
    {
        // Load the workshop with its events
        $workshop->load(['events' => function($query) {
            $query->orderBy('event_date', 'asc');
        }]);

        return view('admin.workshops.edit', compact('workshop'));
    }

    /**
     * Update the specified workshop template in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function updateWorkshop(Request $request, Workshop $workshop)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'target_age_group' => 'required|string|max:50',
            'is_active' => 'boolean',
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
        
        // Set default value for is_active if not provided
        if (!isset($workshopData['is_active'])) {
            $workshopData['is_active'] = false;
        }

        $workshop->update($workshopData);

        // Handle main image upload
        if ($request->hasFile('image_path')) {
            // Delete old image if exists
            if ($workshop->image_path && Storage::disk('public')->exists($workshop->image_path)) {
                Storage::disk('public')->delete($workshop->image_path);
            }
            
            // Upload new image
            $path = $request->file('image_path')->store('workshops', 'public');
            $workshop->image_path = $path;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image_path')) {
            // Delete old image if exists
            if ($workshop->featured_image_path && Storage::disk('public')->exists($workshop->featured_image_path)) {
                Storage::disk('public')->delete($workshop->featured_image_path);
            }
            
            // Upload new image
            $path = $request->file('featured_image_path')->store('workshops', 'public');
            $workshop->featured_image_path = $path;
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $galleryPaths = $workshop->gallery_images ?? [];
            
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('workshops/gallery', 'public');
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

        return redirect()->route('admin.workshops.show', $workshop)
            ->with('success', 'Workshop template updated successfully.');
    }

    /**
     * Remove the specified workshop template from storage.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function destroyWorkshop(Workshop $workshop)
    {
        // Check if there are any events with registrations
        $hasRegistrations = $workshop->events()->whereHas('registrations')->exists();

        if ($hasRegistrations) {
            return redirect()->route('admin.workshops.show', $workshop)
                ->with('error', 'Cannot delete workshop template with existing registrations.');
        }

        // Delete all associated events first
        $workshop->events()->delete();
        
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
        
        // Then delete the workshop
        $workshop->delete();

        return redirect()->route('admin.workshops.index')
            ->with('success', 'Workshop template deleted successfully.');
    }

    /**
     * Display all registrations for a workshop template.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function workshopRegistrations(Workshop $workshop)
    {
        // Get all events for this workshop
        $workshop->load('events');
        
        // Get all registrations across all events
        $registrations = $workshop->events->flatMap->registrations->sortByDesc('created_at');
        
        // Paginate the collection manually
        $page = request()->get('page', 1);
        $perPage = 20;
        $registrations = new \Illuminate\Pagination\LengthAwarePaginator(
            $registrations->forPage($page, $perPage),
            $registrations->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.workshops.registrations', compact('workshop', 'registrations'));
    }
}