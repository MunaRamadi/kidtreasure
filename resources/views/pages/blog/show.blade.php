@extends('layouts.app')

@section('title', ($post->title_ar ?? $post->title_en) . ' - Kids Treasures')

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

    /* Article Content Styling */
    .article-content {
        line-height: 1.8;
        font-size: 1.1rem;
    }

    .article-content h1, .article-content h2, .article-content h3, .article-content h4, .article-content h5, .article-content h6 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 700;
        color: #1f2937;
    }

    .article-content h1 { font-size: 2.5rem; }
    .article-content h2 { font-size: 2rem; }
    .article-content h3 { font-size: 1.75rem; }
    .article-content h4 { font-size: 1.5rem; }

    .article-content p {
        margin-bottom: 1.5rem;
        color: #374151;
    }

    .article-content ul, .article-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }

    .article-content li {
        margin-bottom: 0.5rem;
        color: #374151;
    }

    .article-content blockquote {
        border-left: 4px solid #667eea;
        padding-left: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        background: rgba(102, 126, 234, 0.05);
        padding: 1.5rem;
        border-radius: 0.5rem;
    }

    /* Share buttons */
    .share-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        color: white;
        text-decoration: none;
        font-size: 1.25rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .share-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .share-btn.facebook { background: #1877f2; }
    .share-btn.twitter { background: #1da1f2; }
    .share-btn.linkedin { background: #0077b5; }
    .share-btn.whatsapp { background: #25d366; }

    /* Eco badge */
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
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .floating-element {
            width: 40px !important;
            height: 40px !important;
        }
        
        .article-content {
            font-size: 1rem;
        }

        .article-content h1 { font-size: 2rem; }
        .article-content h2 { font-size: 1.75rem; }
        .article-content h3 { font-size: 1.5rem; }
        .article-content h4 { font-size: 1.25rem; }
    }
</style>
@endsection

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
                    <a href="{{ route('blog') }}" class="hover:text-white transition-colors">المدونة البيئية</a>
                    <span class="mx-3">•</span>
                    <span class="text-white">{{ $post->title_ar ?? $post->title_en }}</span>
                </nav>
                
                <div class="eco-badge mb-6">
                    <i class="fas fa-leaf"></i>
                    مقال بيئي
                </div>
                
                <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight text-white drop-shadow-2xl">
                    {{ $post->title_ar ?? $post->title_en }}
                </h1>
                
                <div class="flex flex-wrap justify-center items-center gap-6 text-white/90">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user"></i>
                        <span>{{ $post->author_name }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $post->publication_date->format('Y/m/d') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-clock"></i>
                        <span>{{ ceil(str_word_count(strip_tags($post->content_ar ?? $post->content_en)) / 200) }} دقائق قراءة</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="py-16 bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="max-w-4xl mx-auto px-6">
        <!-- Featured Image -->
        @if($post->image_url)
        <div class="mb-12 fade-in-up">
            <div class="glass-card rounded-3xl overflow-hidden shadow-2xl">
                <img src="{{ asset('storage/' . $post->image_url) }}" 
                     alt="{{ $post->title_ar ?? $post->title_en }}" 
                     class="w-full h-96 object-cover">
            </div>
        </div>
        @endif

        <!-- Article Content -->
        <div class="glass-card rounded-3xl p-8 md:p-12 shadow-2xl fade-in-left">
            <article class="article-content">
                {!! nl2br(e($post->content_ar ?? $post->content_en)) !!}
            </article>
        </div>

        <!-- Social Sharing -->
        <div class="mt-12 fade-in-right">
            <div class="glass-card rounded-3xl p-8 shadow-2xl">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                    <i class="fas fa-share-alt mr-3 text-blue-600"></i>
                    شارك هذا المقال
                </h3>
                
                <div class="flex justify-center gap-4 flex-wrap">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                       target="_blank" 
                       class="share-btn facebook"
                       title="مشاركة على فيسبوك">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title_ar ?? $post->title_en) }}" 
                       target="_blank" 
                       class="share-btn twitter"
                       title="مشاركة على تويتر">
                        <i class="fab fa-twitter"></i>
                    </a>
                    
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" 
                       target="_blank" 
                       class="share-btn linkedin"
                       title="مشاركة على لينكد إن">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    
                    <a href="https://wa.me/?text={{ urlencode($post->title_ar ?? $post->title_en . ' ' . request()->url()) }}" 
                       target="_blank" 
                       class="share-btn whatsapp"
                       title="مشاركة على واتساب">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="mt-12 fade-in-up">
            <div class="glass-card rounded-3xl p-8 shadow-2xl">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <a href="{{ route('blog') }}" 
                       class="btn-professional inline-flex items-center gap-3 bg-gradient-to-r from-gray-600 via-gray-700 to-gray-800 text-white px-8 py-4 rounded-2xl font-bold hover:shadow-2xl">
                        <i class="fas fa-arrow-right"></i>
                        <span>العودة للمدونة</span>
                    </a>
                    
                    <div class="flex gap-4">
                        <a href="{{ route('contact.create') }}" 
                           class="btn-professional inline-flex items-center gap-3 bg-gradient-to-r from-green-400 via-emerald-500 to-teal-600 text-white px-8 py-4 rounded-2xl font-bold hover:shadow-2xl">
                            <i class="fas fa-comment"></i>
                            <span>اقترح موضوعاً</span>
                        </a>
                        
                        <a href="{{ route('products.index') }}" 
                           class="btn-professional inline-flex items-center gap-3 bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 text-white px-8 py-4 rounded-2xl font-bold hover:shadow-2xl">
                            <i class="fas fa-shopping-bag"></i>
                            <span>تسوق الآن</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Articles Section (Optional - you can implement this later) -->
<section class="py-16 bg-gradient-to-br from-purple-50 via-pink-50 to-red-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12 fade-in-up">
            <h2 class="text-4xl md:text-5xl font-black mb-6">
                <span class="text-gradient-advanced">مقالات ذات صلة</span>
            </h2>
            <div class="flex justify-center mb-6">
                <div class="w-32 h-2 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-full"></div>
            </div>
            <p class="text-xl text-gray-700 leading-relaxed font-light">اكتشف المزيد من المحتوى البيئي المفيد</p>
        </div>
        
        <div class="text-center">
            <div class="glass-card rounded-3xl p-12 max-w-2xl mx-auto">
                <div class="text-6xl text-gray-300 mb-6">
                    <i class="fas fa-seedling"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-4">المزيد من المقالات قريباً!</h3>
                <p class="text-gray-500 mb-6">نحن نعمل على إضافة المزيد من المقالات البيئية المفيدة</p>
                <a href="{{ route('blog') }}" 
                   class="btn-professional inline-flex items-center gap-3 bg-gradient-to-r from-blue-400 via-purple-500 to-pink-600 text-white px-8 py-4 rounded-2xl font-bold hover:shadow-2xl">
                    <i class="fas fa-arrow-right"></i>
                    <span>تصفح جميع المقالات</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Back to Top Button -->
<button id="backToTop" title="العودة للأعلى">
    <i class="fas fa-arrow-up"></i>
</button>

<script>
    // Back to top button functionality
    const backToTopBtn = document.getElementById('backToTop');
    
    if (backToTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.style.opacity = '1';
                backToTopBtn.style.visibility = 'visible';
            } else {
                backToTopBtn.style.opacity = '0';
                backToTopBtn.style.visibility = 'hidden';
            }
        });

        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Social sharing analytics (optional)
    document.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const platform = this.classList.contains('facebook') ? 'Facebook' :
                           this.classList.contains('twitter') ? 'Twitter' :
                           this.classList.contains('linkedin') ? 'LinkedIn' :
                           this.classList.contains('whatsapp') ? 'WhatsApp' : 'Unknown';
            
            console.log(`Shared on ${platform}: {{ $post->title_ar ?? $post->title_en }}`);
        });
    });

    // Loading states for buttons
    document.querySelectorAll('.btn-professional').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.href && !this.href.includes('#')) {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>جاري التحميل...';
                this.disabled = true;
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 1000);
            }
        });
    });
</script>
@endsection