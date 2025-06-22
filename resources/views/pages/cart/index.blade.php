@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
  
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --accent-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --glass-bg: rgba(255, 255, 255, 0.1);
        --glass-border: rgba(255, 255, 255, 0.2);
        --danger-gradient: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
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
        transform: translateY(-5px);
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
        transform: translateY(-3px);
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
           
        }
        100% {
            background: linear-gradient(135deg, #f093fb 0%, #764ba2 50%, #667eea 100%);
           
        }
    }

    /* Card Hover Effects */
    .card-hover-effect {
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        transform-style: preserve-3d;
    }

    .card-hover-effect:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }

    /* Loading Animation */
    .loading-spinner {
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Quantity Controls */
    .quantity-controls {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 4px;
        backdrop-filter: blur(10px);
    }

    .quantity-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    .quantity-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .quantity-input {
        width: 60px;
        text-align: center;
        background: transparent;
        border: none;
        color: white;
        font-weight: bold;
        font-size: 16px;
        margin: 0 8px;
    }

    .quantity-input:focus {
        outline: none;
    }

    /* Cart Item Card */
    .cart-item-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 24px;
        margin-bottom: 20px;
        transition: all 0.4s ease;
    }

    .cart-item-card:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    /* Empty Cart Animation */
    .empty-cart-animation {
        animation: bounceIn 1s ease-out;
    }

    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.3);
        }
        50% {
            opacity: 1;
            transform: scale(1.05);
        }
        70% {
            transform: scale(0.9);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Success/Error Messages */
    .alert-success {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 8px 32px rgba(79, 172, 254, 0.3);
    }

    .alert-error {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
    }

    /* Fade animations */
    .fade-in-up {
        animation: fadeInUp 1s ease-out;
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

    /* Arabic RTL Support */
    .rtl {
        direction: rtl;
        text-align: right;
    }

    /* Price Display */
    .price-display {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: bold;
        font-size: 1.2em;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .floating-element {
            width: 40px !important;
            height: 40px !important;
        }
        
        .cart-item-card {
            padding: 16px;
        }
        
        .quantity-controls {
            transform: scale(0.9);
        }
    }
</style>

{{--  تغيير: تم إضافة كلاس 'animated-bg' لتفعيل الخلفية المتحركة --}}
<section class="animated-bg min-h-screen py-20 relative overflow-hidden">
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-12 fade-in-up">
            <h1 class="text-5xl md:text-7xl font-black text-white mb-8">
                <span class="text-gradient-advanced">🛍️ عربة التسوق</span>
            </h1>
            <div class="flex justify-center mb-8">
                <div class="w-32 h-2 bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 rounded-full"></div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success fade-in-up">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error fade-in-up">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                @if($cart && $cart->items->count() > 0)
                    <div id="cart-items-container">
                        @foreach($cart->items as $item)
                            <div class="cart-item-card fade-in-up" data-item-id="{{ $item->id }}" **data-product-id="{{ $item->product_id }}"** style="animation-delay: {{ $loop->index * 0.1 }}s;">
                                <div class="flex flex-col md:flex-row gap-6 items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-32 h-32 bg-gradient-to-br from-purple-500 to-pink-600 rounded-3xl flex items-center justify-center shadow-2xl">
                                            @if($item->product_image)
                                                <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}" 
                                                    class="w-full h-full object-cover rounded-3xl">
                                            @else
                                                <i class="fas fa-box text-white text-4xl"></i>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex-grow">
                                        <h3 class="text-2xl font-bold text-white mb-2">{{ $item->product_name }}</h3>
                                        <p class="price-display text-xl mb-4">{{ number_format($item->price, 2) }} دينار</p>
                                        
                                        <div class="flex items-center justify-between">
                                            <div class="quantity-controls">
                                                <button type="button" class="quantity-btn decrease-btn" data-item-id="{{ $item->id }}" **data-product-id="{{ $item->product_id }}"**>
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" class="quantity-input" 
                                                        value="{{ $item->quantity }}" 
                                                        min="1" 
                                                        data-item-id="{{ $item->id }}"
                                                        **data-product-id="{{ $item->product_id }}"**
                                                        readonly>
                                                <button type="button" class="quantity-btn increase-btn" data-item-id="{{ $item->id }}" **data-product-id="{{ $item->product_id }}"**>
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>

                                            <button type="button" class="btn-professional bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-3 rounded-2xl remove-item-btn" 
                                                    data-item-id="{{ $item->id }}" **data-product-id="{{ $item->product_id }}"**>
                                                <i class="fas fa-trash mr-2"></i>
                                                حذف
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex-shrink-0 text-center">
                                        <div class="glass-card rounded-2xl p-6">
                                            <p class="text-white/80 mb-2">الإجمالي</p>
                                            <p class="text-2xl font-bold text-white item-total">
                                                {{ number_format($item->total, 2) }} دينار
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-8">
                        <button type="button" class="btn-professional bg-gradient-to-r from-gray-600 to-gray-700 text-white px-8 py-4 rounded-2xl text-lg" id="clear-cart-btn">
                            <i class="fas fa-trash-alt mr-3"></i>
                            تفريغ السلة بالكامل
                        </button>
                    </div>
                @else
                    <div class="empty-cart-animation text-center py-20">
                        <div class="glass-card rounded-3xl p-12 max-w-md mx-auto">
                            <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-full w-32 h-32 flex items-center justify-center mx-auto mb-8 shadow-2xl">
                                <i class="fas fa-shopping-cart text-white text-5xl"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-white mb-6">السلة فارغة</h3>
                            <p class="text-white/80 mb-8 text-lg">لم تقم بإضافة أي منتجات إلى سلة التسوق بعد</p>
                            <a href="{{ route('products.index') }}" 
                               class="btn-professional bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 text-white font-bold py-4 px-8 rounded-2xl text-lg inline-flex items-center">
                                <i class="fas fa-shopping-bag mr-3"></i>
                                تسوق الآن
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            @if($cart && $cart->items->count() > 0)
                <div class="lg:col-span-1">
                    <div class="glass-card rounded-3xl p-8 sticky top-8 fade-in-up">
                        <h3 class="text-3xl font-bold text-white mb-8 text-center">
                            <i class="fas fa-calculator mr-3"></i>
                            ملخص الطلب
                        </h3>

                        <div class="space-y-6">
                            <div class="flex justify-between items-center py-4 border-b border-white/20">
                                <span class="text-white/80 text-lg">عدد المنتجات:</span>
                                <span class="text-white font-bold text-xl" id="cart-total-items">{{ $cart->total_items }}</span>
                            </div>

                            <div class="flex justify-between items-center py-4 border-b border-white/20">
                                <span class="text-white/80 text-lg">المجموع الفرعي:</span>
                                <span class="price-display text-xl" id="cart-subtotal">{{ number_format($cart->total_price, 2) }} دينار</span>
                            </div>

                            <div class="flex justify-between items-center py-4 border-b border-white/20">
                                <span class="text-white/80 text-lg">الشحن:</span>
                                <span class="text-white font-bold text-lg">مجاني</span>
                            </div>

                            <div class="bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 rounded-2xl p-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-white font-bold text-2xl">الإجمالي النهائي:</span>
                                    <span class="text-white font-black text-3xl" id="cart-total-price">{{ number_format($cart->total_price, 2) }} دينار</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 space-y-4">
                            <a href="{{ route('checkout.index') }}" 
                               class="btn-professional bg-gradient-to-r from-green-500 to-green-600 text-white font-bold py-4 px-8 rounded-2xl text-lg w-full inline-flex items-center justify-center">
                                <i class="fas fa-credit-card mr-3"></i>
                                إتمام الطلب
                            </a>

                            <a href="{{ route('products.index') }}" 
                               class="btn-professional glass-card text-white font-bold py-4 px-8 rounded-2xl text-lg w-full inline-flex items-center justify-center border border-white/30">
                                <i class="fas fa-arrow-left mr-3"></i>
                                متابعة التسوق
                            </a>
                        </div>

                        <div class="mt-8 text-center">
                            <div class="glass-card rounded-2xl p-4">
                                <i class="fas fa-lock text-green-400 text-2xl mb-2"></i>
                                <p class="text-white/80 text-sm">معاملاتك آمنة ومحمية</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Helper function to get CSRF token
        function getCsrfToken() {
            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            if (tokenMeta) {
                return tokenMeta.getAttribute('content');
            }
            console.error('CSRF token not found. Please ensure <meta name="csrf-token" content="{{ csrf_token() }}"> is in your <head> tag.');
            return null;
        }

        // Quantity Controls (Decrease/Increase)
        document.querySelectorAll('.increase-btn, .decrease-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Get both product ID and item ID (if needed for finding specific HTML elements)
                const productId = this.dataset.productId; // The ID of the actual Product
                const itemId = this.dataset.itemId; // The ID of the CartItem (useful for UI updates)

                const isIncrease = this.classList.contains('increase-btn');
                const quantityInput = document.querySelector(`input[data-product-id="${productId}"]`); // Use product-id for input
                const currentQuantity = parseInt(quantityInput.value);
                let newQuantity;

                if (isIncrease) {
                    newQuantity = currentQuantity + 1;
                } else {
                    newQuantity = Math.max(1, currentQuantity - 1);
                }

                // Pass the Product ID to the update function
                updateQuantity(productId, newQuantity, this);
            });
        });

        // Quantity Input Change (direct input)
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const productId = this.dataset.productId;
                let newQuantity = parseInt(this.value);

                // Basic validation for quantity
                if (isNaN(newQuantity) || newQuantity < 1) {
                    newQuantity = 1; // Default to 1 if invalid
                    this.value = 1;
                }

                updateQuantity(productId, newQuantity, this); // Pass 'this' for spinner/disabling
            });
        });


        // Remove Item Buttons
        document.querySelectorAll('.remove-item-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId; // The ID of the actual Product
                // No need for itemId here as the route expects productId

                if (confirm('هل أنت متأكد من حذف هذا المنتج من السلة؟')) {
                    removeItem(productId, this); // Pass Product ID
                }
            });
        });

        // Clear Cart Button
        const clearCartBtn = document.getElementById('clear-cart-btn');
        if (clearCartBtn) {
            clearCartBtn.addEventListener('click', function() {
                if (confirm('هل أنت متأكد من تفريغ السلة بالكامل؟')) {
                    clearCart(this);
                }
            });
        }

        // Update Quantity Function (now accepts productId)
        function updateQuantity(productId, quantity, elementToDisable) { // Renamed parameter for clarity
            const originalContent = elementToDisable.innerHTML; // Store original content if it's a button
            const isButton = elementToDisable.tagName === 'BUTTON';

            if (isButton) {
                elementToDisable.innerHTML = '<div class="loading-spinner"></div>';
            }
            elementToDisable.disabled = true;

            const quantityInput = document.querySelector(`input[data-product-id="${productId}"]`);
            if (quantityInput) {
                quantityInput.disabled = true;
            }

            const csrfToken = getCsrfToken();
            if (!csrfToken) {
                if (isButton) {
                    elementToDisable.innerHTML = originalContent;
                }
                elementToDisable.disabled = false;
                if (quantityInput) quantityInput.disabled = false;
                return;
            }

            // Correct URL: uses /cart/{productId} as per Laravel route
            fetch(`/cart/${productId}`, { // ***** هذا هو التعديل الأساسي للـ URL *****
                method: 'PATCH', // يجب أن يكون PATCH
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    quantity: quantity
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'خطأ في الخادم: فشل تحديث الكمية');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    if (quantityInput) {
                        quantityInput.value = data.item.quantity; // Update with actual quantity from server (in case it was capped by stock)
                    }

                    // Select the item card using product-id
                    const itemCard = document.querySelector(`.cart-item-card[data-product-id="${productId}"]`);
                    if (itemCard) {
                        const itemTotalElement = itemCard.querySelector('.item-total');
                        if (itemTotalElement && data.item) { // Ensure data.item exists
                            itemTotalElement.textContent = `${parseFloat(data.item.total).toFixed(2)} دينار`; // Use data.item.total for item subtotal
                        }
                    }

                    updateCartTotals(data.cart); // Update global cart totals
                    showNotification('تم تحديث السلة بنجاح', 'success');
                } else {
                    showNotification(data.message || 'حدث خطأ أثناء تحديث السلة', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification(error.message || 'حدث خطأ أثناء تحديث السلة', 'error');
            })
            .finally(() => {
                if (isButton) {
                    elementToDisable.innerHTML = originalContent;
                }
                elementToDisable.disabled = false;
                if (quantityInput) quantityInput.disabled = false;
            });
        }

        // Remove Item Function (now accepts productId)
        function removeItem(productId, buttonElement) {
            const itemCard = document.querySelector(`.cart-item-card[data-product-id="${productId}"]`); // Use product-id for card selection
            if (itemCard) {
                itemCard.style.opacity = '0.5';
            }

            const originalContent = buttonElement.innerHTML;
            buttonElement.innerHTML = '<div class="loading-spinner"></div>';
            buttonElement.disabled = true;

            const csrfToken = getCsrfToken();
            if (!csrfToken) {
                if (itemCard) itemCard.style.opacity = '1';
                buttonElement.innerHTML = originalContent;
                buttonElement.disabled = false;
                return;
            }

            // Correct URL: uses /cart/{productId} as per Laravel route
            fetch(`/cart/${productId}`, { // ***** هذا هو التعديل الأساسي للـ URL *****
                method: 'DELETE', // يجب أن يكون DELETE
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'خطأ في الخادم: فشل حذف المنتج');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    if (itemCard) {
                        itemCard.style.transform = 'translateX(100%)';
                        itemCard.style.transition = 'all 0.3s ease';
                        setTimeout(() => {
                            itemCard.remove();
                            // After removing, check if cart is empty or update totals
                            if (data.cart.total_items === 0) {
                                displayEmptyCart();
                            } else {
                                updateCartTotals(data.cart);
                            }
                            // Call fetchMiniCart to update the header cart icon
                            fetchMiniCart();
                        }, 300);
                    }
                    showNotification('تم حذف المنتج من السلة', 'success');
                } else {
                    if (itemCard) itemCard.style.opacity = '1';
                    showNotification(data.message || 'حدث خطأ أثناء حذف المنتج', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (itemCard) itemCard.style.opacity = '1';
                showNotification(error.message || 'حدث خطأ أثناء حذف المنتج', 'error');
            })
            .finally(() => {
                buttonElement.innerHTML = originalContent;
                buttonElement.disabled = false;
            });
        }

        // Clear Cart Function
        function clearCart(buttonElement) {
            const originalContent = buttonElement.innerHTML;
            buttonElement.innerHTML = '<div class="loading-spinner"></div>';
            buttonElement.disabled = true;

            const csrfToken = getCsrfToken();
            if (!csrfToken) {
                buttonElement.innerHTML = originalContent;
                buttonElement.disabled = false;
                return;
            }

            // Correct URL for clearing cart
            fetch(`/cart/clear`, { // Updated to use direct string, assuming `url('cart/clear')` works
                method: 'POST', // Still POST for clearing
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'خطأ في الخادم: فشل تفريغ السلة');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    displayEmptyCart();
                    showNotification('تم تفريغ سلة التسوق بنجاح', 'success');
                    // Call fetchMiniCart to update the header cart icon
                    fetchMiniCart();
                } else {
                    showNotification(data.message || 'حدث خطأ أثناء تفريغ السلة', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification(error.message || 'حدث خطأ أثناء تفريغ السلة', 'error');
            })
            .finally(() => {
                buttonElement.innerHTML = originalContent;
                buttonElement.disabled = false;
            });
        }

        // Update Cart Totals (Remains largely the same, but ensure your HTML has these IDs)
        function updateCartTotals(cart) {
            const totalItemsEl = document.getElementById('cart-total-items');
            const subtotalEl = document.getElementById('cart-subtotal');
            const totalPriceEl = document.getElementById('cart-total-price'); // Assuming this is your final total

            if (totalItemsEl) totalItemsEl.textContent = cart.total_items;
            // Ensure these IDs exist in your cart summary HTML
            if (subtotalEl) subtotalEl.textContent = `${parseFloat(cart.total_price).toFixed(2)} دينار`;
            if (totalPriceEl) totalPriceEl.textContent = `${parseFloat(cart.total_price).toFixed(2)} دينار`;
        }

        // Dynamically display empty cart state
        function displayEmptyCart() {
            const cartItemsContainer = document.getElementById('cart-items-container'); // This might be a tbody or div holding individual item cards
            const cartSummarySection = document.querySelector('.lg\\:col-span-1'); // The section with totals/checkout button
            const clearCartBtnContainer = document.querySelector('.text-center.mt-8'); // The div containing the clear cart button

            if (cartItemsContainer) {
                cartItemsContainer.innerHTML = ''; // Clear existing cart items
            }
            if (clearCartBtnContainer) {
                clearCartBtnContainer.remove(); // Remove clear cart button
            }
            if (cartSummarySection) {
                cartSummarySection.remove(); // Remove cart summary section
            }

            const cartContentDiv = document.querySelector('.grid.grid-cols-1.lg\\:grid-cols-3.gap-8'); // The main container for cart content
            if (cartContentDiv) {
                // Get the products.index route using Laravel's route helper
                const productsIndexUrl = "{{ route('products.index') }}";
                const emptyCartHtml = `
                    <div class="lg:col-span-3 empty-cart-animation text-center py-20">
                        <div class="glass-card rounded-3xl p-12 max-w-md mx-auto">
                            <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-full w-32 h-32 flex items-center justify-center mx-auto mb-8 shadow-2xl">
                                <i class="fas fa-shopping-cart text-white text-5xl"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-white mb-6">السلة فارغة</h3>
                            <p class="text-white/80 mb-8 text-lg">لم تقم بإضافة أي منتجات إلى سلة التسوق بعد</p>
                            <a href="${productsIndexUrl}"
                               class="btn-professional bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 text-white font-bold py-4 px-8 rounded-2xl text-lg inline-flex items-center">
                                <i class="fas fa-shopping-bag mr-3"></i>
                                تسوق الآن
                            </a>
                        </div>
                    </div>
                `;
                cartContentDiv.innerHTML = emptyCartHtml; // Display empty cart message
            }
        }


        // Function to fetch and update the mini cart (e.g., in the header)
        function fetchMiniCart() {
            fetch('/cart/mini') // Assuming you have a route for mini cart data
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const miniCartTotalItems = document.getElementById('mini-cart-total-items'); // e.g., a span for item count
                        const miniCartTotalPrice = document.getElementById('mini-cart-total-price'); // e.g., a span for total price

                        if (miniCartTotalItems) {
                            miniCartTotalItems.textContent = data.total_items;
                        }
                        if (miniCartTotalPrice) {
                            miniCartTotalPrice.textContent = `${parseFloat(data.total_price).toFixed(2)} JOD`;
                        }
                        // You might also need to update a list of items in a dropdown mini-cart if you have one
                    }
                })
                .catch(error => {
                    console.error('Error fetching mini cart:', error);
                });
        }

        // Call fetchMiniCart initially on page load to ensure header is updated
        fetchMiniCart();

        // Show Notification (Remains the same as your original)
        let notificationCounter = 0;
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `alert-${type} fixed top-4 right-4 z-50 max-w-sm rounded-lg shadow-lg transform transition-all duration-300 opacity-0 translate-x-full`;

            notification.style.top = `${20 + (notificationCounter * 80)}px`;

            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-3"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);
            notificationCounter++;

            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translateX(0)';
            }, 100);

            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                notificationCounter--;

                setTimeout(() => {
                    if (notification.parentNode) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }
    });
</script>
@endsection