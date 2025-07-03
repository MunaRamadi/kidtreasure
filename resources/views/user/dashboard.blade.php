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
    .animated-bg {
        background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
    }

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

    /* Enhanced Floating Background Elements */
    .floating-elements {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }

    .floating-element {
        position: absolute;
        border-radius: 50%;
        animation: complexFloat 20s infinite ease-in-out;
        backdrop-filter: blur(10px);
    }

    .floating-element:nth-child(1) {
        width: 80px;
        height: 80px;
        top: 10%;
        left: 10%;
        background: rgba(255, 255, 255, 0.1);
        animation-delay: 0s;
    }

    .floating-element:nth-child(2) {
        width: 120px;
        height: 120px;
        top: 70%;
        left: 80%;
        background: rgba(255, 215, 0, 0.2);
        animation-delay: -5s;
    }

    .floating-element:nth-child(3) {
        width: 60px;
        height: 60px;
        top: 50%;
        left: 20%;
        background: rgba(0, 255, 255, 0.15);
        animation-delay: -10s;
    }

    .floating-element:nth-child(4) {
        width: 100px;
        height: 100px;
        top: 30%;
        left: 70%;
        background: rgba(255, 105, 180, 0.15);
        animation-delay: -15s;
    }

    @keyframes complexFloat {
        0%, 100% { 
            transform: translateY(0px) translateX(0px) rotate(0deg); 
            opacity: 0.6; 
        }
        25% { 
            transform: translateY(-100px) translateX(50px) rotate(90deg); 
            opacity: 1; 
        }
        50% { 
            transform: translateY(-50px) translateX(-30px) rotate(180deg); 
            opacity: 0.8; 
        }
        75% { 
            transform: translateY(-80px) translateX(20px) rotate(270deg); 
            opacity: 0.9; 
        }
    }

    /* Glassmorphism Effects */
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .glass-card:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
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

    /* Professional Buttons */
    .btn-professional {
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
    }

    .btn-professional::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.6s;
    }

    .btn-professional:hover::before {
        left: 100%;
    }

    .btn-professional:hover {
        transform: translateY(-5px) rotateX(10deg);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }

    /* Gradient Text Effects */
    .text-gradient-advanced {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: gradientText 3s ease-in-out infinite alternate;
    }

    @keyframes gradientText {
        0% {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            background-clip: text;
        }
        100% {
            background: linear-gradient(135deg, #f093fb 0%, #764ba2 50%, #667eea 100%);
            -webkit-background-clip: text;
            background-clip: text;
        }
    }

    /* Advanced Pulse Effects */
    .pulse-advanced {
        animation: pulseGlow 2s infinite ease-in-out;
    }

    @keyframes pulseGlow {
        0%, 100% { 
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.4),
                        0 0 40px rgba(118, 75, 162, 0.2),
                        inset 0 0 20px rgba(255, 255, 255, 0.1);
        }
        50% { 
            box-shadow: 0 0 30px rgba(102, 126, 234, 0.8),
                        0 0 60px rgba(118, 75, 162, 0.4),
                        inset 0 0 30px rgba(255, 255, 255, 0.2);
        }
    }

    /* Card Hover Effects */
    .card-hover-effect {
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        transform-style: preserve-3d;
    }

    .card-hover-effect:hover {
        transform: rotateY(10deg) rotateX(10deg) translateZ(20px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }

    /* Stats Card Icons */
    .stat-icon {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 25px;
        font-size: 32px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1));
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    /* Badge Styles */
    .status-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 25px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1));
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    /* Table Styles */
    .dashboard-table {
        --bs-table-bg: transparent;
        --bs-table-striped-bg: rgba(0, 0, 0, 0.02);
    }

    .dashboard-table thead th {
        border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        font-weight: 700;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
        backdrop-filter: blur(10px);
    }

    /* Workshop Card */
    .workshop-card {
        transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        overflow: hidden;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .workshop-card:hover {
        transform: translateY(-10px) rotateX(5deg);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }

    .workshop-card img {
        transition: transform 0.5s ease;
        filter: brightness(0.9);
    }

    .workshop-card:hover img {
        transform: scale(1.1);
        filter: brightness(1.1) contrast(1.1);
    }

    /* Section Background Patterns */
    .section-bg-pattern {
        background-image: 
            radial-gradient(circle at 25% 25%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 75% 75%, rgba(118, 75, 162, 0.1) 0%, transparent 50%);
    }

    /* Animation Classes */
    .fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }

    .fade-in-left {
        animation: fadeInLeft 1s ease-out 0.3s both;
    }

    .fade-in-right {
        animation: fadeInRight 1s ease-out 0.6s both;
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

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Animated Stars Effects */
    .stars {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    .star {
        position: absolute;
        width: 3px;
        height: 3px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        animation: twinkle 4s infinite ease-in-out;
    }

    @keyframes twinkle {
        0%, 100% { opacity: 0; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.5); }
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .floating-element {
            width: 40px !important;
            height: 40px !important;
        }
        
        .card-hover-effect:hover {
            transform: none;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section with Greeting -->
<section class="animated-bg min-vh-100 d-flex align-items-center position-relative overflow-hidden">
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <div class="stars">
        <div class="star" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
        <div class="star" style="top: 40%; left: 30%; animation-delay: 1s;"></div>
        <div class="star" style="top: 60%; left: 70%; animation-delay: 2s;"></div>
        <div class="star" style="top: 80%; left: 20%; animation-delay: 3s;"></div>
        <div class="star" style="top: 30%; left: 80%; animation-delay: 0.5s;"></div>
        <div class="star" style="top: 70%; left: 50%; animation-delay: 1.5s;"></div>
    </div>
    
    <div class="container position-relative m-auto mt-6" style="z-index: 10;">
        <div class="row align-items-center">
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="fade-in-up text-center text-lg-end">
                    <h1 class="display-1 fw-black mb-4 text-white" style="line-height: 1.1;">
                        <span class="d-block">مرحباً</span>
                        <span class="d-block text-gradient-advanced display-2">{{ Auth::user()->name }}</span>
                        <span class="d-block h2 fw-bold mt-4 text-white-50">لوحة التحكم الخاصة بك</span>
                    </h1>
                </div>
                
                <div class="fade-in-left text-center text-lg-end">
                    <p class="h4 mb-5 text-white-75 fw-light">
                        نظرة عامة على نشاطك وإنجازاتك في عالم الإبداع والتعلم التفاعلي
                    </p>
                </div>
                
                <div class="fade-in-right">
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-end">
                        <a href="/products" class="btn-professional btn btn-lg px-5 py-3 rounded-pill fw-bold text-white pulse-advanced" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-rocket me-2"></i>
                            استكشف المنتجات
                        </a>
                        <a href="{{ route('stories.create') }}" class="btn-professional btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-bold">
                            <i class="fas fa-plus me-2"></i>
                            أضف قصة جديدة
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 order-1 order-lg-2 fade-in-up mb-5 mb-lg-0">
                <div class="position-relative">
                    <div class="position-absolute" style="inset: -2rem; background: linear-gradient(135deg, #f093fb, #f5576c, #667eea); border-radius: 2rem; filter: blur(20px); opacity: 0.7; animation: pulse 3s infinite;"></div>
                    <div class="glass-card rounded-4 p-4 position-relative">
                        <div class="text-center text-white">
                            <div class="bg-white bg-opacity-10 rounded-3 p-3 d-inline-block mb-3">
                                <span class="h4 fw-bold text-gradient-advanced">{{ now()->format('d M Y') }}</span>
                            </div>
                            <h3 class="h5 mb-0">اليوم هو يوم رائع للإبداع! 🌟</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 section-bg-pattern dashboard-bg">
    <div class="container py-5 m-auto">
        <div class="text-center mb-5 fade-in-up">
            <h2 class="display-4 fw-black text-dark mb-4">
                <span class="text-gradient-advanced">إحصائياتك</span>
            </h2>
            <div class="d-flex justify-content-center mb-4">
                <div style="width: 8rem; height: 4px; background: linear-gradient(135deg, #667eea, #764ba2, #f093fb); border-radius: 2px;"></div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3 fade-in-up" style="animation-delay: 0.1s;">
                <div class="glass-card card-hover-effect rounded-4 h-100 p-4 text-center">
                    <div class="stat-icon text-primary mx-auto mb-4">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h6 class="text-muted mb-2">الطلبات</h6>
                    <h2 class="mb-3 fw-bold text-dark">{{ $stats['orders'] }}</h2>
                    <div class="pt-3 border-top">
                        <small class="text-success fw-bold">
                            <i class="fas fa-arrow-up me-1"></i>
                            {{ $stats['orders'] > 0 ? round(($stats['completed_orders']/$stats['orders'])*100) : 0 }}% معدل الإنجاز
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 fade-in-up" style="animation-delay: 0.2s;">
                <div class="glass-card card-hover-effect rounded-4 h-100 p-4 text-center">
                    <div class="stat-icon text-success mx-auto mb-4">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h6 class="text-muted mb-2">طلبات مكتملة</h6>
                    <h2 class="mb-3 fw-bold text-dark">{{ $stats['completed_orders'] }}</h2>
                    <div class="pt-3 border-top">
                        <small class="text-muted fw-bold">
                            <i class="fas fa-clock me-1"></i>
                            {{ $stats['pending_orders'] }} قيد الانتظار
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 fade-in-up" style="animation-delay: 0.3s;">
                <div class="glass-card card-hover-effect rounded-4 h-100 p-4 text-center">
                    <div class="stat-icon text-info mx-auto mb-4">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h6 class="text-muted mb-2">قصص منشورة</h6>
                    <h2 class="mb-3 fw-bold text-dark">{{ $stats['approved_stories'] }}</h2>
                    <div class="pt-3 border-top">
                        <small class="text-muted fw-bold">
                            <i class="fas fa-pen me-1"></i>
                            {{ $stats['stories'] }} إجمالي القصص
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 fade-in-up" style="animation-delay: 0.4s;">
                <div class="glass-card card-hover-effect rounded-4 h-100 p-4 text-center">
                    <div class="stat-icon text-warning mx-auto mb-4">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h6 class="text-muted mb-2">ورش مسجلة</h6>
                    <h2 class="mb-3 fw-bold text-dark">{{ $stats['workshop_registrations'] }}</h2>
                    <div class="pt-3 border-top">
                        <small class="text-primary fw-bold">
                            <i class="fas fa-calendar-check me-1"></i>
                            {{ $upcomingWorkshops->count() }} قادمة
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recent Activity Section -->
<section class="py-5 animated-bg text-white position-relative overflow-hidden">
    <div class="floating-elements m-auto">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    
    <div class="container py-5 position-relative m-auto" style="z-index: 10;">
        <div class="text-center mb-5 fade-in-up">
            <h2 class="display-4 fw-black mb-4">نشاطك الأخير</h2>
            <p class="h5 text-white-75 mb-5">
                تابع آخر طلباتك وقصصك والورش القادمة
            </p>
        </div>

        <!-- Recent Orders & Stories -->
        <div class="row g-4 mb-5">
            <!-- Recent Orders -->
            <div class="col-lg-8 fade-in-left">
                <div class="glass-card card-hover-effect rounded-4 h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0 text-white">آخر الطلبات</h4>
                    </div>
                    
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table dashboard-table text-white">
                                <thead>
                                    <tr class="text-white-50">
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
                                            <a href="#" class="text-warning fw-bold">#{{ $order->id }}</a>
                                        </td>
                                        <td class="text-white-75">{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="status-badge text-white">
                                                {{ $order->order_status }}
                                            </span>
                                        </td>
                                        <td class="text-end fw-bold text-success">{{ number_format($order->total, 2) }} ر.س</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-4x text-white-50 mb-4"></i>
                            <h5 class="text-white-75">لا توجد طلبات حتى الآن</h5>
                            <a href="/products" class="btn-professional btn btn-outline-light mt-3 rounded-pill px-4">
                                <i class="fas fa-store me-2"></i> تصفح المتجر
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Stories -->
            <div class="col-lg-4 fade-in-right">
                <div class="glass-card card-hover-effect rounded-4 h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0 text-white">آخر القصص</h4>
                        <a href="{{ route('stories.index') }}" class="btn btn-sm btn-outline-light rounded-pill">
                            عرض الكل <i class="fas fa-arrow-left ms-2"></i>
                        </a>
                    </div>
                    
                    @if($recentStories->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentStories as $story)
                            <div class="list-group-item bg-transparent border-0 px-0 py-3 border-bottom border-white-25">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0 fw-bold text-white">{{ Str::limit($story->title, 30) }}</h6>
                                    <span class="status-badge text-white small">
                                        {{ $story->status }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-white-50">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $story->created_at->diffForHumans() }}
                                    </small>
                                    <a href="#" class="text-warning small">عرض التفاصيل</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book-open fa-4x text-white-50 mb-4"></i>
                            <h5 class="text-white-75">لا توجد قصص حتى الآن</h5>
                            <a href="{{ route('stories.create') }}" class="btn-professional btn btn-outline-light mt-3 rounded-pill px-4">
                                <i class="fas fa-plus me-2"></i> أضف قصة جديدة
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Workshops Section -->
<section class="py-5 section-bg-pattern dashboard-bg">
    <div class="container py-5 m-auto">
        <div class="text-center mb-5 fade-in-up">
            <h2 class="display-4 fw-black text-dark mb-4">
                <span class="text-gradient-advanced">ورش العمل القادمة</span>
            </h2>
            <div class="d-flex justify-content-center mb-4">
                <div style="width: 8rem; height: 4px; background: linear-gradient(135deg, #667eea, #764ba2, #f093fb); border-radius: 2px;"></div>
            </div>
        </div>
        
        <div class="row fade-in-up" style="animation-delay: 0.4s;">
            <div class="col-12">
                <div class="glass-card rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0 text-dark">الورش المسجل بها</h4>
                        <a href="{{ route('workshops.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            عرض الكل <i class="fas fa-arrow-left ms-2"></i>
                        </a>
                    </div>
                    
                    @if($upcomingWorkshops->count() > 0)
                        <div class="row g-4">
                            @foreach($upcomingWorkshops as $workshop)
                            <div class="col-md-6 col-lg-4">
                                <div class="workshop-card rounded-4 h-100 overflow-hidden">
                                    @if($workshop->image)
                                        <img src="{{ asset('storage/' . $workshop->image) }}" 
                                             class="card-img-top" 
                                             style="height: 200px; object-fit: cover;" 
                                             alt="{{ $workshop->title }}">
                                    @else
                                        <div class="bg-gradient-primary d-flex align-items-center justify-content-center text-white" 
                                             style="height: 200px;">
                                            <i class="fas fa-chalkboard-teacher fa-4x opacity-50"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h5 class="card-title fw-bold text-dark mb-0">
                                                {{ Str::limit($workshop->title, 40) }}
                                            </h5>
                                            <span class="badge bg-success rounded-pill">مسجل</span>
                                        </div>
                                        
                                        <p class="card-text text-muted mb-3">
                                            {{ Str::limit($workshop->description, 80) }}
                                        </p>
                                        
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="far fa-calendar-alt me-2"></i>
                                                <small>{{ $workshop->start_date ? \Carbon\Carbon::parse($workshop->start_date)->format('d/m/Y') : 'غير محدد' }}</small>
                                            </div>
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="far fa-clock me-2"></i>
                                                <small>{{ $workshop->duration ?? 'غير محدد' }} ساعة</small>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="fas fa-user-tie me-2"></i>
                                                <small>{{ $workshop->instructor ?? 'المدرب غير محدد' }}</small>
                                            </div>
                                            <a href="{{ route('workshops.show', $workshop->id) }}" 
                                               class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                عرض التفاصيل
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
                            <h5 class="text-muted">لا توجد ورش عمل مسجل بها حالياً</h5>
                            <p class="text-muted mb-4">انضم إلى ورش العمل المثيرة وطور مهاراتك</p>
                            <a href="{{ route('workshops.index') }}" class="btn-professional btn btn-primary rounded-pill px-4">
                                <i class="fas fa-search me-2"></i> تصفح الورش المتاحة
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Actions Section -->
<section class="py-5 animated-bg text-white position-relative overflow-hidden">
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    
    <div class="container py-5 position-relative m-auto" style="z-index: 10;">
        <div class="text-center mb-5 fade-in-up">
            <h2 class="display-4 fw-black mb-4">إجراءات سريعة</h2>
            <p class="h5 text-white-75 mb-5">
                الوصول السريع للميزات الأساسية
            </p>
        </div>

        <div class="row g-4 fade-in-up" style="animation-delay: 0.2s;">
            <div class="col-md-6 col-lg-3">
                <div class="glass-card card-hover-effect rounded-4 h-100 p-4 text-center">
                    <div class="stat-icon text-primary mx-auto mb-4">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-3">تصفح المتجر</h5>
                    <p class="text-white-75 mb-4">اكتشف منتجاتنا الرائعة</p>
                    <a href="/products" class="btn-professional btn btn-outline-light rounded-pill px-4">
                        تصفح الآن <i class="fas fa-arrow-left ms-2"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="glass-card card-hover-effect rounded-4 h-100 p-4 text-center">
                    <div class="stat-icon text-success mx-auto mb-4">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-3">قصة جديدة</h5>
                    <p class="text-white-75 mb-4">شارك إبداعك مع العالم</p>
                    <a href="{{ route('stories.create') }}" class="btn-professional btn btn-outline-light rounded-pill px-4">
                        أضف قصة <i class="fas fa-pen ms-2"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="glass-card card-hover-effect rounded-4 h-100 p-4 text-center">
                    <div class="stat-icon text-info mx-auto mb-4">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-3">ورش العمل</h5>
                    <p class="text-white-75 mb-4">انضم لورش تطوير المهارات</p>
                    <a href="{{ route('workshops.index') }}" class="btn-professional btn btn-outline-light rounded-pill px-4">
                        عرض الورش <i class="fas fa-chalkboard-teacher ms-2"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="glass-card card-hover-effect rounded-4 h-100 p-4 text-center">
                    <div class="stat-icon text-warning mx-auto mb-4">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-3">الملف الشخصي</h5>
                    <p class="text-white-75 mb-4">إدارة حسابك وإعداداتك</p>
                    <a href="{{ route('profile.edit') }}" class="btn-professional btn btn-outline-light rounded-pill px-4">
                        تحديث الملف <i class="fas fa-user ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Motivational Quote Section -->
<section class="py-5 section-bg-pattern dashboard-bg">
    <div class="container py-5 m-auto">
        <div class="row justify-content-center fade-in-up">
            <div class="col-lg-8">
                <div class="glass-card rounded-4 p-5 text-center">
                    <div class="mb-4">
                        <i class="fas fa-quote-left fa-2x text-gradient-advanced mb-4"></i>
                    </div>
                    <blockquote class="blockquote mb-4">
                        <p class="h4 fw-light text-dark mb-0" style="line-height: 1.8;">
                            "الإبداع هو الذكاء وهو يستمتع، والتعلم رحلة لا تنتهي نحو اكتشاف إمكانياتك اللامحدودة"
                        </p>
                    </blockquote>
                    <footer class="blockquote-footer">
                        <cite title="Source Title" class="text-gradient-advanced fw-bold">منصة الإبداع والتعلم</cite>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling to all anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add intersection observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all elements with animation classes
    document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right').forEach(el => {
        observer.observe(el);
    });

    // Add dynamic time greeting
    const now = new Date();
    const hour = now.getHours();
    let greeting = '';
    
    if (hour < 12) {
        greeting = 'صباح الخير';
    } else if (hour < 17) {
        greeting = 'مساء الخير';
    } else {
        greeting = 'مساء الخير';
    }
    
    // Update greeting if element exists
    const greetingElement = document.querySelector('.greeting-text');
    if (greetingElement) {
        greetingElement.textContent = greeting;
    }

    // Add card tilt effect for touch devices
    if ('ontouchstart' in window) {
        document.querySelectorAll('.card-hover-effect').forEach(card => {
            card.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.98)';
            });
            
            card.addEventListener('touchend', function() {
                this.style.transform = 'scale(1)';
            });
        });
    }

    // Progress bars animation (if any exist)
    document.querySelectorAll('.progress-bar').forEach(bar => {
        const width = bar.style.width || bar.getAttribute('aria-valuenow') + '%';
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 500);
    });

    // Add loading states for buttons
    document.querySelectorAll('.btn-professional').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!this.classList.contains('disabled')) {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري التحميل...';
                this.classList.add('disabled');
                
                // Re-enable after 2 seconds (adjust as needed)
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.remove('disabled');
                }, 2000);
            }
        });
    });
});

// Add window scroll effects
window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    const parallax = document.querySelectorAll('.floating-element');
    
    parallax.forEach(element => {
        const speed = 0.5;
        element.style.transform = `translateY(${scrolled * speed}px)`;
    });
});

// Performance optimization: Reduce motion for users who prefer it
if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.documentElement.style.setProperty('--animation-duration', '0.01ms');
    document.querySelectorAll('*').forEach(el => {
        el.style.animationDuration = '0.01ms';
        el.style.animationIterationCount = '1';
        el.style.transitionDuration = '0.01ms';
    });
}
</script>
@endsection