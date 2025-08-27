@extends('admin.layouts.app')

@section('title', 'تفاصيل الطلب #' . $order->order_number)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center mb-4 justify-content-between">        
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> العودة للطلبات
            </a>
            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> تعديل الطلب
            </a>
        </div>
        <h1 class="h3 mb-0 text-gray-800" dir="rtl"> تفاصيل الطلب #{{ $order->order_number ?? $order->id }}</h1>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4" dir="rtl">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">معلومات الطلب</h6>
                </div>
                <div class="card-body text-right">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-right"><strong>رقم الطلب:</strong> {{ $order->order_number ?? $order->id }}</p>
                            <p class="text-right"><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                            <p class="text-right">
                                <strong>حالة الطلب:</strong>
                                @switch($order->order_status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">قيد الانتظار</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-success">تم</span>
                                        @break
                                    @case('canceled')
                                        <span class="badge bg-danger">ملغي</span>
                                        @break
                                    @case('refunded')
                                        <span class="badge bg-info">مسترجع</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $order->order_status }}</span>
                                @endswitch
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-right"><strong>المبلغ الإجمالي:</strong> {{ number_format($order->total_amount_jod, 2) }} دينار</p>
                            <p class="text-right">
                                <strong>حالة الدفع:</strong>
                                @switch($order->payment_status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">قيد الانتظار</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-success">تم</span>
                                        @break
                                    @case('canceled')
                                        <span class="badge bg-danger">ملغي</span>
                                        @break
                                    @case('refunded')
                                        <span class="badge bg-info">مسترجع</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $order->payment_status }}</span>
                                @endswitch
                            </p>
                            <p class="text-right"><strong>طريقة الدفع:</strong> {{ $order->payment_method }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="font-weight-bold text-right">ملاحظات:</h6>
                        <p class="text-right">{{ $order->notes ?? 'لا توجد ملاحظات' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4" dir="rtl">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">معلومات العميل</h6>
                </div>
                <div class="card-body text-right">
                    @if($order->user)
                        <p class=""><strong>الاسم:</strong> {{ $order->user->first_name }} {{ $order->user->last_name }}</p>
                        <p class=""><strong>البريد الإلكتروني:</strong> {{ $order->user->email }}</p>
                        <p class=""><strong>رقم الهاتف:</strong> {{ $order->user->phone ?? 'غير متوفر' }}</p>
                        <p class=""><strong>العنوان:</strong> 
                            @if(is_array($order->shipping_address))
                                {{ implode(', ', array_filter($order->shipping_address)) }}
                            @else
                                {{ $order->user->address ?? 'غير متوفر' }}
                            @endif
                        </p>
                        <a href="{{ route('admin.users.show', $order->user) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-user"></i> عرض ملف العميل
                        </a>
                    @else
                        <p class="text-right"><strong>الاسم:</strong> {{ $order->customer_name ?? 'غير متوفر' }}</p>
                        <p class="text-right"><strong>البريد الإلكتروني:</strong> {{ $order->customer_email ?? 'غير متوفر' }}</p>
                        <p class="text-right"><strong>رقم الهاتف:</strong> {{ $order->customer_phone ?? 'غير متوفر' }}</p>
                        <p class="text-right"><strong>العنوان:</strong> 
                            @if(is_array($order->shipping_address))
                                {{ implode(', ', array_filter($order->shipping_address)) }}
                            @else
                                {{ 'غير متوفر' }}
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">منتجات الطلب</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-right" dir="rtl">
                    <thead>
                        <tr>
                            <th class="text-right">المنتج</th>
                            <th class="text-right">الصورة</th>
                            <th class="text-right">السعر</th>
                            <th class="text-right">الكمية</th>
                            <th class="text-right">المجموع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    @if($item->product)
                                        <a href="{{ route('admin.products.show', $item->product) }}">{{ $item->product->name }}</a>
                                    @else
                                        {{ $item->product_name ?? 'منتج محذوف' }}
                                    @endif
                                </td>
                                <td>
                                    @if($item->product && $item->product->image_url)
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" width="50">
                                    @else
                                        <span class="text-muted">لا توجد صورة</span>
                                    @endif
                                </td>
                                <td>{{ number_format($item->price, 2) }} دينار</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price * $item->quantity, 2) }} دينار</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-left"><strong>المجموع الفرعي:</strong></td>
                            <td>{{ number_format($order->subtotal ?? $order->total_amount_jod, 2) }} دينار</td>
                        </tr>
                        @if(isset($order->tax) && $order->tax > 0)
                        <tr>
                            <td colspan="4" class="text-left"><strong>الضريبة:</strong></td>
                            <td>{{ number_format($order->tax, 2) }} دينار</td>
                        </tr>
                        @endif
                        @if(isset($order->shipping_cost) && $order->shipping_cost > 0)
                        <tr>
                            <td colspan="4" class="text-left"><strong>تكلفة الشحن:</strong></td>
                            <td>{{ number_format($order->shipping_cost, 2) }} دينار</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="4" class="text-left"><strong>المجموع الكلي:</strong></td>
                            <td><strong>{{ number_format($order->total_amount_jod, 2) }} دينار</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Update Order Status -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">تحديث حالة الطلب</h6>
                </div>
                <div class="card-body text-right">
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="status" class="form-label text-right">حالة الطلب</label>
                            <select name="status" id="status" class="form-select text-right" dir="rtl">
                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>تم</option>
                                <option value="canceled" {{ $order->order_status == 'canceled' ? 'selected' : '' }}>ملغي</option>
                                <option value="refunded" {{ $order->order_status == 'refunded' ? 'selected' : '' }}>مسترجع</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label text-right">ملاحظات</label>
                            <textarea name="notes" id="notes" class="form-control text-right" dir="rtl" rows="3">{{ $order->notes }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">تحديث الحالة</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">تحديث حالة الدفع</h6>
                </div>
                <div class="card-body text-right">
                    <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="payment_status" class="form-label text-right">حالة الدفع</label>
                            <select name="payment_status" id="payment_status" class="form-select text-right" dir="rtl">
                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                <option value="completed" {{ $order->payment_status == 'completed' ? 'selected' : '' }}>تم</option>
                                <option value="canceled" {{ $order->payment_status == 'canceled' ? 'selected' : '' }}>ملغي</option>
                                <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>مسترجع</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">تحديث حالة الدفع</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
