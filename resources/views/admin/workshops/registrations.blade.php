@extends('admin.layouts.app')

@section('title', 'Workshop Registrations')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Workshop Registrations</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.workshops.index') }}">Workshops</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.workshops.show', $workshop) }}">{{ $workshop->name_en }}</a></li>
        <li class="breadcrumb-item active">Registrations</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-users me-1"></i>
            Registrations for "{{ $workshop->name_en }}"
        </div>
        <div class="card-body">
            <!-- Filters -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <form action="{{ route('admin.workshops.registrations', $workshop) }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="event" class="form-label">Event Date</label>
                            <select class="form-select" id="event" name="event">
                                <option value="">All Events</option>
                                @foreach($workshop->events as $event)
                                    <option value="{{ $event->id }}" {{ request('event') == $event->id ? 'selected' : '' }}>
                                        {{ $event->event_date->format('Y-m-d') }} ({{ $event->location }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Registration Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All Statuses</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="payment" class="form-label">Payment Status</label>
                            <select class="form-select" id="payment" name="payment">
                                <option value="">All Payment Statuses</option>
                                <option value="paid" {{ request('payment') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="pending" {{ request('payment') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="failed" {{ request('payment') == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="not_applicable" {{ request('payment') == 'not_applicable' ? 'selected' : '' }}>N/A</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="search" name="search" placeholder="Search by name..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if(request()->anyFilled(['event', 'status', 'payment', 'search']))
                                    <a href="{{ route('admin.workshops.registrations', $workshop) }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Registrations Table -->
            @if($registrations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Event Date</th>
                                <th>Attendee Name</th>
                                <th>Parent Name</th>
                                <th>Contact</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrations as $registration)
                                <tr>
                                    <td>{{ $registration->id }}</td>
                                    <td>{{ $registration->event->event_date->format('Y-m-d') }}</td>
                                    <td>{{ $registration->attendee_name }}</td>
                                    <td>{{ $registration->parent_name }}</td>
                                    <td>
                                        {{ $registration->parent_contact }}<br>
                                        <small>{{ $registration->parent_email }}</small>
                                    </td>
                                    <td>{{ $registration->registration_date->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm dropdown-toggle 
                                                {{ $registration->status == 'confirmed' ? 'btn-success' : 
                                                   ($registration->status == 'pending' ? 'btn-warning' : 'btn-danger') }}"
                                                type="button" id="dropdownStatus{{ $registration->id }}" 
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ ucfirst($registration->status) }}
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownStatus{{ $registration->id }}">
                                                <li>
                                                    <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button type="submit" class="dropdown-item">Confirm</button>
                                                    </form>
                                                </li>
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
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="dropdown-item">Cancel</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            {{ $registration->payment_status == 'paid' ? 'bg-success' : 
                                               ($registration->payment_status == 'pending' ? 'bg-warning text-dark' : 
                                               ($registration->payment_status == 'not_applicable' ? 'bg-secondary' : 'bg-danger')) }}">
                                            {{ $registration->payment_status == 'not_applicable' ? 'N/A' : ucfirst($registration->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#registrationModal{{ $registration->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Registration Details Modal -->
                                <div class="modal fade" id="registrationModal{{ $registration->id }}" tabindex="-1" aria-labelledby="registrationModalLabel{{ $registration->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="registrationModalLabel{{ $registration->id }}">Registration Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <h6>Workshop</h6>
                                                        <p>{{ $workshop->name_en }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Event Date</h6>
                                                        <p>{{ $registration->event->event_date->format('Y-m-d') }} at {{ $registration->event->event_time->format('H:i') }}</p>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <h6>Attendee Name</h6>
                                                        <p>{{ $registration->attendee_name }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Attendee Age</h6>
                                                        <p>{{ $registration->attendee_age ?? 'Not specified' }}</p>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <h6>Parent Name</h6>
                                                        <p>{{ $registration->parent_name }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Parent Contact</h6>
                                                        <p>{{ $registration->parent_contact }}</p>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <h6>Parent Email</h6>
                                                        <p>{{ $registration->parent_email }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Registration Date</h6>
                                                        <p>{{ $registration->registration_date->format('Y-m-d H:i') }}</p>
                                                    </div>
                                                </div>
                                                @if($registration->notes)
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <h6>Notes</h6>
                                                        <p>{{ $registration->notes }}</p>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <h6>Status</h6>
                                                        <p>
                                                            <span class="badge 
                                                                {{ $registration->status == 'confirmed' ? 'bg-success' : 
                                                                   ($registration->status == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                                                {{ ucfirst($registration->status) }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Payment Status</h6>
                                                        <p>
                                                            <span class="badge 
                                                                {{ $registration->payment_status == 'paid' ? 'bg-success' : 
                                                                   ($registration->payment_status == 'pending' ? 'bg-warning text-dark' : 
                                                                   ($registration->payment_status == 'not_applicable' ? 'bg-secondary' : 'bg-danger')) }}">
                                                                {{ $registration->payment_status == 'not_applicable' ? 'N/A' : ucfirst($registration->payment_status) }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $registrations->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    No registrations found for this workshop.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-close alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-success, .alert-danger');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Auto-submit form when filters change
        document.getElementById('event').addEventListener('change', function() {
            this.form.submit();
        });
        
        document.getElementById('status').addEventListener('change', function() {
            this.form.submit();
        });
        
        document.getElementById('payment').addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
@endsection
