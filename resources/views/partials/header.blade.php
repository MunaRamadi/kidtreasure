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
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 via-blue-50 to-pink-50 min-h-screen">
    <header class="sticky top-0 z-50 glass-effect shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Logo Section -->
 <div class="flex items-center space-x-4 ltr:space-x-reverse">
     <a href="/" class="flex items-center space-x-3 ltr:space-x-reverse group">
         <div class="relative">
             <div class="w-20 h-17 rounded-full flex items-center justify-center shadow-lg transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-500 overflow-hidden border-2 border-white">
                 <img src="{{ asset('images/824bf781-4537-4798-8606-8d9660988496.jfif') }}" alt="Children's Treasures Logo" class="w-full h-full object-cover"  width="50px" >
                 <div class="absolute inset-0 rounded-full border-2 border-white/30 animate-spin-slow" style="animation-duration: 8s;"></div>
             </div>
             
         </div>
    </a>
</div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center space-x-1 ltr:space-x-reverse">
                    <a href="/" class="nav-link px-4 py-2 rounded-lg font-medium text-sm active-nav">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                   
                    <a href="/workshops" class="nav-link px-4 py-2 rounded-lg font-medium text-sm">
                        <i class="fas fa-users mr-2"></i>Workshops
                    </a>
                    <a href="/stories" class="nav-link px-4 py-2 rounded-lg font-medium text-sm">
                        <i class="fas fa-book mr-2"></i>Stories
                    </a>
                    <a href="/blog" class="nav-link px-4 py-2 rounded-lg font-medium text-sm">
                        <i class="fas fa-blog mr-2"></i>Blog
                    </a>
                    <a href="/about" class="nav-link px-4 py-2 rounded-lg font-medium text-sm">
                        <i class="fas fa-info-circle mr-2"></i>About Us
                    </a>
                    <a href="/contact" class="nav-link px-4 py-2 rounded-lg font-medium text-sm">
                        <i class="fas fa-envelope mr-2"></i>Contact Us
                    </a>
                </nav>

                <!-- Right Side Actions -->
                <div class="hidden lg:flex items-center space-x-4 ltr:space-x-reverse">
                    <div class="language-switcher flex items-center space-x-1 ltr:space-x-reverse text-gray-600 hover:text-indigo-600 cursor-pointer">
                        <i class="fas fa-language text-lg"></i>
                        <span class="text-sm font-medium">Arabic</span>
                    </div>
                    
                    <a href="/login" class="flex items-center space-x-2 ltr:space-x-reverse text-indigo-600 hover:text-white font-medium px-4 py-2 rounded-full bg-indigo-50 hover:bg-indigo-600 transition-all duration-300 transform hover:scale-105 text-sm">
                        <i class="fas fa-user"></i>
                        <span>Login</span>
                    </a>
                    <a href="/cart" class="relative flex items-center space-x-2 ltr:space-x-reverse text-indigo-600 hover:text-white font-medium px-4 py-2 rounded-full bg-indigo-50 hover:bg-indigo-600 transition-all duration-300 transform hover:scale-105 text-sm">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Cart</span>
                        <span class="cart-badge absolute -top-2 -right-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold shadow-lg">3</span>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden">
                    <button id="mobile-menu-button" class="relative p-2 rounded-lg bg-indigo-50 hover:bg-indigo-100 transition-all duration-300 transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        <div class="w-5 h-0.5 bg-indigo-600 mb-1 transition-all duration-300" id="line1"></div>
                        <div class="w-5 h-0.5 bg-indigo-600 mb-1 transition-all duration-300" id="line2"></div>
                        <div class="w-5 h-0.5 bg-indigo-600 transition-all duration-300" id="line3"></div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="lg:hidden mobile-menu-slide fixed top-0 right-0 h-full w-80 bg-white shadow-2xl z-50 hidden">
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                    <div class="flex items-center space-x-3 ltr:space-x-reverse">
                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-baby text-indigo-600"></i>
                        </div>
                        <span class="text-white font-bold text-sm">Children's Treasures</span>
                    </div>
                    <button id="close-mobile-menu" class="text-white hover:text-gray-200 p-2">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto py-4">
                    <div class="px-4 space-y-2">
                        <a href="/" class="flex items-center space-x-3 ltr:space-x-reverse text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-3 rounded-lg transition-all duration-300">
                            <i class="fas fa-home text-sm w-5"></i>
                            <span class="font-medium text-sm">Home</span>
                        </a>
                        <a href="/products" class="flex items-center space-x-3 ltr:space-x-reverse text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-3 rounded-lg transition-all duration-300">
                            <i class="fas fa-box text-sm w-5"></i>
                            <span class="font-medium text-sm">Educational Tools</span>
                        </a>
                        <a href="/workshops" class="flex items-center space-x-3 ltr:space-x-reverse text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-3 rounded-lg transition-all duration-300">
                            <i class="fas fa-users text-sm w-5"></i>
                            <span class="font-medium text-sm">Workshops</span>
                        </a>
                        <a href="/stories" class="flex items-center space-x-3 ltr:space-x-reverse text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-3 rounded-lg transition-all duration-300">
                            <i class="fas fa-book text-sm w-5"></i>
                            <span class="font-medium text-sm">Stories</span>
                        </a>
                        <a href="/blog" class="flex items-center space-x-3 ltr:space-x-reverse text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-3 rounded-lg transition-all duration-300">
                            <i class="fas fa-blog text-sm w-5"></i>
                            <span class="font-medium text-sm">Blog</span>
                        </a>
                        <a href="/about" class="flex items-center space-x-3 ltr:space-x-reverse text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-3 rounded-lg transition-all duration-300">
                            <i class="fas fa-info-circle text-sm w-5"></i>
                            <span class="font-medium text-sm">About Us</span>
                        </a>
                        <a href="/contact-us" class="flex items-center space-x-3 ltr:space-x-reverse text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-3 rounded-lg transition-all duration-300">
                            <i class="fas fa-envelope text-sm w-5"></i>
                            <span class="font-medium text-sm">Contact Us</span>
                        </a>
                    </div>
                </div>

                <div class="border-t border-gray-200 p-4">
                    <div class="flex items-center justify-center space-x-3 ltr:space-x-reverse mb-3">
                        <div class="language-switcher flex items-center justify-center space-x-1 ltr:space-x-reverse text-gray-600 hover:text-indigo-600 cursor-pointer px-3 py-2 rounded-lg bg-gray-100 w-full">
                            <i class="fas fa-language"></i>
                            <span class="font-medium text-sm">Switch to Arabic</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-center space-x-3 ltr:space-x-reverse">
                        <a href="/login" class="flex items-center space-x-2 ltr:space-x-reverse bg-indigo-600 text-white px-3 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-300 flex-1 justify-center text-sm">
                            <i class="fas fa-user"></i>
                            <span>Login</span>
                        </a>
                        <a href="/cart" class="relative flex items-center space-x-2 ltr:space-x-reverse bg-purple-600 text-white px-3 py-2 rounded-lg font-medium hover:bg-purple-700 transition-colors duration-300 flex-1 justify-center text-sm">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Cart</span>
                            <span class="absolute -top-2 -right-2 bg-pink-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-bold">3</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
        mobileMenu.classList.toggle('active');
        
        // Transform hamburger icon to close icon
        document.getElementById('line1').classList.toggle('rotate-45');
        document.getElementById('line1').classList.toggle('translate-y-2');
        document.getElementById('line2').classList.toggle('opacity-0');
        document.getElementById('line3').classList.toggle('-rotate-45');
        document.getElementById('line3').classList.toggle('-translate-y-2');
    });

    document.getElementById('close-mobile-menu').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.remove('active');
        mobileMenu.classList.add('hidden');
        
        // Transform close icon back to hamburger icon
        document.getElementById('line1').classList.remove('rotate-45');
        document.getElementById('line1').classList.remove('translate-y-2');
        document.getElementById('line2').classList.remove('opacity-0');
        document.getElementById('line3').classList.remove('-rotate-45');
        document.getElementById('line3').classList.remove('-translate-y-2');
    });

    // Highlight active nav link
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active-nav');
            link.classList.add('text-indigo-600');
        }
    });
</script>
</body>
</html>