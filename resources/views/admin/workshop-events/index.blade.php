@extends('admin.layouts.app')

@section('title', 'Workshop Events')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Workshop Events</h1>
        <a href="{{ route('admin.workshop-events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Event
        </a>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.workshop-events.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                        placeholder="Search by title" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label for="date_from" class="form-label">Date From</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" 
                        value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label for="date_to" class="form-label">Date To</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" 
                        value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Registration Status</label>
                    <select class="form-select form-control" id="status" name="status">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="sort" class="form-label">Sort By</label>
                    <select class="form-select form-control" id="sort" name="sort">
                        <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Date (Newest)</option>
                        <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Date (Oldest)</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title (A-Z)</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title (Z-A)</option>
                        <option value="registrations" {{ request('sort') == 'registrations' ? 'selected' : '' }}>Most Registrations</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Workshop Events Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Workshop Events</h6>
        </div>
        <div class="card-body">
            @if($workshops->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Price (JOD)</th>
                                <th>Registrations</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($workshops as $workshop)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.workshop-events.show', $workshop) }}">
                                            {{ $workshop->title }}
                                        </a>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($workshop->event_date)->format('d M Y, h:i A') }}</td>
                                    <td>{{ $workshop->location }}</td>
                                    <td>{{ number_format($workshop->price_jod, 2) }}</td>
                                    <td>
                                        <a href="{{ route('admin.workshop-events.registrations', $workshop) }}">
                                            {{ $workshop->registrations_count }} / {{ $workshop->max_attendees }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($workshop->is_open_for_registration)
                                            <span class="badge bg-success text-white">Open</span>
                                        @else
                                            <span class="badge bg-danger text-white">Closed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.workshop-events.show', $workshop) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.workshop-events.edit', $workshop) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $workshop->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $workshop->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $workshop->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $workshop->id }}">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete the event "{{ $workshop->title }}"?
                                                        @if($workshop->registrations_count > 0)
                                                            <div class="alert alert-warning mt-3">
                                                                <i class="fas fa-exclamation-triangle"></i> This event has {{ $workshop->registrations_count }} registrations. You must remove all registrations before deleting this event.
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('admin.workshop-events.destroy', $workshop) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $workshops->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    No workshop events found. <a href="{{ route('admin.workshop-events.create') }}">Create your first workshop event</a>.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize date pickers if needed
        if ($.fn.flatpickr) {
            $("#date_from, #date_to").flatpickr({
                dateFormat: "Y-m-d",
            });
        }
    });
</script>
@endsection
