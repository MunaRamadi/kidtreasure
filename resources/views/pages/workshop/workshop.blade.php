@extends('layouts.app')

@section('title', 'Workshops - Children\'s Treasures')

@section('description', 'Learn about our Treasure and Creativity workshops for children - fostering creativity and environmental awareness through engaging educational activities.')

@section('styles')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
@endsection

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

        /* Form Styles with Improved Placeholder Visibility */
        .form-input {
            @apply w-full px-4 py-3 bg-white bg-opacity-90 rounded-xl border border-indigo-200 shadow-inner focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 transition duration-300 outline-none text-gray-900 font-medium;
        }

        /* Placeholder styling for better visibility */
        .form-input::placeholder {
            @apply text-gray-500 opacity-100;
        }

        /* Animated Background Effect */
        .animated-bg {
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        /* Swiper Slider Custom Styles */
        .swiper-container {
            width: 100%;
            padding-bottom: 40px;
        }
        
        .swiper-pagination {
            bottom: 0 !important;
        }
        
        .swiper-button-next, .swiper-button-prev {
            color: white !important;
            background: rgba(118, 75, 162, 0.7);
            width: 40px !important;
            height: 40px !important;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .swiper-button-next:hover, .swiper-button-prev:hover {
            background: rgba(118, 75, 162, 1);
        }
        
        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 18px !important;
        }
        
        .swiper-pagination-bullet {
            background: white !important;
            opacity: 0.7;
        }
        
        .swiper-pagination-bullet-active {
            opacity: 1;
            background: #f093fb !important;
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

            0%,
            100% {
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

        /* Fade-in Animation Classes */
        .fade-in-up {
            animation: fadeInUp 1s ease-out;
        }

        .fade-in-left {
            animation: fadeInLeft 1s ease-out;
        }

        .fade-in-right {
            animation: fadeInRight 1s ease-out;
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

        /* Workshop Cards */
        .workshop-card {
            overflow: hidden;
            border-radius: 1.5rem;
            transition: all 0.3s ease;
        }

        .workshop-card:hover .workshop-image img {
            transform: scale(1.1);
        }

        .workshop-image {
            overflow: hidden;
            height: 240px;
        }

        .workshop-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .form-input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .form-input:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 15px rgba(102, 126, 234, 0.5);
            outline: none;
        }

        .register-btn {
            width: 100%;
            padding: 1rem;
            border-radius: 0.75rem;
            background: var(--primary-gradient);
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .register-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>

    <!-- Hero Section -->
    <section class="animated-bg min-h-screen flex items-center relative overflow-hidden">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>

        <div class="container mx-auto px-6 py-24 relative z-10">
            <div class="flex flex-col items-center justify-center text-center text-white">
                <h1 class="text-5xl md:text-7xl font-black mb-8 fade-in-up">
                    <span class="text-gradient-advanced">Treasure & Creativity</span> Workshops
                </h1>
                <p class="text-xl md:text-2xl max-w-3xl mx-auto mb-12 fade-in-up" style="animation-delay: 0.2s;">
                    Inspiring a new generation of creative thinkers through immersive, hands-on workshops that blend art,
                    sustainability, and imagination.
                </p>
                <div class="fade-in-up" style="animation-delay: 0.4s;">
                    <a href="#upcoming-workshops"
                        class="btn-professional bg-white text-purple-700 px-10 py-4 rounded-full font-bold text-lg hover:bg-opacity-90 shadow-lg">
                        Explore Events
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Workshop Section -->
    <section class="py-24 bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 text-white relative overflow-hidden">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16 fade-in-up">
                <h2 class="text-5xl md:text-7xl font-black mb-8">
                    <span class="text-white">Featured</span>
                    <span class="text-gradient-advanced">Workshops</span>
                </h2>
                <p class="text-xl max-w-3xl mx-auto">
                    Discover our most popular and engaging workshop experiences
                </p>
            </div>
            
            @if(isset($featuredWorkshops) && $featuredWorkshops->count() > 0)
                <div id="featuredWorkshopsCarousel" class="carousel slide" data-bs-ride="carousel">
                    <!-- Carousel Indicators -->
                    <div class="carousel-indicators">
                        @foreach($featuredWorkshops as $index => $workshop)
                            <button type="button" data-bs-target="#featuredWorkshopsCarousel" data-bs-slide-to="{{ $index }}" 
                                class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" 
                                aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                    
                                 <!-- Carousel Items -->
                                 <div class="carousel-inner">
                        @foreach($featuredWorkshops as $index => $workshop)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-xl overflow-hidden shadow-2xl">
                                    <div class="md:flex">
                                        <div class="md:w-1/2 carousel-image-container">
                                            @if($workshop->image)
                                                <img src="{{ asset('storage/' . $workshop->image) }}" 
                                                    alt="{{ app()->getLocale() == 'en' ? $workshop->name_en : $workshop->name_ar }}" 
                                                    class="workshop-carousel-image">
                                            @else
                                                <img src="{{ asset('images/placeholder-workshop.jpg') }}" 
                                                    alt="{{ app()->getLocale() == 'en' ? $workshop->name_en : $workshop->name_ar }}" 
                                                    class="workshop-carousel-image">
                                            @endif
                                        </div>
                                        <div class="md:w-1/2 p-8 workshop-content">
                                            <div class="mb-4">
                                                <span class="inline-block bg-purple-500 bg-opacity-30 text-white px-3 py-1 rounded-full text-sm font-medium mb-4">
                                                    {{ $workshop->target_age_group }}
                                                </span>
                                                <h3 class="text-3xl font-bold mb-4">
                                                    {{ app()->getLocale() == 'en' ? $workshop->name_en : $workshop->name_ar }}
                                                </h3>
                                            </div>
                                            
                                            <p class="text-white text-opacity-80 mb-6">
                                                {{ \Illuminate\Support\Str::limit(app()->getLocale() == 'en' ? $workshop->description_en : $workshop->description_ar, 250) }}
                                            </p>
                                            
                                            <div class="mt-8">
                                                <div class="flex flex-wrap gap-4 mb-6">
                                                    <div class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span>{{ $workshop->events->count() }} Events</span>
                                                    </div>
                                                    
                                                    <div class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                        </svg>
                                                        <span>{{ $workshop->events->sum(function($event) { return $event->registrations->count(); }) ?? 0 }} Participants</span>
                                                    </div>
                                                </div>
                                                
                                                @if($workshop->events->where('event_date', '>=', now())->count() > 0)
                                                    <div class="mb-6">
                                                        <h4 class="text-xl font-semibold mb-3">Next Event</h4>
                                                        @php
                                                            $nextEvent = $workshop->events->where('event_date', '>=', now())->sortBy('event_date')->first();
                                                        @endphp
                                                        
                                                        @if($nextEvent)
                                                            <div class="bg-white bg-opacity-10 rounded-lg p-4">
                                                                <div class="flex justify-between items-center mb-2">
                                                                    <span class="font-medium">{{ $nextEvent->title }}</span>
                                                                    <span>{{ \Carbon\Carbon::parse($nextEvent->event_date)->format('M d, Y') }}</span>
                                                                </div>
                                                                <div class="flex justify-between items-center">
                                                                    <span>{{ \Carbon\Carbon::parse($nextEvent->event_time)->format('g:i A') }}</span>
                                                                    <span>{{ $nextEvent->location }}</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                                
                                                <div class="mt-8">
                                                    <a href="{{ route('workshops.show', $workshop) }}" class="inline-block bg-white text-purple-800 h-12 px-6 py-3 rounded-full font-bold text-sm hover:bg-opacity-90 transition-colors">
                                                        {{ __('workshops.learn_more') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#featuredWorkshopsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#featuredWorkshopsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                
                @push('styles')
                <style>
                    /* Custom carousel styles */
                    #featuredWorkshopsCarousel {
                        margin: 0 auto;
                        max-width: 1200px;
                    }
                    
                    #featuredWorkshopsCarousel .carousel-item {
                        transition: transform 0.6s ease-in-out;
                        height: 550px; /* Increased height for carousel items */
                    }
                    
                    #featuredWorkshopsCarousel .carousel-inner {
                        height: 550px; /* Increased height for carousel container */
                    }

                    #featuredWorkshopsCarousel .md\:flex {
                        height: 100%; /* Make flex container take full height */
                    }
                    
                    /* Image container styles */
                    #featuredWorkshopsCarousel .carousel-image-container {
                        height: 550px; /* Increased height to match */
                        overflow: hidden;
                    }
                    
                    /* Workshop image styles */
                    #featuredWorkshopsCarousel .workshop-carousel-image {
                        width: 100%;
                        height: 100%;
                        object-fit: cover; /* This ensures the image covers the area without distortion */
                    }
                    
                    /* Content area styles */
                    #featuredWorkshopsCarousel .workshop-content {
                        height: 550px; /* Increased height to match */
                        overflow-y: visible; /* Changed from auto to visible to remove scroll */
                        display: flex;
                        flex-direction: column;
                        justify-content: space-between;
                    }
                    
                    /* Button styling to be more compact */
                    #featuredWorkshopsCarousel .workshop-content .mt-8 a {
                        padding: 0.5rem 1.5rem; /* Reduced padding */
                        display: inline-block;
                    }
                    
                    #featuredWorkshopsCarousel .carousel-control-prev,
                    #featuredWorkshopsCarousel .carousel-control-next {
                        width: 5%;
                        background: rgba(0, 0, 0, 0.2);
                        border-radius: 50%;
                        height: 50px;
                        width: 50px;
                        top: 50%;
                        transform: translateY(-50%);
                    }
                    
                    #featuredWorkshopsCarousel .carousel-indicators {
                        bottom: -50px;
                    }
                    
                    #featuredWorkshopsCarousel .carousel-indicators button {
                        width: 12px;
                        height: 12px;
                        border-radius: 50%;
                        background-color: rgba(255, 255, 255, 0.5);
                        margin: 0 5px;
                    }
                    
                    #featuredWorkshopsCarousel .carousel-indicators button.active {
                        background-color: white;
                    }
                </style>
                @endpush
                
                @push('scripts')
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Initialize the carousel with custom settings
                        const carousel = new bootstrap.Carousel(document.getElementById('featuredWorkshopsCarousel'), {
                            interval: 5000,  // Change slides every 5 seconds
                            wrap: true,      // Continuous loop
                            keyboard: true,  // Allow keyboard navigation
                            pause: 'hover'   // Pause on mouse hover
                        });
                    });
                </script>
                @endpush
            @else
                <div class="text-center py-12">
                    <p class="text-white text-opacity-80">Stay tuned for our featured workshops coming soon!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- About Our Workshops Section -->
    <section class="py-24 section-bg-pattern bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16 fade-in-up">
                <h2 class="text-5xl md:text-7xl font-black text-gray-800 mb-8">
                    <span class="text-gradient-advanced">Treasure and Creativity</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Our workshops are designed to inspire children to explore their creativity while learning about
                    environmental sustainability.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="fade-in-left">
                    <div class="relative">
                        <div
                            class="absolute -inset-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-3xl blur opacity-75">
                        </div>
                        <img src="{{ asset('images/WorkshopImg4.png') }}"
                            alt="Children creating art from recycled materials"
                            class="rounded-3xl relative z-10 w-full h-auto shadow-lg">
                    </div>
                </div>

                <div class="fade-in-right">
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">What Children Will Experience</h3>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div
                                    class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                    1</div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-xl font-bold text-gray-800">Hands-on Creating</h4>
                                <p class="text-gray-600 mt-2">Children will transform recycled materials into beautiful art
                                    pieces and functional items, learning the value of reusing resources.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div
                                    class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                    2</div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-xl font-bold text-gray-800">Environmental Education</h4>
                                <p class="text-gray-600 mt-2">Through storytelling and interactive activities, children will
                                    learn about environmental challenges and how they can contribute to solutions.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div
                                    class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                    3</div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-xl font-bold text-gray-800">Collaborative Projects</h4>
                                <p class="text-gray-600 mt-2">Children will work together on group projects, developing
                                    communication skills and learning the power of teamwork.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div
                                    class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                    4</div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-xl font-bold text-gray-800">Exhibition Opportunity</h4>
                                <p class="text-gray-600 mt-2">Selected creations will be featured in our gallery and
                                    community exhibitions, giving children a chance to showcase their work.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Workshops Section -->
    <section id="upcoming-workshops" class="py-24 animated-bg text-white relative overflow-hidden">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16 fade-in-up">
                <h2 class="text-5xl md:text-7xl font-black mb-8">
                    <span class="text-white">Upcoming</span>
                    <span class="text-gradient-advanced">Events</span>
                </h2>
                <p class="text-xl max-w-3xl mx-auto">
                    Join us for our upcoming workshop events and experience the joy of creative learning.
                </p>
            </div>

            <!-- Simple Grid Layout for All Workshops -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($upcomingEvents as $event)
                    <div class="workshop-card glass-card card-hover-effect p-0 fade-in-up h-full">
                        <div class="workshop-image">
                        @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}">
                            @else
                                <img src="{{ asset('images/placeholder-workshop.jpg') }}" alt="{{ $event->title }}">
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <span
                                    class="bg-purple-500 bg-opacity-30 text-white px-3 py-1 rounded-full text-sm">{{ $event->workshop->target_age_group ?? 'All Ages' }}</span>
                                <span class="text-white text-opacity-80 text-sm">
                                    {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}
                                </span>
                            </div>
                            <h3 class="text-2xl font-bold mb-2">{{ $event->title }}</h3>
                            <p class="text-white text-opacity-80 mb-4">
                                {{ \Illuminate\Support\Str::limit($event->description ?? $event->workshop->description_en, 100) }}
                            </p>

                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white text-opacity-80 mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span
                                        class="text-white text-opacity-80">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white text-opacity-80 mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-white text-opacity-80">{{ $event->location }}</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-white font-bold text-xl">{{ $event->price_jod }} JOD</span>
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('workshops.event.show', $event) }}"
                                        class="btn-professional bg-white text-indigo-600 px-4 py-2 rounded-full text-sm hover:bg-opacity-90 transition-colors">
                                        Details
                                    </a>
                                    
                                    @php
                                        $userRegistered = false;
                                        if (auth()->check()) {
                                            $userRegistered = $event->registrations()
                                                ->where('user_id', auth()->id())
                                                ->exists();
                                        }
                                    @endphp

                                    @if($userRegistered)
                                        <span class="bg-green-500 text-white px-4 py-2 rounded-full font-bold text-sm">
                                            Registered
                                        </span>
                                        <a href="{{ $event->getGoogleCalendarUrl() }}" 
                                           class="bg-purple-600 text-white px-2 py-2 rounded-full text-sm hover:bg-purple-700 transition-colors flex items-center"
                                           target="_blank">
                                            Add to Calendar
                                        </a>
                                    @elseif($event->is_open_for_registration)
                                        <button type="button"
                                            class="btn-professional bg-white text-purple-700 px-4 py-2 rounded-full font-bold text-sm hover:bg-opacity-90"
                                            onclick="openRegistrationModal('{{ $event->id }}', '{{ $event->title }}')">
                                            Register Now
                                        </button>
                                    @else
                                        <span class="text-sm text-white text-opacity-80 italic px-4 py-2">Registration closed</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- If no upcoming events -->
            @if(count($upcomingEvents) == 0)
                <div class="text-center py-12">
                    <p class="text-white text-xl">No upcoming events at the moment. Please check back later!</p>
                </div>
            @endif

            <!-- Call to Action Button for Workshops Page -->
            <div class="text-center mt-12 fade-in-up">
                <a href="{{ route('workshops.list') }}"
                    class="btn-professional bg-white text-purple-700 px-8 py-3 rounded-full font-bold text-lg hover:bg-opacity-90 inline-flex items-center transition-all duration-300 transform hover:scale-105">
                    <span>Explore Workshops</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
                <p class="text-white text-opacity-80 mt-4">Discover all our creative workshops and their upcoming events</p>
            </div>
        </div>
    </section>

    <!-- Registration Modal -->
    <div id="registrationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-gray-100 rounded-3xl shadow-2xl max-w-4xl w-full mx-4 md:mx-auto max-h-[90vh] overflow-y-auto">
            <div class="p-6 md:p-10">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-3xl font-bold text-gray-800" id="modalWorkshopTitle">Register Interest</h3>
                    <button type="button" onclick="closeRegistrationModal()" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form id="registrationForm" action="{{ route('workshops.register', ['event' => 0]) }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="event_id" id="modalWorkshopId">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-input-group">
                            <input type="text" name="parent_name" class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white " placeholder="Parent's Name *" required>
                        </div>

                        <div class="form-input-group">
                            <input type="tel" name="parent_contact" class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white text-gray-800" placeholder="Parent's Phone *"
                                required>
                        </div>

                        <div class="form-input-group">
                            <input type="text" name="attendee_name" class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white text-gray-800" placeholder="Child's Name *" required>
                        </div>
                    </div>

                    <div class="form-input-group">
                        <textarea name="special_requirements" class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white text-gray-800"
                            placeholder="Any special requirements or interests?" rows="4"></textarea>
                    </div>


                    <div class="mt-8">
                        <button type="submit" class="register-btn btn-professional w-full">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Workshop FAQs Section -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-5xl md:text-6xl font-black mb-8">
                    <span class="text-gradient-advanced">{{ __('workshops.frequently_asked') }}</span> {{ __('workshops.questions') }}
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    {{ __('workshops.faq_description') }}
                </p>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="space-y-6">
                    <div class="glass-card p-6 rounded-xl card-hover-effect bg-gradient-to-r from-blue-50 to-purple-50">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ __('workshops.faq_age_question') }}</h3>
                        <p class="text-gray-600">{{ __('workshops.faq_age_answer') }}</p>
                    </div>

                    <div class="glass-card p-6 rounded-xl card-hover-effect bg-gradient-to-r from-blue-50 to-purple-50">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ __('workshops.faq_parents_question') }}</h3>
                        <p class="text-gray-600">{{ __('workshops.faq_parents_answer') }}</p>
                    </div>

                    <div class="glass-card p-6 rounded-xl card-hover-effect bg-gradient-to-r from-blue-50 to-purple-50">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ __('workshops.faq_bring_question') }}</h3>
                        <p class="text-gray-600">{{ __('workshops.faq_bring_answer') }}</p>
                    </div>

                    <div class="glass-card p-6 rounded-xl card-hover-effect bg-gradient-to-r from-blue-50 to-purple-50">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ __('workshops.faq_duration_question') }}</h3>
                        <p class="text-gray-600">{{ __('workshops.faq_duration_answer') }}</p>
                    </div>

                    <div class="glass-card p-6 rounded-xl card-hover-effect bg-gradient-to-r from-blue-50 to-purple-50">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ __('workshops.faq_special_needs_question') }}</h3>
                        <p class="text-gray-600">{{ __('workshops.faq_special_needs_answer') }}</p>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <p class="text-gray-600 mb-6">{{ __('workshops.still_have_questions') }}</p>
                    <a href="contact-us"
                        class="btn-professional bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-3 rounded-full font-bold text-lg hover:shadow-lg">
                        {{ __('workshops.contact_us') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Add smooth scrolling for anchor links
        document.addEventListener('DOMContentLoaded', function () {
            // Add smooth scrolling for all anchor links that point to sections on the same page
            const anchorLinks = document.querySelectorAll('a[href^="#"]');

            anchorLinks.forEach(function (link) {
                link.addEventListener('click', function (e) {
                    e.preventDefault();

                    const targetSection = document.querySelector(this.getAttribute('href'));

                    if (targetSection) {
                        window.scrollTo({
                            top: targetSection.offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });

        function openRegistrationModal(workshopId, workshopTitle) {
            document.getElementById('modalWorkshopId').value = workshopId;
            document.getElementById('modalWorkshopTitle').textContent = 'Register for: ' + workshopTitle;
            
            // Update the form action URL with the correct event ID
            const form = document.getElementById('registrationForm');
            const action = form.getAttribute('action');
            form.setAttribute('action', action.replace('/0/register', '/' + workshopId + '/register'));
            
            document.getElementById('registrationModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        }

        function closeRegistrationModal() {
            document.getElementById('registrationModal').classList.add('hidden');
            document.body.style.overflow = ''; // Re-enable scrolling
        }

        // Close modal when clicking outside of it
        document.addEventListener('click', function (event) {
            const modal = document.getElementById('registrationModal');
            const modalContent = modal.querySelector('div');

            if (event.target === modal) {
                closeRegistrationModal();
            }
        });
    </script>

@endsection

@section('scripts')
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script>
        
        function openRegistrationModal(eventId = null, workshopTitle = 'Workshop Interest') {
            // Set the workshop title in the modal
            document.getElementById('modalWorkshopTitle').innerText = workshopTitle;
            
            // Set the workshop ID in the hidden input if provided
            if (eventId) {
                document.getElementById('modalWorkshopId').value = eventId;
                document.getElementById('registration_type').value = 'event';
                document.getElementById('event_id').value = eventId;
                
                // Update UI for event registration
                document.getElementById('register_button_text').innerText = 'Register for Event';
                document.getElementById('registration_badge').innerText = 'Event Registration';
                document.getElementById('registration_badge').classList.remove('bg-blue-500');
                document.getElementById('registration_badge').classList.add('bg-green-500');
                
                // Hide preferred day field for event registration
                if (document.getElementById('preferred_day_group')) {
                    document.getElementById('preferred_day_group').classList.add('hidden');
                }
            } else {
                document.getElementById('modalWorkshopId').value = '';
                document.getElementById('registration_type').value = 'interest';
                document.getElementById('event_id').value = '';
                
                // Update UI for interest registration
                document.getElementById('register_button_text').innerText = 'Register Interest';
                document.getElementById('registration_badge').innerText = 'Interest Registration';
                document.getElementById('registration_badge').classList.remove('bg-green-500');
                document.getElementById('registration_badge').classList.add('bg-blue-500');
                
                // Show preferred day field for interest registration
                if (document.getElementById('preferred_day_group')) {
                    document.getElementById('preferred_day_group').classList.remove('hidden');
                }
            }
            
            // Show the modal
            document.getElementById('registrationModal').classList.remove('hidden');
        }
        
        function closeRegistrationModal() {
            // Hide the modal
            document.getElementById('registrationModal').classList.add('hidden');
        }
    </script>
@endsection