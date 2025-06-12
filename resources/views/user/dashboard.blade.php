@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('styles')
<style>
    /* CSS Variables for Colors */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --accent-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --glass-bg: rgba(255, 255, 255, 0.1);
        --glass-border: rgba(255, 255, 255, 0.2);
    }

    /* Animated Background Effect */
    .dashboard-bg {
        background: linear-gradient(-45deg, #f8f9fa, #e9ecef, #dee2e6, #ced4da);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Enhanced Card Design */
    .dashboard-card {
        background: white;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        transform-style: preserve-3d;
    }

    .dashboard-card:hover {
        transform: translateY(-10px) rotateX(5deg);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    /* Stats Card Icons */
    .stat-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        font-size: 24px;
    }

    /* Badge Styles */
    .status-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
    }

    /* Table Styles */
    .dashboard-table {
        --bs-table-bg: transparent;
        --bs-table-striped-bg: rgba(0, 0, 0, 0.02);
    }

    .dashboard-table thead th {
        border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        font-weight: 700;
    }

    /* Workshop Card */
    .workshop-card {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .workshop-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .workshop-card img {
        transition: transform 0.5s ease;
    }

    .workshop-card:hover img {
        transform: scale(1.05);
    }

    /* Animation Classes */
    .fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .stat-icon {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-bg min-vh-100 py-5">
    <div class="container py-4">
        <!-- Header Section -->
        <div class="row mb-5 fade-in-up">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="display-5 fw-bold text-dark mb-2">مرحباً {{ Auth::user()->name }} 👋</h1>
                        <p class="text-muted fs-5">هذه نظرة عامة على نشاطك الأخير</p>
                    </div>
                    <div class="d-none d-md-block">
                        <div class="bg-white p-3 rounded-3 shadow-sm">
                            <span class="text-primary fw-bold">{{ now()->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3 fade-in-up" style="animation-delay: 0.1s;">
                <div class="dashboard-card rounded-4 h-100 p-4">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary me-4">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">الطلبات</h6>
                            <h3 class="mb-0">{{ $stats['orders'] }}</h3>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-success">
                            <i class="fas fa-arrow-up me-1"></i>
                            {{ $stats['orders'] > 0 ? round(($stats['completed_orders']/$stats['orders'])*100) : 0 }}% معدل الإنجاز
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 fade-in-up" style="animation-delay: 0.2s;">
                <div class="dashboard-card rounded-4 h-100 p-4">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success bg-opacity-10 text-success me-4">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">طلبات مكتملة</h6>
                            <h3 class="mb-0">{{ $stats['completed_orders'] }}</h3>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            {{ $stats['pending_orders'] }} قيد الانتظار
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 fade-in-up" style="animation-delay: 0.3s;">
                <div class="dashboard-card rounded-4 h-100 p-4">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info bg-opacity-10 text-info me-4">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">قصص منشورة</h6>
                            <h3 class="mb-0">{{ $stats['approved_stories'] }}</h3>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted">
                            <i class="fas fa-pen me-1"></i>
                            {{ $stats['stories'] }} إجمالي القصص
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 fade-in-up" style="animation-delay: 0.4s;">
                <div class="dashboard-card rounded-4 h-100 p-4">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning me-4">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">ورش مسجلة</h6>
                            <h3 class="mb-0">{{ $stats['workshop_registrations'] }}</h3>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-primary">
                            <i class="fas fa-calendar-check me-1"></i>
                            {{ $upcomingWorkshops->count() }} قادمة
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders & Stories -->
        <div class="row g-4 mb-5">
            <!-- Recent Orders -->
            <div class="col-lg-8 fade-in-up" style="animation-delay: 0.2s;">
                <div class="dashboard-card rounded-4 h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">آخر الطلبات</h4>
                       
                    </div>
                    
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table dashboard-table">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>التاريخ</th>
                                        <th>الحالة</th>
                                        <th class="text-end">الإجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="#" class="text-primary fw-bold">#{{ $order->id }}</a>
                                        </td>
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="status-badge bg-{{ $order->order_status == 'delivered' ? 'success' : 'warning' }}-subtle text-{{ $order->order_status == 'delivered' ? 'success' : 'warning' }}">
                                                {{ $order->order_status }}
                                            </span>
                                        </td>
                                        <td class="text-end fw-bold">{{ number_format($order->total, 2) }} ر.س</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                            <h5 class="text-muted">لا توجد طلبات حتى الآن</h5>
                            <a href="/products" class="btn btn-primary mt-3">
                                <i class="fas fa-store me-2"></i> تصفح المتجر
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Stories -->
            <div class="col-lg-4 fade-in-up" style="animation-delay: 0.3s;">
                <div class="dashboard-card rounded-4 h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">آخر القصص</h4>
                        <a href="{{ route('stories.index') }}" class="btn btn-sm btn-outline-primary">
                            عرض الكل <i class="fas fa-arrow-left ms-2"></i>
                        </a>
                    </div>
                    
                    @if($recentStories->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentStories as $story)
                            <div class="list-group-item border-0 px-0 py-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0 fw-bold">{{ Str::limit($story->title, 30) }}</h6>
                                    <span class="status-badge bg-{{ $story->status == 'approved' ? 'success' : 'secondary' }}-subtle text-{{ $story->status == 'approved' ? 'success' : 'secondary' }}">
                                        {{ $story->status }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $story->created_at->diffForHumans() }}
                                    </small>
                                    <a href="#" class="text-primary small">عرض التفاصيل</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book-open fa-4x text-muted mb-4"></i>
                            <h5 class="text-muted">لا توجد قصص حتى الآن</h5>
                            <a href="{{ route('stories.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus me-2"></i> أضف قصة جديدة
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Upcoming Workshops -->
        <div class="row fade-in-up" style="animation-delay: 0.4s;">
            <div class="col-12">
                <div class="dashboard-card rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">ورش العمل القادمة</h4>
                        <a href="{{ route('workshops.index') }}" class="btn btn-sm btn-outline-primary">
                            عرض الكل <i class="fas fa-arrow-left ms-2"></i>
                        </a>
                    </div>
                    
                    @if($upcomingWorkshops->count() > 0)
                        <div class="row g-4">
                            @foreach($upcomingWorkshops as $workshop)
                            <div class="col-md-4">
                                <div class="workshop-card rounded-3 overflow-hidden h-100 border">
                                    <img src="{{ $workshop->image_url ?? asset('images/default-workshop.jpg') }}" 
                                         class="img-fluid w-100" 
                                         style="height: 180px; object-fit: cover;" 
                                         alt="{{ $workshop->title }}">
                                    <div class="p-3">
                                        <h5 class="fw-bold mb-2">{{ Str::limit($workshop->title, 30) }}</h5>
                                        <div class="d-flex align-items-center text-muted mb-3">
                                            <i class="far fa-calendar-alt me-2"></i>
                                            <small>{{ $workshop->date->format('d M Y') }}</small>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                <i class="fas fa-users me-1"></i>
                                                {{ $workshop->registrations_count }} مسجلين
                                            </span>
                                            <a href="{{ route('workshops.show', $workshop->id) }}" class="btn btn-sm btn-outline-primary">
                                                التفاصيل
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chalkboard-teacher fa-4x text-muted mb-4"></i>
                            <h5 class="text-muted">لا توجد ورش مسجلة حتى الآن</h5>
                            <a href="{{ route('workshops.index') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-calendar me-2"></i> تصفح الورش القادمة
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // يمكنك إضافة أي تفاعلات JavaScript هنا
        console.log('Dashboard loaded successfully');
    });
</script>
@endsection