@extends('admin.layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">لوحة التحكم</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> إنشاء تقرير
        </a>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                المنتجات
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['products'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                الطلبات الكلية
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['orders'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                المستخدمين
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['users'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                الرسائل
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['messages'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                القصص
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['stories'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                الورش
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['workshops'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                منشورات المدونة
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['blog_posts'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-blog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                العناصر المعلقة
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['pending_stories'] + $stats['pending_orders'] + $stats['unread_messages'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">الطلبات الأخيرة</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>رقم الطلب</th>
                                    <th>العميل</th>
                                    <th>الحالة</th>
                                    <th>التاريخ</th>
                                    <th>المبلغ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $order->order_status == 'completed' ? 'success' : ($order->order_status == 'pending' ? 'warning' : 'secondary') }}">
                                            {{ $order->order_status }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">أفضل المنتجات مبيعاً</h6>
                </div>
                <div class="card-body">
                    @foreach($topProducts as $product)
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <img src="{{ $product->image_url ?? '/images/default-product.jpg' }}" 
                                 alt="{{ $product->name }}" 
                                 class="rounded" 
                                 style="width: 50px; height: 50px; object-fit: cover;">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">{{ $product->name }}</h6>
                            <small class="text-muted">{{ $product->order_items_count }} مباع</small>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="badge badge-primary">${{ $product->price }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">الإجراءات المطلوبة</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($stats['pending_orders'] > 0)
                        <div class="col-md-4">
                            <div class="alert alert-warning" role="alert">
                                <h6 class="alert-heading">الطلبات المعلقة</h6>
                                <p>هناك {{ $stats['pending_orders'] }} طلبات في انتظار المراجعة.</p>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-warning">عرض الطلبات</a>
                            </div>
                        </div>
                        @endif

                        @if($stats['pending_stories'] > 0)
                        <div class="col-md-4">
                            <div class="alert alert-info" role="alert">
                                <h6 class="alert-heading">القصص المعلقة</h6>
                                <p>هناك {{ $stats['pending_stories'] }} قصص في انتظار الموافقة.</p>
                                <a href="{{ route('admin.stories.index') }}" class="btn btn-sm btn-info">مراجعة القصص</a>
                            </div>
                        </div>
                        @endif

                        @if($stats['unread_messages'] > 0)
                        <div class="col-md-4">
                            <div class="alert alert-danger" role="alert">
                                <h6 class="alert-heading">الرسائل غير المقروءة</h6>
                                <p>هناك {{ $stats['unread_messages'] }} رسائل جديدة.</p>
                                <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-sm btn-danger">قراءة الرسائل</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Sales chart (Chart.js can be added here)
    $(document).ready(function() {
        // Setup any additional dashboard scripts
        console.log('Admin Dashboard loaded');
    });
</script>
