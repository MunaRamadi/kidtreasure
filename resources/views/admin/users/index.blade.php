@extends('admin.layouts.app') {{-- Assuming you have an admin layout --}}

@section('content')
<div class="container" style="direction: rtl; text-align: right;">
    <h2>إدارة المستخدمين</h2>

    {{-- قسم الفلترة والبحث الحالي --}}
    <div class="card mb-3">
        <div class="card-header">
            البحث والتصفية
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="form-inline">
                <div class="form-group my-3">
                    <input type="text" name="search" class="form-control" placeholder="البحث بالاسم أو البريد الإلكتروني" value="{{ request('search') }}">
                </div>
                <div class="form-group mb-3">
                    <select name="role" class="form-control">
                        <option value="">جميع الأدوار</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>مستخدم</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>مدير</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">تطبيق الفلاتر</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">إعادة تعيين</a>
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
            طلبات إعادة تعيين كلمة المرور المعلقة
        </div>
        <div class="card-body">
            @if ($passwordResetRequests->count() > 0)
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>اسم المستخدم</th>
                            <th>البريد الإلكتروني</th>
                            <th>تاريخ الطلب</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($passwordResetRequests as $request)
                            <tr>
                                <td>{{ $request->user->name ?? 'غير متوفر' }}</td>
                                <td>{{ $request->email }}</td>
                                <td>{{ $request->created_at->format('Y/m/d H:i') }}</td>
                                <td>
                                    {{-- التأكد من وجود user_id قبل استخدامه أو البحث عن المستخدم بالبريد الإلكتروني --}}
                                    @php
                                        $targetUserId = $request->user_id ?? \App\Models\User::where('email', $request->email)->first()->id ?? null;
                                    @endphp
                                    @if ($targetUserId)
                                        <a href="{{ route('admin.users.edit', $targetUserId) }}" class="btn btn-info btn-sm">تعديل كلمة المرور</a>
                                    @else
                                        <span class="text-danger">المستخدم غير موجود</span>
                                    @endif

                                    <form action="{{ route('admin.password-reset-requests.resolve', $request) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('هل أنت متأكد من تحديد هذا الطلب كمحلول؟');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">تحديد كمحلول</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $passwordResetRequests->links() }}
            @else
                <p class="text-center">لا توجد طلبات إعادة تعيين كلمة المرور معلقة.</p>
            @endif
        </div>
    </div>

    {{-- قسم إدارة المستخدمين الحالي --}}
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>جميع المستخدمين</span>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> إضافة مستخدم جديد
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>الرقم</th>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>الدور</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
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
                                    <span class="badge bg-primary text-white">مدير</span>
                                @else
                                    <span class="badge bg-secondary text-white">مستخدم</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }} text-white">
                                    {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-sm">عرض</a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">تعديل</a>

                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn {{ $user->is_active ? 'btn-danger' : 'btn-success' }} btn-sm">
                                        {{ $user->is_active ? 'تعطيل' : 'تفعيل' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">لم يتم العثور على مستخدمين.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection