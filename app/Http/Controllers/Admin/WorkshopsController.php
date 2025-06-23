<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
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
            'is_open_for_registration' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $workshop = WorkshopEvent::create($request->all());

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $imageFile) {
                $path = $imageFile->store('workshops', 'public');
                
                $image = new Image([
                    'image_path' => $path,
                    'workshop_event_id' => $workshop->id,
                    'sort_order' => $index,
                    'is_main' => ($index === 0) // First image is the main image
                ]);
                
                $image->save();
            }
        }

        return redirect()->route('admin.workshops.index')
            ->with('success', 'تم إضافة الورشة بنجاح');
    }

    public function show(WorkshopEvent $workshop)
    {
        $workshop->load(['registrations.user', 'images']);
        return view('admin.workshops.show', compact('workshop'));
    }

    public function edit(WorkshopEvent $workshop)
    {
        $workshop->load('images');
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
            'is_open_for_registration' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:images,id'
        ]);

        $workshop->update($request->all());

        // Delete images if requested
        if ($request->has('delete_images')) {
            $imagesToDelete = Image::whereIn('id', $request->delete_images)
                ->where('workshop_event_id', $workshop->id)
                ->get();
                
            foreach ($imagesToDelete as $image) {
                // Delete the file from storage
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                
                // Delete the database record
                $image->delete();
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $currentMaxOrder = $workshop->images()->max('sort_order') ?? -1;
            
            foreach ($request->file('images') as $index => $imageFile) {
                $path = $imageFile->store('workshops', 'public');
                
                $image = new Image([
                    'image_path' => $path,
                    'workshop_event_id' => $workshop->id,
                    'sort_order' => $currentMaxOrder + $index + 1,
                    'is_main' => false // New uploads are not main by default
                ]);
                
                $image->save();
            }
        }

        return redirect()->route('admin.workshops.index')
            ->with('success', 'تم تحديث الورشة بنجاح');
    }

    public function destroy(WorkshopEvent $workshop)
    {
        // Delete associated images from storage
        foreach ($workshop->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }
        
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
    
    /**
     * Update the main image for a workshop event
     */
    public function setMainImage(Request $request, WorkshopEvent $workshop)
    {
        $request->validate([
            'image_id' => 'required|exists:images,id'
        ]);
        
        // Reset all images to not main
        $workshop->images()->update(['is_main' => false]);
        
        // Set the selected image as main
        Image::where('id', $request->image_id)
            ->where('workshop_event_id', $workshop->id)
            ->update(['is_main' => true]);
            
        return back()->with('success', 'تم تعيين الصورة الرئيسية بنجاح');
    }
    
    /**
     * Update the sort order of images
     */
    public function updateImageOrder(Request $request, WorkshopEvent $workshop)
    {
        $request->validate([
            'image_order' => 'required|array',
            'image_order.*' => 'integer|exists:images,id'
        ]);
        
        foreach ($request->image_order as $index => $imageId) {
            Image::where('id', $imageId)
                ->where('workshop_event_id', $workshop->id)
                ->update(['sort_order' => $index]);
        }
        
        return response()->json(['success' => true]);
    }
}