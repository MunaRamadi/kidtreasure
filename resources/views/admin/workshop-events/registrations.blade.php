@extends('admin.layouts.app')

@section('title', 'Event Registrations')

@section('styles')
<style>
    .status-badge {
        cursor: pointer;
    }
    .registration-details {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 15px;
    }
    .registration-info {
        margin-bottom: 0;
    }
    .registration-info dt {
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Event Registrations</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.workshop-events.index') }}">Workshop Events</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.workshop-events.show', $event) }}">{{ $event->title }}</a></li>
        <li class="breadcrumb-item active">Registrations</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-users me-1"></i>
                Registrations for: {{ $event->title }}
            </div>
            <div>
                <span class="badge bg-info">{{ $registrations->total() }} / {{ $event->max_attendees }} Registered</span>
            </div>
        </div>
        <div class="card-body">
            <!-- Event Summary -->
            <div class="alert alert-info mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <strong>Date:</strong> {{ $event->event_date->format('Y-m-d') }} at {{ $event->event_date->format('h:i A') }}
                    </div>
                    <div class="col-md-4">
                        <strong>Duration:</strong> {{ $event->duration_hours }} hours
                    </div>
                    <div class="col-md-4">
                        <strong>Location:</strong> {{ $event->location }}
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <strong>Price:</strong> {{ $event->price_jod }} JOD
                    </div>
                    <div class="col-md-4">
                        <strong>Age Group:</strong> {{ $event->age_group }}
                    </div>
                    <div class="col-md-4">
                        <strong>Status:</strong>
                        @if($event->is_open_for_registration)
                            <span class="badge bg-success">Open for Registration</span>
                        @else
                            <span class="badge bg-danger">Closed</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Search and Filter Form -->
            <form action="{{ route('admin.workshop-events.registrations', $event) }}" method="GET" class="mb-4">
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

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

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
                                            {{ $registration->user->name }}
                                        </a>
                                        <span class="badge bg-primary">User</span>
                                    @else
                                        {{ $registration->attendee_name }}
                                        <span class="badge bg-secondary">Guest</span>
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
                                                    
                                                    @if($registration->event)
                                                        <dt class="col-sm-3">Event:</dt>
                                                        <dd class="col-sm-9">
                                                            <a href="{{ route('admin.workshop-events.show', $registration->event_id) }}">
                                                                {{ $registration->event->title }}
                                                            </a>
                                                        </dd>
                                                    @endif
                                                </dl>
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
                            
                            <!-- Delete Registration Modal -->
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
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No registrations found</td>
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
</div>
@endsection

@section('scripts')
<script>
    // Auto-close alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endsection
