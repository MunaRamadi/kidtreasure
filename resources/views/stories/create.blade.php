@extends('layouts.app')

@section('title', 'شارك قصتك')

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
        transform: translateY(-3px) rotateX(5deg);
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
        transform: rotateY(5deg) rotateX(5deg) translateZ(10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
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

    /* Form Specific Styles */
    .form-container {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .form-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .form-section:hover {
        background: rgba(255, 255, 255, 0.98);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .form-input {
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid rgba(102, 126, 234, 0.2);
        transition: all 0.3s ease;
    }

    .form-input:focus {
        background: rgba(255, 255, 255, 1);
        border-color: #667eea;
        box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
        transform: scale(1.02);
    }

    .section-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        transition: all 0.3s ease;
    }

    .section-icon:hover {
        transform: rotate(360deg) scale(1.1);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
    }

    /* File Upload Styles */
    .file-upload-area {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border: 2px dashed rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
    }

    .file-upload-area:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
        border-color: #667eea;
        transform: scale(1.02);
    }

    /* Inspiration Cards */
    .inspiration-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .inspiration-card:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    /* RTL Support */
    [dir="rtl"] .mr-3 {
        margin-right: 0;
        margin-left: 0.75rem;
    }

    [dir="rtl"] .ml-2 {
        margin-left: 0;
        margin-right: 0.5rem;
    }

    [dir="rtl"] .ml-4 {
        margin-left: 0;
        margin-right: 1rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .floating-element {
            width: 40px !important;
            height: 40px !important;
        }
        
        .card-hover-effect:hover {
            transform: translateY(-2px);
        }
        
        .text-5xl {
            font-size: 2.5rem;
        }
        
        .text-7xl {
            font-size: 3rem;
        }
    }

    /* Animated Stars */
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
        <div class="text-center mb-12">
            <div class="fade-in-up">
                <a href="{{ route('stories.index') }}" 
                   class="inline-flex items-center text-white/80 hover:text-white transition-colors duration-300 mb-8 btn-professional glass-card px-6 py-3 rounded-2xl">
                    <i class="fas fa-arrow-left mr-3 text-xl"></i>
                    <span class="text-lg">Back to Stories</span>
                </a>
                
                <h1 class="text-5xl md:text-7xl font-black mb-8 leading-tight">
                    <span class="block text-white drop-shadow-2xl">Share</span>
                    <span class="block text-gradient-advanced text-6xl md:text-8xl">Your Story</span>
                    <span class="block text-white text-3xl md:text-4xl font-bold mt-6 drop-shadow-lg">with the World</span>
                </h1>
                
                <p class="text-xl md:text-2xl mb-12 leading-relaxed text-white/95 font-light max-w-4xl mx-auto">
                    Tell us about your child's amazing experience with boxes and how they transformed broken things into beautiful creations.
                </p>
            </div>
        </div>
        
        <div class="fade-in-up mb-12">
            <div class="glass-card rounded-3xl p-8 max-w-5xl mx-auto">
                <h2 class="text-3xl font-bold text-white mb-8 text-center">
                    <i class="fas fa-lightbulb text-yellow-400 mr-3 text-4xl"></i>
                    Get Inspired by These Amazing Stories
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="inspiration-card rounded-2xl p-6 text-center card-hover-effect">
                        <i class="fas fa-car text-blue-500 text-3xl mb-4"></i>
                        <p class="text-sm font-bold text-gray-800">Car from Broken Pieces</p>
                    </div>
                    <div class="inspiration-card rounded-2xl p-6 text-center card-hover-effect">
                        <i class="fas fa-heart text-pink-500 text-3xl mb-4"></i>
                        <p class="text-sm font-bold text-gray-800">Doll with a New Heart</p>
                    </div>
                    <div class="inspiration-card rounded-2xl p-6 text-center card-hover-effect">
                        <i class="fas fa-puzzle-piece text-green-500 text-3xl mb-4"></i>
                        <p class="text-sm font-bold text-gray-800">Puzzle Piece Painting</p>
                    </div>
                    <div class="inspiration-card rounded-2xl p-6 text-center card-hover-effect">
                        <i class="fas fa-castle text-orange-500 text-3xl mb-4"></i>
                        <p class="text-sm font-bold text-gray-800">Recycled Paper Castle</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50 relative" dir="ltr">
    <div class="max-w-6xl mx-auto px-6">
        <form action="{{ route('stories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
            @csrf

            <div class="form-section rounded-3xl shadow-2xl p-10 card-hover-effect fade-in-left">
                <div class="flex items-center mb-8">
                    <div class="section-icon w-16 h-16 rounded-3xl flex items-center justify-center mr-6 pulse-advanced">
                        <i class="fas fa-child text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-black text-gray-800">Child Information</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="child_name" class="block text-lg font-bold text-gray-700 mb-4">
                            Child's Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="child_name"
                               name="child_name"
                               value="{{ old('child_name') }}"
                               class="form-input w-full px-6 py-4 rounded-2xl text-lg @error('child_name') border-red-500 @enderror"
                               placeholder="Enter child's name"
                               required>
                        @error('child_name')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="child_age" class="block text-lg font-bold text-gray-700 mb-4">
                            Child's Age (in years)
                        </label>
                        <input type="number"
                               id="child_age"
                               name="child_age"
                               value="{{ old('child_age') }}"
                               min="1"
                               max="18"
                               class="form-input w-full px-6 py-4 rounded-2xl text-lg @error('child_age') border-red-500 @enderror"
                               placeholder="Example: 8">
                        @error('child_age')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section rounded-3xl shadow-2xl p-10 card-hover-effect fade-in-up">
                <div class="flex items-center mb-8">
                    <div class="section-icon w-16 h-16 rounded-3xl flex items-center justify-center mr-6 pulse-advanced" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <i class="fas fa-user-friends text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-black text-gray-800">Parent/Guardian Information</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="parent_name" class="block text-lg font-bold text-gray-700 mb-4">
                            Parent/Guardian's Name
                        </label>
                        <input type="text"
                               id="parent_name"
                               name="parent_name"
                               value="{{ old('parent_name', Auth::user()->name ?? '') }}"
                               class="form-input w-full px-6 py-4 rounded-2xl text-lg @error('parent_name') border-red-500 @enderror"
                               placeholder="Enter parent/guardian's name">
                        @error('parent_name')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="parent_contact" class="block text-lg font-bold text-gray-700 mb-4">
                            Contact Information
                        </label>
                        <input type="text"
                               id="parent_contact"
                               name="parent_contact"
                               value="{{ old('parent_contact', Auth::user()->email ?? Auth::user()->phone ?? '') }}"
                               class="form-input w-full px-6 py-4 rounded-2xl text-lg @error('parent_contact') border-red-500 @enderror"
                               placeholder="Email or phone number">
                        @error('parent_contact')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section rounded-3xl shadow-2xl p-10 card-hover-effect fade-in-right">
                <div class="flex items-center mb-8">
                    <div class="section-icon w-16 h-16 rounded-3xl flex items-center justify-center mr-6 pulse-advanced" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fas fa-book-open text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-black text-gray-800">Story Content</h2>
                </div>

                <div class="space-y-8">
                    <div>
                        <label for="title_ar" class="block text-lg font-bold text-gray-700 mb-4">
                            Story Title (Arabic)
                        </label>
                        <input type="text"
                               id="title_ar"
                               name="title_ar"
                               value="{{ old('title_ar') }}"
                               class="form-input w-full px-6 py-4 rounded-2xl text-lg @error('title_ar') border-red-500 @enderror"
                               placeholder="Example: The New Car Story (Arabic)"
                               dir="rtl">
                        @error('title_ar')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="title_en" class="block text-lg font-bold text-gray-700 mb-4">
                            Story Title (English)
                        </label>
                        <input type="text"
                               id="title_en"
                               name="title_en"
                               value="{{ old('title_en') }}"
                               class="form-input w-full px-6 py-4 rounded-2xl text-lg @error('title_en') border-red-500 @enderror"
                               placeholder="Example: The New Car Story"
                               dir="ltr">
                        @error('title_en')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="content_ar" class="block text-lg font-bold text-gray-700 mb-4">
                            Story Text (Arabic) <span class="text-red-500">*</span>
                        </label>
                        <textarea id="content_ar"
                                  name="content_ar"
                                  rows="8"
                                  class="form-input w-full px-6 py-4 rounded-2xl text-lg @error('content_ar') border-red-500 @enderror"
                                  placeholder="Tell us your child's story about recycling or fixing toys... How did the broken toy become something beautiful and new?"
                                  required dir="rtl">{{ old('content_ar') }}</textarea>
                        @error('content_ar')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="content_en" class="block text-lg font-bold text-gray-700 mb-4">
                            Story Text (English)
                        </label>
                        <textarea id="content_en"
                                  name="content_en"
                                  rows="8"
                                  class="form-input w-full px-6 py-4 rounded-2xl text-lg @error('content_en') border-red-500 @enderror"
                                  placeholder="Tell us your child's story about recycling or fixing toys... How did the broken toy become something beautiful and new?"
                                  dir="ltr">{{ old('content_en') }}</textarea>
                        @error('content_en')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section rounded-3xl shadow-2xl p-10 card-hover-effect fade-in-left">
                <div class="flex items-center mb-8">
                    <div class="section-icon w-16 h-16 rounded-3xl flex items-center justify-center mr-6 pulse-advanced" style="background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);">
                        <i class="fas fa-camera text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-black text-gray-800">Photos and Videos</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="image" class="block text-lg font-bold text-gray-700 mb-4">
                            Add Image
                        </label>
                        <div class="file-upload-area rounded-3xl p-8 text-center cursor-pointer" onclick="document.getElementById('image').click()">
                            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="text-lg text-gray-600 font-semibold">Click to upload an image</p>
                            <p class="text-sm text-gray-500 mt-2">PNG, JPG, JPEG up to 5MB</p>
                            <input id="image" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(event)">
                        </div>
                        @error('image')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                        <div id="imagePreview" class="mt-6 hidden">
                            <img id="previewImg" src="" alt="Image preview" class="max-w-full mx-auto rounded-2xl shadow-lg">
                        </div>
                    </div>

                    <div>
                        <label for="video" class="block text-lg font-bold text-gray-700 mb-4">
                            Add Video
                            </label>
                        <div class="file-upload-area rounded-3xl p-8 text-center cursor-pointer" onclick="document.getElementById('video').click()">
                            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-lg text-gray-600 font-semibold">Click to upload a video</p>
                            <p class="text-sm text-gray-500 mt-2">MP4, MOV, AVI up to 50MB</p>
                            <input id="video" name="video" type="file" class="hidden" accept="video/*" onchange="previewVideo(event)">
                        </div>
                        @error('video')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                        <div id="videoPreview" class="mt-6 hidden">
                            <video id="previewVideo" controls class="max-w-full mx-auto rounded-2xl shadow-lg">
                                <source id="videoSource" src="" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section rounded-3xl shadow-2xl p-10 card-hover-effect fade-in-up">
                <div class="flex items-center mb-8">
                    <div class="section-icon w-16 h-16 rounded-3xl flex items-center justify-center mr-6 pulse-advanced" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <i class="fas fa-info-circle text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-black text-gray-800">Additional Information</h2>
                </div>

                <div class="space-y-8">
                    <div>
                        <label for="lesson_learned" class="block text-lg font-bold text-gray-700 mb-4">
                            What did the child learn from this experience?
                        </label>
                        <textarea id="lesson_learned"
                                  name="lesson_learned"
                                  rows="4"
                                  class="form-input w-full px-6 py-4 rounded-2xl text-lg @error('lesson_learned') border-red-500 @enderror"
                                  placeholder="Example: They learned that broken things can be fixed, and that creativity can transform anything into something beautiful..."></textarea>
                        @error('lesson_learned')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="materials_used" class="block text-lg font-bold text-gray-700 mb-4">
                            Materials used in repair/creation
                        </label>
                        <input type="text"
                               id="materials_used"
                               name="materials_used"
                               value="{{ old('materials_used') }}"
                               class="form-input w-full px-6 py-4 rounded-2xl text-lg @error('materials_used') border-red-500 @enderror"
                               placeholder="Example: Colored paper, glue, scissors, threads, buttons...">
                        @error('materials_used')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration" class="block text-lg font-bold text-gray-700 mb-4">
                            How long did the work take to complete?
                        </label>
                        <select id="duration"
                                name="duration"
                                class="form-input w-full px-6 py-4 rounded-2xl text-lg @error('duration') border-red-500 @enderror">
                            <option value="">Select duration</option>
                            <option value="Less than an hour" {{ old('duration') == 'Less than an hour' ? 'selected' : '' }}>Less than an hour</option>
                            <option value="1-2 hours" {{ old('duration') == '1-2 hours' ? 'selected' : '' }}>1-2 hours</option>
                            <option value="Half a day" {{ old('duration') == 'Half a day' ? 'selected' : '' }}>Half a day</option>
                            <option value="Full day" {{ old('duration') == 'Full day' ? 'selected' : '' }}>Full day</option>
                            <option value="Several days" {{ old('duration') == 'Several days' ? 'selected' : '' }}>Several days</option>
                            <option value="A week or more" {{ old('duration') == 'A week or more' ? 'selected' : '' }}>A week or more</option>
                        </select>
                        @error('duration')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="difficulty_level" class="block text-lg font-bold text-gray-700 mb-4">
                            Project Difficulty Level
                        </label>
                        <div class="grid grid-cols-3 gap-6">
                            <label class="cursor-pointer">
                                <input type="radio" name="difficulty_level" value="Easy" class="sr-only" {{ old('difficulty_level') == 'Easy' ? 'checked' : '' }}>
                                <div class="difficulty-card p-6 rounded-2xl text-center transition-all duration-300 border-2 border-green-200 hover:border-green-400">
                                    <i class="fas fa-smile text-green-500 text-3xl mb-3"></i>
                                    <p class="font-bold text-gray-800">Easy</p>
                                    <p class="text-sm text-gray-600 mt-2">For beginners</p>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="difficulty_level" value="Medium" class="sr-only" {{ old('difficulty_level') == 'Medium' ? 'checked' : '' }}>
                                <div class="difficulty-card p-6 rounded-2xl text-center transition-all duration-300 border-2 border-yellow-200 hover:border-yellow-400">
                                    <i class="fas fa-meh text-yellow-500 text-3xl mb-3"></i>
                                    <p class="font-bold text-gray-800">Medium</p>
                                    <p class="text-sm text-gray-600 mt-2">Requires some skill</p>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="difficulty_level" value="Hard" class="sr-only" {{ old('difficulty_level') == 'Hard' ? 'checked' : '' }}>
                                <div class="difficulty-card p-6 rounded-2xl text-center transition-all duration-300 border-2 border-red-200 hover:border-red-400">
                                    <i class="fas fa-frown text-red-500 text-3xl mb-3"></i>
                                    <p class="font-bold text-gray-800">Hard</p>
                                    <p class="text-sm text-gray-600 mt-2">For experts</p>
                                </div>
                            </label>
                        </div>
                        @error('difficulty_level')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section rounded-3xl shadow-2xl p-10 card-hover-effect fade-in-right">
                <div class="flex items-center mb-8">
                    <div class="section-icon w-16 h-16 rounded-3xl flex items-center justify-center mr-6 pulse-advanced" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-black text-gray-800">Privacy and Permissions</h2>
                </div>

                <div class="space-y-6">
                    <div class="flex items-start">
                        <input type="checkbox"
                               id="privacy_consent"
                               name="privacy_consent"
                               value="1"
                               class="mt-2 h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                               {{ old('privacy_consent') ? 'checked' : '' }}
                               required>
                        <label for="privacy_consent" class="ml-4 text-gray-700 leading-relaxed">
                            <span class="font-bold text-lg">Consent to Publish</span>
                            <p class="mt-2 text-gray-600">
                                I agree to publish this story and the attached photos/videos on the Al-Sanadiq platform to inspire others.
                                I confirm that I have the right to publish this content and that all provided information is correct.
                            </p>
                        </label>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox"
                               id="data_consent"
                               name="data_consent"
                               value="1"
                               class="mt-2 h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                               {{ old('data_consent') ? 'checked' : '' }}
                               required>
                        <label for="data_consent" class="ml-4 text-gray-700 leading-relaxed">
                            <span class="font-bold text-lg">Consent to Data Usage</span>
                            <p class="mt-2 text-gray-600">
                                I agree to use the provided data for service improvement and to share positive experiences with the community.
                                All data will be handled in accordance with our privacy policy.
                            </p>
                        </label>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-info-circle text-blue-500 text-xl mr-3"></i>
                            <span class="font-bold text-blue-800">Important Note</span>
                        </div>
                        <p class="text-blue-700 leading-relaxed">
                            All submitted stories will be reviewed before publication to ensure content quality and suitability.
                            It may take 1-3 business days for a story to be approved and published.
                        </p>
                    </div>
                </div>

                @error('privacy_consent')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
                @error('data_consent')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-center fade-in-up">
                <button type="submit"
                        class="btn-professional px-12 py-6 bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-600 text-white text-xl font-bold rounded-3xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 pulse-advanced">
                    <i class="fas fa-paper-plane mr-4 text-2xl"></i>
                    Submit Story for Review
                </button>
                <p class="text-gray-600 mt-6 text-lg">
                    Thank you for sharing your amazing story with us! 🎉
                </p>
            </div>
        </form>
    </div>
</section>

<script>
    // Image Preview Function
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Video Preview Function
    function previewVideo(event) {
        const input = event.target;
        const preview = document.getElementById('videoPreview');
        const previewVideo = document.getElementById('previewVideo');
        const videoSource = document.getElementById('videoSource');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const url = URL.createObjectURL(file);
            videoSource.src = url;
            previewVideo.load();
            preview.classList.remove('hidden');
        }
    }

    // Difficulty Level Selection
    document.querySelectorAll('input[name="difficulty_level"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Remove selected class from all cards
            document.querySelectorAll('.difficulty-card').forEach(function(card) {
                card.classList.remove('bg-blue-100', 'border-blue-400', 'shadow-lg');
            });
            
            // Add selected class to chosen card
            if (this.checked) {
                const card = this.nextElementSibling;
                card.classList.add('bg-blue-100', 'border-blue-400', 'shadow-lg');
            }
        });
    });

    // Initialize selected difficulty if exists
    document.addEventListener('DOMContentLoaded', function() {
        const selectedRadio = document.querySelector('input[name="difficulty_level"]:checked');
        if (selectedRadio) {
            const card = selectedRadio.nextElementSibling;
            card.classList.add('bg-blue-100', 'border-blue-400', 'shadow-lg');
        }
    });

    // Form Validation Enhancement
    document.querySelector('form').addEventListener('submit', function(e) {
        const childName = document.getElementById('child_name').value.trim();
        const contentAr = document.getElementById('content_ar').value.trim();
        const privacyConsent = document.getElementById('privacy_consent').checked;
        const dataConsent = document.getElementById('data_consent').checked;

        if (!childName) {
            e.preventDefault();
            alert('يرجى إدخال اسم الطفل');
            document.getElementById('child_name').focus();
            return;
        }

        if (!contentAr) {
            e.preventDefault();
            alert('يرجى كتابة نص القصة باللغة العربية');
            document.getElementById('content_ar').focus();
            return;
        }

        if (!privacyConsent || !dataConsent) {
            e.preventDefault();
            alert('يرجى الموافقة على شروط النشر واستخدام البيانات');
            return;
        }

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin ml-4"></i> جاري الإرسال...';
        submitBtn.disabled = true;
    });

    // Character count for textareas
    function addCharacterCount(textareaId, maxLength = 1000) {
        const textarea = document.getElementById(textareaId);
        const countElement = document.createElement('p');
        countElement.className = 'text-sm text-gray-500 mt-2 text-left';
        countElement.id = textareaId + '_count';
        textarea.parentNode.appendChild(countElement);

        function updateCount() {
            const remaining = maxLength - textarea.value.length;
            countElement.textContent = `${textarea.value.length} / ${maxLength}`;
            countElement.style.color = remaining < 50 ? '#ef4444' : '#6b7280';
        }

        textarea.addEventListener('input', updateCount);
        updateCount();
    }

    // Add character counters
    document.addEventListener('DOMContentLoaded', function() {
        addCharacterCount('content_ar', 2000);
        addCharacterCount('content_en', 2000);
        addCharacterCount('lesson_learned', 500);
    });

    // Animate elements on scroll
    function animateOnScroll() {
        const elements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right');
        
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add('animate-fadeInUp');
            }
        });
    }

    window.addEventListener('scroll', animateOnScroll);
    document.addEventListener('DOMContentLoaded', animateOnScroll);
</script>

@endsection