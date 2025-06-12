@extends('layouts.app')

@section('title', 'Educational Boxes')

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
        transform: rotateY(5deg) rotateX(5deg) translateZ(10px);
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

    /* Enhanced Product Card Effects */
    .product-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        transform-style: preserve-3d;
    }

    .product-card:hover {
        transform: translateY(-15px) rotateX(5deg);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        background: rgba(255, 255, 255, 0.98);
    }

    .product-image-container {
        overflow: hidden;
        position: relative;
    }

    .product-image {
        transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        filter: brightness(0.95);
    }

    .product-card:hover .product-image {
        transform: scale(1.1) rotateZ(2deg);
        filter: brightness(1.05) contrast(1.1);
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

    /* Enhanced Filter Sidebar */
    .filter-sidebar {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    /* Responsive Design for Mobile */
    @media (max-width: 768px) {
        .floating-element {
            width: 40px !important;
            height: 40px !important;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
        }
        
        .card-hover-effect:hover {
            transform: none;
        }
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<!-- Header Section with Animated Background -->
<section class="animated-bg text-white relative overflow-hidden py-20">
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
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center fade-in-up">
            <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight">
                <span class="text-gradient-advanced">Educational Boxes</span>
            </h1>
            <div class="flex justify-center mb-8">
                <div class="w-32 h-2 bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 rounded-full"></div>
            </div>
            <p class="text-xl md:text-2xl max-w-4xl mx-auto text-white/95 font-light leading-relaxed">
                Discover our diverse collection of educational boxes designed to develop children's skills and enrich their learning experience.
            </p>
        </div>
    </div>
</section>

<section class="py-16 section-bg-pattern bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-1/4">
                <div class="filter-sidebar rounded-3xl shadow-2xl p-8 sticky top-6 card-hover-effect">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 text-gradient-advanced">Filter Results</h3>
                    
                    <form method="GET" action="{{ route('products.index') }}" id="filterForm">
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search for product..." 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Price Range</label>
                            <div class="flex gap-3">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                       placeholder="Min" min="{{ $filters['price_range']['min'] }}" 
                                       class="w-1/2 px-4 py-3 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">
                                <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                       placeholder="Max" max="{{ $filters['price_range']['max'] }}" 
                                       class="w-1/2 px-4 py-3 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">
                            </div>
                            <div class="text-sm text-gray-500 mt-2 font-medium">
                                {{ number_format($filters['price_range']['min'], 2) }} - {{ number_format($filters['price_range']['max'], 2) }} JOD
                            </div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Box Type</label>
                            <select name="category" class="w-full px-4 py-3 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">
                                <option value="">All Types</option>
                                @foreach($filters['categories'] as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Age Group</label>
                            <select name="age_group" class="w-full px-4 py-3 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">
                                <option value="">All Ages</option>
                                @foreach($filters['age_groups'] as $ageGroup)
                                    <option value="{{ $ageGroup }}" {{ request('age_group') == $ageGroup ? 'selected' : '' }}>
                                        {{ $ageGroup }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Difficulty Level</label>
                            <select name="difficulty_level" class="w-full px-4 py-3 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">
                                <option value="">All Levels</option>
                                @foreach($filters['difficulty_levels'] as $level)
                                    <option value="{{ $level }}" {{ request('difficulty_level') == $level ? 'selected' : '' }}>
                                        {{ $level }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="flex-1 btn-professional bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 text-white font-bold py-4 px-6 rounded-2xl hover:from-blue-600 hover:via-purple-700 hover:to-pink-600">
                                <i class="fas fa-search mr-2"></i>
                                Apply
                            </button>
                            <a href="{{ route('products.index') }}" class="flex-1 btn-professional bg-gradient-to-r from-gray-400 to-gray-500 text-white font-bold py-4 px-6 rounded-2xl hover:from-gray-500 hover:to-gray-600 text-center">
                                <i class="fas fa-refresh mr-2"></i>
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:w-3/4">
                <div class="glass-card rounded-3xl shadow-2xl p-6 mb-8 fade-in-up">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div class="mb-4 sm:mb-0">
                            <p class="text-gray-700 font-semibold text-lg">
                                <i class="fas fa-box mr-2 text-blue-500"></i>
                                Displaying {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                            </p>
                        </div>
                        
                        <div class="flex gap-3 items-center">
                            <i class="fas fa-sort text-gray-500"></i>
                            <select name="sort_by" onchange="updateSort()" class="px-4 py-3 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 font-medium">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Newest</option>
                                <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="featured" {{ request('sort_by') == 'featured' ? 'selected' : '' }}>Featured</option>
                            </select>
                        </div>
                    </div>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
                        @foreach($products as $product)
                            <div class="product-card rounded-3xl shadow-2xl overflow-hidden group fade-in-up" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                                <div class="product-image-container relative">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                         class="product-image w-full h-56 object-cover">
                                    
                                    @if($product->is_featured)
                                        <div class="absolute top-4 right-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-2 rounded-full text-sm font-bold shadow-lg pulse-advanced">
                                            <i class="fas fa-star mr-1"></i>
                                            Featured
                                        </div>
                                    @endif
                                    
                                    <div class="absolute top-4 left-4 bg-gradient-to-r from-{{ $product->stock_quantity > 0 ? 'green-500 to-emerald-600' : 'red-500 to-red-600' }} text-white px-3 py-2 rounded-full text-sm font-bold shadow-lg">
                                        <i class="fas fa-{{ $product->stock_quantity > 0 ? 'check' : 'times' }} mr-1"></i>
                                        {{ $product->stock_status }}
                                    </div>

                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>

                                <div class="p-6">
                                    <div class="mb-3">
                                        <span class="text-sm text-blue-600 font-bold bg-blue-50 px-3 py-1 rounded-full">{{ $product->category }}</span>
                                        @if($product->age_group)
                                            <span class="text-sm text-gray-500 font-medium mr-2">• {{ $product->age_group }}</span>
                                        @endif
                                    </div>
                                    
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors duration-300">{{ $product->name }}</h3>
                                    
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed">{{ $product->description }}</p>
                                    
                                    @if($product->difficulty_level)
                                        <div class="flex items-center mb-4">
                                            <div class="flex items-center bg-gray-100 rounded-full px-3 py-1">
                                                <i class="fas fa-layer-group text-gray-500 text-xs mr-2"></i>
                                                <span class="text-sm font-medium text-gray-700">{{ $product->difficulty_level }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between">
                                        <div class="text-2xl font-black text-gradient-advanced">
                                            {{ $product->formatted_price }}
                                        </div>
                                        
                                        <a href="{{ route('products.show', $product) }}" 
                                           class="btn-professional bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 text-white font-bold px-6 py-3 rounded-2xl hover:from-blue-600 hover:via-purple-700 hover:to-pink-600 text-sm inline-flex items-center">
                                            <i class="fas fa-eye mr-2"></i>
                                            <span>View Details</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="glass-card rounded-3xl shadow-2xl p-6 fade-in-up">
                        <div class="flex justify-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                @else
                    <div class="glass-card rounded-3xl shadow-2xl p-16 text-center fade-in-up">
                        <div class="text-gray-400 mb-8">
                            <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-search text-4xl text-gradient-advanced"></i>
                            </div>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-4 text-gradient-advanced">No Products Found</h3>
                        <p class="text-xl text-gray-600 mb-8 leading-relaxed max-w-md mx-auto">No products were found matching your search criteria.</p>
                        <a href="{{ route('products.index') }}" class="btn-professional bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 text-white font-bold px-8 py-4 rounded-2xl hover:from-blue-600 hover:via-purple-700 hover:to-pink-600 inline-flex items-center">
                            <i class="fas fa-box mr-3"></i>
                            <span>View All Products</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<script>
function updateSort() {
    const sortSelect = document.querySelector('select[name="sort_by"]');
    const url = new URL(window.location);
    url.searchParams.set('sort_by', sortSelect.value);
    window.location.href = url.toString();
}

// Auto-submit form on filter change with enhanced UX
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    const inputs = filterForm.querySelectorAll('select, input');
    
    inputs.forEach(input => {
        if (input.type !== 'submit') {
            input.addEventListener('change', function() {
                // Add loading state
                const submitBtn = filterForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>جاري التحميل...';
                submitBtn.disabled = true;
                
                if (this.name !== 'search') {
                    setTimeout(() => {
                        filterForm.submit();
                    }, 300);
                }
            });
        }
    });

    // Enhanced search with debounce
    const searchInput = filterForm.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 3 || this.value.length === 0) {
                    const submitBtn = filterForm.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-search fa-spin mr-2"></i>بحث...';
                    filterForm.submit();
                }
            }, 500);});
    }

    // Smooth scrolling animations on scroll
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

    // Observe all fade-in elements
    document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right').forEach(el => {
        observer.observe(el);
    });

    // Enhanced product card hover effects
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) rotateX(5deg)';
            this.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.15)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) rotateX(0)';
            this.style.boxShadow = '0 8px 32px rgba(0, 0, 0, 0.1)';
        });
    });

    // Dynamic star generation
    function createStar() {
        const star = document.createElement('div');
        star.className = 'star';
        star.style.top = Math.random() * 100 + '%';
        star.style.left = Math.random() * 100 + '%';
        star.style.animationDelay = Math.random() * 4 + 's';
        return star;
    }

    // Add more stars dynamically
    const starsContainer = document.querySelector('.stars');
    if (starsContainer) {
        for (let i = 0; i < 20; i++) {
            starsContainer.appendChild(createStar());
        }
    }

    // Parallax effect for floating elements
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        
        document.querySelectorAll('.floating-element').forEach((element, index) => {
            const speed = (index + 1) * 0.2;
            element.style.transform = `translateY(${rate * speed}px) translateX(${Math.sin(scrolled * 0.001 + index) * 20}px)`;
        });
    });

    // Price range validation
    const minPriceInput = document.querySelector('input[name="min_price"]');
    const maxPriceInput = document.querySelector('input[name="max_price"]');

    if (minPriceInput && maxPriceInput) {
        minPriceInput.addEventListener('input', function() {
            const minValue = parseFloat(this.value);
            const maxValue = parseFloat(maxPriceInput.value);
            
            if (maxValue && minValue > maxValue) {
                maxPriceInput.value = minValue;
            }
        });

        maxPriceInput.addEventListener('input', function() {
            const maxValue = parseFloat(this.value);
            const minValue = parseFloat(minPriceInput.value);
            
            if (minValue && maxValue < minValue) {
                minPriceInput.value = maxValue;
            }
        });
    }

    // Keyboard navigation support
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.tagName === 'SELECT') {
            e.target.dispatchEvent(new Event('change'));
        }
    });

    // Loading overlay for better UX
    function showLoadingOverlay() {
        const overlay = document.createElement('div');
        overlay.id = 'loading-overlay';
        overlay.innerHTML = `
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-3xl p-8 shadow-2xl text-center">
                    <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-blue-500 mx-auto mb-4"></div>
                    <p class="text-xl font-bold text-gray-700">جاري التحميل...</p>
                </div>
            </div>
        `;
        document.body.appendChild(overlay);
    }

    // Enhanced form submission with loading state
    filterForm.addEventListener('submit', function(e) {
        showLoadingOverlay();
    });

    // Auto-hide loading overlay after navigation
    window.addEventListener('pageshow', function() {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.remove();
        }
    });

    // Enhanced accessibility
    document.querySelectorAll('button, a, select, input').forEach(element => {
        element.addEventListener('focus', function() {
            this.style.outline = '3px solid rgba(59, 130, 246, 0.5)';
            this.style.outlineOffset = '2px';
        });

        element.addEventListener('blur', function() {
            this.style.outline = 'none';
        });
    });

    // Performance optimization - lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Add ripple effect to buttons
    document.querySelectorAll('.btn-professional').forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Add CSS for ripple effect
    const rippleCSS = `
        .btn-professional {
            position: relative;
            overflow: hidden;
        }
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    
    const style = document.createElement('style');
    style.textContent = rippleCSS;
    document.head.appendChild(style);
});

// Additional utility functions
function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            timeout = null;
            if (!immediate) func(...args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func(...args);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Initialize tooltips for better UX
function initTooltips() {
    document.querySelectorAll('[data-tooltip]').forEach(element => {
        element.addEventListener('mouseenter', function(e) {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.dataset.tooltip;
            tooltip.style.cssText = `
                position: absolute;
                background: rgba(0, 0, 0, 0.8);
                color: white;
                padding: 8px 12px;
                border-radius: 6px;
                font-size: 14px;
                pointer-events: none;
                z-index: 1000;
                white-space: nowrap;
            `;
            
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + rect.width / 2 - tooltip.offsetWidth / 2 + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';
            
            this._tooltip = tooltip;
        });

        element.addEventListener('mouseleave', function() {
            if (this._tooltip) {
                this._tooltip.remove();
                this._tooltip = null;
            }
        });
    });
}

// Initialize all enhancements
document.addEventListener('DOMContentLoaded', initTooltips);
</script>

@endsection