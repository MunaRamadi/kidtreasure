@extends('admin.layouts.app') {{-- Assuming you have an admin layout --}}

@section('content')
<div class="container" style="direction: rtl; text-align: right;">
    <h2>تعديل المستخدم: {{ $user->name }}</h2>

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
            تعديل معلومات المستخدم
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">الاسم</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                {{-- حقول كلمة المرور الجديدة --}}
                <div class="form-group">
                    <label for="password">كلمة المرور الجديدة</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <small class="form-text text-muted">اتركه فارغًا إذا كنت لا ترغب في تغيير كلمة المرور.</small>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">تأكيد كلمة المرور الجديدة</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>
                {{-- نهاية حقول كلمة المرور الجديدة --}}

                <div class="form-group">
                    <label for="phone">رقم الهاتف</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="form-group">
                    <label for="address">العنوان</label>
                    <textarea name="address" id="address" class="form-control">{{ old('address', $user->address) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="language_preference">تفضيل اللغة</label>
                    <input type="text" name="language_preference" id="language_preference" class="form-control" value="{{ old('language_preference', $user->language_preference) }}">
                </div>

                <div class="form-group">
                    <label for="role">الدور</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>مستخدم</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>مدير</option>
                    </select>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">نشط</label>
                </div>

                <button type="submit" class="btn btn-primary">تحديث المستخدم</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection