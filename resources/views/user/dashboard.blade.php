@extends('layouts.app')
@section('content')

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
    
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center fade-in-up">
            <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight">
                <span class="block text-white drop-shadow-2xl">Welcome to Your</span>
                <span class="block text-gradient-advanced text-5xl md:text-7xl">Dashboard</span>
            </h1>
            <p class="text-xl md:text-2xl text-white/95 font-light max-w-3xl mx-auto">
                Manage your sustainable educational journey with comprehensive insights and controls
            </p>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-16 section-bg-pattern bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12 fade-in-up">
            <h2 class="text-3xl md:text-5xl font-black text-gray-800 mb-4">
                <span class="text-gradient-advanced">Your Statistics</span>
            </h2>
            <div class="flex justify-center mb-6">
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="dashboard-grid">
            <div class="stat-card card-hover-effect p-8 rounded-3xl fade-in-left">
                <div class="bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700 rounded-3xl w-16 h-16 flex items-center justify-center mb-6 shadow-2xl">
                    <i class="fas fa-box text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Total Products</h3>
                <p class="text-4xl font-black text-gradient-advanced mb-4">{{ $totalProducts ?? '127' }}</p>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 85%;"></div>
                </div>
                <p class="text-sm text-gray-600 mt-2">+12% from last month</p>
            </div>
            
            <div class="stat-card card-hover-effect p-8 rounded-3xl fade-in-up" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-br from-green-500 via-emerald-600 to-teal-700 rounded-3xl w-16 h-16 flex items-center justify-center mb-6 shadow-2xl">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Active Users</h3>
                <p class="text-4xl font-black text-gradient-advanced mb-4">{{ $activeUsers ?? '2,543' }}</p>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 92%;"></div>
                </div>
                <p class="text-sm text-gray-600 mt-2">+8% from last month</p>
            </div>
            
            <div class="stat-card card-hover-effect p-8 rounded-3xl fade-in-right" style="animation-delay: 0.4s;">
                <div class="bg-gradient-to-br from-purple-500 via-pink-600 to-rose-700 rounded-3xl w-16 h-16 flex items-center justify-center mb-6 shadow-2xl">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Revenue</h3>
                <p class="text-4xl font-black text-gradient-advanced mb-4">JD {{ $revenue ?? '15,240' }}</p>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 78%;"></div>
                </div>
                <p class="text-sm text-gray-600 mt-2">+15% from last month</p>
            </div>
            
            <div class="stat-card card-hover-effect p-8 rounded-3xl fade-in-left" style="animation-delay: 0.6s;">
                <div class="bg-gradient-to-br from-yellow-500 via-orange-600 to-red-700 rounded-3xl w-16 h-16 flex items-center justify-center mb-6 shadow-2xl">
                    <i class="fas fa-shopping-cart text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Orders</h3>
                <p class="text-4xl font-black text-gradient-advanced mb-4">{{ $totalOrders ?? '432' }}</p>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 95%;"></div>
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
                    </div>
                    
                    <div class="activity-item">
                        <div class="flex items-center">
                            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full w-10 h-10 flex items-center justify-center mr-4">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">New User Registration</h4>
                                <p class="text-sm text-gray-600">Ahmad Ali joined - 12 minutes ago</p>
                            </div>
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
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-white text-sm">Sales Target</span>
                                <span class="text-white text-sm">85%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 85%;"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-white text-sm">User Engagement</span>
                                <span class="text-white text-sm">92%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 92%;"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-white text-sm">Sustainability Goal</span>
                                <span class="text-white text-sm">78%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 78%;"></div>
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
    
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
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
                  
                </div>
            </div>
        </div>
    </div>
</section>



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

    // Add progress bar animation on scroll
    const progressBars = document.querySelectorAll('.progress-fill');
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const width = entry.target.style.width;
                entry.target.style.width = '0%';
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