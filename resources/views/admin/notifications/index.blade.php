@extends('admin.layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Notifications</h1>
    </div>

    <!-- Notification List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">All Notifications</h6>
            <div>
                <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-check-double"></i> Mark All as Read
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            @if($notifications->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Message</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notifications as $notification)
                                <tr class="{{ is_null($notification->read_at) ? 'bg-light' : '' }} notification-row" 
                                    data-url="{{ $notification->data['url'] ?? '#' }}"
                                    data-id="{{ $notification->id }}"
                                    style="cursor: pointer;">
                                    <td>
                                        @if(isset($notification->data['type']) && $notification->data['type'] == 'order')
                                            <span class="badge badge-primary">Order</span>
                                        @elseif(isset($notification->data['type']) && $notification->data['type'] == 'contact_message')
                                            <span class="badge badge-info">Contact</span>
                                        @elseif(isset($notification->data['type']) && $notification->data['type'] == 'story_request')
                                            <span class="badge badge-success">Story</span>
                                        @else
                                            <span class="badge badge-secondary">Other</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $notification->data['message'] ?? 'Notification' }}
                                    </td>
                                    <td>{{ $notification->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if(is_null($notification->read_at))
                                            <span class="badge badge-warning">Unread</span>
                                        @else
                                            <span class="badge badge-secondary">Read</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            @if(is_null($notification->read_at))
                                                <form action="{{ route('admin.notifications.mark-read', $notification->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-bell-slash fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500">No notifications found.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationRows = document.querySelectorAll('.notification-row');
        
        notificationRows.forEach(row => {
            row.addEventListener('click', function(e) {
                // Don't trigger if clicking on buttons or forms
                if (e.target.closest('.btn-group') || e.target.closest('form')) {
                    return;
                }
                
                const notificationId = this.dataset.id;
                const url = this.dataset.url;
                
                // Mark as read if unread
                if (this.classList.contains('bg-light')) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    fetch(`{{ route('admin.notifications.mark-read', '') }}/${notificationId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Navigate to the URL after marking as read
                        window.location.href = url;
                    })
                    .catch(error => {
                        console.error('Error marking notification as read:', error);
                        // Still navigate even if marking as read fails
                        window.location.href = url;
                    });
                } else {
                    // Already read, just navigate
                    window.location.href = url;
                }
            });
        });
    });
</script>
@endsection
