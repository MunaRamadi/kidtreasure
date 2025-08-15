@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Create New User</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            User Information
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="phone">Phone (Optional)</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                </div>

                <div class="form-group mb-3">
                    <label for="address">Address (Optional)</label>
                    <textarea name="address" id="address" class="form-control">{{ old('address') }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="language_preference">Language Preference</label>
                    <select name="language_preference" id="language_preference" class="form-control">
                        <option value="en" {{ old('language_preference') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="ar" {{ old('language_preference') == 'ar' ? 'selected' : '' }}>Arabic</option>
                    </select>
                </div>

                <div class="form-group form-check mb-3">
                    <input type="checkbox" name="is_admin" id="is_admin" class="form-check-input" value="1" {{ old('is_admin') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_admin">Is Admin</label>
                </div>

                <div class="form-group form-check mb-3">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Is Active</label>
                </div>

                <button type="submit" class="btn btn-primary">Create User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
