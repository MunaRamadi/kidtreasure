@extends('admin.layouts.app') {{-- Assuming you have an admin layout --}}

@section('content')
<div class="container">
    <h2>User Management</h2>

    <div class="card mb-3">
        <div class="card-header">
            Filter and Search
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="form-inline">
                <div class="form-group mr-2">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request('search') }}">
                </div>
                <div class="form-group mr-2">
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

    <table class="table table-bordered">
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
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>
                        <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}">
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
@endsection