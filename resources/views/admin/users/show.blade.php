@extends('admin.layouts.app') {{-- Assuming you have an admin layout --}}

@section('content')
<div class="container">
    <h2>User Details: {{ $user->name }}</h2>

    <div class="card mb-3">
        <div class="card-header">
            User Information
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $user->id }}</p>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $user->address ?? 'N/A' }}</p>
            <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
            <p><strong>Status:</strong> 
                <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}">
                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
            </p>
            <p><strong>Member Since:</strong> {{ $user->created_at->format('M d, Y') }}</p>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">Edit User</a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Back to Users</a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            User Orders
        </div>
        <div class="card-body">
            @if ($user->orders->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{-- route('admin.orders.show', $order) --}}" class="btn btn-info btn-sm">View Order</a> {{-- You'll need to define this route if not already --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No orders found for this user.</p>
            @endif
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            User Stories
        </div>
        <div class="card-body">
            @if ($user->stories->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Story ID</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Date Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->stories as $story)
                            <tr>
                                <td>{{ $story->id }}</td>
                                <td>{{ $story->title }}</td>
                                <td>{{ ucfirst($story->status) }}</td>
                                <td>{{ $story->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{-- route('admin.stories.show', $story) --}}" class="btn btn-info btn-sm">View Story</a> {{-- You'll need to define this route if not already --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No stories submitted by this user.</p>
            @endif
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            User Workshop Registrations
        </div>
        <div class="card-body">
            @if ($user->workshopRegistrations->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Registration ID</th>
                            <th>Workshop</th>
                            <th>Status</th>
                            <th>Date Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->workshopRegistrations as $registration)
                            <tr>
                                <td>{{ $registration->id }}</td>
                                <td>{{ $registration->workshop->title ?? 'N/A' }}</td> {{-- Assuming Workshop model has a 'title' attribute --}}
                                <td>{{ ucfirst($registration->status) }}</td>
                                <td>{{ $registration->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{-- route('admin.workshops.registrations.show', $registration) --}}" class="btn btn-info btn-sm">View Registration</a> {{-- You'll need to define this route if not already --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No workshop registrations for this user.</p>
            @endif
        </div>
    </div>

</div>
@endsection