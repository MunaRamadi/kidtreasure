@extends('admin.layouts.app')

@section('title', 'Workshop Details')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Workshop Details</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.workshops.index') }}">Workshops</a></li>
        <li class="breadcrumb-item active">{{ $workshop->name_en }}</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Workshop Information Card -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-info-circle me-1"></i>
                        Workshop Information
                    </div>
                    <div>
                        <a href="{{ route('admin.workshops.edit', $workshop) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>English Name</h5>
                            <p>{{ $workshop->name_en }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Arabic Name</h5>
                            <p dir="rtl" class="text-end">{{ $workshop->name_ar }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5>Status</h5>
                            @if($workshop->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5>Target Age Group</h5>
                            <p>{{ $workshop->target_age_group }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5>English Description</h5>
                            <div class="border rounded p-3 bg-light">
                                {{ $workshop->description_en }}
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5>Arabic Description</h5>
                            <div class="border rounded p-3 bg-light" dir="rtl">
                                {{ $workshop->description_ar }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Created At</h5>
                            <p>{{ $workshop->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Last Updated</h5>
                            <p>{{ $workshop->updated_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Workshop Events Card -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-calendar me-1"></i>
                        Workshop Events
                    </div>
                    <a href="#" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Add Event
                    </a>
                </div>
                <div class="card-body">
                    @if($workshop->events->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Location</th>
                                        <th>Price (JOD)</th>
                                        <th>Attendees</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workshop->events as $event)
                                        <tr>
                                            <td>{{ $event->event_date->format('Y-m-d') }}</td>
                                            <td>{{ $event->event_time->format('H:i') }}</td>
                                            <td>{{ $event->location }}</td>
                                            <td>{{ number_format($event->price_jod, 2) }}</td>
                                            <td>
                                                {{ $event->current_attendees }} / {{ $event->max_attendees }}
                                                <div class="progress mt-1" style="height: 5px;">
                                                    <div class="progress-bar bg-info" role="progressbar" 
                                                        style="width: {{ ($event->current_attendees / $event->max_attendees) * 100 }}%;" 
                                                        aria-valuenow="{{ $event->current_attendees }}" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="{{ $event->max_attendees }}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($event->is_open_for_registration)
                                                    <span class="badge bg-success">Open</span>
                                                @else
                                                    <span class="badge bg-danger">Closed</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.workshops.registrations', $event) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-users"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No events have been scheduled for this workshop yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-users me-1"></i>
            Recent Registrations
        </div>
        <div class="card-body">
            @if($workshop->events->flatMap->registrations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Event Date</th>
                                <th>Attendee Name</th>
                                <th>Parent Name</th>
                                <th>Contact</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                                <th>Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($workshop->events->flatMap->registrations->take(10) as $registration)
                                <tr>
                                    <td>{{ $registration->event->event_date->format('Y-m-d') }}</td>
                                    <td>{{ $registration->attendee_name }}</td>
                                    <td>{{ $registration->parent_name }}</td>
                                    <td>{{ $registration->parent_contact }}</td>
                                    <td>{{ $registration->registration_date->format('Y-m-d') }}</td>
                                    <td>
                                        @if($registration->status == 'confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @elseif($registration->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($registration->payment_status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($registration->payment_status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($registration->payment_status == 'not_applicable')
                                            <span class="badge bg-secondary">N/A</span>
                                        @else
                                            <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($workshop->events->flatMap->registrations->count() > 10)
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.workshops.registrations', $workshop) }}" class="btn btn-primary">
                            View All Registrations
                        </a>
                    </div>
                @endif
            @else
                <div class="alert alert-info">
                    No registrations found for this workshop.
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the workshop "{{ $workshop->name_en }}"? This will also delete all associated events and registrations.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.workshops.destroy', $workshop) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-close alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-success');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endsection