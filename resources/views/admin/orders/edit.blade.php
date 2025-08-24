@extends('admin.layouts.app')

@section('title', 'تعديل الطلب #' . $order->order_number)

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">تعديل الطلب #{{ $order->order_number ?? $order->id }}</h1>
        <div>
            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm">
                <i class="fas fa-eye"></i> عرض الطلب
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> العودة للطلبات
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">تعديل معلومات الطلب</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order_status" class="form-label">حالة الطلب</label>
                                    <select name="status" id="order_status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                        <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>تم</option>
                                        <option value="canceled" {{ $order->order_status == 'canceled' ? 'selected' : '' }}>ملغي</option>
                                        <option value="refunded" {{ $order->order_status == 'refunded' ? 'selected' : '' }}>مسترجع</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_status" class="form-label">حالة الدفع</label>
                                    <select name="payment_status" id="payment_status" class="form-control @error('payment_status') is-invalid @enderror">
                                        <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                        <option value="completed" {{ $order->payment_status == 'completed' ? 'selected' : '' }}>تم</option>
                                        <option value="canceled" {{ $order->payment_status == 'canceled' ? 'selected' : '' }}>ملغي</option>
                                        <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>مسترجع</option>
                                    </select>
                                    @error('payment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="shipping_carrier" class="form-label">شركة الشحن</label>
                                    <input type="text" name="shipping_carrier" id="shipping_carrier" class="form-control @error('shipping_carrier') is-invalid @enderror" value="{{ $order->shipping_carrier ?? '' }}">
                                    @error('shipping_carrier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tracking_number" class="form-label">رقم التتبع</label>
                                    <input type="text" name="tracking_number" id="tracking_number" class="form-control @error('tracking_number') is-invalid @enderror" value="{{ $order->tracking_number ?? '' }}">
                                    @error('tracking_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">ملاحظات</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="4">{{ $order->notes }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Information (Read-only) -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">معلومات العميل</h6>
                </div>
                <div class="card-body">
                    @if($order->user)
                        <p><strong>الاسم:</strong> {{ $order->user->name }}</p>
                        <p><strong>البريد الإلكتروني:</strong> {{ $order->user->email }}</p>
                        <p><strong>رقم الهاتف:</strong> {{ $order->user->phone ?? 'غير متوفر' }}</p>
                        <p><strong>العنوان:</strong> 
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
                        <p><strong>الاسم:</strong> {{ $order->customer_name ?? 'غير متوفر' }}</p>
                        <p><strong>البريد الإلكتروني:</strong> {{ $order->customer_email ?? 'غير متوفر' }}</p>
                        <p><strong>رقم الهاتف:</strong> {{ $order->customer_phone ?? 'غير متوفر' }}</p>
                        <p><strong>العنوان:</strong> 
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

        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">معلومات الطلب</h6>
                </div>
                <div class="card-body">
                    <p><strong>رقم الطلب:</strong> {{ $order->order_number ?? $order->id }}</p>
                    <p><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                    <p><strong>المبلغ الإجمالي:</strong> {{ number_format($order->total_amount_jod, 2) }} دينار</p>
                    <p><strong>طريقة الدفع:</strong> {{ $order->payment_method }}</p>
                    @if($order->paid_at)
                        <p><strong>تاريخ الدفع:</strong> {{ \Carbon\Carbon::parse($order->paid_at)->format('Y-m-d H:i') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items (Read-only) -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">منتجات الطلب</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>السعر</th>
                            <th>الكمية</th>
                            <th>المجموع</th>
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
                                <td>{{ number_format($item->price, 2) }} دينار</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price * $item->quantity, 2) }} دينار</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>المجموع الكلي:</strong></td>
                            <td><strong>{{ number_format($order->total_amount_jod, 2) }} دينار</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
