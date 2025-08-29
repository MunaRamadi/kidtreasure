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

        // Search by name (both English and Arabic)
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name_en', 'like', $searchTerm)
                  ->orWhere('name_ar', 'like', $searchTerm)
                  ->orWhere('description_en', 'like', $searchTerm)
                  ->orWhere('description_ar', 'like', $searchTerm);
            });
        }

        // Filter by target age group
        if ($request->has('age_group') && !empty($request->age_group)) {
            $query->where('target_age_group', 'like', '%' . $request->age_group . '%');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $workshopData = $request->except(['image']);
        
        // Set default value for is_active if not provided
        if (!isset($workshopData['is_active'])) {
            $workshopData['is_active'] = false;
        }
        
        $workshop = Workshop::create($workshopData);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('workshops', 'public');
            $workshop->image = $path; // Use image instead of image_path
        }
        
        $workshop->save();

        return redirect()->route('admin.workshops.index')
            ->with('snackbar', 'تم إنشاء ورشة جديدة بنجاح');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        $workshopData = $request->except([
            'image', 'remove_image'
        ]);
        
        // Set default value for is_active if not provided
        if (!isset($workshopData['is_active'])) {
            $workshopData['is_active'] = false;
        }

        $workshop->update($workshopData);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($workshop->image && Storage::disk('public')->exists($workshop->image)) {
                Storage::disk('public')->delete($workshop->image);
            }
            
            // Upload new image
            $path = $request->file('image')->store('workshops', 'public');
            $workshop->image = $path; // Use image instead of image_path
        }

        // Remove image if requested
        if ($request->boolean('remove_image') && $workshop->image) {
            if (Storage::disk('public')->exists($workshop->image)) {
                Storage::disk('public')->delete($workshop->image);
            }
            
            $workshop->image = null; // Use image instead of image_path
        }

        $workshop->save();

        return redirect()->route('admin.workshops.index')
            ->with('snackbar', 'تم تحديث الورشة بنجاح');
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
        
        // Delete image if exists
        if ($workshop->image && Storage::disk('public')->exists($workshop->image)) {
            Storage::disk('public')->delete($workshop->image);
        }
        
        // Then delete the workshop
        $workshop->delete();

        return redirect()->route('admin.workshops.index')
            ->with('snackbar', 'تم حذف الورشة بنجاح');
    }

    /**
     * Display all registrations for a workshop template.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function registrationsWorkshop(Workshop $workshop)
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

    /**
     * Remove an image from a workshop via AJAX
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function removeImage(Request $request, Workshop $workshop)
    {
        // Validate request
        $request->validate([
            'type' => 'required|string|in:main',
        ]);

        $success = false;

        if ($workshop->image) {
            // Delete the image file from storage
            if (Storage::disk('public')->exists($workshop->image)) {
                Storage::disk('public')->delete($workshop->image);
            }
            
            // Update the workshop record
            $workshop->image = null; // Use image instead of image_path
            $workshop->save();
            $success = true;
        } else {
            // If there was no image to begin with, still return success
            $success = true;
        }

        if ($success) {
            return response()->json(['success' => true, 'message' => 'تم حذف الصورة بنجاح']);
        }

        return response()->json(['success' => false, 'message' => 'فشل حذف الصورة'], 400);
    }
}