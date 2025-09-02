@extends('admin.layouts.app')

@section('title', 'إدارة الطلبات')

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">إدارة الطلبات</h1>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">تصفية الطلبات</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="mb-0">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control" name="search" placeholder="بحث..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 mb-2">
                        <select name="status" class="form-select">
                            <option value="">كل الحالات</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>تم</option>
                            <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>ملغي</option>
                            <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>مسترجع</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <select name="payment_status" class="form-select">
                            <option value="">كل حالات الدفع</option>
                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="completed" {{ request('payment_status') == 'completed' ? 'selected' : '' }}>تم</option>
                            <option value="canceled" {{ request('payment_status') == 'canceled' ? 'selected' : '' }}>ملغي</option>
                            <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>مسترجع</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <input type="date" class="form-control" name="date_from" placeholder="من تاريخ" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2 mb-2">
                        <input type="date" class="form-control" name="date_to" placeholder="إلى تاريخ" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-1 mb-2">
                        <button type="submit" class="btn btn-primary w-100">تصفية</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">قائمة الطلبات</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>العميل</th>
                            <th>المبلغ الإجمالي</th>
                            <th>حالة الطلب</th>
                            <th>حالة الدفع</th>
                            <th>تاريخ الطلب</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr class="{{ isset($highlightId) && $order->id == $highlightId ? 'table-danger' : '' }}">
                                <td>{{ $order->order_number ?? $order->id }}</td>
                                <td>
                                    @if($order->user)
                                        <a href="{{ route('admin.users.show', $order->user) }}">
                                            {{ $order->user->first_name }} {{ $order->user->last_name }}
                                            <br>
                                            <small class="text-muted">{{ $order->user->email }}</small>
                                        </a>
                                    @else
                                        {{ $order->customer_name ?? 'زائر' }}
                                        <br>
                                        <small class="text-muted">{{ $order->customer_email ?? 'غير متوفر' }}</small>
                                    @endif
                                </td>
                                <td>{{ number_format($order->total_amount_jod, 2) }} دينار</td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $order->order_status == 'pending' ? 'warning text-dark' : 
                                        ($order->order_status == 'completed' ? 'success' : 
                                        ($order->order_status == 'canceled' ? 'danger' : 
                                        'info')) }}">
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
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $order->payment_status == 'pending' ? 'warning text-dark' : 
                                        ($order->payment_status == 'completed' ? 'success' : 
                                        ($order->payment_status == 'canceled' ? 'danger' : 
                                        'info')) }}">
                                        @switch($order->payment_status)
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
                                                {{ $order->payment_status }}
                                        @endswitch
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">لا توجد طلبات</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize any datepickers or other plugins
        // $('.datepicker').datepicker();
    });
</script>
@endsection
