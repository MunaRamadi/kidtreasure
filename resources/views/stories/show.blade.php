@extends('layouts.app')

@section('title', ($story->title_ar ?? $story->title_en ?? 'Story of ' . $story->child_name) . ' - Kids Treasures')

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

    /* Story Content Styling */
    .story-content {
        line-height: 1.8;
        font-size: 1.1rem;
    }

    .story-content h1, .story-content h2, .story-content h3, .story-content h4, .story-content h5, .story-content h6 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 700;
        color: #1f2937;
    }

    .story-content h1 { font-size: 2.5rem; }
    .story-content h2 { font-size: 2rem; }
    .story-content h3 { font-size: 1.75rem; }
    .story-content h4 { font-size: 1.5rem; }

    .story-content p {
        margin-bottom: 1.5rem;
        color: #374151;
    }

    .story-content ul, .story-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }

    .story-content li {
        margin-bottom: 0.5rem;
        color: #374151;
    }

    .story-content blockquote {
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

    /* Story badge */
    .story-badge {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3);
    }

    /* Image Hover Effects */
    .image-hover-effect {
        transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        filter: brightness(0.9);
    }

    .image-hover-effect:hover {
        filter: brightness(1.1) contrast(1.1);
        transform: scale(1.02) rotateZ(1deg);
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
        
        .story-content {
            font-size: 1rem;
        }

        .story-content h1 { font-size: 2rem; }
        .story-content h2 { font-size: 1.75rem; }
        .story-content h3 { font-size: 1.5rem; }
        .story-content h4 { font-size: 1.25rem; }
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
                    <a href="{{ route('stories.index') }}" class="hover:text-white transition-colors">القصص</a>
                    <span class="mx-3">•</span>
                    <span class="text-white">{{ $story->title_ar ?? $story->title_en ?? 'قصة ' . $story->child_name }}</span>
                </nav>
                
                <div class="story-badge mb-6">
                    <i class="fas fa-book-open"></i>
                    قصة طفل
                </div>
                
                <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight text-white drop-shadow-2xl">
                    {{ $story->title_ar ?? $story->title_en ?? 'قصة ' . $story->child_name }}
                </h1>
                
                <div class="flex flex-wrap justify-center items-center gap-6 text-white/90">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-child"></i>
                        <span>{{ $story->child_name ?? 'طفل مجهول' }}</span>
                    </div>
                    @if($story->child_age)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-birthday-cake"></i>
                        <span>{{ $story->child_age }} سنة</span>
                    </div>
                    @endif
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $story->created_at->format('Y/m/d') }}</span>
                    </div>
                    @if($story->category)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-tag"></i>
                        <span>{{ $story->category }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Story Content -->
<section class="py-16 bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="max-w-4xl mx-auto px-6">
        <!-- Featured Media -->
        <div class="mb-12 fade-in-up">
            <div class="glass-card rounded-3xl overflow-hidden shadow-2xl">
                @if($story->video_full_url)
                    <video class="w-full h-96 object-cover image-hover-effect" controls poster="{{ $story->image_full_url }}">
                        <source src="{{ $story->video_full_url }}" type="video/mp4">
                        متصفحك لا يدعم تشغيل الفيديو.
                    </video>
                @elseif($story->image_full_url)
                    <img src="{{ $story->image_full_url }}" 
                         alt="{{ $story->title_ar ?? $story->title_en ?? 'قصة ' . $story->child_name }}" 
                         class="w-full h-96 object-cover image-hover-effect">
                @else
                    <div class="w-full h-96 bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                        <div class="text-center text-white">
                            <i class="fas fa-book-open text-6xl mb-4 drop-shadow-lg"></i>
                            <p class="text-2xl font-bold drop-shadow-lg">قصة مكتوبة</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Child Info Card -->
        <div class="mb-12 fade-in-left">
            <div class="glass-card rounded-3xl p-8 shadow-2xl">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                    <i class="fas fa-child mr-3 text-pink-600"></i>
                    معلومات الطفل
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">اسم الطفل</p>
                            <p class="text-lg font-bold text-gray-800">{{ $story->child_name ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                    
                    @if($story->child_age)
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-blue-400 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-birthday-cake text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">العمر</p>
                            <p class="text-lg font-bold text-gray-800">{{ $story->child_age }} سنة</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Story Content -->
        <div class="glass-card rounded-3xl p-8 md:p-12 shadow-2xl fade-in-right">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-black text-gray-800 mb-4">
                    <span class="text-gradient-advanced">القصة</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-full mx-auto"></div>
            </div>

            <div class="story-content">
                @if($story->content_ar)
                    <div class="mb-8" dir="rtl">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center justify-end">
                            <span>النسخة العربية</span>
                            <i class="fas fa-book mr-3 text-blue-600"></i>
                        </h3>
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($story->content_ar)) !!}
                        </div>
                    </div>
                @endif

                @if($story->content_en)
                    <div class="mb-8" dir="ltr">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-book mr-3 text-blue-600"></i>
                            English Version
                        </h3>
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($story->content_en)) !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Lesson Learned Section -->
        @if($story->lesson_learned_ar || $story->lesson_learned_en)
        <div class="mt-12 fade-in-up">
            <div class="glass-card rounded-3xl p-8 md:p-12 bg-gradient-to-br from-yellow-50 to-orange-50 border border-yellow-200/50 shadow-2xl">
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-black text-gray-800 mb-4">
                        <span class="text-gradient-advanced">الدرس المستفاد</span>
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-yellow-500 via-orange-600 to-red-500 rounded-full mx-auto"></div>
                </div>

                <div class="story-content">
                    @if($story->lesson_learned_ar)
                        <div class="mb-8" dir="rtl">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center justify-end">
                                <span>النسخة العربية</span>
                                <i class="fas fa-lightbulb mr-3 text-yellow-600"></i>
                            </h3>
                            <div class="text-gray-700 leading-relaxed">
                                {!! nl2br(e($story->lesson_learned_ar)) !!}
                            </div>
                        </div>
                    @endif

                    @if($story->lesson_learned_en)
                        <div class="mb-8" dir="ltr">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-lightbulb mr-3 text-yellow-600"></i>
                                English Version
                            </h3>
                            <div class="text-gray-700 leading-relaxed">
                                {!! nl2br(e($story->lesson_learned_en)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Social Sharing -->
        <div class="mt-12 fade-in-left">
            <div class="glass-card rounded-3xl p-8 shadow-2xl">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                    <i class="fas fa-share-alt mr-3 text-blue-600"></i>
                    شارك هذه القصة
                </h3>
                
                <div class="flex justify-center gap-4 flex-wrap">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                       target="_blank" 
                       class="share-btn facebook"
                       title="مشاركة على فيسبوك">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($story->title_ar ?? $story->title_en ?? 'قصة ' . $story->child_name) }}" 
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
                    
                    <a href="https://wa.me/?text={{ urlencode(($story->title_ar ?? $story->title_en ?? 'قصة ' . $story->child_name) . ' ' . request()->url()) }}" 
                       target="_blank" 
                       class="share-btn whatsapp"
                       title="مشاركة على واتساب">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="mt-12 fade-in-right">
            <div class="glass-card rounded-3xl p-8 shadow-2xl">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <a href="{{ route('stories.index') }}" 
                       class="btn-professional inline-flex items-center gap-3 bg-gradient-to-r from-gray-600 via-gray-700 to-gray-800 text-white px-8 py-4 rounded-2xl font-bold hover:shadow-2xl">
                        <i class="fas fa-arrow-right"></i>
                        <span>العودة للقصص</span>
                    </a>
                    
                    <div class="flex gap-4">
                        <a href="{{ route('contact.create') }}" 
                           class="btn-professional inline-flex items-center gap-3 bg-gradient-to-r from-green-400 via-emerald-500 to-teal-600 text-white px-8 py-4 rounded-2xl font-bold hover:shadow-2xl">
                            <i class="fas fa-comment"></i>
                            <span>تواصل معنا</span>
                        </a>
                        
                        <a href="{{ route('stories.create') }}" 
                           class="btn-professional inline-flex items-center gap-3 bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 text-white px-8 py-4 rounded-2xl font-bold hover:shadow-2xl">
                            <i class="fas fa-plus"></i>
                            <span>شارك قصتك</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Stories Section -->
<section class="py-16 bg-gradient-to-br from-purple-50 via-pink-50 to-red-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12 fade-in-up">
            <h2 class="text-4xl md:text-5xl font-black mb-6">
                <span class="text-gradient-advanced">قصص ذات صلة</span>
            </h2>
            <div class="flex justify-center mb-6">
                <div class="w-32 h-2 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-full"></div>
            </div>
            <p class="text-xl text-gray-700 leading-relaxed font-light">اكتشف المزيد من القصص الملهمة</p>
        </div>
        
        <div class="text-center">
            <div class="glass-card rounded-3xl p-12 max-w-2xl mx-auto">
                <div class="text-6xl text-gray-300 mb-6">
                    <i class="fas fa-book-heart"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-4">المزيد من القصص قريباً!</h3>
                <p class="text-gray-500 mb-6">نحن نعمل على جمع المزيد من القصص الملهمة والمفيدة</p>
                <a href="{{ route('stories.index') }}" 
                   class="btn-professional inline-flex items-center gap-3 bg-gradient-to-r from-blue-400 via-purple-500 to-pink-600 text-white px-8 py-4 rounded-2xl font-bold hover:shadow-2xl">
                    <i class="fas fa-arrow-right"></i>
                    <span>تصفح جميع القصص</span>
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

    // Social sharing analytics
    document.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const platform = this.classList.contains('facebook') ? 'Facebook' :
                           this.classList.contains('twitter') ? 'Twitter' :
                           this.classList.contains('linkedin') ? 'LinkedIn' :
                           this.classList.contains('whatsapp') ? 'WhatsApp' : 'Unknown';
            
            // You can add analytics tracking here
            console.log(`Story shared on ${platform}`);
            
            // Optional: Send analytics to your backend
            // fetch('/api/analytics/share', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //     },
            //     body: JSON.stringify({
            //         story_id: {{ $story->id }},
            //         platform: platform,
            //         url: window.location.href
            //     })
            // });
        });
    });

    // Enhanced scroll animations
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

    // Observe elements for animation
    document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        observer.observe(el);
    });

    // Enhanced floating elements interaction
    document.querySelectorAll('.floating-element').forEach((element, index) => {
        element.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.2) rotate(180deg)';
            this.style.opacity = '1';
        });
        
        element.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.opacity = '';
        });
    });

    // Reading progress indicator
    function createReadingProgress() {
        const progressBar = document.createElement('div');
        progressBar.id = 'reading-progress';
        progressBar.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
            z-index: 9999;
            transition: width 0.3s ease;
        `;
        document.body.appendChild(progressBar);

        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset;
            const docHeight = document.body.scrollHeight - window.innerHeight;
            const scrollPercent = (scrollTop / docHeight) * 100;
            progressBar.style.width = scrollPercent + '%';
        });
    }

    // Initialize reading progress
    createReadingProgress();

    // Story content enhancement
    document.addEventListener('DOMContentLoaded', function() {
        // Add reading time estimation
        const storyContent = document.querySelector('.story-content');
        if (storyContent) {
            const wordCount = storyContent.innerText.split(' ').length;
            const readingTime = Math.ceil(wordCount / 200); // Average reading speed
            
            const readingTimeElement = document.createElement('div');
            readingTimeElement.className = 'text-center mb-6 text-gray-500';
            readingTimeElement.innerHTML = `
                <i class="fas fa-clock mr-2"></i>
                <span>وقت القراءة المتوقع: ${readingTime} دقيقة</span>
            `;
            
            storyContent.parentNode.insertBefore(readingTimeElement, storyContent);
        }

        // Enhanced image loading with lazy loading simulation
        const images = document.querySelectorAll('img[src]');
        images.forEach(img => {
            img.addEventListener('load', function() {
                this.style.opacity = '0';
                this.style.transition = 'opacity 0.5s ease';
                setTimeout(() => {
                    this.style.opacity = '1';
                }, 100);
            });
        });

        // Add copy to clipboard functionality for story content
        const copyButton = document.createElement('button');
        copyButton.innerHTML = '<i class="fas fa-copy mr-2"></i>نسخ القصة';
        copyButton.className = 'btn-professional bg-gradient-to-r from-indigo-400 to-purple-600 text-white px-6 py-3 rounded-xl font-bold hover:shadow-lg transition-all duration-300 mb-4';
        
        copyButton.addEventListener('click', function() {
            const storyText = document.querySelector('.story-content').innerText;
            navigator.clipboard.writeText(storyText).then(function() {
                copyButton.innerHTML = '<i class="fas fa-check mr-2"></i>تم النسخ!';
                copyButton.style.background = 'linear-gradient(to right, #10b981, #34d399)';
                
                setTimeout(() => {
                    copyButton.innerHTML = '<i class="fas fa-copy mr-2"></i>نسخ القصة';
                    copyButton.style.background = '';
                }, 2000);
            });
        });

        const storyContentDiv = document.querySelector('.story-content').parentNode;
        storyContentDiv.insertBefore(copyButton, document.querySelector('.story-content'));
    });

    // Print functionality
    function printStory() {
        const printWindow = window.open('', '_blank');
        const storyTitle = '{{ $story->title_ar ?? $story->title_en ?? "قصة " . $story->child_name }}';
        const storyContent = document.querySelector('.story-content').innerHTML;
        const childName = '{{ $story->child_name ?? "غير محدد" }}';
        const childAge = '{{ $story->child_age ?? "" }}';
        
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>${storyTitle}</title>
                <style>
                    body { font-family: 'Tajawal', Arial, sans-serif; direction: rtl; }
                    .header { text-align: center; margin-bottom: 30px; }
                    .story-content { line-height: 1.8; font-size: 16px; }
                    .child-info { background: #f3f4f6; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
                    @media print { body { margin: 0; } }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>${storyTitle}</h1>
                    <div class="child-info">
                        <p><strong>اسم الطفل:</strong> ${childName}</p>
                        ${childAge ? `<p><strong>العمر:</strong> ${childAge} سنة</p>` : ''}
                    </div>
                </div>
                <div class="story-content">${storyContent}</div>
            </body>
            </html>
        `);
        
        printWindow.document.close();
        printWindow.print();
    }

    // Add print button
    const printButton = document.createElement('button');
    printButton.innerHTML = '<i class="fas fa-print mr-2"></i>طباعة القصة';
    printButton.className = 'btn-professional bg-gradient-to-r from-gray-500 to-gray-700 text-white px-6 py-3 rounded-xl font-bold hover:shadow-lg transition-all duration-300 mb-4 ml-4';
    printButton.addEventListener('click', printStory);

    // Add print button next to copy button
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            const copyBtn = document.querySelector('.story-content').parentNode.querySelector('button');
            if (copyBtn) {
                copyBtn.parentNode.insertBefore(printButton, copyBtn.nextSibling);
            }
        }, 100);
    });

    // Enhanced keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            // Close any open modals or overlays
            document.querySelectorAll('.modal, .overlay').forEach(el => {
                el.style.display = 'none';
            });
        }
        
        if (e.key === 'Home') {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        if (e.key === 'End') {
            window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
        }
    });

    // Story view tracking (optional)
    // You can implement this to track story views
    /*
    fetch('/api/stories/{{ $story->id }}/view', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            timestamp: new Date().toISOString(),
            user_agent: navigator.userAgent
        })
    }).catch(error => console.log('View tracking failed:', error));
    */
</script>
@endsection