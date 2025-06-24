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
        <li class="breadcrumb-item"><a href="{{ route('admin.workshop-events.show', $workshop) }}">{{ $workshop->title }}</a></li>
        <li class="breadcrumb-item active">Registrations</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-users me-1"></i>
                Registrations for: {{ $workshop->title }}
            </div>
            <div>
                <span class="badge bg-info">{{ $registrations->total() }} / {{ $workshop->max_attendees }} Registered</span>
            </div>
        </div>
        <div class="card-body">
            <!-- Event Summary -->
            <div class="alert alert-info mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <strong>Date:</strong> {{ $workshop->event_date->format('Y-m-d') }} at {{ $workshop->event_date->format('h:i A') }}
                    </div>
                    <div class="col-md-4">
                        <strong>Duration:</strong> {{ $workshop->duration_hours }} hours
                    </div>
                    <div class="col-md-4">
                        <strong>Location:</strong> {{ $workshop->location }}
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <strong>Price:</strong> {{ $workshop->price_jod }} JOD
                    </div>
                    <div class="col-md-4">
                        <strong>Age Group:</strong> {{ $workshop->age_group }}
                    </div>
                    <div class="col-md-4">
                        <strong>Status:</strong>
                        @if($workshop->is_open_for_registration)
                            <span class="badge bg-success">Open for Registration</span>
                        @else
                            <span class="badge bg-danger">Closed</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Search and Filter Form -->
            <form action="{{ route('admin.workshop-events.registrations', $workshop) }}" method="GET" class="mb-4">
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
                                        {{ $registration->guest_name }}
                                        <span class="badge bg-secondary">Guest</span>
                                    @endif
                                </td>
                                <td>{{ $registration->user_id ? $registration->user->email : $registration->guest_email }}</td>
                                <td>{{ $registration->user_id ? $registration->user->phone : $registration->guest_phone }}</td>
                                <td>{{ $registration->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <span class="badge status-badge dropdown-toggle 
                                            @if($registration->status == 'confirmed') bg-success 
                                            @elseif($registration->status == 'pending') bg-warning 
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
                                                    <dd class="col-sm-9">{{ $registration->user_id ? $registration->user->name : $registration->guest_name }}</dd>
                                                    
                                                    <dt class="col-sm-3">Email:</dt>
                                                    <dd class="col-sm-9">{{ $registration->user_id ? $registration->user->email : $registration->guest_email }}</dd>
                                                    
                                                    <dt class="col-sm-3">Phone:</dt>
                                                    <dd class="col-sm-9">{{ $registration->user_id ? $registration->user->phone : $registration->guest_phone }}</dd>
                                                    
                                                    <dt class="col-sm-3">Registration Type:</dt>
                                                    <dd class="col-sm-9">{{ $registration->user_id ? 'Registered User' : 'Guest' }}</dd>
                                                    
                                                    @if($registration->guest_age)
                                                    <dt class="col-sm-3">Age:</dt>
                                                    <dd class="col-sm-9">{{ $registration->guest_age }}</dd>
                                                    @endif
                                                    
                                                    <dt class="col-sm-3">Status:</dt>
                                                    <dd class="col-sm-9">
                                                        <span class="badge 
                                                            @if($registration->status == 'confirmed') bg-success 
                                                            @elseif($registration->status == 'pending') bg-warning 
                                                            @elseif($registration->status == 'cancelled') bg-danger 
                                                            @elseif($registration->status == 'attended') bg-info 
                                                            @endif">
                                                            {{ ucfirst($registration->status) }}
                                                        </span>
                                                    </dd>
                                                    
                                                    <dt class="col-sm-3">Registered On:</dt>
                                                    <dd class="col-sm-9">{{ $registration->created_at->format('Y-m-d H:i:s') }}</dd>
                                                    
                                                    @if($registration->notes)
                                                    <dt class="col-sm-3">Notes:</dt>
                                                    <dd class="col-sm-9">{{ $registration->notes }}</dd>
                                                    @endif
                                                </dl>
                                                
                                                @if($registration->user_id)
                                                <div class="mt-3">
                                                    <a href="{{ route('admin.users.show', $registration->user_id) }}" class="btn btn-sm btn-primary" target="_blank">
                                                        <i class="fas fa-user"></i> View User Profile
                                                    </a>
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
                                <td colspan="7" class="text-center">No registrations found</td>
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
