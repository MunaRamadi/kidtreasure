@extends('layouts.app')

@section('title', $product->name)

@push('styles')
{{-- The old styles have been removed and replaced by the styles from index.blade.php --}}
@endpush

@section('content')

{{-- The new design starts here, using styles and structure from index.blade.php --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    
    /* CSS Variables for Colors */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --accent-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --glass-bg: rgba(255, 255, 255, 0.1);
        --glass-border: rgba(255, 255, 255, 0.2);
        --light-gray: #F8FAFC;
        --medium-gray: #64748B;
        --dark-gray: #1E293B;
        --border-radius: 1.5rem; /* 24px */
    }

    /* Set body to LTR */
    body {
        direction: ltr;
        text-align: left;
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

    /* Floating Background Elements */
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

    .floating-element:nth-child(1) { width: 80px; height: 80px; top: 10%; left: 10%; background: rgba(255, 255, 255, 0.1); animation-delay: 0s; }
    .floating-element:nth-child(2) { width: 120px; height: 120px; top: 70%; left: 80%; background: rgba(255, 215, 0, 0.2); animation-delay: -5s; }
    .floating-element:nth-child(3) { width: 60px; height: 60px; top: 50%; left: 20%; background: rgba(0, 255, 255, 0.15); animation-delay: -10s; }
    .floating-element:nth-child(4) { width: 100px; height: 100px; top: 30%; left: 70%; background: rgba(255, 105, 180, 0.15); animation-delay: -15s; }

    @keyframes complexFloat {
        0%, 100% { transform: translateY(0px) translateX(0px) rotate(0deg); opacity: 0.6; }
        25% { transform: translateY(-100px) translateX(50px) rotate(90deg); opacity: 1; }
        50% { transform: translateY(-50px) translateX(-30px) rotate(180deg); opacity: 0.8; }
        75% { transform: translateY(-80px) translateX(20px) rotate(270deg); opacity: 0.9; }
    }

    /* Glassmorphism Effects */
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border-radius: var(--border-radius);
    }
    .glass-card:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }
    
    /* Solid background card for better readability */
    .solid-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        transform-style: preserve-3d;
        border-radius: var(--border-radius);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .solid-card:hover {
        transform: translateY(-15px) rotateX(5deg);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        background: rgba(255, 255, 255, 0.98);
    }


    /* Professional Buttons */
    .btn-professional {
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
        border-radius: 1rem; /* 16px */
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
        0% { background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); -webkit-background-clip: text; background-clip: text; }
        100% { background: linear-gradient(135deg, #f093fb 0%, #764ba2 50%, #667eea 100%); -webkit-background-clip: text; background-clip: text; }
    }

    /* Advanced Pulse Effects */
    .pulse-advanced {
        animation: pulseGlow 2s infinite ease-in-out;
    }

    @keyframes pulseGlow {
        0%, 100% { 
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.4), 0 0 40px rgba(118, 75, 162, 0.2), inset 0 0 20px rgba(255, 255, 255, 0.1);
        }
        50% { 
            box-shadow: 0 0 30px rgba(102, 126, 234, 0.8), 0 0 60px rgba(118, 75, 162, 0.4), inset 0 0 30px rgba(255, 255, 255, 0.2);
        }
    }
    
    /* Section Background Patterns */
    .section-bg-pattern {
        background-image: 
            radial-gradient(circle at 25% 25%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 75% 75%, rgba(118, 75, 162, 0.1) 0%, transparent 50%);
    }

    /* Loading and Animation Effects */
    .fade-in-up { animation: fadeInUp 1s ease-out; }
    .fade-in-right { animation: fadeInRight 1s ease-out 0.3s both; }

    @keyframes fadeInUp { from { opacity: 0; transform: translateY(50px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInRight { from { opacity: 0; transform: translateX(50px); } to { opacity: 1; transform: translateX(0); } }

    /* Product Card from index.blade.php */
    .product-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        transform-style: preserve-3d;
        border-radius: var(--border-radius);
    }
    .product-card:hover {
        transform: translateY(-15px) rotateX(5deg);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        background: rgba(255, 255, 255, 0.98);
    }
    .product-image-container { overflow: hidden; position: relative; border-radius: var(--border-radius); cursor: zoom-in; }
    .product-image { transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94); filter: brightness(0.95); }
    .product-card:hover .product-image, .product-image:hover { transform: scale(1.1) rotateZ(2deg); filter: brightness(1.05) contrast(1.1); }
    
    /* Animated Stars Effects */
    .stars { position: absolute; width: 100%; height: 100%; z-index: 0; }
    .star { position: absolute; width: 2px; height: 2px; background: white; border-radius: 50%; animation: twinkle 4s infinite ease-in-out; }
    @keyframes twinkle { 0%, 100% { opacity: 0; transform: scale(1); } 50% { opacity: 1; transform: scale(1.5); } }

    /* Utility */
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    /* Thumbnail Gallery */
    .thumbnail-gallery { display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1.5rem; justify-content: center; }
    .thumbnail { width: 80px; height: 80px; border-radius: 1rem; overflow: hidden; cursor: pointer; border: 2px solid transparent; transition: all 0.3s ease; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .thumbnail:hover, .thumbnail.active { border-color: #667eea; transform: translateY(-5px) scale(1.05); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4); }
    .thumbnail img { width: 100%; height: 100%; object-fit: cover; }

    /* Quantity Control */
    .quantity-control { display: flex; align-items: center; border: 2px solid #e5e7eb; border-radius: 1rem; overflow: hidden; background: white; }
    .quantity-btn { width: 48px; height: 48px; border: none; background: #f9fafb; color: #6b7280; cursor: pointer; transition: all 0.3s ease; }
    .quantity-btn:hover { background: #667eea; color: white; }
    .quantity-input { width: 60px; height: 48px; border: none; text-align: center; font-weight: 700; font-size: 1rem; color: var(--dark-gray); outline: none; }
    
    /* Image Zoom Modal */
    .image-zoom-modal { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); cursor: zoom-out; }
    .image-zoom-modal img { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 90%; max-height: 90%; object-fit: contain; }
    .image-zoom-close { position: absolute; top: 20px; right: 30px; color: white; font-size: 40px; font-weight: bold; cursor: pointer; z-index: 10000; }

    /* Text styling for better readability */
    .text-dark { color: #1f2937; }
    .text-section { color: #374151; }
</style>

<div id="imageZoomModal" class="image-zoom-modal">
    <span class="image-zoom-close">&times;</span>
    <img id="zoomedImage" src="" alt="Zoomed Product Image">
</div>

{{-- Hero Section --}}
<section class="animated-bg text-white relative overflow-hidden py-20">
    {{-- Background Floating Elements (for animation) --}}
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    {{-- Background Stars (generated by JS) --}}
    <div class="stars"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center fade-in-up">
            {{-- Breadcrumbs Navigation --}}
            <nav class="flex justify-center items-center text-lg mb-6 text-white/80">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <i class="fas fa-chevron-right mx-3"></i>
                <a href="{{ route('products.index') }}" class="hover:text-white transition">Products</a>
                <i class="fas fa-chevron-right mx-3"></i>
                <span class="font-bold text-white">{{ $product->name }}</span>
            </nav>

            {{-- Product Name --}}
            <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight">
                <span class="text-gradient-advanced">{{ $product->name }}</span>
            </h1>
            {{-- Product Description (Short) --}}
            <p class="text-xl md:text-2xl max-w-4xl mx-auto text-white/95 font-light leading-relaxed">
                {{ $product->description ?? 'Discover this amazing product' }}
            </p>
        </div>
    </div>
</section>

{{-- Product Details Section --}}
<section class="py-16 section-bg-pattern bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            {{-- Product Image & Thumbnails Column --}}
            <div class="fade-in-right">
                <div class="solid-card p-6">
                    <div class="product-image-container">
                        @php
                            // Determine the main product image based on available paths
                            $mainImage = null;
                            if ($product->product_image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->product_image_path)) {
                                $mainImage = asset('storage/' . $product->product_image_path);
                            } elseif ($product->featured_image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->featured_image_path)) {
                                $mainImage = asset('storage/' . $product->featured_image_path);
                            } elseif ($product->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image_path)) {
                                $mainImage = asset('storage/' . $product->image_path);
                            } else {
                                $mainImage = asset('images/placeholder-product.jpg');
                            }
                        @endphp

                        <img src="{{ $mainImage }}" alt="{{ $product->name }}" class="product-image w-full h-auto object-cover rounded-2xl" id="mainProductImage">
                    </div>

                    @php
                        // Create an array of thumbnail images
                        $thumbnails = [];

                        // Add main product image to thumbnails
                        if ($product->product_image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->product_image_path)) {
                            $thumbnails[] = [
                                'url' => asset('storage/' . $product->product_image_path),
                                'label' => 'Product Image',
                                'active' => true
                            ];
                        }

                        // Add featured image to thumbnails
                        if ($product->featured_image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->featured_image_path)) {
                            $thumbnails[] = [
                                'url' => asset('storage/' . $product->featured_image_path),
                                'label' => 'Featured Image',
                                'active' => empty($thumbnails) // Set active if no main image was found yet
                            ];
                        }

                        // Add generic image to thumbnails
                        if ($product->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image_path)) {
                            $thumbnails[] = [
                                'url' => asset('storage/' . $product->image_path),
                                'label' => 'Main Image',
                                'active' => empty($thumbnails) // Set active if no main/featured image was found yet
                            ];
                        }

                        // Add gallery images to thumbnails
                        if (!empty($product->gallery_images) && is_array($product->gallery_images)) {
                            foreach ($product->gallery_images as $index => $image) {
                                if (!empty($image) && \Illuminate\Support\Facades\Storage::disk('public')->exists($image)) {
                                    $thumbnails[] = [
                                        'url' => asset('storage/' . $image),
                                        'label' => 'Gallery Image ' . ($index + 1),
                                        'active' => false
                                    ];
                                }
                            }
                        }
                    @endphp

                    {{-- Thumbnail Gallery --}}
                    @if(count($thumbnails) > 1)
                        <div class="thumbnail-gallery">
                            @foreach($thumbnails as $thumbnail)
                                <div class="thumbnail {{ $thumbnail['active'] ? 'active' : '' }}" onclick="changeMainImage('{{ $thumbnail['url'] }}', this)" title="{{ $thumbnail['label'] }}">
                                    <img src="{{ $thumbnail['url'] }}" alt="{{ $thumbnail['label'] }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Product Information Column --}}
            <div class="fade-in-up">
                <div class="glass-card p-8 h-full flex flex-col">
                    {{-- Product Badges/Metadata --}}
                    <div class="flex flex-wrap gap-3 mb-6">
                        @if($product->is_featured)
                            <div class="pulse-advanced inline-block">
                                <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                    <i class="fas fa-star mr-1"></i> Featured
                                </span>
                            </div>
                        @endif
                        @if($product->category)
                            <span class="text-sm text-blue-600 font-bold bg-blue-50 px-4 py-2 rounded-full">{{ $product->category }}</span>
                        @endif
                        @if($product->age_group)
                            <span class="text-sm text-gray-500 font-medium bg-gray-100 px-4 py-2 rounded-full">
                                <i class="fas fa-child mr-2"></i>{{ $product->age_group }}
                            </span>
                        @endif
                    </div>

                    {{-- Price and Stock Status --}}
                    <div class="flex items-center justify-between mb-6">
                        <div class="text-5xl font-black text-gradient-advanced">
                            {{ $product->price_jod ? number_format($product->price_jod, 2) . ' JOD' : 'السعر غير متاح' }}
                        </div>
                        <div class="px-4 py-2 rounded-full text-sm font-bold shadow-lg {{ $product->stock_quantity > 0 ? 'bg-green-500/20 text-green-800' : 'bg-red-500/20 text-red-800' }}">
                            <i class="fas fa-{{ $product->stock_quantity > 0 ? 'check' : 'times' }} mr-1"></i>
                            {{ $product->stock_quantity > 0 ? 'متوفر' : 'غير متوفر' }}
                        </div>
                    </div>

                    {{-- Product Details Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        @if($product->difficulty_level)
                            <div class="flex items-center bg-gray-100 rounded-2xl p-4">
                                <i class="fas fa-layer-group text-gray-500 text-2xl mr-4"></i>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">مستوى الصعوبة</span>
                                    <p class="font-bold text-gray-900">{{ $product->difficulty_level }}</p>
                                </div>
                            </div>
                        @endif
                        @if($product->estimated_time)
                            <div class="flex items-center bg-gray-100 rounded-2xl p-4">
                                <i class="fas fa-clock text-gray-500 text-2xl mr-4"></i>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">الوقت المقدر</span>
                                    <p class="font-bold text-gray-900">{{ $product->estimated_time }}</p>
                                </div>
                            </div>
                        @endif
                        @if($product->material)
                            <div class="flex items-center bg-gray-100 rounded-2xl p-4">
                                <i class="fas fa-hammer text-gray-500 text-2xl mr-4"></i>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">المواد</span>
                                    <p class="font-bold text-gray-900">{{ $product->material }}</p>
                                </div>
                            </div>
                        @endif
                        @if($product->dimensions)
                            <div class="flex items-center bg-gray-100 rounded-2xl p-4">
                                <i class="fas fa-ruler text-gray-500 text-2xl mr-4"></i>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">الأبعاد</span>
                                    <p class="font-bold text-gray-900">{{ $product->dimensions }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Product Contents --}}
                    @if($product->contents)
                        <div class="bg-gray-50 rounded-2xl p-6 mb-6">
                            <h3 class="text-xl font-bold mb-3 text-gradient-advanced">محتويات الصندوق</h3>
                            <div class="text-section leading-relaxed">{!! nl2br(e($product->contents)) !!}</div>
                        </div>
                    @endif

                    {{-- Educational Goals --}}
                    @if($product->educational_goals)
                        <div class="bg-blue-50 rounded-2xl p-6 mb-6">
                            <h3 class="text-xl font-bold mb-3 text-gradient-advanced">الأهداف التعليمية</h3>
                            <div class="text-section leading-relaxed">{!! nl2br(e($product->educational_goals)) !!}</div>
                        </div>
                    @endif

                    {{-- Detailed Description --}}
                    @if($product->detailed_description)
                        <div class="bg-purple-50 rounded-2xl p-6 mb-8">
                            <h3 class="text-xl font-bold mb-3 text-gradient-advanced">تفاصيل المنتج</h3>
                            <div class="text-section leading-relaxed">{!! nl2br(e($product->detailed_description)) !!}</div>
                        </div>
                    @endif

                    {{-- Add to Cart Form / Out of Stock Button --}}
                    @if($product->is_active && ($product->stock_quantity > 0))
                        <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form" class="mt-auto">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="flex flex-col sm:flex-row items-center gap-4">
                                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                                    <button type="button"
                                        class="flex items-center justify-center w-10 h-10 text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors duration-200"
                                        onclick="decreaseQuantity()"
                                        aria-label="Decrease quantity">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number"
                                        name="quantity"
                                        id="quantity"
                                        value="1"
                                        min="1"
                                        max="{{ $product->stock_quantity }}"
                                        class="w-16 h-10 text-center text-gray-800 font-medium text-lg border-l border-r border-gray-300 focus:outline-none focus:ring-0"
                                        aria-live="polite"
                                        aria-atomic="true">
                                    <button type="button"
                                        class="flex items-center justify-center w-10 h-10 text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors duration-200"
                                        onclick="increaseQuantity()"
                                        aria-label="Increase quantity">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <button type="submit"
                                    class="flex-1 flex items-center justify-center w-full sm:w-auto
                                           bg-gradient-to-r from-blue-600 to-purple-700 text-white
                                           font-bold py-3 px-6 rounded-lg shadow-lg
                                           hover:from-blue-700 hover:to-purple-800
                                           focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-75
                                           transition-all duration-300 transform hover:scale-105"
                                    aria-label="Add item to cart">
                                    <i class="fas fa-shopping-cart mr-3 text-xl"></i>
                                    <span class="text-lg">أضف إلى السلة</span>
                                </button>
                            </div>
                        </form>
                    @else
                        <button class="w-full btn-professional bg-gradient-to-r from-gray-400 to-gray-500 text-white font-bold py-4 px-6 mt-auto text-lg" disabled>
                            <i class="fas fa-times mr-3"></i>
                            غير متوفر
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

---

{{-- Related Products Section --}}
@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<section class="py-16 section-bg-pattern bg-gradient-to-br from-purple-50 via-blue-50 to-pink-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 fade-in-up">
            <h2 class="text-4xl md:text-5xl font-black mb-4">
                <span class="text-gradient-advanced">منتجات ذات صلة</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                اكتشف المزيد من المنتجات المشابهة التي قد تهمك
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedProducts as $index => $relatedProduct)
            <div class="product-card p-6 fade-in-up" style="animation-delay: {{ $index * 0.2 }}s;">
                <div class="product-image-container mb-6">
                    @php
                        // Determine the image for related products
                        $relatedImage = null;
                        if ($relatedProduct->product_image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($relatedProduct->product_image_path)) {
                            $relatedImage = asset('storage/' . $relatedProduct->product_image_path);
                        } elseif ($relatedProduct->featured_image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($relatedProduct->featured_image_path)) {
                            $relatedImage = asset('storage/' . $relatedProduct->featured_image_path);
                        } elseif ($relatedProduct->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($relatedProduct->image_path)) {
                            $relatedImage = asset('storage/' . $relatedProduct->image_path);
                        } else {
                            $relatedImage = asset('images/placeholder-product.jpg');
                        }
                    @endphp

                    <img src="{{ $relatedImage }}"
                        alt="{{ $relatedProduct->name }}"
                        class="product-image w-full h-48 object-cover rounded-xl">
                </div>

                {{-- Related Product Badges --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    @if($relatedProduct->is_featured)
                        <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                            <i class="fas fa-star mr-1"></i> مميز
                        </span>
                    @endif
                    @if($relatedProduct->category)
                        <span class="text-xs text-blue-600 font-medium bg-blue-50 px-3 py-1 rounded-full">
                            {{ $relatedProduct->category }}
                        </span>
                    @endif
                </div>

                {{-- Related Product Name --}}
                <h3 class="text-xl font-bold text-dark mb-3 line-clamp-2">
                    {{ $relatedProduct->name }}
                </h3>

                {{-- Related Product Description (truncated) --}}
                @if($relatedProduct->description)
                <p class="text-gray-600 mb-4 line-clamp-2">
                    {{ Str::limit($relatedProduct->description, 100) }}
                </p>
                @endif

                {{-- Related Product Price and Stock --}}
                <div class="flex items-center justify-between mb-4">
                    <div class="text-2xl font-black text-gradient-advanced">
                        {{ $relatedProduct->price_jod ? number_format($relatedProduct->price_jod, 2) . ' JOD' : 'السعر غير متاح' }}
                    </div>
                    <div class="text-sm font-medium {{ $relatedProduct->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                        <i class="fas fa-{{ $relatedProduct->stock_quantity > 0 ? 'check' : 'times' }} mr-1"></i>
                        {{ $relatedProduct->stock_quantity > 0 ? 'متوفر' : 'غير متوفر' }}
                    </div>
                </div>

                {{-- Related Product Attributes --}}
                <div class="grid grid-cols-2 gap-2 mb-6">
                    @if($relatedProduct->difficulty_level)
                    <div class="text-center bg-gray-50 rounded-lg p-2">
                        <i class="fas fa-layer-group text-gray-500 mb-1"></i>
                        <p class="text-xs text-gray-600">{{ $relatedProduct->difficulty_level }}</p>
                    </div>
                    @endif
                    @if($relatedProduct->age_group)
                    <div class="text-center bg-gray-50 rounded-lg p-2">
                        <i class="fas fa-child text-gray-500 mb-1"></i>
                        <p class="text-xs text-gray-600">{{ $relatedProduct->age_group }}</p>
                    </div>
                    @endif
                </div>

                {{-- View Details Button for Related Product --}}
                <a href="{{ route('products.show', $relatedProduct) }}"
                   class="block w-full btn-professional bg-gradient-to-r from-blue-600 to-purple-700 text-white font-bold py-3 px-4 text-center rounded-lg hover:from-blue-700 hover:to-purple-800 transition-all duration-300">
                    <i class="fas fa-eye mr-2"></i>
                    عرض التفاصيل
                </a>
            </div>
            @endforeach
        </div>

        {{-- View All Products Button --}}
        <div class="text-center mt-12 fade-in-up">
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center btn-professional bg-gradient-to-r from-gray-600 to-gray-800 text-white font-bold py-4 px-8 rounded-xl hover:from-gray-700 hover:to-gray-900 transition-all duration-300">
                <i class="fas fa-arrow-left mr-3"></i>
                عرض جميع المنتجات
            </a>
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate animated stars
    generateStars();
    
    // Setup image zoom functionality
    setupImageZoom();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup quantity controls
    setupQuantityControls();
});

function generateStars() {
    const starsContainer = document.querySelector('.stars');
    if (!starsContainer) return;
    
    const numberOfStars = 50;
    
    for (let i = 0; i < numberOfStars; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        star.style.left = Math.random() * 100 + '%';
        star.style.top = Math.random() * 100 + '%';
        star.style.animationDelay = Math.random() * 4 + 's';
        starsContainer.appendChild(star);
    }
}

function changeMainImage(imageUrl, thumbnailElement) {
    const mainImage = document.getElementById('mainProductImage');
    if (mainImage) {
        mainImage.src = imageUrl;
        
        // Update active thumbnail
        document.querySelectorAll('.thumbnail').forEach(thumb => {
            thumb.classList.remove('active');
        });
        thumbnailElement.classList.add('active');
    }
}

function setupImageZoom() {
    const mainImage = document.getElementById('mainProductImage');
    const modal = document.getElementById('imageZoomModal');
    const zoomedImage = document.getElementById('zoomedImage');
    const closeBtn = document.querySelector('.image-zoom-close');
    
    if (mainImage && modal && zoomedImage) {
        mainImage.addEventListener('click', function() {
            zoomedImage.src = this.src;
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        });
        
        if (closeBtn) {
            closeBtn.addEventListener('click', closeZoomModal);
        }
        
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeZoomModal();
            }
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.style.display === 'block') {
                closeZoomModal();
            }
        });
    }
}

function closeZoomModal() {
    const modal = document.getElementById('imageZoomModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

function setupQuantityControls() {
    const quantityInput = document.getElementById('quantity');
    if (!quantityInput) return;
    
    // Prevent invalid input
    quantityInput.addEventListener('input', function() {
        let value = parseInt(this.value);
        const min = parseInt(this.min);
        const max = parseInt(this.max);
        
        if (isNaN(value) || value < min) {
            this.value = min;
        } else if (value > max) {
            this.value = max;
        }
    });
}

function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    if (!quantityInput) return;
    
    let currentValue = parseInt(quantityInput.value);
    const maxValue = parseInt(quantityInput.max);
    
    if (currentValue < maxValue) {
        quantityInput.value = currentValue + 1;
        
        // Trigger change event for any listeners
        quantityInput.dispatchEvent(new Event('change'));
    }
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    if (!quantityInput) return;
    
    let currentValue = parseInt(quantityInput.value);
    const minValue = parseInt(quantityInput.min);
    
    if (currentValue > minValue) {
        quantityInput.value = currentValue - 1;
        
        // Trigger change event for any listeners
        quantityInput.dispatchEvent(new Event('change'));
    }
}

function setupFormValidation() {
    const form = document.getElementById('add-to-cart-form');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        const quantityInput = document.getElementById('quantity');
        const submitBtn = form.querySelector('button[type="submit"]');
        
        if (!quantityInput || !submitBtn) return;
        
        const quantity = parseInt(quantityInput.value);
        const maxQuantity = parseInt(quantityInput.max);
        
        if (quantity < 1 || quantity > maxQuantity) {
            e.preventDefault();
            alert(`الكمية يجب أن تكون بين 1 و ${maxQuantity}`);
            return;
        }
        
        // Show loading state
        const originalContent = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i>جاري الإضافة...';
        submitBtn.disabled = true;
        
        // Reset button after a delay if form doesn't submit successfully
        setTimeout(() => {
            if (!submitBtn.disabled) return;
            submitBtn.innerHTML = originalContent;
            submitBtn.disabled = false;
        }, 3000);
    });
}

// Handle successful cart addition (if using AJAX)
function handleCartSuccess(response) {
    const submitBtn = document.querySelector('#add-to-cart-form button[type="submit"]');
    if (submitBtn) {
        submitBtn.innerHTML = '<i class="fas fa-check mr-3"></i>تمت الإضافة!';
        submitBtn.classList.remove('from-blue-600', 'to-purple-700');
        submitBtn.classList.add('from-green-500', 'to-green-600');
        
        setTimeout(() => {
            submitBtn.innerHTML = '<i class="fas fa-shopping-cart mr-3"></i>أضف إلى السلة';
            submitBtn.classList.remove('from-green-500', 'to-green-600');
            submitBtn.classList.add('from-blue-600', 'to-purple-700');
            submitBtn.disabled = false;
        }, 2000);
    }
    
    // Show success message (you can customize this)
    showNotification('تم إضافة المنتج إلى السلة بنجاح!', 'success');
}

// Simple notification function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle text-green-500' : 'info-circle text-blue-500'} mr-3"></i>
            <span class="text-white font-medium">${message}</span>
        </div>
    `;
    
    if (type === 'success') {
        notification.classList.add('bg-green-600');
    } else {
        notification.classList.add('bg-blue-600');
    }
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto hide after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Smooth scrolling for anchor links
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

// Add intersection observer for fade animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0) translateX(0)';
        }
    });
}, observerOptions);

// Observe all fade elements
document.querySelectorAll('.fade-in-up, .fade-in-right').forEach(el => {
    el.style.opacity = '0';
    if (el.classList.contains('fade-in-up')) {
        el.style.transform = 'translateY(50px)';
    } else if (el.classList.contains('fade-in-right')) {
        el.style.transform = 'translateX(50px)';
    }
    observer.observe(el);
});
</script>
@endpush