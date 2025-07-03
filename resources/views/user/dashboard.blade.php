@extends('layouts.app')

@section('title', 'لوحة التحكم')

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
    }

    .glass-card:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-10px);
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

    /* Section Background Patterns */
    .section-bg-pattern {
        background-image: 
            radial-gradient(circle at 25% 25%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 75% 75%, rgba(118, 75, 162, 0.1) 0%, transparent 50%);
    }

    /* Loading and Animation Effects */
    .fade-in-up {
        animation: fadeInUp 1s ease-out;
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
            transform: translateY(50px);
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

    /* Responsive Design for Mobile */
    @media (max-width: 768px) {
        .floating-element {
            width: 40px !important;
            height: 40px !important;
        }
        
        .card-hover-effect:hover {
            transform: none;
        }
        
        .dashboard-grid {
            grid-template-columns: 1fr !important;
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
        width: 2px;
        height: 2px;
        background: white;
        border-radius: 50%;
        animation: twinkle 4s infinite ease-in-out;
    }

    @keyframes twinkle {
        0%, 100% { opacity: 0; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.5); }
    }

    /* Dashboard Specific Styles */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .stat-card {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .stat-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .progress-bar {
        background: linear-gradient(90deg, #667eea, #764ba2);
        height: 8px;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #f093fb, #f5576c);
        border-radius: 10px;
        animation: progressGlow 2s ease-in-out infinite alternate;
    }

    @keyframes progressGlow {
        0% { box-shadow: 0 0 10px rgba(240, 147, 251, 0.5); }
        100% { box-shadow: 0 0 20px rgba(245, 87, 108, 0.8); }
    }

    /* Chart Container Styles */
    .chart-container {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 2rem;
    }

    /* Activity Feed Styles */
    .activity-item {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 1rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(10px);
    }

    /* Quick Actions Grid */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .quick-action-btn {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        padding: 1.5rem;
        border-radius: 20px;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        color: white;
        text-decoration: none;
    }

    .quick-action-btn:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        color: white;
        text-decoration: none;
    }
</style>

<!-- Header Section -->
<section class="animated-bg py-16 relative overflow-hidden">
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
            <div class="flex justify-center mb-6">
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-full"></div>
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
                <p class="text-sm text-gray-600 mt-2">+12% from last month</p>
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
                <p class="text-sm text-gray-600 mt-2">+8% from last month</p>
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
                <p class="text-sm text-gray-600 mt-2">+15% from last month</p>
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
                <p class="text-sm text-gray-600 mt-2">+22% from last month</p>
            </div>
        </div>
    </div>
</section>



<!-- Recent Activity Section -->
<section class="py-16 section-bg-pattern bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Recent Activity -->
            <div class="fade-in-left">
                <h3 class="text-3xl font-bold text-gray-800 mb-8">
                    <span class="text-gradient-advanced">Recent Activity</span>
                </h3>
                <div class="space-y-4">
                    <div class="activity-item">
                        <div class="flex items-center">
                            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-full w-10 h-10 flex items-center justify-center mr-4">
                                <i class="fas fa-check text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">New Order Received</h4>
                                <p class="text-sm text-gray-600">Educational Kit #1234 - 5 minutes ago</p>
                            </div>
                        </div>
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
                    </div>
                    
                    <div class="activity-item">
                        <div class="flex items-center">
                            <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-full w-10 h-10 flex items-center justify-center mr-4">
                                <i class="fas fa-star text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Product Review</h4>
                                <p class="text-sm text-gray-600">5-star review received - 1 hour ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Performance Chart -->
            <div class="fade-in-right">
                <h3 class="text-3xl font-bold text-gray-800 mb-8">
                    <span class="text-gradient-advanced">Performance Overview</span>
                </h3>
                <div class="chart-container">
                    <div class="flex items-center justify-between mb-6">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-white">87%</p>
                            <p class="text-sm text-white/80">Customer Satisfaction</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-white">156</p>
                            <p class="text-sm text-white/80">Active Projects</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-white">24/7</p>
                            <p class="text-sm text-white/80">Support Available</p>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Action Panel -->
<section class="py-16 animated-bg text-white relative overflow-hidden">
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    
    <div class="max-w-4xl mx-auto px-6 text-center relative m-auto z-10">
        <div class="fade-in-up">
            <h2 class="text-3xl md:text-5xl font-black mb-8">Ready to Take Action?</h2>
            <p class="text-xl text-white/95 mb-12 leading-relaxed">
                Explore your management tools and continue building sustainable educational experiences
            </p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-6 justify-center fade-in-up" style="animation-delay: 0.3s;">
            <a href="/products" class="btn-professional bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 hover:from-yellow-500 hover:via-orange-600 hover:to-red-600 text-white font-bold py-4 px-10 rounded-3xl text-lg shadow-2xl inline-flex items-center justify-center pulse-advanced">
                <i class="fas fa-cogs mr-3 text-xl"></i>
                <span>Manage Products</span>
            </a>
            
         
        </div>
        
        <div class="mt-12 fade-in-up" style="animation-delay: 0.6s;">
            <div class="glass-card rounded-3xl p-8 max-w-2xl mx-auto">
                <h3 class="text-2xl font-bold mb-4">Need Help?</h3>
                <p class="text-white/90 mb-6">Our support team is here to assist you with any questions or technical issues.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/contact-us" class="btn-professional bg-white/20 hover:bg-white/30 text-white font-semibold py-3 px-6 rounded-2xl inline-flex items-center justify-center">
                        <i class="fas fa-headset mr-2"></i>
                        Contact Support
                    </a>
                  

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
    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Add intersection observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, observerOptions);

    // Observe all animated elements
    document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right').forEach(el => {
        el.style.animationPlayState = 'paused';
        observer.observe(el);
    });

    // Add dynamic star generation
    function createStars() {
        const starsContainer = document.querySelector('.stars');
        const numStars = 20;
        
        for (let i = 0; i < numStars; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            star.style.top = Math.random() * 100 + '%';
            star.style.left = Math.random() * 100 + '%';
            star.style.animationDelay = Math.random() * 4 + 's';
            starsContainer.appendChild(star);
        }
    }

    // Initialize stars on page load
    document.addEventListener('DOMContentLoaded', createStars);

    // Add tooltip functionality for stat cards
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) scale(1.05)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

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
                    entry.target.style.width = width;
                    entry.target.style.transition = 'width 2s ease-in-out';
                }, 100);
            }
        });
    });

    progressBars.forEach(bar => {
        progressObserver.observe(bar);
    });

    // Add real-time clock functionality
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', {
            hour12: false,
            hour: '2-digit',
            minute: '2-digit'
        });
        
        // If there's a clock element, update it
        const clockElement = document.getElementById('dashboard-clock');
        if (clockElement) {
            clockElement.textContent = timeString;
        }
    }

    // Update clock every second
    setInterval(updateClock, 1000);
    updateClock(); // Initial call

    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey || e.metaKey) {
            switch(e.key) {
                case '1':
                    e.preventDefault();
                    window.location.href = '/products/create';
                    break;
                case '2':
                    e.preventDefault();
                    window.location.href = '/orders';
                    break;
                case '3':
                    e.preventDefault();
                    window.location.href = '/users';
                    break;
                case '4':
                    e.preventDefault();
                    window.location.href = '/analytics';
                    break;
            }
        }
    });

    // Add loading states for quick action buttons
    document.querySelectorAll('.quick-action-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const icon = this.querySelector('i');
            const originalClass = icon.className;
            
            icon.className = 'fas fa-spinner fa-spin text-white text-2xl';
            
            setTimeout(() => {
                icon.className = originalClass;
            }, 1000);
        });
    });
</script>

@endsection