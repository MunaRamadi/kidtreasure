@extends('admin.layouts.app') {{-- Assuming you have an admin layout --}}

@section('content')
<div class="container">
    <h2>User Management</h2>

    {{-- قسم الفلترة والبحث الحالي --}}
    <div class="card mb-3">
        <div class="card-header">
            Filter and Search
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="form-inline">
                <div class="form-group my-3">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request('search') }}">
                </div>
                <div class="form-group mb-3">
                    <select name="role" class="form-control">
                        <option value="">All Roles</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ml-2">Clear Filters</a>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- قسم جديد لعرض طلبات إعادة تعيين كلمة المرور --}}
    <div class="card mb-4">
        <div class="card-header">
            Pending Password Reset Requests
        </div>
        <div class="card-body">
            @if ($passwordResetRequests->count() > 0)
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>Requested At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($passwordResetRequests as $request)
                            <tr>
                                <td>{{ $request->user->name ?? 'N/A' }}</td>
                                <td>{{ $request->email }}</td>
                                <td>{{ $request->created_at->format('M d, Y H:i A') }}</td>
                                <td>
                                    {{-- التأكد من وجود user_id قبل استخدامه أو البحث عن المستخدم بالبريد الإلكتروني --}}
                                    @php
                                        $targetUserId = $request->user_id ?? \App\Models\User::where('email', $request->email)->first()->id ?? null;
                                    @endphp
                                    @if ($targetUserId)
                                        <a href="{{ route('admin.users.edit', $targetUserId) }}" class="btn btn-info btn-sm">Edit User's Password</a>
                                    @else
                                        <span class="text-danger">User not found</span>
                                    @endif

                                    <form action="{{ route('admin.password-reset-requests.resolve', $request) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to mark this request as resolved?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">Mark as Resolved</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $passwordResetRequests->links() }}
            @else
                <p class="text-center">No pending password reset requests.</p>
            @endif
        </div>
    </div>

    {{-- قسم إدارة المستخدمين الحالي --}}
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>All Users</span>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Create User
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->is_admin)
                                    <span class="badge bg-primary text-white">Admin</span>
                                @else
                                    <span class="badge bg-secondary text-white">User</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }} text-white">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn {{ $user->is_active ? 'btn-danger' : 'btn-success' }} btn-sm">
                                        {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection