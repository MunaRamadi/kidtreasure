<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Children's Treasures - كنوز الأطفال</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Tajawal:wght@400;500;700&display=swap');

        body {
            font-family: 'Poppins', 'Tajawal', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #4f46e5 0%, #8b5cf6 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
            color: #4b5563;
        }

        .nav-link:hover {
            color: #4f46e5;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: linear-gradient(90deg, #4f46e5, #8b5cf6);
            transition: all 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .active-nav::after {
            width: 100%;
            background: linear-gradient(90deg, #4f46e5, #8b5cf6);
        }

        .cart-badge {
            animation: pulse 2s infinite;
            transition: all 0.3s ease;
        }

        .cart-badge.hidden {
            opacity: 0;
            transform: scale(0);
        }

        .cart-badge.show {
            opacity: 1;
            transform: scale(1);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .mobile-menu-slide {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        .mobile-menu-slide.active {
            transform: translateX(0);
        }

        .logo-bounce {
            animation: bounce 1s ease-in-out;
            
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .language-switcher {
            transition: all 0.3s ease;
        }

        .language-switcher:hover {
            transform: scale(1.05);
        }

        /* RTL specific styles */
        html[dir="rtl"] .ltr\:space-x-reverse {
            margin-right: 0;
            margin-left: initial;
        }
        html[dir="rtl"] .ltr\:space-x-reverse > *:not(:first-child) {
            margin-right: var(--tw-space-x-reverse);
            margin-left: 0;
        }
        html[dir="rtl"] .ltr\:space-x-reverse {
            --tw-space-x-reverse: 0.5rem;
        }
        html[dir="rtl"] .nav-link::after {
            left: initial;
            right: 0;
        }
        html[dir="rtl"] .fa-home,
        html[dir="rtl"] .fa-box,
        html[dir="rtl"] .fa-users,
        html[dir="rtl"] .fa-book,
        html[dir="rtl"] .fa-blog,
        html[dir="rtl"] .fa-info-circle,
        html[dir="rtl"] .fa-envelope,
        html[dir="rtl"] .fa-user,
        html[dir="rtl"] .fa-shopping-cart {
            margin-right: initial;
            margin-left: 0.5rem;
        }
    </style>
    
</head>
<body class="bg-gradient-to-br from-purple-50 via-blue-50 to-pink-50 min-h-screen">
    <header class="sticky top-0 z-50 glass-effect shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <div class="flex items-center space-x-4 ltr:space-x-reverse">
                    <a href="/" class="flex items-center space-x-3 ltr:space-x-reverse group">
                        <div class="relative">
                            <div class="w-20 h-17 rounded-full flex items-center justify-center shadow-lg transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-500 overflow-hidden border-2 border-white">
                                <img src="{{ asset('images/824bf781-4537-4798-8606-8d9660988496.jfif') }}" alt="Children's Treasures Logo" class="w-full h-full object-cover" width="50px" >
                                <div class="absolute inset-0 rounded-full border-2 border-white/30 animate-spin-slow" style="animation-duration: 8s;"></div>
                            </div>
                        </div>
                    </a>
                </div>

                <nav class="hidden lg:flex items-center space-x-1 ltr:space-x-reverse">
                    <a href="/" class="nav-link px-4 py-2 rounded-lg font-medium text-sm" data-translate="nav_home">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                    <a href="/about" class="nav-link px-4 py-2 rounded-lg font-medium text-sm" data-translate="nav_about">
                        <i class="fas fa-info-circle mr-2"></i><span class="whitespace-nowrap">AboutUs</span>
                    </a>
                    <a href="/products" class="nav-link px-4 py-2 rounded-lg font-medium text-sm" data-translate="nav_products">
                        <i class="fas fa-box mr-2"></i>Products
                    </a>
                    <a href="/workshops" class="nav-link px-4 py-2 rounded-lg font-medium text-sm" data-translate="nav_workshops">
                        <i class="fas fa-users mr-2"></i>Workshops
                    </a>
                    <a href="/stories" class="nav-link px-4 py-2 rounded-lg font-medium text-sm" data-translate="nav_stories">
                        <i class="fas fa-book mr-2"></i>Stories
                    </a>
                    <a href="/blog" class="nav-link px-4 py-2 rounded-lg font-medium text-sm" data-translate="nav_blog">
                        <i class="fas fa-blog mr-2"></i>Blog
                    </a>
                    <a href="/contact-us" class="nav-link px-4 py-2 rounded-lg font-medium text-sm" data-translate="nav_contact">
                        <i class="fas fa-envelope mr-2"></i><span class="whitespace-nowrap">Contact Us</span>
                    </a>
                </nav>

                <div class="hidden lg:flex items-center space-x-4 ltr:space-x-reverse">
                 
                    
                    @guest
                    <a href="/login" class="flex items-center space-x-2 ltr:space-x-reverse text-indigo-600 hover:text-indigo-700 font-medium px-4 py-2 rounded-lg transition-all duration-300 text-sm" data-translate="login_button">
                        <i class="fas fa-user"></i>
                        <span>{{ app()->getLocale() == 'en' ? 'Login' : 'تسجيل الدخول' }}</span>
                    </a>
                    <a href="/register" class="flex items-center space-x-2 ltr:space-x-reverse text-purple-600 hover:text-purple-700 font-medium px-4 py-2 rounded-lg transition-all duration-300 text-sm" data-translate="register_button">
                        <i class="fas fa-user-plus"></i>
                        <span>{{ app()->getLocale() == 'en' ? 'Register' : 'إنشاء حساب' }}</span>
                    </a>
                    @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-2 ltr:space-x-reverse text-purple-600 px-3 py-2 rounded-lg font-medium hover:text-purple-700 transition-colors duration-300 text-sm">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs ml-1"></i>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200" 
                             x-transition:enter-start="opacity-0 scale-95" 
                             x-transition:enter-end="opacity-100 scale-100" 
                             x-transition:leave="transition ease-in duration-150" 
                             x-transition:leave-start="opacity-100 scale-100" 
                             x-transition:leave-end="opacity-0 scale-95" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50"
                             style="display: none;">
                            <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600" data-translate="profile_option">
                                <i class="fas fa-user-circle mr-2 text-indigo-500"></i> Profile
                            </a>
                            <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600" data-translate="orders_option">
                                <i class="fas fa-shopping-bag mr-2 text-indigo-500"></i> Orders
                            </a>
                            @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-indigo-700 hover:bg-indigo-50 hover:text-indigo-800" data-translate="admin_panel_option">
                                <i class="fas fa-user-shield mr-2"></i> Admin Panel
                            </a>
                            @endif
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50" data-translate="logout_option">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @endguest
                       <div id="desktop-language-switcher" class="language-switcher flex items-center space-x-1 ltr:space-x-reverse text-gray-600 hover:text-indigo-600 cursor-pointer">
                        <i class="fas fa-language text-lg"></i>
                        @if(app()->getLocale() == 'en')
                            <a href="{{ route('lang.switch', 'ar') }}" class="text-sm font-medium">العربية</a>
                        @else
                            <a href="{{ route('lang.switch', 'en') }}" class="text-sm font-medium">English</a>
                        @endif
                    </div>
                   <a href="{{ route('cart.index') }}" class="relative flex items-center text-purple-600 px-3 py-2 rounded-lg font-medium hover:text-purple-700 transition-colors duration-300 text-sm">
                       <i class="fas fa-shopping-cart"></i>
                       <span id="desktop-cart-badge" class="cart-badge absolute -top-2 -right-2 bg-pink-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-bold {{ isset($cart) && $cart->total_items > 0 ? '' : 'hidden' }}">
                           {{ isset($cart) ? $cart->total_items : '0' }}
                       </span>
                  </a>
                </div>
                <div class="lg:hidden">
                    <button id="mobile-menu-button" class="relative p-2 rounded-lg bg-indigo-50 hover:bg-indigo-100 transition-all duration-300 transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        <div class="w-5 h-0.5 bg-indigo-600 mb-1 transition-all duration-300" id="line1"></div>
                        <div class="w-5 h-0.5 bg-indigo-600 mb-1 transition-all duration-300" id="line2"></div>
                        <div class="w-5 h-0.5 bg-indigo-600 transition-all duration-300" id="line3"></div>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="lg:hidden mobile-menu-slide fixed top-0 right-0 h-full w-80 bg-white shadow-2xl z-50 hidden">
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                    <div class="flex items-center space-x-3 ltr:space-x-reverse">
                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-baby text-indigo-600"></i>
                        </div>
                        <span class="text-white font-bold text-sm" data-translate="company_name">Children's Treasures</span>
                    </div>
                    <button id="close-mobile-menu" class="text-white hover:text-gray-200 p-2">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto py-4">
                    <div class="px-4 space-y-2">
                        <a href="/" class="flex items-center space-x-3 ltr:space-x-reverse text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-3 rounded-lg transition-all duration-300" data-translate="nav_home">
                            <i class="fas fa-home text-sm w-5"></i>
                            <span class="font-medium text-sm">Home</span>
                        </a>
                        <a href="/products" class="flex items-center space-x-3 ltr:space-x-reverse text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-3 rounded-lg transition-all duration-300" data-translate="nav_products_mobile">
                            <i class="fas fa-box text-sm w-5"></i>
                            <span class="font-medium text-sm">Educational Tools</span>
                        </a>
                        <a href="/workshops" class="flex items-center space-x-3 ltr:space-x-reverse text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-3 rounded-lg transition-all duration-300" data-translate="nav_workshops">
                            <i class="fas fa-users text-sm w-5"></i>
                            <span class="font-medium text-sm">Workshops</span>
                        </a>
                        <a href="/stories" class="flex items-center space-x-3 ltr:space-x-reverse text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-3 rounded-lg transition-all duration-300" data-translate="nav_stories">
                            <i class="fas fa-book text-sm w-5"></i>
                            <span class="font-medium text-sm">Stories</span>
                        </a>
                        <a href="/blog" class="flex items-center space-x-3 ltr:space-x-reverse text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-3 rounded-lg transition-all duration-300" data-translate="nav_blog">
                            <i class="fas fa-blog text-sm w-5"></i>
                            <span class="font-medium text-sm">Blog</span>
                        </a>
                        <a href="/about" class="flex items-center space-x-3 ltr:space-x-reverse text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-3 rounded-lg transition-all duration-300" data-translate="nav_about">
                            <i class="fas fa-info-circle text-sm w-5"></i>
                            <span class="font-medium text-sm whitespace-nowrap">About Us</span>
                        </a>
                        <a href="/contact-us" class="flex items-center space-x-3 ltr:space-x-reverse text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-3 rounded-lg transition-all duration-300">
                            <i class="fas fa-envelope text-sm w-5"></i>
                            <span class="font-medium text-sm whitespace-nowrap">Contact Us</span>
                        </a>
                    </div>
                </div>

                <div class="border-t border-gray-200 p-4">
                    <div class="flex items-center justify-center space-x-3 ltr:space-x-reverse mb-3">
                        <div id="mobile-language-switcher" class="language-switcher flex items-center justify-center space-x-1 ltr:space-x-reverse text-gray-600 hover:text-indigo-600 cursor-pointer px-3 py-2 rounded-lg bg-gray-100 w-full">
                            <i class="fas fa-language"></i>
                            <span class="font-medium text-sm" data-translate="switch_lang_mobile">Switch to Arabic</span>
                        </div>
                    </div>
                    @auth
                    <div class="flex items-center justify-center mb-3">
                        <div class="text-gray-700 font-medium text-sm px-3 py-2 bg-gray-100 rounded-lg w-full text-center">
                            Hi, {{ Auth::user()->name }}
                        </div>
                    </div>
                    @endauth
                    <div class="flex items-center justify-center space-x-3 ltr:space-x-reverse">
                        @guest
                        <a href="/login" class="flex items-center space-x-2 ltr:space-x-reverse bg-indigo-600 text-white px-3 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-300 flex-1 justify-center text-sm" data-translate="login_button">
                            <i class="fas fa-user text-indigo-200"></i>
                            <span>Login</span>
                        </a>
                        <a href="/register" class="flex items-center space-x-2 ltr:space-x-reverse bg-purple-600 text-white px-3 py-2 rounded-lg font-medium hover:bg-purple-700 transition-colors duration-300 flex-1 justify-center text-sm" data-translate="register_button">
                            <i class="fas fa-user-plus text-purple-200"></i>
                            <span>Register</span>
                        </a>
                        @else
                        <div class="grid grid-cols-2 gap-2 w-full">
                            <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-1 ltr:space-x-reverse bg-indigo-600 text-white px-2 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-300 justify-center text-sm" data-translate="profile_option">
                                <i class="fas fa-user-circle text-indigo-200"></i>
                                <span>Profile</span>
                            </a>
                            <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-1 ltr:space-x-reverse bg-indigo-600 text-white px-2 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-300 justify-center text-sm" data-translate="settings_option">
                                <i class="fas fa-cog text-indigo-200"></i>
                                <span>Settings</span>
                            </a>
                            <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-1 ltr:space-x-reverse bg-indigo-600 text-white px-2 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-300 justify-center text-sm" data-translate="orders_option">
                                <i class="fas fa-shopping-bag text-indigo-200"></i>
                                <span>Orders</span>
                            </a>
                            @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-1 ltr:space-x-reverse bg-indigo-600 text-white px-2 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-300 justify-center text-sm" data-translate="admin_panel_option">
                                <span>Admin Panel</span>
                            </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full flex items-center space-x-1 ltr:space-x-reverse bg-red-600 text-white px-2 py-2 rounded-lg font-medium hover:bg-red-700 transition-colors duration-300 justify-center text-sm" data-translate="logout_option">
                                    <i class="fas fa-sign-out-alt text-red-200"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                        <a href="/cart" class="relative flex items-center space-x-2 ltr:space-x-reverse bg-purple-600 text-white px-3 py-2 rounded-lg font-medium hover:bg-purple-700 transition-colors duration-300 flex-1 justify-center text-sm" data-translate="cart_button">
                            <i class="fas fa-shopping-cart text-purple-200"></i>
                            <span>Cart</span>
                            <span id="mobile-cart-badge" class="cart-badge absolute -top-2 -right-2 bg-pink-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-bold hidden">0</span>
                        </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </header>

    

<script>
    // --- Cart Management ---
    let cartCount = 0;

    // Function to update cart badge display
    function updateCartBadge() {
        fetch('/cart/mini')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const totalItems = data.total_items;
                    const desktopBadge = document.getElementById('desktop-cart-badge');
                    const mobileBadge = document.getElementById('mobile-cart-badge');
                    
                    if (totalItems > 0) {
                        // Update desktop badge
                        if (desktopBadge) {
                            desktopBadge.textContent = totalItems;
                            desktopBadge.classList.remove('hidden');
                            desktopBadge.classList.add('show');
                        }
                        
                        // Update mobile badge
                        if (mobileBadge) {
                            mobileBadge.textContent = totalItems;
                            mobileBadge.classList.remove('hidden');
                            mobileBadge.classList.add('show');
                        }
                        
                        // Add a little animation feedback
                        const badges = document.querySelectorAll('.cart-badge');
                        badges.forEach(badge => {
                            badge.style.animation = 'none';
                            badge.offsetHeight; // Trigger reflow
                            badge.style.animation = 'pulse 0.6s ease-in-out';
                        });
                    } else {
                        // Hide badges if cart is empty
                        if (desktopBadge) {
                            desktopBadge.classList.add('hidden');
                            desktopBadge.classList.remove('show');
                        }
                        if (mobileBadge) {
                            mobileBadge.classList.add('hidden');
                            mobileBadge.classList.remove('show');
                        }
                    }
                }
            })
            .catch(error => console.error('Error fetching cart data:', error));
    }


    // Function to add item to cart
    function addToCart(productId, quantity = 1) {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);
        
        fetch('/cart/add', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message if available
                if (typeof showToast === 'function') {
                    showToast('Success', data.message, 'success');
                } else {
                    console.log('Success:', data.message);
                }
                
                // Update cart badge
                updateCartBadge();
            } else {
                if (typeof showToast === 'function') {
                    showToast('Error', data.message, 'error');
                } else {
                    console.error('Error:', data.message);
                }
            }
        })
        .catch(error => {
            console.error('Error adding to cart:', error);
            if (typeof showToast === 'function') {
                showToast('Error', 'Failed to add item to cart', 'error');
            }
        });
    }

    // Function to update cart item quantity
    function updateCartItem(productId, quantity) {
        fetch(`/cart/${productId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message if available
                if (typeof showToast === 'function') {
                    showToast('Success', data.message, 'success');
                } else {
                    console.log('Success:', data.message);
                }
                
                // Update cart badge
                updateCartBadge();
                
                // If we're on the cart page, update the item subtotal and cart total
                if (document.querySelector('.cart-page')) {
                    const itemRow = document.querySelector(`[data-product-id="${productId}"]`);
                    if (itemRow) {
                        const subtotalElement = itemRow.querySelector('.item-subtotal');
                        if (subtotalElement && data.item_subtotal) {
                            subtotalElement.textContent = data.item_subtotal;
                        }
                    }
                    
                    const cartTotalElement = document.querySelector('.cart-total');
                    if (cartTotalElement && data.cart_total) {
                        cartTotalElement.textContent = data.cart_total;
                    }
                }
            } else {
                if (typeof showToast === 'function') {
                    showToast('Error', data.message, 'error');
                } else {
                    console.error('Error:', data.message);
                }
            }
        })
        .catch(error => {
            console.error('Error updating cart item:', error);
            if (typeof showToast === 'function') {
                showToast('Error', 'Failed to update item quantity', 'error');
            }
        });
    }

       // Function to remove item from cart
       function removeCartItem(productId) {
        fetch(`/cart/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message if available
                if (typeof showToast === 'function') {
                    showToast('Success', data.message, 'success');
                } else {
                    console.log('Success:', data.message);
                }
                
                // Update cart badge
                updateCartBadge();
                
                // If we're on the cart page, remove the item row
                if (document.querySelector('.cart-page')) {
                    const itemRow = document.querySelector(`[data-product-id="${productId}"]`);
                    if (itemRow) {
                        itemRow.remove();
                    }
                    
                    // Update cart total
                    const cartTotalElement = document.querySelector('.cart-total');
                    if (cartTotalElement && data.cart_total) {
                        cartTotalElement.textContent = data.cart_total;
                    }
                    
                    // If cart is empty, show empty cart message
                    if (data.total_items === 0) {
                        const cartTable = document.querySelector('.cart-table');
                        if (cartTable) {
                            cartTable.innerHTML = '<tr><td colspan="6" class="text-center py-4">Your cart is empty</td></tr>';
                        }
                    }
                }
            } else {
                if (typeof showToast === 'function') {
                    showToast('Error', data.message, 'error');
                } else {
                    console.error('Error:', data.message);
                }
            }
        })
        .catch(error => {
            console.error('Error removing cart item:', error);
            if (typeof showToast === 'function') {
                showToast('Error', 'Failed to remove item from cart', 'error');
            }
        });
    }
     // Function to clear cart
     function clearCart() {
        fetch('/cart/clear', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message if available
                if (typeof showToast === 'function') {
                    showToast('Success', data.message, 'success');
                } else {
                    console.log('Success:', data.message);
                }
                
                // Update cart badge
                updateCartBadge();
                
                // If we're on the cart page, show empty cart message
                if (document.querySelector('.cart-page')) {
                    const cartTable = document.querySelector('.cart-table');
                    if (cartTable) {
                        cartTable.innerHTML = '<tr><td colspan="6" class="text-center py-4">Your cart is empty</td></tr>';
                    }
                    
                    // Update cart total
                    const cartTotalElement = document.querySelector('.cart-total');
                    if (cartTotalElement) {
                        cartTotalElement.textContent = '0.00';
                    }
                }
            } else {
                if (typeof showToast === 'function') {
                    showToast('Error', data.message, 'error');
                } else {
                    console.error('Error:', data.message);
                }
            }
        })
        .catch(error => {
            console.error('Error clearing cart:', error);
            if (typeof showToast === 'function') {
                showToast('Error', 'Failed to clear cart', 'error');
            }
        });
    }

    // Apply coupon code
    function applyCoupon(couponCode) {
        fetch('/cart/apply-coupon', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ coupon_code: couponCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message if available
                if (typeof showToast === 'function') {
                    showToast('Success', data.message, 'success');
                } else {
                    console.log('Success:', data.message);
                }
                
                // Update cart total and discount if we're on the cart page
                if (document.querySelector('.cart-page')) {
                    const cartTotalElement = document.querySelector('.cart-total');
                    if (cartTotalElement && data.cart_total) {
                        cartTotalElement.textContent = data.cart_total;
                    }
                    
                    const discountElement = document.querySelector('.discount-amount');
                    if (discountElement && data.discount) {
                        discountElement.textContent = data.discount;
                        discountElement.closest('.discount-row').classList.remove('hidden');
                    }
                }
            } else {
                if (typeof showToast === 'function') {
                    showToast('Error', data.message, 'error');
                } else {
                    console.error('Error:', data.message);
                }
            }
        })
        .catch(error => {
            console.error('Error applying coupon:', error);
            if (typeof showToast === 'function') {
                showToast('Error', 'Failed to apply coupon', 'error');
            }
        });
    }

    // Initialize cart on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartBadge();
        
        // Add event listeners for quantity inputs on cart page
        if (document.querySelector('.cart-page')) {
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const productId = this.closest('[data-product-id]').dataset.productId;
                    const quantity = parseInt(this.value);
                    if (quantity > 0) {
                        updateCartItem(productId, quantity);
                    } else {
                        removeCartItem(productId);
                    }
                });
            });
            
            // Add event listeners for remove buttons
            document.querySelectorAll('.remove-item-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.closest('[data-product-id]').dataset.productId;
                    removeCartItem(productId);
                });
            });
            
            // Add event listener for coupon form
            const couponForm = document.querySelector('#coupon-form');
            if (couponForm) {
                couponForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const couponCode = this.querySelector('input[name="coupon_code"]').value;
                    if (couponCode) {
                        applyCoupon(couponCode);
                    }
                });
            }
            
            // Add event listener for clear cart button
            const clearCartBtn = document.querySelector('.clear-cart-btn');
            if (clearCartBtn) {
                clearCartBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to clear your cart?')) {
                        clearCart();
                    }
                });
            }
        }
    });

    // Initialize cart on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Load cart count from storage if you want persistence
        const savedCartCount = parseInt(localStorage.getItem('cartCount') || '0');
        cartCount = savedCartCount;
        updateCartBadge();
    });

    // Save cart count to storage whenever it changes
    function saveCartCount() {
        localStorage.setItem('cartCount', cartCount.toString());
    }

    // Override the addToCart function to include saving
    const originalAddToCart = addToCart;
    addToCart = function() {
        originalAddToCart();
        saveCartCount();
    };

    // Override the clearCart function to include saving
    const originalClearCart = clearCart;
    clearCart = function() {
        originalClearCart();
        saveCartCount();
    };
    
    // --- Translations Object ---
    const translations = {
        'en': {
            'page_title': "Children's Treasures - كنوز الأطفال",
            'company_name': "Children's Treasures",
            'nav_home': "Home",
            'nav_products': "Products",
            'nav_products_mobile': "Educational Tools",
            'nav_workshops': "Workshops",
            'nav_stories': "Stories",
            'nav_blog': "Blog",
            'nav_about': "About Us",
            'nav_contact': "Contact Us",
            'login_button': "Login",
            'register_button': "Register",
            'profile_button': "Profile",
            'profile_option': "Profile",
            'settings_option': "Settings",
            'orders_option': "Orders",
            'logout_option': "Logout",
            'cart_button': "Cart",
            'switch_lang_desktop': "العربية",
            'switch_lang_mobile': "Switch to Arabic"
        },
        'ar': {
            'page_title': "كنوز الأطفال - Children's Treasures",
            'company_name': "كنوز الأطفال",
            'nav_home': "الرئيسية",
            'nav_products': "المنتجات",
            'nav_products_mobile': "أدوات تعليمية",
            'nav_workshops': "ورش العمل",
            'nav_stories': "القصص",
            'nav_blog': "المدونة",
            'nav_about': "من نحن",
            'nav_contact': "اتصل بنا",
            'login_button': "تسجيل الدخول",
            'register_button': "إنشاء حساب",
            'profile_button': "الملف الشخصي",
            'profile_option': "الملف الشخصي",
            'settings_option': "الإعدادات",
            'orders_option': "الطلبات",
            'logout_option': "تسجيل الخروج",
            'cart_button': "السلة",
            'switch_lang_desktop': "English",
            'switch_lang_mobile': "التبديل إلى الإنجليزية"
        }
    };

    // --- Language Handling Functions ---
    const html = document.documentElement;
    const desktopLanguageSwitcher = document.getElementById('desktop-language-switcher');
    const mobileLanguageSwitcher = document.getElementById('mobile-language-switcher');
    
    // Function to apply translations
    function applyTranslations(lang) {
        document.querySelectorAll('[data-translate]').forEach(element => {
            const key = element.getAttribute('data-translate');
            if (translations[lang] && translations[lang][key]) {
                element.textContent = translations[lang][key];
            }
        });
        document.title = translations[lang]['page_title'];
        html.setAttribute('lang', lang);
        html.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');

        if (lang === 'ar') {
            document.body.classList.add('rtl');
            document.body.classList.remove('ltr');
        } else {
            document.body.classList.add('ltr');
            document.body.classList.remove('rtl');
        }

        // Adjust logo direction for RTL
        const logoDiv = document.querySelector('.flex.items-center.space-x-4.ltr\\:space-x-reverse');
        const logoLink = document.querySelector('.flex.items-center.space-x-3.ltr\\:space-x-reverse');

        if (lang === 'ar') {
            logoDiv.classList.remove('ltr:space-x-reverse');
            logoDiv.classList.add('space-x-reverse');
            logoLink.classList.remove('ltr:space-x-reverse');
            logoLink.classList.add('space-x-reverse');
        } else {
            logoDiv.classList.add('ltr:space-x-reverse');
            logoDiv.classList.remove('space-x-reverse');
            logoLink.classList.add('ltr:space-x-reverse');
            logoLink.classList.remove('space-x-reverse');
        }
    }

    // Initialize language and other functionality on page load
    document.addEventListener('DOMContentLoaded', function() {
        const storedLang = localStorage.getItem('preferredLang') || 'en';
        applyTranslations(storedLang);

        // Highlight active nav link
        const currentPath = window.location.pathname;
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active-nav', 'text-indigo-600');
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active-nav');
                link.classList.add('text-indigo-600');
            }
        });

        // --- Mobile Menu Toggle ---
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMobileMenuButton = document.getElementById('close-mobile-menu');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('active');
            
            // Transform hamburger icon to close icon
            document.getElementById('line1').classList.toggle('rotate-45');
            document.getElementById('line1').classList.toggle('translate-y-2');
            document.getElementById('line2').classList.toggle('opacity-0');
            document.getElementById('line3').classList.toggle('-rotate-45');
            document.getElementById('line3').classList.toggle('-translate-y-2');
        });

        closeMobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.remove('active');
            mobileMenu.classList.add('hidden');
            
            // Transform close icon back to hamburger icon
            document.getElementById('line1').classList.remove('rotate-45', 'translate-y-2');
            document.getElementById('line2').classList.remove('opacity-0');
            document.getElementById('line3').classList.remove('-rotate-45', '-translate-y-2');
        });

        // --- Language Switcher Click Handlers ---
        [desktopLanguageSwitcher, mobileLanguageSwitcher].forEach(switcher => {
            switcher.addEventListener('click', function() {
                const currentLang = localStorage.getItem('preferredLang') || 'en';
                const newLang = currentLang === 'en' ? 'ar' : 'en';
                
                localStorage.setItem('preferredLang', newLang);
                window.location.reload();
            });
        });
    });
</script>
</body>
</html>

<!-- Add Alpine.js for dropdown functionality -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>