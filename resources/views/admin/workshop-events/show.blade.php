@extends('admin.layouts.app')

@section('title', 'Workshop Event Details')

@section('styles')
    <style>
        .event-image {
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }

        .event-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .event-stats {
            background-color: #e9ecef;
            border-radius: 8px;
            padding: 15px;
        }

        .stat-card {
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
        }

        .stat-label {
            font-size: 14px;
            color: #6c757d;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Workshop Event Details</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.workshop-events.index') }}">Workshop Events</a></li>
            <li class="breadcrumb-item active">{{ $workshop->title }}</li>
        </ol>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-calendar-alt me-1"></i>
                            Event Details
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if($workshop->image)
                                    <img src="{{ asset('storage/' . $workshop->image) }}" alt="{{ $workshop->title }}"
                                        class="img-fluid event-image w-100 mb-3">
                                @else
                                    <div
                                        class="bg-light d-flex justify-content-center align-items-center event-image w-100 mb-3">
                                        <span class="text-muted">No image available</span>
                                    </div>
                                @endif

                                <div class="event-stats">
                                    <h5 class="mb-3">Event Statistics</h5>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="stat-card bg-primary text-white">
                                                <div class="stat-number">{{ $workshop->registrations_count }}</div>
                                                <div class="stat-label">Registrations</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="stat-card bg-success text-white">
                                                <div class="stat-number">
                                                    {{ $workshop->max_attendees - $workshop->registrations_count }}
                                                </div>
                                                <div class="stat-label">Available Spots</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="stat-card bg-info text-white">
                                                <div class="stat-number">{{ $workshop->confirmed_count ?? 0 }}</div>
                                                <div class="stat-label">Confirmed</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="stat-card bg-warning text-white">
                                                <div class="stat-number">{{ $workshop->pending_count ?? 0 }}</div>
                                                <div class="stat-label">Pending</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        @if($workshop->is_open_for_registration)
                                            <form action="{{ route('admin.workshop-events.toggle-registration', $workshop) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                                    <i class="fas fa-lock"></i> Close Registration
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.workshop-events.toggle-registration', $workshop) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm w-100">
                                                    <i class="fas fa-lock-open"></i> Open Registration
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="event-details">
                                    <h3>{{ $workshop->title }}</h3>

                                    @if($workshop->workshop_id)
                                        <div class="mb-3">
                                            <span class="badge bg-secondary">Part of Workshop Series:</span>
                                            <a href="{{ route('admin.workshops.show', $workshop->workshop_id) }}">
                                                {{ $workshop->workshop->title }}
                                            </a>
                                        </div>
                                    @endif

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="far fa-calendar"></i> Date:</strong></p>
                                            <p>{{ $workshop->event_date->format('Y-m-d') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="far fa-clock"></i> Time:</strong></p>
                                            <p>{{ $workshop->event_date->format('h:i A') }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="fas fa-hourglass-half"></i> Duration:</strong>
                                            </p>
                                            <p>{{ $workshop->duration_hours }} hours</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="fas fa-map-marker-alt"></i> Location:</strong>
                                            </p>
                                            <p>{{ $workshop->location }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="fas fa-users"></i> Max Attendees:</strong></p>
                                            <p>{{ $workshop->max_attendees }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="fas fa-tag"></i> Price:</strong></p>
                                            <p>{{ $workshop->price_jod }} JOD</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="fas fa-child"></i> Age Group:</strong></p>
                                            <p>{{ $workshop->age_group }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="fas fa-toggle-on"></i> Status:</strong></p>
                                            <p>
                                                @if($workshop->is_open_for_registration)
                                                    <span class="badge bg-success">Open for Registration</span>
                                                @else
                                                    <span class="badge bg-danger">Closed</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <p class="mb-1"><strong><i class="fas fa-align-left"></i> Description:</strong></p>
                                        <div class="p-3 bg-white rounded">
                                            {!! $workshop->description !!}
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0"><small class="text-muted">Created:
                                                    {{ $workshop->created_at->format('Y-m-d H:i') }}</small></p>
                                            <p class="mb-0"><small class="text-muted">Last Updated:
                                                    {{ $workshop->updated_at->format('Y-m-d H:i') }}</small></p>
                                        </div>



                                        <div>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal">
                                                <i class="fas fa-trash"></i> Remove Event
                                            </button>
                                            <a href="{{ route('admin.workshop-events.edit', $workshop) }}"
                                                class="btn btn-primary btn-sm me-2">
                                                <i class="fas fa-edit"></i> Edit Event
                                            </a>
                                            <a href="{{ route('admin.workshop-events.registrations', $workshop) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-users"></i> View Registrations
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Registrations Section -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-user-check me-1"></i>
                    Recent Registrations
                </div>
                <a href="{{ route('admin.workshop-events.registrations', $workshop) }}" class="btn btn-sm btn-primary">
                    View All
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Registered On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentRegistrations as $registration)
                                <tr>
                                    <td>
                                        @if($registration->user_id)
                                            <a href="{{ route('admin.users.show', $registration->user_id) }}">
                                                {{ $registration->user->name }}
                                            </a>
                                        @else
                                            {{ $registration->guest_name }}
                                        @endif
                                    </td>
                                    <td>{{ $registration->user_id ? $registration->user->email : $registration->guest_email }}
                                    </td>
                                    <td>
                                        @if($registration->user_id)
                                            <span class="badge bg-primary">User</span>
                                        @else
                                            <span class="badge bg-secondary">Guest</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge 
                                                        @if($registration->status == 'confirmed') bg-success 
                                                        @elseif($registration->status == 'pending') bg-warning 
                                                        @elseif($registration->status == 'cancelled') bg-danger 
                                                        @elseif($registration->status == 'attended') bg-info 
                                                        @endif">
                                            {{ ucfirst($registration->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $registration->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No registrations yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
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
                    <p>Are you sure you want to delete this workshop event: <strong>{{ $workshop->title }}</strong>?</p>
                    <p class="text-danger"><strong>Warning:</strong> This will also delete all registrations associated with
                        this event. This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.workshop-events.destroy', $workshop) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Auto-close alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                const alerts = document.querySelectorAll('.alert-dismissible');
                alerts.forEach(function (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
@endsection