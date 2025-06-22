@extends('layouts.app')

@section('title', 'Environmental Blog - Kids Treasures')

@section('styles')
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

    /* Blog Card Specific Styles */
    .blog-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        transform-style: preserve-3d;
    }
    
    .blog-card:hover {
        transform: translateY(-10px) rotateY(5deg) rotateX(5deg);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        background: rgba(255, 255, 255, 0.98);
    }

    .eco-badge {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 6px 16px;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .search-box {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .category-pill {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        color: white;
        font-weight: 500;
    }
    
    .category-pill:hover, .category-pill.active {
        background: linear-gradient(135deg, #4f46e5 0%, #8b5cf6 100%);
        color: white;
        transform: scale(1.05) translateY(-2px);
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4);
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

    /* Responsive Design for Mobile */
    @media (max-width: 768px) {
        .floating-element {
            width: 40px !important;
            height: 40px !important;
        }
        
        .card-hover-effect:hover {
            transform: none;
        }
        
        .blog-card:hover {
            transform: translateY(-5px);
        }
    }

    /* Newsletter section enhancement */
    .newsletter-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        background-size: 400% 400%;
        animation: gradientShift 20s ease infinite;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="animated-bg min-h-screen flex items-center relative overflow-hidden">
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
    
    <div class="max-w-7xl mx-auto px-6 py-20 relative z-10">
        <div class="text-center">
            <div class="fade-in-up">
                <h1 class="text-5xl md:text-7xl font-black mb-8 leading-tight">
                    <span class="block text-white drop-shadow-2xl">Environmental</span>
                    <span class="block text-gradient-advanced text-6xl md:text-8xl">Blog</span>
                    <span class="block text-white text-3xl md:text-4xl font-bold mt-6 drop-shadow-lg">🌱 Towards a Greener Future 🌍</span>
                </h1>
            </div>
            
            <div class="fade-in-left">
                <p class="text-xl md:text-2xl mb-12 leading-relaxed text-white/95 font-light max-w-4xl mx-auto">
                    Discover creative ideas and fun activities to teach children about environmental love and recycling
                </p>
            </div>
            

            </div>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->


<!-- Blog Posts Section -->
<section class="py-24 section-bg-pattern bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="container mx-auto px-4">
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($posts as $index => $post)
                <article class="blog-card card-hover-effect rounded-3xl overflow-hidden shadow-2xl fade-in-up" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="relative">
                        <img src="{{ $post->image_url ?? 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=400&h=250&fit=crop' }}" 
                             alt="{{ $post->title_ar ?? $post->title_en }}" 
                             class="w-full h-56 object-cover image-hover-effect">
                        <div class="absolute top-6 right-6">
                            <span class="eco-badge">
                                <i class="fas fa-leaf"></i>
                                Eco
                            </span>
                        </div>
                        <div class="absolute bottom-6 left-6 text-white">
                            <div class="flex items-center gap-2 text-sm bg-black/30 backdrop-blur-10 px-3 py-2 rounded-full">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $post->publication_date->format('Y/m/d') }}</span>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
                    </div>
                    
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-4 py-2 bg-gradient-to-r from-blue-100 via-purple-100 to-pink-100 text-blue-800 rounded-full text-sm font-semibold">
                                <i class="fas fa-user mr-2"></i>
                                {{ $post->author_name }}
                            </span>
                            <div class="flex items-center gap-1 text-yellow-500">
                                @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-sm"></i>
                                @endfor
                            </div>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 leading-tight">
                            {{ $post->title_ar ?? $post->title_en }}
                        </h3>
                        
                        <p class="text-gray-600 mb-6 text-base leading-relaxed">
                            {{ Str::limit(strip_tags($post->content_ar ?? $post->content_en), 120) }}
                        </p>
                        
                        <div class="flex items-center justify-between">
                           <a href="{{ route('blog.show', $post) }}" class="inline-flex items-center gap-2 font-semibold text-indigo-600 hover:text-indigo-800 transition-colors duration-300">
        <span>Read More</span>
        <i class="fas fa-arrow-right"></i>
    </a>
                            
                            
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-16 flex justify-center">
                {{ $posts->links('pagination::tailwind') }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20 fade-in-up">
                <div class="max-w-md mx-auto glass-card rounded-3xl p-12">
                    <div class="text-8xl text-gray-300 mb-8">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-700 mb-6">No Articles Available</h3>
                    <p class="text-gray-500 mb-8 text-lg">We're working on adding amazing environmental articles soon!</p>
                    <a href="{{ route('contact.create') }}" 
                       class="btn-professional inline-flex items-center gap-3 bg-gradient-to-r from-green-400 via-emerald-500 to-teal-600 text-white px-8 py-4 rounded-2xl font-bold hover:shadow-2xl">
                        <i class="fas fa-envelope"></i>
                        <span>Suggest a Topic</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Featured Environmental Tips -->
<section class="py-24 section-bg-pattern bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 fade-in-up">
            <h2 class="text-5xl md:text-7xl font-black mb-8">
                <span class="text-gradient-advanced">Quick Environmental Tips</span>
            </h2>
            <div class="flex justify-center mb-8">
                <div class="w-32 h-2 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-full"></div>
            </div>
            <p class="text-2xl text-gray-700 leading-relaxed font-light">Simple ideas you can implement today</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="glass-card card-hover-effect rounded-3xl p-8 shadow-2xl fade-in-left">
                <div class="bg-gradient-to-br from-green-500 via-emerald-600 to-teal-700 rounded-3xl w-20 h-20 flex items-center justify-center mx-auto mb-6 shadow-2xl">
                    <i class="fas fa-recycle text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">Recycling</h3>
                <p class="text-gray-600 text-center leading-relaxed">Waste separation and material reuse</p>
                <div class="mt-6 w-full h-1 bg-gradient-to-r from-green-500 to-teal-600 rounded-full"></div>
            </div>

            <div class="glass-card card-hover-effect rounded-3xl p-8 shadow-2xl fade-in-up" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700 rounded-3xl w-20 h-20 flex items-center justify-center mx-auto mb-6 shadow-2xl">
                    <i class="fas fa-tint text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">Water Saving</h3>
                <p class="text-gray-600 text-center leading-relaxed">Use water wisely and avoid waste</p>
                <div class="mt-6 w-full h-1 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full"></div>
            </div>

            <div class="glass-card card-hover-effect rounded-3xl p-8 shadow-2xl fade-in-up" style="animation-delay: 0.4s;">
                <div class="bg-gradient-to-br from-yellow-500 via-orange-600 to-red-700 rounded-3xl w-20 h-20 flex items-center justify-center mx-auto mb-6 shadow-2xl">
                    <i class="fas fa-lightbulb text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">Energy Saving</h3>
                <p class="text-gray-600 text-center leading-relaxed">Use energy-efficient appliances</p>
                <div class="mt-6 w-full h-1 bg-gradient-to-r from-yellow-500 to-red-600 rounded-full"></div>
            </div>

            <div class="glass-card card-hover-effect rounded-3xl p-8 shadow-2xl fade-in-right" style="animation-delay: 0.6s;">
                <div class="bg-gradient-to-br from-purple-500 via-pink-600 to-rose-700 rounded-3xl w-20 h-20 flex items-center justify-center mx-auto mb-6 shadow-2xl">
                    <i class="fas fa-seedling text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">Home Gardening</h3>
                <p class="text-gray-600 text-center leading-relaxed">Grow plants at home</p>
                <div class="mt-6 w-full h-1 bg-gradient-to-r from-purple-500 to-rose-600 rounded-full"></div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-bg relative overflow-hidden py-24">
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    
  
            
           
<!-- Social Media & Call to Action -->
<section class="py-20 bg-gradient-to-br from-gray-900 via-slate-800 to-gray-900 relative overflow-hidden">
    <div class="stars">
        <div class="star" style="top: 15%; left: 5%; animation-delay: 0s;"></div>
        <div class="star" style="top: 35%; left: 25%; animation-delay: 0.5s;"></div>
        <div class="star" style="top: 55%; left: 65%; animation-delay: 1s;"></div>
        <div class="star" style="top: 75%; left: 15%; animation-delay: 1.5s;"></div>
        <div class="star" style="top: 25%; left: 85%; animation-delay: 0.3s;"></div>
        <div class="star" style="top: 65%; left: 45%; animation-delay: 1.2s;"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16 fade-in-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-8">
                Follow Us on Social Media 🌍
            </h2>
            <p class="text-xl text-gray-300 leading-relaxed">
                Join our growing community of environmental lovers
            </p>
        </div>
        
        <div class="flex flex-wrap justify-center gap-6 mb-16 fade-in-left">
            <a href="#" class="glass-card btn-professional rounded-2xl p-6 text-white hover:scale-110 transition-all duration-300">
                <i class="fab fa-facebook-f text-3xl mb-2 text-blue-400"></i>
                <div class="text-sm font-semibold">Facebook</div>
            </a>
            <a href="#" class="glass-card btn-professional rounded-2xl p-6 text-white hover:scale-110 transition-all duration-300">
                <i class="fab fa-instagram text-3xl mb-2 text-pink-400"></i>
                <div class="text-sm font-semibold">Instagram</div>
            </a>
        
        </div>
        
        <div class="text-center fade-in-right">
            <div class="glass-card rounded-3xl p-8 md:p-12 max-w-2xl mx-auto">
                <h3 class="text-3xl font-bold text-white mb-6">
                    Have an Environmental Idea? 💡
                </h3>
                <p class="text-gray-300 mb-8 text-lg leading-relaxed">
                    Share your environmental ideas and experiences with us
                </p>
                <a href="{{ route('contact.create') }}" 
                   class="btn-professional inline-flex items-center gap-3 bg-gradient-to-r from-green-400 via-emerald-500 to-teal-600 text-white px-8 py-4 rounded-2xl font-bold hover:shadow-2xl text-lg">
                    <i class="fas fa-edit"></i>
                    <span>Suggest an Article</span>
                </a>
            </div>
        </div>
    </div>
</section>
   <script >
        // دالة للمساعدة في التحقق من وجود العنصر قبل التفاعل معه
        function getElement(selector, isAll = false) {
            const element = isAll ? document.querySelectorAll(selector) : document.querySelector(selector);
            return element && (isAll ? element.length > 0 : true) ? element : null;
        }

        // --- 1. زر العودة للأعلى (Back to top button visibility) ---
        const backToTopBtn = getElement('#backToTop');
        if (backToTopBtn) {
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopBtn.style.opacity = '1';
                    backToTopBtn.style.visibility = 'visible';
                } else {
                    backToTopBtn.style.opacity = '0';
                    backToTopBtn.style.visibility = 'hidden'; // تم التصحيح من 'invisible'
                }
            });

            // إضافة وظيفة النقر للعودة للأعلى
            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth' // للتمرير الناعم
                });
            });
        }

        // --- 2. وظيفة تصفية الفئات (Category filter functionality) ---
        const categoryPills = getElement('.category-pill', true); // true للحصول على كل العناصر
        if (categoryPills) {
            categoryPills.forEach(pill => {
                pill.addEventListener('click', function() {
                    // إزالة فئة 'active' من جميع الأقراص
                    categoryPills.forEach(p => p.classList.remove('active'));
                    // إضافة فئة 'active' إلى القرص الذي تم النقر عليه
                    this.classList.add('active');

                    // أضف منطق التصفية هنا إذا لزم الأمر
                    console.log('الفئة المختارة:', this.textContent.trim());
                });
            });
        }

        // --- 3. وظيفة البحث (Search functionality) ---
        const searchButton = getElement('.search-box button');
        const searchInput = getElement('.search-box input');
        if (searchButton && searchInput) {
            searchButton.addEventListener('click', function(e) {
                e.preventDefault(); // منع السلوك الافتراضي للزر (إرسال النموذج)
                const searchTerm = searchInput.value.trim();
                if (searchTerm) {
                    // أضف منطق البحث هنا
                    console.log('البحث عن:', searchTerm);
                    // يمكنك إضافة بحث AJAX أو إعادة التوجيه إلى صفحة نتائج البحث
                }
            });
        }

        // --- 4. إرسال نموذج النشرة الإخبارية (Newsletter form submission) ---
        const newsletterForm = getElement('.newsletter-bg form');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault(); // منع السلوك الافتراضي للنموذج (إعادة تحميل الصفحة)
                const emailInput = this.querySelector('input[type="email"]');
                const email = emailInput ? emailInput.value.trim() : '';

                if (email) {
                    // أضف منطق الاشتراك في النشرة الإخبارية هنا
                    console.log('اشتراك النشرة الإخبارية لـ:', email);
                    alert('شكرا لك! تم تسجيل اشتراكك بنجاح 🌱');
                    if (emailInput) {
                        emailInput.value = ''; // مسح حقل البريد الإلكتروني
                    }
                }
            });
        }

        // --- 5. وظيفة المشاركة الاجتماعية (Social sharing functionality) ---
        function shareArticle(url, title) {
            if (navigator.share) { // Web Share API (للمتصفحات التي تدعمها)
                navigator.share({
                    title: title,
                    url: url
                }).catch(error => console.error('خطأ في المشاركة:', error));
            } else {
                // بديل للمتصفحات التي لا تدعم Web Share API (مثال: تويتر)
                const shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
                window.open(shareUrl, '_blank', 'noopener,noreferrer'); // فتح في نافذة جديدة مع حماية
            }
        }

        const shareButtons = getElement('.fa-share-alt', true);
        if (shareButtons) {
            shareButtons.forEach(btn => {
                const parentLink = btn.parentElement; // يفترض أن الأيقونة داخل <a href="#">
                if (parentLink && parentLink.tagName === 'A') { // التأكد من أنه رابط
                    parentLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        const articleCard = this.closest('.blog-card'); // البحث عن أقرب عنصر 'blog-card'
                        if (articleCard) {
                            const titleElement = articleCard.querySelector('h3');
                            // إذا لم يكن هناك عنوان H3، يمكن استخدام عنوان الصفحة الافتراضي
                            const title = titleElement ? titleElement.textContent.trim() : document.title; 
                            const url = this.href && this.href !== '#' ? this.href : window.location.href; // استخدام رابط المقال إن وجد، وإلا رابط الصفحة الحالية
                            shareArticle(url, title);
                        } else {
                            // إذا لم يتم العثور على .blog-card، يمكن مشاركة الصفحة الحالية
                            shareArticle(window.location.href, document.title);
                        }
                    });
                }
            });
        }

        // --- 6. التمرير السلس للروابط الداخلية (Smooth scrolling for internal links) ---
        const internalLinks = getElement('a[href^="#"]', true);
        if (internalLinks) {
            internalLinks.forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetSelector = this.getAttribute('href');
                    const target = document.querySelector(targetSelector);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start' // التمرير ليكون الجزء العلوي من العنصر في بداية الرؤية
                        });
                    }
                });
            });
        }

        // --- 7. إضافة حالة التحميل للأزرار (Add loading state to buttons) ---
        const professionalButtons = getElement('.btn-professional', true);
        if (professionalButtons) {
            professionalButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const originalText = this.innerHTML; // حفظ النص الأصلي للزر
                    
                    // منع النقر المتكرر أثناء التحميل
                    if (this.disabled) {
                        return;
                    }

                    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>جاري التحميل...'; // إضافة أيقونة التحميل
                    this.disabled = true; // تعطيل الزر

                    // إعادة تمكين الزر واستعادة نصه بعد 2 ثانية (يمكنك تعديل المدة أو جعلها بعد اكتمال عملية حقيقية)
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }, 2000); 
                });
            });
        }
    </script>
@endsection