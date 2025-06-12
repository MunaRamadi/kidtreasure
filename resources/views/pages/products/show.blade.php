@extends('layouts.app')

@section('title', $product->name)

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

    /* Image Hover Effects */
    .image-hover-effect {
        transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        filter: brightness(0.9);
    }

    .image-hover-effect:hover {
        filter: brightness(1.1) contrast(1.1);
        transform: scale(1.05) rotateZ(2deg);
    }

    /* Product specific styles */
    .product-image-hover {
        transition: all 0.3s ease;
        border-radius: 20px;
    }

    .product-image-hover:hover {
        transform: scale(1.05);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .thumbnail-hover {
        transition: all 0.3s ease;
        border-radius: 15px;
    }

    .thumbnail-hover:hover {
        transform: scale(1.1);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    /* Content box effects */
    .content-item {
        transition: all 0.3s ease;
        border-radius: 15px;
    }

    .content-item:hover {
        transform: translateX(10px);
        background: rgba(59, 130, 246, 0.1);
    }

    .benefit-item {
        transition: all 0.3s ease;
        border-radius: 15px;
    }

    .benefit-item:hover {
        transform: translateX(10px);
        background: rgba(34, 197, 94, 0.2);
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
        
        .order-1, .order-2 {
            order: 0;
        }
        
        .lg\:text-right {
            text-align: center !important;
        }
        
        .lg\:justify-end {
            justify-content: center !important;
        }
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .prose {
        line-height: 1.6;
    }

    .prose p {
        margin-bottom: 1rem;
    }
</style>

<!-- Breadcrumb Section with animated background -->
<section class="animated-bg relative overflow-hidden">
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    
    <div class="stars">
        <div class="star" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
        <div class="star" style="top: 40%; left: 30%; animation-delay: 1s;"></div>
        <div class="star" style="top: 60%; left: 70%; animation-delay: 2s;"></div>
    </div>

    <div class="glass-card border-0 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-white/90 hover:text-white font-semibold transition-colors">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-white/70 rtl:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('products.index') }}" class="mr-1 text-white/90 hover:text-white mr-2 font-semibold transition-colors">Boxes</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-white/70 rtl:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="mr-1 text-white font-bold mr-2">{{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="py-16 section-bg-pattern bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-card rounded-3xl shadow-2xl overflow-hidden card-hover-effect fade-in-up">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 p-8 lg:p-12">
                <div class="space-y-6 fade-in-left">
                    <div class="aspect-square rounded-3xl overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 relative">
                        <div class="absolute -inset-4 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-3xl blur-xl opacity-30 animate-pulse"></div>
                        <img id="mainImage" src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                             class="relative w-full h-full object-cover product-image-hover">
                    </div>

                    @if(count($product->gallery_urls) > 0)
                        <div class="grid grid-cols-4 gap-4">
                            <button onclick="changeMainImage('{{ $product->image_url }}')" 
                                    class="aspect-square rounded-2xl overflow-hidden bg-gray-100 border-4 border-blue-500 thumbnail-hover">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover">
                            </button>
                            @foreach($product->gallery_urls as $image)
                                <button onclick="changeMainImage('{{ $image }}')" 
                                        class="aspect-square rounded-2xl overflow-hidden bg-gray-100 border-4 border-transparent hover:border-blue-500 transition-all thumbnail-hover">
                                    <img src="{{ $image }}" alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    @if($product->video_url)
                        <div class="aspect-video rounded-3xl overflow-hidden bg-gray-100 shadow-2xl">
                            <iframe src="{{ $product->video_url }}" 
                                    class="w-full h-full" 
                                    frameborder="0" 
                                    allowfullscreen></iframe>
                        </div>
                    @endif
                </div>

                <div class="space-y-8 fade-in-right">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            @if($product->is_featured)
                                <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">⭐ Featured</span>
                            @endif
                            <span class="text-lg text-gradient-advanced font-bold">{{ $product->category }}</span>
                            @if($product->age_group)
                                <span class="text-lg text-gray-600 font-semibold">• {{ $product->age_group }}</span>
                            @endif
                        </div>
                        
                        <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 leading-tight">{{ $product->name }}</h1>
                        
                        <div class="flex items-center gap-6 mb-6">
                            <div class="text-3xl font-black text-gradient-advanced">{{ $product->formatted_price }}</div>
                            <div class="flex items-center">
                                <span class="w-4 h-4 rounded-full bg-{{ $product->stock_quantity > 0 ? 'green' : 'red' }}-500 mr-3 shadow-lg"></span>
                                <span class="text-lg font-bold text-{{ $product->stock_quantity > 0 ? 'green' : 'red' }}-600">
                                    {{ $product->stock_status }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card p-6 rounded-2xl">
                        <p class="text-gray-700 leading-relaxed text-lg">{{ $product->description }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-6 glass-card p-6 rounded-2xl">
                        @if($product->difficulty_level)
                            <div class="text-center">
                                <span class="text-sm text-gray-600 block mb-2">Difficulty Level:</span>
                                <div class="font-bold text-gray-900 text-lg">{{ $product->difficulty_level }}</div>
                            </div>
                        @endif
                        
                        @if($product->estimated_time)
                            <div class="text-center">
                                <span class="text-sm text-gray-600 block mb-2">Estimated Time:</span>
                                <div class="font-bold text-gray-900 text-lg">{{ $product->estimated_time }}</div>
                            </div>
                        @endif
                        
                        <div class="text-center">
                            <span class="text-sm text-gray-600 block mb-2">Available Quantity:</span>
                            <div class="font-bold text-gray-900 text-lg">{{ $product->stock_quantity }} pieces</div>
                        </div>
                        
                        @if($product->age_group)
                            <div class="text-center">
                                <span class="text-sm text-gray-600 block mb-2">Age Group:</span>
                                <div class="font-bold text-gray-900 text-lg">{{ $product->age_group }}</div>
                            </div>
                        @endif
                    </div>

                    @if($product->is_available)
                        <form action="{{ route('cart.add-item') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="flex items-center gap-6">
                                <label class="text-lg font-bold text-gray-700">Quantity:</label>
                                <div class="flex items-center glass-card rounded-2xl overflow-hidden">
                                    <button type="button" onclick="decreaseQuantity()" 
                                            class="px-6 py-3 text-gray-600 hover:bg-white/50 font-bold text-xl transition-all">-</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" 
                                           class="w-20 text-center border-0 focus:ring-0 bg-transparent font-bold text-xl">
                                    <button type="button" onclick="increaseQuantity()" 
                                            class="px-6 py-3 text-gray-600 hover:bg-white/50 font-bold text-xl transition-all">+</button>
                                </div>
                            </div>

                            <button type="submit" 
                                    class="btn-professional w-full bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 hover:from-blue-600 hover:via-purple-700 hover:to-pink-600 text-white py-4 px-8 rounded-2xl font-bold text-xl pulse-advanced flex items-center justify-center gap-3 shadow-2xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5L5 21h14"></path>
                                </svg>
                                Add to Cart
                            </button>
                        </form>
                    @else
                        <div class="bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-2xl p-6 text-center glass-card">
                            <p class="font-bold text-xl">⚠️ This product is currently unavailable</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($product->detailed_description)
                <div class="border-t border-gray-200/50 p-8 lg:p-12 section-bg-pattern">
                    <h2 class="text-3xl font-black text-gradient-advanced mb-6">📋 Product Details</h2>
                    <div class="prose max-w-none text-gray-700 glass-card p-8 rounded-3xl">
                        {!! nl2br(e($product->detailed_description)) !!}
                    </div>
                </div>
            @endif

            @if($product->contents && count($product->contents) > 0)
                <div class="border-t border-gray-200/50 p-8 lg:p-12">
                    <h2 class="text-3xl font-black text-gradient-advanced mb-8">📦 Box Contents</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($product->contents as $content)
                            <div class="flex items-center gap-4 p-6 glass-card rounded-2xl content-item">
                                <div class="w-4 h-4 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex-shrink-0 shadow-lg"></div>
                                <span class="text-gray-700 font-semibold text-lg">{{ $content }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($product->educational_benefits && count($product->educational_benefits) > 0)
                <div class="border-t border-gray-200/50 p-8 lg:p-12">
                    <h2 class="text-3xl font-black text-gradient-advanced mb-8">🎯 Educational Benefits</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($product->educational_benefits as $benefit)
                            <div class="flex items-start gap-4 p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl benefit-item card-hover-effect">
                                <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1 shadow-lg">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 leading-relaxed font-semibold text-lg">{{ $benefit }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        @if($relatedProducts->count() > 0)
            <div class="mt-20 fade-in-up">
                <h2 class="text-4xl font-black text-gradient-advanced mb-10 text-center">🔗 Similar Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="glass-card rounded-3xl card-hover-effect shadow-2xl overflow-hidden">
                            <div class="relative overflow-hidden">
                                <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}" 
                                     class="w-full h-56 object-cover image-hover-effect">
                                @if($relatedProduct->is_featured)
                                    <div class="absolute top-4 right-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-2 rounded-full text-sm font-bold shadow-lg">
                                        ⭐ Featured
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <div class="mb-3">
                                    <span class="text-sm text-gradient-advanced font-bold">{{ $relatedProduct->category }}</span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-4 line-clamp-2">{{ $relatedProduct->name }}</h3>
                                <div class="flex items-center justify-between">
                                    <div class="text-xl font-black text-gradient-advanced">{{ $relatedProduct->formatted_price }}</div>
                                    <a href="{{ route('products.show', $relatedProduct) }}" 
                                       class="btn-professional bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-2xl hover:from-blue-600 hover:to-purple-700 transition-all font-bold shadow-lg">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<script>
function changeMainImage(imageSrc) {
    document.getElementById('mainImage').src = imageSrc;
    
    // Update active thumbnail border
    const thumbnails = document.querySelectorAll('button[onclick*="changeMainImage"]');
    thumbnails.forEach(thumb => {
        thumb.classList.remove('border-blue-500');
        thumb.classList.add('border-transparent');});
    
    // Set active border for clicked thumbnail
    event.target.closest('button').classList.remove('border-transparent');
    event.target.closest('button').classList.add('border-blue-500');
}

function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const max = parseInt(quantityInput.getAttribute('max'));
    const current = parseInt(quantityInput.value);
    
    if (current < max) {
        quantityInput.value = current + 1;
    }
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const min = parseInt(quantityInput.getAttribute('min'));
    const current = parseInt(quantityInput.value);
    
    if (current > min) {
        quantityInput.value = current - 1;
    }
}

// Add dynamic stars animation
function createStars() {
    const starsContainer = document.querySelector('.stars');
    if (!starsContainer) return;
    
    for (let i = 0; i < 20; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        star.style.top = Math.random() * 100 + '%';
        star.style.left = Math.random() * 100 + '%';
        star.style.animationDelay = Math.random() * 4 + 's';
        starsContainer.appendChild(star);
    }
}

// Initialize animations on page load
document.addEventListener('DOMContentLoaded', function() {
    createStars();
    
    // Add smooth scrolling for internal links
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
    
    // Lazy load images
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
    
    // Add product image zoom functionality
    const mainImage = document.getElementById('mainImage');
    if (mainImage) {
        mainImage.addEventListener('click', function() {
            // Create modal for image zoom
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
            modal.style.backdropFilter = 'blur(10px)';
            
            const img = document.createElement('img');
            img.src = this.src;
            img.className = 'max-w-full max-h-full object-contain rounded-2xl shadow-2xl';
            
            const closeBtn = document.createElement('button');
            closeBtn.innerHTML = '✕';
            closeBtn.className = 'absolute top-4 right-4 text-white text-3xl font-bold hover:text-gray-300 transition-colors';
            closeBtn.onclick = () => modal.remove();
            
            modal.appendChild(img);
            modal.appendChild(closeBtn);
            modal.onclick = (e) => {
                if (e.target === modal) modal.remove();
            };
            
            document.body.appendChild(modal);
        });
        
        // Add cursor pointer to indicate clickable
        mainImage.style.cursor = 'zoom-in';
    }
    
    // Form validation
    const addToCartForm = document.querySelector('form[action*="cart.add-item"]');
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            const quantity = parseInt(document.getElementById('quantity').value);
            const maxQuantity = parseInt(document.getElementById('quantity').getAttribute('max'));
            
            if (quantity > maxQuantity) {
                e.preventDefault();
                alert('الكمية المطلوبة أكبر من المتوفر في المخزون');
                return false;
            }
            
            if (quantity < 1) {
                e.preventDefault();
                alert('يجب أن تكون الكمية أكبر من صفر');
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<div class="animate-spin rounded-full h-6 w-6 border-b-2 border-white mx-auto"></div>';
            submitBtn.disabled = true;
            
            // Re-enable after 2 seconds (in case of slow response)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });
    }
    
    // Add scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const scrollObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);
    
    // Observe all cards and sections
    document.querySelectorAll('.glass-card, .content-item, .benefit-item').forEach(el => {
        scrollObserver.observe(el);
    });
    
    // Add keyboard navigation for quantity
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        quantityInput.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowUp') {
                e.preventDefault();
                increaseQuantity();
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                decreaseQuantity();
            }
        });
    }
    
    // Add touch gestures for mobile image gallery
    let touchStartX = 0;
    let touchEndX = 0;
    
    const imageContainer = document.querySelector('.aspect-square');
    if (imageContainer) {
        imageContainer.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        imageContainer.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            handleGesture();
        });
    }
    
    function handleGesture() {
        const gallery = document.querySelectorAll('button[onclick*="changeMainImage"]');
        if (gallery.length <= 1) return;
        
        const currentActive = document.querySelector('button[onclick*="changeMainImage"].border-blue-500');
        const currentIndex = Array.from(gallery).indexOf(currentActive);
        
        if (touchEndX < touchStartX - 50) {
            // Swipe left - next image
            const nextIndex = (currentIndex + 1) % gallery.length;
            gallery[nextIndex].click();
        }
        
        if (touchEndX > touchStartX + 50) {
            // Swipe right - previous image
            const prevIndex = currentIndex > 0 ? currentIndex - 1 : gallery.length - 1;
            gallery[prevIndex].click();
        }
    }
});

// Add CSS for additional animations
const additionalStyles = `
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out forwards;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Loading spinner */
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    /* Enhanced mobile responsiveness */
    @media (max-width: 640px) {
        .text-4xl { font-size: 2rem !important; }
        .text-3xl { font-size: 1.5rem !important; }
        .py-16 { padding-top: 2rem !important; padding-bottom: 2rem !important; }
        .p-8 { padding: 1rem !important; }
        .gap-12 { gap: 2rem !important; }
    }
`;

// Inject additional styles
const styleSheet = document.createElement('style');
styleSheet.textContent = additionalStyles;
document.head.appendChild(styleSheet);