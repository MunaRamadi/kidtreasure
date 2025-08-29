@extends('admin.layouts.app') {{-- Assuming you have an admin layout --}}

@section('content')
<div class="container" style="direction: rtl; text-align: right;">
    <h2>تفاصيل المستخدم: {{ $user->name }}</h2>

    <div class="card mb-3">
        <div class="card-header">
            معلومات المستخدم
        </div>
        <div class="card-body">
            <p><strong>الرقم:</strong> {{ $user->id }}</p>
            <p><strong>الاسم:</strong> {{ $user->name }}</p>
            <p><strong>البريد الإلكتروني:</strong> {{ $user->email }}</p>
            <p><strong>رقم الهاتف:</strong> {{ $user->phone ?? 'غير متوفر' }}</p>
            <p><strong>العنوان:</strong> {{ $user->address ?? 'غير متوفر' }}</p>
            <p><strong>الدور:</strong> 
                @if($user->role == 'admin')
                    مدير
                @else
                    مستخدم
                @endif
            </p>
            <p><strong>الحالة:</strong> 
                <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}">
                    {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                </span>
            </p>
            <p><strong>عضو منذ:</strong> {{ $user->created_at->format('Y/m/d') }}</p>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">تعديل المستخدم</a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">العودة للمستخدمين</a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            طلبات المستخدم
        </div>
        <div class="card-body">
            @if ($user->orders->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>المجموع</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ number_format($order->total, 2) }} دينار</td>
                                <td>
                                    @switch($order->order_status)
                                        @case('pending')
                                            قيد الانتظار
                                            @break
                                        @case('completed')
                                            تم
                                            @break
                                        @case('canceled')
                                            ملغي
                                            @break
                                        @case('refunded')
                                            مسترجع
                                            @break
                                        @default
                                            {{ $order->order_status }}
                                    @endswitch
                                </td>
                                <td>{{ $order->created_at->format('Y/m/d') }}</td>
                                <td>
                                    <a href="{{-- route('admin.orders.show', $order) --}}" class="btn btn-info btn-sm">عرض الطلب</a> {{-- You'll need to define this route if not already --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>لا توجد طلبات لهذا المستخدم.</p>
            @endif
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            قصص المستخدم
        </div>
        <div class="card-body">
            @if ($user->stories->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>رقم القصة</th>
                            <th>العنوان</th>
                            <th>الحالة</th>
                            <th>تاريخ التقديم</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->stories as $story)
                            <tr>
                                <td>{{ $story->id }}</td>
                                <td>{{ $story->title }}</td>
                                <td>
                                    @switch($story->status)
                                        @case('pending')
                                            قيد المراجعة
                                            @break
                                        @case('approved')
                                            مقبولة
                                            @break
                                        @case('rejected')
                                            مرفوضة
                                            @break
                                        @default
                                            {{ $story->status }}
                                    @endswitch
                                </td>
                                <td>{{ $story->created_at->format('Y/m/d') }}</td>
                                <td>
                                    <a href="{{-- route('admin.stories.show', $story) --}}" class="btn btn-info btn-sm">عرض القصة</a> {{-- You'll need to define this route if not already --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>لا توجد قصص مقدمة من هذا المستخدم.</p>
            @endif
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            تسجيلات ورش العمل للمستخدم
        </div>
        <div class="card-body">
            @if ($user->workshopRegistrations->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>رقم التسجيل</th>
                            <th>ورشة العمل</th>
                            <th>الحالة</th>
                            <th>تاريخ التسجيل</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->workshopRegistrations as $registration)
                            <tr>
                                <td>{{ $registration->id }}</td>
                                <td>{{ $registration->workshop->title ?? 'غير متوفر' }}</td> {{-- Assuming Workshop model has a 'title' attribute --}}
                                <td>
                                    @switch($registration->status)
                                        @case('pending')
                                            قيد الانتظار
                                            @break
                                        @case('confirmed')
                                            مؤكد
                                            @break
                                        @case('cancelled')
                                            ملغي
                                            @break
                                        @default
                                            {{ $registration->status }}
                                    @endswitch
                                </td>
                                <td>{{ $registration->created_at->format('Y/m/d') }}</td>
                                <td>
                                    <a href="{{-- route('admin.workshops.registrations.show', $registration) --}}" class="btn btn-info btn-sm">عرض التسجيل</a> {{-- You'll need to define this route if not already --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>لا توجد تسجيلات ورش عمل لهذا المستخدم.</p>
            @endif
        </div>
    </div>

</div>
@endsection