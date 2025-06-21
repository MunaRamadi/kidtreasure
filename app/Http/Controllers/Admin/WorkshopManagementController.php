<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopManagementController extends Controller
{
    /**
     * Constructor to apply middleware
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of workshops with search, filtering and pagination.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
     * Show the form for creating a new workshop.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.workshops.create');
    }

    /**
     * Store a newly created workshop in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'target_age_group' => 'required|string|max:50',
            'is_active' => 'boolean',
        ]);

        Workshop::create($validated);

        return redirect()->route('admin.workshops.index')
            ->with('success', 'Workshop created successfully.');
    }

    /**
     * Display the specified workshop.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function show(Workshop $workshop)
    {
        // Load the workshop with its events and recent registrations
        $workshop->load(['events' => function($query) {
            $query->orderBy('event_date', 'asc');
        }, 'events.registrations']);

        return view('admin.workshops.show', compact('workshop'));
    }

    /**
     * Show the form for editing the specified workshop.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function edit(Workshop $workshop)
    {
        // Load the workshop with its events
        $workshop->load(['events' => function($query) {
            $query->orderBy('event_date', 'asc');
        }]);

        return view('admin.workshops.edit', compact('workshop'));
    }

    /**
     * Update the specified workshop in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workshop $workshop)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'target_age_group' => 'required|string|max:50',
            'is_active' => 'boolean',
        ]);

        $workshop->update($validated);

        return redirect()->route('admin.workshops.show', $workshop)
            ->with('success', 'Workshop updated successfully.');
    }

    /**
     * Remove the specified workshop from storage.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workshop $workshop)
    {
        // Check if there are any events with registrations
        $hasRegistrations = $workshop->events()->whereHas('registrations')->exists();

        if ($hasRegistrations) {
            return redirect()->route('admin.workshops.show', $workshop)
                ->with('error', 'Cannot delete workshop with existing registrations.');
        }

        // Delete all associated events first
        $workshop->events()->delete();
        
        // Then delete the workshop
        $workshop->delete();

        return redirect()->route('admin.workshops.index')
            ->with('success', 'Workshop deleted successfully.');
    }

    /**
     * Display all registrations for a workshop.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function registrations(Workshop $workshop)
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
