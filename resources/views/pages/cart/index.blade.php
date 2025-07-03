@extends('layouts.app')

@section('title', 'سلة التسوق')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Tajawal:wght@400;500;700&display=swap');
    
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
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .glass-card:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    /* Enhanced Glass Card for Cart Items */
    .cart-glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .cart-glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    /* Professional Buttons */
    .btn-professional {
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
        border: none;
        border-radius: 15px;
        font-weight: 600;
        padding: 12px 24px;
        font-size: 1rem;
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
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
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

    .fade-in-item {
        animation: fadeInUp 0.6s ease-out both;
    }

    .fade-in-item:nth-child(1) { animation-delay: 0.1s; }
    .fade-in-item:nth-child(2) { animation-delay: 0.2s; }
    .fade-in-item:nth-child(3) { animation-delay: 0.3s; }
    .fade-in-item:nth-child(4) { animation-delay: 0.4s; }

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

    /* Cart Item Styling */
    .cart-item {
        background: white;
        border-radius: 20px;
        transition: all 0.3s ease;
        border: 1px solid rgba(102, 126, 234, 0.1);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .cart-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border-color: #667eea;
    }

    /* Quantity Controls */
    .quantity-controls {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 15px;
        border: 1px solid #e2e8f0;
        padding: 8px;
    }

    .quantity-btn {
        width: 40px;
        height: 40px;
        border: none;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        font-weight: bold;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-btn:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6b4593 100%);
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .quantity-btn:disabled {
        background: linear-gradient(135deg, #cbd5e0 0%, #a0aec0 100%);
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .quantity-display {
        background: white;
        border-radius: 10px;
        padding: 8px 16px;
        font-weight: bold;
        font-size: 1.1rem;
        color: #1a202c;
        min-width: 60px;
        text-align: center;
        box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Remove Button */
    .remove-btn {
        background: linear-gradient(135deg, #ff6b6b, #ee5a5a);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .remove-btn:hover {
        background: linear-gradient(135deg, #ff5252, #e53e3e);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
    }

    /* Checkout Card */
    .checkout-card {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border-radius: 25px;
        color: white;
        position: sticky;
        top: 20px;
        box-shadow: 0 15px 35px rgba(79, 172, 254, 0.3);
    }

    .checkout-btn {
        background: white;
        color: #4facfe;
        border: none;
        padding: 18px 35px;
        border-radius: 18px;
        font-weight: bold;
        font-size: 1.2rem;
        transition: all 0.4s ease;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .checkout-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        background: linear-gradient(135deg, #f8f9ff 0%, #e6f0ff 100%);
    }

    /* Empty Cart */
    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 25px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .empty-cart-icon {
        font-size: 5rem;
        color: #cbd5e0;
        margin-bottom: 2rem;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-10px); }
        60% { transform: translateY(-5px); }
    }

    /* Price Highlight */
    .price-highlight {
        color: #667eea;
        font-weight: bold;
        font-size: 1.2rem;
        text-shadow: 0 2px 4px rgba(102, 126, 234, 0.2);
    }

    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        backdrop-filter: blur(5px);
    }

    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid rgba(102, 126, 234, 0.3);
        border-top: 4px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Product Image */
    .product-image {
        border-radius: 15px;
        transition: transform 0.4s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .product-image:hover {
        transform: scale(1.1);
    }

    /* Cart Summary Items */
    .cart-summary-item {
        padding: 15px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        font-size: 1.1rem;
    }

    .cart-summary-item:last-child {
        border-bottom: none;
        font-size: 1.3rem;
        font-weight: bold;
        background: rgba(255, 255, 255, 0.1);
        margin: 15px -20px -20px -20px;
        padding: 20px;
        border-radius: 0 0 25px 25px;
    }

    /* Eco Badge */
    .eco-badge {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    /* Back to top button */
    #backToTop {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 1.5rem;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    #backToTop:hover {
        transform: translateY(-5px) scale(1.1);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .floating-element {
            width: 40px !important;
            height: 40px !important;
        }
        
        .cart-item {
            margin-bottom: 1rem;
        }

        .quantity-btn {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }

        .quantity-display {
            padding: 6px 12px;
            font-size: 1rem;
            min-width: 50px;
        }

        .checkout-btn {
            font-size: 1.1rem;
            padding: 15px 25px;
        }

        .empty-cart-icon {
            font-size: 4rem;
        }
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6b4593 100%);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="animated-bg min-h-96 flex items-center relative overflow-hidden">
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-6 py-20 relative z-10">
        <div class="text-center">
            <div class="fade-in-up">
                <nav class="text-white/80 text-lg mb-8">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">الرئيسية</a>
                    <span class="mx-3">•</span>
                    <a href="{{ route('products.index') }}" class="hover:text-white transition-colors">المنتجات</a>
                    <span class="mx-3">•</span>
                    <span class="text-white">سلة التسوق</span>
                </nav>
                
                <div class="eco-badge mb-6">
                    <i class="fas fa-shopping-cart"></i>
                    تسوق صديق للبيئة
                </div>
                
                <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight text-white drop-shadow-2xl">
                    🛒 سلة التسوق
                </h1>
                
                <p class="text-xl text-white/90 leading-relaxed font-light">
                    راجع منتجاتك المختارة واكمل عملية الشراء
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Cart Content -->
<section class="py-16 bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="container mx-auto px-6">
        @if($cart->items->count() > 0)
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 fade-in-left">
                    <div class="cart-glass-card p-8">
                        <!-- Cart Header -->
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="text-2xl font-bold text-gray-800">
                                <i class="fas fa-shopping-basket text-blue-600 mr-3"></i>
                                منتجاتك ({{ $cart->total_items }} قطعة)
                            </h3>
                            <button class="btn-professional bg-gradient-to-r from-red-400 to-red-600 text-white" onclick="clearCart()">
                                <i class="fas fa-trash mr-2"></i>
                                تفريغ السلة
                            </button>
                        </div>

                        <!-- Cart Items List -->
                        <div id="cart-items" class="space-y-6">
                            @foreach($cart->items as $index => $item)
                                <div class="cart-item p-6 fade-in-item" data-product-id="{{ $item->product_id }}">
                                    <div class="grid md:grid-cols-6 gap-6 items-center">
                                        <!-- Product Image -->
                                        <div class="md:col-span-1">
                                            <img src="{{ $item->current_product_image }}" 
                                                 alt="{{ $item->current_product_name }}"
                                                 class="product-image w-20 h-20 object-cover mx-auto">
                                        </div>

                                        <!-- Product Details -->
                                        <div class="md:col-span-2">
                                            <h5 class="font-bold text-lg mb-2">
                                                <a href="{{ route('products.show', $item->product_id) }}" 
                                                   class="text-gray-800 hover:text-blue-600 transition-colors">
                                                    {{ $item->current_product_name }}
                                                </a>
                                            </h5>
                                            <p class="text-gray-600 mb-2">
                                                <span class="price-highlight">{{ number_format($item->current_product_price, 2) }} دينار</span>
                                            </p>
                                            @if($item->product && $item->product->stock_quantity <= 5)
                                                <small class="text-orange-500 flex items-center">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    متبقي {{ $item->product->stock_quantity }} قطع فقط
                                                </small>
                                            @endif
                                        </div>

                                        <!-- Quantity Controls -->
                                        <div class="md:col-span-2">
                                            <div class="quantity-controls flex items-center justify-center gap-3">
                                                <button class="quantity-btn" 
                                                        onclick="updateQuantity({{ $item->product_id }}, {{ $item->quantity - 1 }})"
                                                        {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <div class="quantity-display" id="quantity-{{ $item->product_id }}">
                                                    {{ $item->quantity }}
                                                </div>
                                                <button class="quantity-btn" 
                                                        onclick="updateQuantity({{ $item->product_id }}, {{ $item->quantity + 1 }})"
                                                        {{ $item->product && $item->quantity >= $item->product->stock_quantity ? 'disabled' : '' }}>
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Price and Remove -->
                                        <div class="md:col-span-1 text-center">
                                            <div class="mb-4">
                                                <span class="price-highlight text-xl" id="subtotal-{{ $item->product_id }}">
                                                    {{ number_format($item->total, 2) }} د.أ
                                                </span>
                                            </div>
                                            <button class="remove-btn" onclick="removeItem({{ $item->product_id }})">
                                                <i class="fas fa-trash"></i>
                                                حذف
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <div class="grid md:grid-cols-2 gap-6">
                                <a href="{{ route('products.index') }}" class="btn-professional bg-gradient-to-r from-gray-500 to-gray-700 text-white text-center py-4">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    متابعة التسوق
                                </a>
                                <button class="btn-professional bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4" onclick="refreshCart()">
                                    <i class="fas fa-sync-alt mr-2"></i>
                                    تحديث السلة
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checkout Summary -->
                <div class="lg:col-span-1 fade-in-right">
                    <div class="checkout-card p-8">
                        <h4 class="text-2xl font-bold mb-6 flex items-center">
                            <i class="fas fa-receipt mr-3"></i>
                            ملخص الطلب
                        </h4>

                        <div class="cart-summary space-y-4">
                            <div class="cart-summary-item flex justify-between items-center">
                                <span>عدد المنتجات:</span>
                                <span id="summary-items">{{ $cart->total_items }} قطعة</span>
                            </div>
                            
                            <div class="cart-summary-item flex justify-between items-center">
                                <span>المجموع الفرعي:</span>
                                <span id="summary-subtotal">{{ number_format($cart->total_price, 2) }} د.أ</span>
                            </div>
                            
                            <div class="cart-summary-item flex justify-between items-center">
                                <span>الشحن:</span>
                                <span class="text-green-300 font-bold">مجاني</span>
                            </div>
                            
                            <div class="cart-summary-item flex justify-between items-center">
                                <span>الإجمالي:</span>
                                <span id="summary-total">{{ number_format($cart->total_price, 2) }} د.أ</span>
                            </div>
                        </div>

                        <button class="checkout-btn mt-8" onclick="proceedToCheckout()">
                            <i class="fas fa-credit-card"></i>
                            متابعة إلى الدفع
                        </button>

                        <!-- Coupon Code -->
                        <div class="mt-6">
                            <div class="flex gap-2">
                                <input type="text" 
                                       class="flex-1 px-4 py-3 rounded-lg border border-white/30 bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50" 
                                       placeholder="كود الخصم" 
                                       id="coupon-code">
                                <button class="btn-professional bg-white text-blue-500 px-6" onclick="applyCoupon()">
                                    تطبيق
                                </button>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="mt-8 pt-6 border-t border-white/20 space-y-3">
                            <div class="flex items-center text-sm text-white/90">
                                <i class="fas fa-shield-alt mr-2"></i>
                                عملية دفع آمنة ومشفرة
                            </div>
                            <div class="flex items-center text-sm text-white/90">
                                <i class="fas fa-truck mr-2"></i>
                                شحن مجاني للطلبات فوق 50 دينار
                            </div>
                            <div class="flex items-center text-sm text-white/90">
                                <i class="fas fa-leaf mr-2"></i>
                                منتجات صديقة للبيئة
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <!-- Empty Cart -->
            <div class="max-w-2xl mx-auto fade-in-up">
                <div class="empty-cart">
                    <div class="empty-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">سلة التسوق فارغة</h3>
                    <p class="text-gray-600 mb-8 text-lg">لا توجد منتجات في سلة التسوق حالياً</p>
                    
                    <div class="space-y-4">
                        <a href="{{ route('products.index') }}" class="btn-professional bg-gradient-to-r from-blue-500 to-purple-600 text-white inline-flex items-center px-8 py-4 text-lg">
                            <i class="fas fa-shopping-bag mr-2"></i>
                            ابدأ التسوق الآن
                        </a>
                        
                        <div class="flex justify-center space-x-4 mt-6">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-leaf text-blue-600 text-xl"></i>
                                </div>
                                <span class="text-sm text-gray-600">منتجات صديقة للبيئة</span>
                            </div>
                            <div class="text-center">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-truck text-green-600 text-xl"></i>
                                </div>
                                <span class="text-sm text-gray-600">شحن مجاني</span>
                            </div>
                            <div class="text-center">
                                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-shield-alt text-purple-600 text-xl"></i>
                                </div>
                                <span class="text-sm text-gray-600">دفع آمن</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Back to Top Button -->
<button id="backToTop" onclick="scrollToTop()">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

@endsection

@push('scripts')
<script>
// CSRF Token for AJAX requests
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Update quantity function
function updateQuantity(productId, newQuantity) {
    if (newQuantity < 1) return;
    
    showLoading();
    
    fetch(`{{ route("cart.update", ['productId' => '___PRODUCT_ID___']) }}`.replace('___PRODUCT_ID___', productId), {
    method: 'PATCH', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        
        if (data.success) {
            // Update quantity display
            document.getElementById(`quantity-${productId}`).textContent = newQuantity;
            
            // Update subtotal
            document.getElementById(`subtotal-${productId}`).textContent = 
                parseFloat(data.item_total).toFixed(2) + ' د.أ';
            
            // Update summary
            updateSummary(data.cart_total, data.cart_items);
            
            // Update button states
            updateQuantityButtons(productId, newQuantity, data.max_quantity);
            
            showSuccessMessage('تم تحديث الكمية بنجاح');
        } else {
            showErrorMessage(data.message || 'حدث خطأ أثناء تحديث الكمية');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        showErrorMessage('حدث خطأ أثناء تحديث الكمية');
    });
}

// Remove item function
function removeItem(productId) {
    if (!confirm('هل أنت متأكد من حذف هذا المنتج من السلة؟')) {
        return;
    }
    
    showLoading();
    
    fetch(`{{ route("cart.remove", ['productId' => '${productId}']) }}`, {
    method: 'DELETE', // Correct method
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify({
        // product_id is now in the URL, remove from body if not needed by your controller
        // product_id: productId
    })
})
    .then(response => response.json())
    .then(data => {
        hideLoading();
        
        if (data.success) {
            // Remove item from DOM with animation
            const itemElement = document.querySelector(`[data-product-id="${productId}"]`);
            if (itemElement) {
                itemElement.style.animation = 'fadeOutUp 0.5s ease-out';
                setTimeout(() => {
                    itemElement.remove();
                    
                    // Check if cart is empty
                    if (data.cart_items === 0) {
                        location.reload(); // Reload to show empty cart
                    } else {
                        updateSummary(data.cart_total, data.cart_items);
                    }
                }, 500);
            }
            
            showSuccessMessage('تم حذف المنتج من السلة');
        } else {
            showErrorMessage(data.message || 'حدث خطأ أثناء حذف المنتج');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        showErrorMessage('حدث خطأ أثناء حذف المنتج');
    });
}

// Clear cart function
function clearCart() {
    if (!confirm('هل أنت متأكد من تفريغ السلة بالكامل؟')) {
        return;
    }
    
    showLoading();
    
    fetch('{{ route("cart.clear") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        
        if (data.success) {
            showSuccessMessage('تم تفريغ السلة بنجاح');
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showErrorMessage(data.message || 'حدث خطأ أثناء تفريغ السلة');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        showErrorMessage('حدث خطأ أثناء تفريغ السلة');
    });
}

// Refresh cart function
function refreshCart() {
    showLoading();
    setTimeout(() => {
        location.reload();
    }, 1000);
}

// Proceed to checkout
function proceedToCheckout() {
    showLoading();
    
    // Check if user is logged in
    @auth
        window.location.href = '{{ route("checkout.index") }}';
    @else
        if (confirm('يجب تسجيل الدخول أولاً للمتابعة إلى الدفع. هل تريد تسجيل الدخول الآن؟')) {
            window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent('{{ route("checkout.index") }}');
        }
        hideLoading();
    @endauth
}

// Apply coupon function
function applyCoupon() {
    const couponCode = document.getElementById('coupon-code').value.trim();
    
    if (!couponCode) {
        showErrorMessage('يرجى إدخال كود الخصم');
        return;
    }
    
    showLoading();
    
    fetch('{{ route("cart.apply-coupon") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            coupon_code: couponCode
        })
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        
        if (data.success) {
            showSuccessMessage('تم تطبيق كود الخصم بنجاح');
            updateSummary(data.cart_total, data.cart_items, data.discount);
        } else {
            showErrorMessage(data.message || 'كود الخصم غير صحيح');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        showErrorMessage('حدث خطأ أثناء تطبيق كود الخصم');
    });
}

// Update summary function
function updateSummary(total, items, discount = 0) {
    document.getElementById('summary-items').textContent = items + ' قطعة';
    document.getElementById('summary-subtotal').textContent = parseFloat(total + discount).toFixed(2) + ' د.أ';
    document.getElementById('summary-total').textContent = parseFloat(total).toFixed(2) + ' د.أ';
    
    // Update item count in header if available
    const headerCount = document.querySelector('.cart-count');
    if (headerCount) {
        headerCount.textContent = items;
    }
}

// Update quantity buttons state
function updateQuantityButtons(productId, quantity, maxQuantity) {
    const decreaseBtn = document.querySelector(`[onclick="updateQuantity(${productId}, ${quantity - 1})"]`);
    const increaseBtn = document.querySelector(`[onclick="updateQuantity(${productId}, ${quantity + 1})"]`);
    
    if (decreaseBtn) {
        decreaseBtn.disabled = quantity <= 1;
    }
    
    if (increaseBtn) {
        increaseBtn.disabled = quantity >= maxQuantity;
    }
}

// Show loading overlay
function showLoading() {
    document.getElementById('loadingOverlay').style.display = 'flex';
}

// Hide loading overlay
function hideLoading() {
    document.getElementById('loadingOverlay').style.display = 'none';
}

// Show success message
function showSuccessMessage(message) {
    // Create toast notification
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 opacity-0 transition-opacity duration-300';
    toast.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Fade in
    setTimeout(() => {
        toast.style.opacity = '1';
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}

// Show error message
function showErrorMessage(message) {
    // Create toast notification
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 opacity-0 transition-opacity duration-300';
    toast.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Fade in
    setTimeout(() => {
        toast.style.opacity = '1';
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}

// Back to top functionality
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Show/hide back to top button
window.addEventListener('scroll', function() {
    const backToTopBtn = document.getElementById('backToTop');
    if (window.pageYOffset > 300) {
        backToTopBtn.style.opacity = '1';
        backToTopBtn.style.visibility = 'visible';
    } else {
        backToTopBtn.style.opacity = '0';
        backToTopBtn.style.visibility = 'hidden';
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl + U for update cart
    if (e.ctrlKey && e.key === 'u') {
        e.preventDefault();
        refreshCart();
    }
    
    // Escape to close any modals
    if (e.key === 'Escape') {
        hideLoading();
    }
});

// Auto-save cart changes
let autoSaveTimer;
function autoSaveCart() {
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(() => {
        // Auto-save logic here if needed
        console.log('Auto-saving cart...');
    }, 2000);
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Add fade-in animation to cart items
    const cartItems = document.querySelectorAll('.fade-in-item');
    cartItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Initialize tooltips for buttons
    const buttons = document.querySelectorAll('[title]');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            // Add hover effect
            this.style.transform = 'translateY(-2px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Add loading animation to images
    const images = document.querySelectorAll('.product-image');
    images.forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
        });
        
        img.addEventListener('error', function() {
            this.src = '/images/default-product.jpg'; // Fallback image
        });
    });
});

// Custom animations for cart items
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOutUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-50px);
        }
    }
    
    .cart-item {
        transition: all 0.3s ease;
    }
    
    .cart-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
`;
document.head.appendChild(style);

// Performance optimization
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Debounced quantity update
const debouncedUpdateQuantity = debounce(updateQuantity, 300);

// Service worker registration for offline functionality
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js').then(function(registration) {
            console.log('SW registered: ', registration);
        }).catch(function(registrationError) {
            console.log('SW registration failed: ', registrationError);
        });
    });
}
</script>
@endpush