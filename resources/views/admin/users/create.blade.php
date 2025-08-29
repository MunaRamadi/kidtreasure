@extends('admin.layouts.app')

@section('content')
<div class="container" style="direction: rtl; text-align: right;">
    <h2>إضافة مستخدم جديد</h2>

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
            معلومات المستخدم
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="name">الاسم</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password">كلمة المرور</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirmation">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="phone">رقم الهاتف (اختياري)</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                </div>

                <div class="form-group mb-3">
                    <label for="address">العنوان (اختياري)</label>
                    <textarea name="address" id="address" class="form-control">{{ old('address') }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="language_preference">تفضيل اللغة</label>
                    <select name="language_preference" id="language_preference" class="form-control">
                        <option value="en" {{ old('language_preference') == 'en' ? 'selected' : '' }}>الإنجليزية</option>
                        <option value="ar" {{ old('language_preference') == 'ar' ? 'selected' : '' }}>العربية</option>
                    </select>
                </div>

                <div class="form-group form-check mb-3">
                    <input type="checkbox" name="is_admin" id="is_admin" class="form-check-input" value="1" {{ old('is_admin') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_admin">مدير</label>
                </div>

                <div class="form-group form-check mb-3">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">نشط</label>
                </div>

                <button type="submit" class="btn btn-primary">إنشاء المستخدم</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection
