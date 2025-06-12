@extends('layouts.app')

@section('title', 'Stories of
Creativity ')

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
        transform: rotateY(5deg) rotateX(5deg) translateZ(20px);
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

    /* Image Hover Effects */
    .image-hover-effect {
        transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        filter: brightness(0.9);
    }

    .image-hover-effect:hover {
        filter: brightness(1.1) contrast(1.1);
        transform: scale(1.05) rotateZ(2deg);
    }

    /* RTL specific styles */
    [dir="rtl"] .fas {
        margin-left: 0.5rem;
        margin-right: 0;
    }

    [dir="rtl"] .mr-2 {
        margin-right: 0;
        margin-left: 0.5rem;
    }

    [dir="rtl"] .ml-2 {
        margin-left: 0;
        margin-right: 0.5rem;
    }

    /* Line clamp utilities */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
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

    /* Responsive Design for Mobile */
    @media (max-width: 768px) {
        .floating-element {
            width: 40px !important;
            height: 40px !important;
        }
        
        .card-hover-effect:hover {
            transform: translateY(-5px);
        }
    }
</style>

<!-- Hero Section -->
<section class="animated-bg min-h-screen flex items-center relative overflow-hidden" dir="ltr">
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
                    <span class="block text-white drop-shadow-2xl">Stories of</span>
                    <span class="block text-gradient-advanced text-6xl md:text-8xl">Creativity</span>
                    <span class="block text-white text-3xl md:text-4xl font-bold mt-6 drop-shadow-lg">Our Children's Unique Experiences</span>
                </h1>
            </div>

            <div class="fade-in-left">
                <p class="text-xl md:text-2xl mb-12 leading-relaxed text-white/95 font-light max-w-4xl mx-auto">
                    Discover a world of creativity and sustainability through our children's inspiring stories and their wonderful experiences with educational boxes.
                </p>
            </div>

            <div class="fade-in-right">
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="{{ route('stories.create') }}" class="btn-professional bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 hover:from-yellow-500 hover:via-orange-600 hover:to-red-600 text-white font-bold py-4 px-10 rounded-3xl text-lg shadow-2xl inline-flex items-center justify-center pulse-advanced">
                        <i class="fas fa-plus mr-3 text-xl"></i>
                        <span>Share Your Story</span>
                    </a>
                    <a href="#stories-section" class="btn-professional glass-card text-white font-bold py-4 px-10 rounded-3xl text-lg border border-white/30 inline-flex items-center justify-center">
                        <i class="fas fa-book-open mr-3 text-xl"></i>
                        <span>Explore Stories</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="stories-section" class="py-24 section-bg-pattern bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50" dir="ltr">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16 fade-in-up">
            <h2 class="text-5xl md:text-7xl font-black text-gray-800 mb-8">
                <span class="text-gradient-advanced">Featured Stories</span>
            </h2>
            <div class="flex justify-center mb-8">
                <div class="w-32 h-2 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-full"></div>
            </div>
            <p class="text-2xl text-gray-700 leading-relaxed max-w-4xl mx-auto font-light">
                Inspiring stories from our children about their journey of creativity, sustainability, and interactive learning.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            <div class="glass-card card-hover-effect rounded-3xl overflow-hidden shadow-2xl fade-in-left">
                <div class="relative aspect-video overflow-hidden">
                    <div class="absolute -inset-4 bg-gradient-to-r from-blue-400 via-cyan-500 to-blue-600 rounded-3xl blur-xl opacity-50 animate-pulse"></div>
                    <div class="relative">
                        <img src="https://cdn.salla.sa/rOYrr/b6ac49ba-d251-4a3a-8a2c-df0dea1e12d9-500x500-BF3o5mYQRLmKyT8bNMUmVaPFGp8hM1o7eVGNNdqp.jpg"
                             alt="Colorful plastic toy car"
                             class="w-full h-full object-cover image-hover-effect">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent rounded-t-3xl"></div>
                        <div class="absolute bottom-3 right-3 bg-white/90 rounded-full p-3 shadow-lg">
                            <i class="fas fa-car text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">The Plastic Toy Car</h3>
                    <p class="text-gray-600 line-clamp-3 leading-relaxed">
                        The toy car was missing its wheels, lying amidst piles of plastic in a home garden. Other plastic pieces from broken toys were collected and skillfully reassembled.
                    </p>
                    <div class="mt-4 flex items-center text-blue-600 bg-blue-50 rounded-lg p-2">
                        <i class="fas fa-recycle mr-2"></i>
                        <span class="text-sm font-semibold">Reuse and Innovation</span>
                    </div>
                </div>
            </div>

            <div class="glass-card card-hover-effect rounded-3xl overflow-hidden shadow-2xl fade-in-up" style="animation-delay: 0.2s;">
                <div class="relative aspect-video overflow-hidden">
                    <div class="absolute -inset-4 bg-gradient-to-r from-pink-400 via-rose-500 to-pink-600 rounded-3xl blur-xl opacity-50 animate-pulse"></div>
                    <div class="relative">
                        <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcS6gYWUx0QrRbg2OkZcuORBJjd8lvJgp5ZcEzNvnl0caHTno4l560BNGvodtMN4"
                             alt="Colorful handmade fabric dolls"
                             class="w-full h-full object-cover image-hover-effect">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent rounded-t-3xl"></div>
                        <div class="absolute bottom-3 right-3 bg-white/90 rounded-full p-3 shadow-lg">
                            <i class="fas fa-heart text-pink-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">The Fabric Dolls</h3>
                    <p class="text-gray-600 line-clamp-3 leading-relaxed">
                        An old fabric girl doll had lost her hair and her colors had faded. With creativity and love, hair was made from leftover threads and colorful dresses were added.
                    </p>
                    <div class="mt-4 flex items-center text-pink-600 bg-pink-50 rounded-lg p-2">
                        <i class="fas fa-magic mr-2"></i>
                        <span class="text-sm font-semibold">True Beauty in Change</span>
                    </div>
                </div>
            </div>

            <div class="glass-card card-hover-effect rounded-3xl overflow-hidden shadow-2xl fade-in-up" style="animation-delay: 0.4s;">
                <div class="relative aspect-video overflow-hidden">
                    <div class="absolute -inset-4 bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 rounded-3xl blur-xl opacity-50 animate-pulse"></div>
                    <div class="relative">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmvd505OBjtVLldKNQKX0Vw8fq1-XZdVpvJg&s"
                             alt="Colorful puzzle pieces on a wooden table"
                             class="w-full h-full object-cover image-hover-effect">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent rounded-t-3xl"></div>
                        <div class="absolute bottom-3 right-3 bg-white/90 rounded-full p-3 shadow-lg">
                            <i class="fas fa-puzzle-piece text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">The Puzzle Game</h3>
                    <p class="text-gray-600 line-clamp-3 leading-relaxed">
                        Puzzle pieces were scattered and incomplete, unable to form any picture. Similar pieces from different games were collected and repainted to create a new tableau.
                    </p>
                    <div class="mt-4 flex items-center text-green-600 bg-green-50 rounded-lg p-2">
                        <i class="fas fa-brain mr-2"></i>
                        <span class="text-sm font-semibold">The World Can Be Rebuilt</span>
                    </div>
                </div>
            </div>

            <div class="glass-card card-hover-effect rounded-3xl overflow-hidden shadow-2xl fade-in-right" style="animation-delay: 0.6s;">
                <div class="relative aspect-video overflow-hidden">
                    <div class="absolute -inset-4 bg-gradient-to-r from-orange-400 via-amber-500 to-orange-600 rounded-3xl blur-xl opacity-50 animate-pulse"></div>
                    <div class="relative">
                        <img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcRRCq8vY6V5gKz9vLCaL8j-5dCq5a0twFGY1XAlXbmMEjkjHZFJg3yq6eKPv5xU"
                             alt="Colorful paper models and children's artwork"
                             class="w-full h-full object-cover image-hover-effect">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent rounded-t-3xl"></div>
                        <div class="absolute bottom-3 right-3 bg-white/90 rounded-full p-3 shadow-lg">
                            <i class="fas fa-castle text-orange-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">The Paper Models Game</h3>
                    <p class="text-gray-600 line-clamp-3 leading-relaxed">
                        Paper models were torn and neglected in old boxes. New, colorful papers were collected and reshaped to build a beautiful castle.
                    </p>
                    <div class="mt-4 flex items-center text-orange-600 bg-orange-50 rounded-lg p-2">
                        <i class="fas fa-book mr-2"></i>
                        <span class="text-sm font-semibold">Children's Creativity Hub</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($stories->count() > 0)
<section class="py-24 animated-bg text-white relative overflow-hidden" dir="ltr">
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16 fade-in-up">
            <h2 class="text-5xl md:text-7xl font-black mb-8">Stories Shared by Our Children</h2>
            <p class="text-xl md:text-2xl text-white/95 mb-8 leading-relaxed max-w-4xl mx-auto">
                Real experiences and amazing creations from the world of childhood and sustainability.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($stories as $index => $story)
                <div class="glass-card card-hover-effect rounded-3xl overflow-hidden border border-white/20 fade-in-up" style="animation-delay: {{ $index * 0.1 }}s;">
                    @if($story->image_url || $story->video_url)
                        <div class="relative aspect-video overflow-hidden">
                            <div class="absolute -inset-4 bg-gradient-to-r from-purple-400 via-pink-500 to-purple-600 rounded-3xl blur-xl opacity-50 animate-pulse"></div>
                            <div class="relative">
                                @if($story->video_url)
                                    <video class="w-full h-full object-cover image-hover-effect" controls poster="{{ $story->image_url }}">
                                        <source src="{{ $story->video_url }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-2 rounded-full text-sm font-semibold shadow-lg">
                                        <i class="fas fa-video mr-1"></i>
                                        Video
                                    </div>
                                @elseif($story->image_url)
                                    <img src="{{ $story->image_url }}"
                                         alt="{{ $story->title_ar ?? $story->title_en }}"
                                         class="w-full h-full object-cover image-hover-effect">
                                    <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-2 rounded-full text-sm font-semibold shadow-lg">
                                        <i class="fas fa-image mr-1"></i>
                                        Image
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent rounded-t-3xl"></div>
                            </div>
                        </div>
                    @else
                        <div class="aspect-video bg-gradient-to-br from-yellow-400 via-orange-500 to-red-500 flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent"></div>
                            <div class="text-center z-10">
                                <i class="fas fa-book-open text-5xl text-white mb-3 drop-shadow-lg"></i>
                                <p class="text-white font-semibold text-lg drop-shadow-lg">Written Story</p>
                            </div>
                        </div>
                    @endif

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-4 line-clamp-2">
                            {{ $story->title_en ?? $story->title_ar ?? 'Story of ' . $story->child_name }}
                        </h3>

                        <div class="flex items-center mb-4 glass-card rounded-lg p-3 border border-white/20">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full flex items-center justify-center mr-3 shadow-lg">
                                <i class="fas fa-child text-white text-lg"></i>
                            </div>
                            <div>
                                <p class="text-white font-semibold">{{ $story->child_name ?? 'Unnamed Child' }}</p>
                                <p class="text-white/80 text-sm">{{ $story->child_age ? $story->child_age . ' years old' : 'Age not specified' }}</p>
                            </div>
                        </div>

                        <p class="text-white/90 line-clamp-3 leading-relaxed mb-4">
                            {{ $story->content_en ?? $story->content_ar ?? 'Story content not available.' }}
                        </p>

                        @if($story->lesson_learned_en || $story->lesson_learned_ar)
                            <div class="bg-white/10 backdrop-filter backdrop-blur-sm rounded-lg p-3 mb-4 border border-white/20">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-lightbulb text-yellow-300 mr-2"></i>
                                    <span class="text-white font-semibold text-sm">Lesson Learned</span>
                                </div>
                                <p class="text-white/90 text-sm leading-relaxed">
                                    {{ $story->lesson_learned_en ?? $story->lesson_learned_ar }}
                                </p>
                            </div>
                        @endif

                        <div class="flex items-center justify-between text-sm text-white/80">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>{{ $story->created_at->format('d M Y') }}</span>
                            </div>
                            @if($story->category)
                                <div class="bg-white/20 px-3 py-1 rounded-full">
                                    <span class="text-xs font-semibold">{{ $story->category }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-16 fade-in-up">
            <a href="{{ route('stories.index') }}" class="btn-professional glass-card text-white font-bold py-4 px-12 rounded-3xl text-lg border border-white/30 inline-flex items-center justify-center hover:bg-white/20">
                <i class="fas fa-books mr-3 text-xl"></i>
                <span>View All Stories</span>
            </a>
        </div>
    </div>
</section>
@endif

<section class="py-24 bg-gradient-to-br from-gray-50 via-white to-gray-100" dir="ltr">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16 fade-in-up">
            <h2 class="text-4xl md:text-6xl font-black text-gray-800 mb-8">
                <span class="text-gradient-advanced">Creativity Statistics</span>
            </h2>
            <p class="text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                Numbers reflecting the journey of creativity and sustainability in our community.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="glass-card card-hover-effect rounded-3xl p-8 text-center bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-200/50">
                <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full mx-auto mb-6 flex items-center justify-center shadow-xl">
                    <i class="fas fa-book-open text-white text-2xl"></i>
                </div>
                <h3 class="text-4xl font-black text-gray-800 mb-2">{{ $stories->count() }}</h3>
                <p class="text-gray-600 font-semibold">Stories Shared</p>
            </div>

            <div class="glass-card card-hover-effect rounded-3xl p-8 text-center bg-gradient-to-br from-purple-50 to-pink-50 border border-purple-200/50">
                <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full mx-auto mb-6 flex items-center justify-center shadow-xl">
                    <i class="fas fa-palette text-white text-2xl"></i>
                </div>
                <h3 class="text-4xl font-black text-gray-800 mb-2">150+</h3>
                <p class="text-gray-600 font-semibold">Creative Projects</p>
            </div>

            <div class="glass-card card-hover-effect rounded-3xl p-8 text-center bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200/50">
                <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full mx-auto mb-6 flex items-center justify-center shadow-xl">
                    <i class="fas fa-recycle text-white text-2xl"></i>
                </div>
                <h3 class="text-4xl font-black text-gray-800 mb-2">500+</h3>
                <p class="text-gray-600 font-semibold">Recycled Items</p>
            </div>

            <div class="glass-card card-hover-effect rounded-3xl p-8 text-center bg-gradient-to-br from-orange-50 to-yellow-50 border border-orange-200/50">
                <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-full mx-auto mb-6 flex items-center justify-center shadow-xl">
                    <i class="fas fa-child text-white text-2xl"></i>
                </div>
                <h3 class="text-4xl font-black text-gray-800 mb-2">300+</h3>
                <p class="text-gray-600 font-semibold">Happy Children</p>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling for anchor links
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

    // Add intersection observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right').forEach(el => {
        observer.observe(el);
    });

    // Add dynamic star creation
    function createStar() {
        const star = document.createElement('div');
        star.className = 'star';
        star.style.top = Math.random() * 100 + '%';
        star.style.left = Math.random() * 100 + '%';
        star.style.animationDelay = Math.random() * 4 + 's';
        
        document.querySelectorAll('.stars').forEach(container => {
            if (container.children.length < 20) {
                container.appendChild(star.cloneNode());
            }
        });
    }

    // Create additional stars periodically
    setInterval(createStar, 3000);

    // Add parallax effect to floating elements
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.floating-element');
        
        parallaxElements.forEach((element, index) => {
            const speed = 0.1 + (index * 0.05);
            element.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });

    // Add loading animation for images
    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
        });
    });
});
</script>

@endsection