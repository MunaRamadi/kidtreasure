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
            <li class="breadcrumb-item active">{{ $event->title }}</li>
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
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
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
                                                <div class="stat-number">{{ $event->registrations_count }}</div>
                                                <div>Registrations</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="stat-card bg-success text-white">
                                                <div class="stat-number">
                                                    {{ $event->max_attendees - $event->registrations_count }}
                                                </div>
                                                <div>Available Spots</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="stat-card bg-info text-white">
                                                <div class="stat-number">{{ $event->confirmed_count ?? 0 }}</div>
                                                <div>Confirmed</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="stat-card bg-warning text-white">
                                                <div class="stat-number">{{ $event->pending_count ?? 0 }}</div>
                                                <div>Pending</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        @if($event->is_open_for_registration)
                                            <form action="{{ route('admin.workshop-events.toggle-registration', $event) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                                    <i class="fas fa-lock"></i> Close Registration
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.workshop-events.toggle-registration', $event) }}"
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
                                    <h3>{{ $event->title }}</h3>

                                    @if($event->workshop_id)
                                        <div class="mb-3">
                                            <span class="badge bg-secondary">Part of Workshop Series:</span>
                                            <a href="{{ route('admin.workshops.show', $event->workshop_id) }}">
                                                {{ $event->workshop->title }}
                                            </a>
                                        </div>
                                    @endif

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="far fa-calendar"></i> Date:</strong></p>
                                            <p>{{ $event->event_date->format('Y-m-d') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="far fa-clock"></i> Time:</strong></p>
                                            <p>{{ $event->event_date->format('h:i A') }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="fas fa-users"></i> Max Attendees:</strong></p>
                                            <p>{{ $event->max_attendees }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="fas fa-money-bill"></i> Price:</strong></p>
                                            <p>{{ $event->price_jod }} JOD</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="fas fa-child"></i> Age Group:</strong></p>
                                            <p>{{ $event->workshop->target_age_group ?? 'Not specified' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="fas fa-hourglass-half"></i> Duration:</strong></p>
                                            <p>{{ $event->duration_hours ?? $event->workshop->duration_hours ?? '2' }} hours</p>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <p class="mb-1"><strong><i class="fas fa-align-left"></i> Description:</strong></p>
                                        <div class="p-3 bg-white rounded">
                                            {!! $event->description !!}
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0"><small class="text-muted">Created:
                                                    {{ $event->created_at->format('Y-m-d H:i') }}</small></p>
                                            <p class="mb-0"><small class="text-muted">Last Updated:
                                                    {{ $event->updated_at->format('Y-m-d H:i') }}</small></p>
                                        </div>



                                        <div>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal">
                                                <i class="fas fa-trash"></i> Remove Event
                                            </button>
                                            <a href="{{ route('admin.workshop-events.edit', $event) }}"
                                                class="btn btn-primary btn-sm me-2">
                                                <i class="fas fa-edit"></i> Edit Event
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

        <!-- Registrations Section -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-users me-1"></i>
                    Event Registrations
                </div>
                <div>
                    <span class="badge bg-info">{{ $registrations->total() }} / {{ $event->max_attendees }} Registered</span>
                </div>
            </div>
            <div class="card-body">
                <!-- Search and Filter Form -->
                <form action="{{ route('admin.workshop-events.show', $event) }}" method="GET" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by name or email..." name="search" value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="attended" {{ request('status') == 'attended' ? 'selected' : '' }}>Attended</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="type" class="form-select">
                                <option value="">All Types</option>
                                <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>Registered Users</option>
                                <option value="guest" {{ request('type') == 'guest' ? 'selected' : '' }}>Guests</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </form>

                <!-- Registrations Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Attendee Name</th>
                                <th>Parent Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $registration)
                                <tr>
                                    <td>{{ $registration->id }}</td>
                                    <td>
                                        @if($registration->user_id)
                                            <a href="{{ route('admin.users.show', $registration->user_id) }}">
                                                {{ $registration->user->name }} <i class="fas fa-user-check text-success" title="Registered User"></i>
                                            </a>
                                        @else
                                            {{ $registration->attendee_name }} <i class="fas fa-user text-secondary" title="Guest"></i>
                                        @endif
                                    </td>
                                    <td>{{ $registration->attendee_name ?? 'N/A' }}</td>
                                    <td>{{ $registration->parent_name ?? 'N/A' }}</td>
                                    <td>
                                        @if($registration->user_id)
                                            {{ $registration->user->email }}
                                        @else
                                            {{ $registration->attendee_email ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td>{{ $registration->parent_contact }}</td>
                                    <td>{{ $registration->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <span class="badge status-badge dropdown-toggle 
                                                @if($registration->status == 'confirmed') bg-success
                                                @elseif($registration->status == 'pending') bg-warning text-dark
                                                @elseif($registration->status == 'cancelled') bg-danger
                                                @elseif($registration->status == 'attended') bg-info
                                                @endif" 
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ ucfirst($registration->status) }}
                                            </span>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="pending">
                                                        <button type="submit" class="dropdown-item">Pending</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button type="submit" class="dropdown-item">Confirmed</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="dropdown-item">Cancelled</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="attended">
                                                        <button type="submit" class="dropdown-item">Attended</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $registration->id }}">
                                            <i class="fas fa-info-circle"></i> Details
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $registration->id }}">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Registration Details Modal -->
                                <div class="modal fade" id="detailsModal{{ $registration->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $registration->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailsModalLabel{{ $registration->id }}">Registration Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="registration-details">
                                                    <h5>Attendee Information</h5>
                                                    <dl class="row registration-info">
                                                        <dt class="col-sm-3">Registration ID:</dt>
                                                        <dd class="col-sm-9">{{ $registration->id }}</dd>
                                                        
                                                        <dt class="col-sm-3">Name:</dt>
                                                        <dd class="col-sm-9">
                                                            @if($registration->user_id)
                                                                {{ $registration->user->name }}
                                                            @else
                                                                {{ $registration->attendee_name }}
                                                            @endif
                                                        </dd>
                                                        
                                                        <dt class="col-sm-3">Attendee Name:</dt>
                                                        <dd class="col-sm-9">{{ $registration->attendee_name ?? 'N/A' }}</dd>
                                                        
                                                        <dt class="col-sm-3">Parent Name:</dt>
                                                        <dd class="col-sm-9">{{ $registration->parent_name ?? 'N/A' }}</dd>
                                                        
                                                        <dt class="col-sm-3">Email:</dt>
                                                        <dd class="col-sm-9">
                                                            @if($registration->user_id)
                                                                {{ $registration->user->email }}
                                                            @else
                                                                {{ $registration->attendee_email ?? 'N/A' }}
                                                            @endif
                                                        </dd>
                                                        
                                                        <dt class="col-sm-3">Phone:</dt>
                                                        <dd class="col-sm-9">{{ $registration->parent_contact }}</dd>
                                                        
                                                        <dt class="col-sm-3">Registration Type:</dt>
                                                        <dd class="col-sm-9">{{ $registration->user_id ? 'Registered User' : 'Guest' }}</dd>
                                                        
                                                        <dt class="col-sm-3">Registration Date:</dt>
                                                        <dd class="col-sm-9">{{ $registration->created_at->format('Y-m-d H:i:s') }}</dd>
                                                        
                                                        <dt class="col-sm-3">Status:</dt>
                                                        <dd class="col-sm-9">
                                                            <span class="badge 
                                                                @if($registration->status == 'confirmed') bg-success
                                                                @elseif($registration->status == 'pending') bg-warning text-dark
                                                                @elseif($registration->status == 'cancelled') bg-danger
                                                                @elseif($registration->status == 'attended') bg-info
                                                                @endif">
                                                                {{ ucfirst($registration->status) }}
                                                            </span>
                                                        </dd>
                                                        
                                                        @if($registration->special_requirements)
                                                            <dt class="col-sm-3">Special Requirements:</dt>
                                                            <dd class="col-sm-9">{{ $registration->special_requirements }}</dd>
                                                        @endif
                                                        
                                                        @if($registration->user_id)
                                                            <dt class="col-sm-3">User Account:</dt>
                                                            <dd class="col-sm-9">
                                                                <a href="{{ route('admin.users.show', $registration->user_id) }}">
                                                                    View User Profile <i class="fas fa-external-link-alt"></i>
                                                                </a>
                                                            </dd>
                                                        @endif
                                                    </dl>
                                                    
                                                    @if($registration->notes)
                                                        <h5 class="mt-4">Notes</h5>
                                                        <div class="p-3 bg-light rounded">
                                                            {{ $registration->notes }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Update Status
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="pending">
                                                                <button type="submit" class="dropdown-item">Pending</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="confirmed">
                                                                <button type="submit" class="dropdown-item">Confirmed</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="cancelled">
                                                                <button type="submit" class="dropdown-item">Cancelled</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="attended">
                                                                <button type="submit" class="dropdown-item">Attended</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No registrations found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $registrations->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

        <!-- Delete Event Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this workshop event: <strong>{{ $event->title }}</strong>?</p>
                        <p class="text-danger"><strong>Warning:</strong> This will also delete all registrations associated with
                            this event. This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.workshop-events.destroy', $event) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Event</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Registration Modals -->
        @foreach($registrations as $registration)
            <div class="modal fade" id="deleteModal{{ $registration->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $registration->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $registration->id }}">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to remove this registration?</p>
                            <p><strong>Name:</strong> 
                                @if($registration->user_id)
                                    {{ $registration->user->name }}
                                @else
                                    {{ $registration->attendee_name }}
                                @endif
                            </p>
                            <p><strong>Email:</strong> 
                                @if($registration->user_id)
                                    {{ $registration->user->email }}
                                @else
                                    {{ $registration->attendee_email ?? 'N/A' }}
                                @endif
                            </p>
                            <p class="text-danger">This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ route('admin.workshop-events.registrations.destroy', $registration->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Registration</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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