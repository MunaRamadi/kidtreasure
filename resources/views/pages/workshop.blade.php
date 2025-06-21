@extends('layouts.app')

@section('title', 'Workshops - Children\'s Treasures')

@section('description', 'Learn about our Treasure and Creativity workshops for children - fostering creativity and environmental awareness through engaging educational activities.')

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
        @apply w-full px-4 py-3 bg-white bg-opacity-80 rounded-xl border border-indigo-100 shadow-inner focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 transition duration-300 outline-none text-gray-700;
    }

    /* Removing custom placeholder styling to use browser defaults */

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
        color: #fff;
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
                Inspiring a new generation of creative thinkers through immersive, hands-on workshops that blend art, sustainability, and imagination.
            </p>
            <div class="fade-in-up" style="animation-delay: 0.4s;">
                <a href="#upcoming-workshops" class="btn-professional bg-white text-purple-700 px-10 py-4 rounded-full font-bold text-lg hover:bg-opacity-90 shadow-lg">
                    Explore Workshops
                </a>
            </div>
        </div>
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
                Our workshops are designed to inspire children to explore their creativity while learning about environmental sustainability.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="fade-in-left">
                <div class="relative">
                    <div class="absolute -inset-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-3xl blur opacity-75"></div>
                    <img src="{{ asset('images/WorkshopImg4.png') }}" alt="Children creating art from recycled materials" class="rounded-3xl relative z-10 w-full h-auto shadow-lg">
                </div>
            </div>
            
            <div class="fade-in-right">
                <h3 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">What Children Will Experience</h3>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">1</div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xl font-bold text-gray-800">Hands-on Creating</h4>
                            <p class="text-gray-600 mt-2">Children will transform recycled materials into beautiful art pieces and functional items, learning the value of reusing resources.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">2</div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xl font-bold text-gray-800">Environmental Education</h4>
                            <p class="text-gray-600 mt-2">Through storytelling and interactive activities, children will learn about environmental challenges and how they can contribute to solutions.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">3</div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xl font-bold text-gray-800">Collaborative Projects</h4>
                            <p class="text-gray-600 mt-2">Children will work together on group projects, developing communication skills and learning the power of teamwork.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">4</div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xl font-bold text-gray-800">Exhibition Opportunity</h4>
                            <p class="text-gray-600 mt-2">Selected creations will be featured in our gallery and community exhibitions, giving children a chance to showcase their work.</p>
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
                <span class="text-gradient-advanced">Workshops</span>
            </h2>
            <p class="text-xl max-w-3xl mx-auto">
                Join us for our upcoming workshops and experience the joy of creative learning.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($workshops as $workshop)
            <div class="workshop-card glass-card card-hover-effect p-0 fade-in-up">
                <div class="workshop-image">
                    <img src="{{ asset('images/workshopImg' . ($loop->iteration % 3 + 1) . '.png') }}" alt="{{ $workshop->name_en }}">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="bg-purple-500 bg-opacity-30 text-white px-3 py-1 rounded-full text-sm">{{ $workshop->target_age_group }}</span>
                        <span class="text-white text-opacity-80 text-sm">
                            @if($workshop->events->isNotEmpty())
                                {{ $workshop->events->first()->event_time }}
                            @else
                                Available Soon
                            @endif
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">{{ $workshop->name_en }}</h3>
                    <p class="text-white text-opacity-80 mb-4">{{ \Illuminate\Support\Str::limit($workshop->description_en, 120) }}</p>
                    
                    @if($workshop->events->isNotEmpty())
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white text-opacity-80 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-white text-opacity-80">{{ \Carbon\Carbon::parse($workshop->events->first()->event_date)->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white text-opacity-80 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-white text-opacity-80">{{ \Carbon\Carbon::parse($workshop->events->first()->event_time)->format('g:i A') }}</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-white font-bold text-xl">{{ $workshop->events->first()->price_jod }} JOD</span>
                        <button type="button" class="btn-professional bg-white text-purple-700 px-4 py-2 rounded-full font-bold text-sm hover:bg-opacity-90" 
                            onclick="openRegistrationModal('{{ $workshop->events->first()->id }}', '{{ $workshop->name_en }}')">
                            Register Now
                        </button>
                    </div>
                    @else
                    <div class="flex justify-between items-center">
                        <span class="text-white text-opacity-80">No events scheduled</span>
                        <button type="button" class="btn-professional bg-white bg-opacity-50 text-purple-700 px-4 py-2 rounded-full font-bold text-sm cursor-not-allowed">
                            Coming Soon
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <!-- Static Workshop 1 -->
            <div class="workshop-card glass-card card-hover-effect p-0 fade-in-up" style="animation-delay: 0s;">
                <div class="workshop-image">
                    <img src="{{ asset('images/workshopImg1.png') }}" alt="Recycled Art Masterpieces">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="bg-purple-500 bg-opacity-30 text-white px-3 py-1 rounded-full text-sm">Art & Craft</span>
                        <span class="text-white text-opacity-80 text-sm">120 mins</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Recycled Art Masterpieces</h3>
                    <p class="text-white text-opacity-80 mb-4">Children will learn to create beautiful art pieces from recycled materials, fostering creativity and environmental awareness.</p>
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white text-opacity-80 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-white text-opacity-80">{{ now()->addDays(7)->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white text-opacity-80 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-white text-opacity-80">10:00 AM</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-white font-bold text-xl">25 JOD</span>
                        <button type="button" class="btn-professional bg-white text-purple-700 px-4 py-2 rounded-full font-bold text-sm hover:bg-opacity-90" 
                            onclick="openRegistrationModal('WS-2025-001', 'Recycled Art Masterpieces')">
                            Register Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- Static Workshop 2 -->
            <div class="workshop-card glass-card card-hover-effect p-0 fade-in-up" style="animation-delay: 0.2s;">
                <div class="workshop-image">
                    <img src="{{ asset('images/workshopImg2.png') }}" alt="Storytelling & Imagination">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="bg-purple-500 bg-opacity-30 text-white px-3 py-1 rounded-full text-sm">Storytelling</span>
                        <span class="text-white text-opacity-80 text-sm">90 mins</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Storytelling & Imagination</h3>
                    <p class="text-white text-opacity-80 mb-4">A workshop that encourages children to create and tell their own stories, developing language skills and imagination.</p>
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white text-opacity-80 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-white text-opacity-80">{{ now()->addDays(14)->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white text-opacity-80 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-white text-opacity-80">2:00 PM</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-white font-bold text-xl">15 JOD</span>
                        <button type="button" class="btn-professional bg-white text-purple-700 px-4 py-2 rounded-full font-bold text-sm hover:bg-opacity-90" 
                            onclick="openRegistrationModal('WS-2025-002', 'Storytelling & Imagination')">
                            Register Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- Static Workshop 3 -->
            <div class="workshop-card glass-card card-hover-effect p-0 fade-in-up" style="animation-delay: 0.4s;">
                <div class="workshop-image">
                    <img src="{{ asset('images/workshopImg3.png') }}" alt="Nature Explorers">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="bg-purple-500 bg-opacity-30 text-white px-3 py-1 rounded-full text-sm">Nature & Science</span>
                        <span class="text-white text-opacity-80 text-sm">150 mins</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Nature Explorers</h3>
                    <p class="text-white text-opacity-80 mb-4">An outdoor workshop where children connect with nature through exploration, observation, and nature-inspired art activities.</p>
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white text-opacity-80 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-white text-opacity-80">{{ now()->addDays(21)->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white text-opacity-80 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-white text-opacity-80">9:30 AM</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-white font-bold text-xl">30 JOD</span>
                        <button type="button" class="btn-professional bg-white text-purple-700 px-4 py-2 rounded-full font-bold text-sm hover:bg-opacity-90" 
                            onclick="openRegistrationModal('WS-2025-003', 'Nature Explorers')">
                            Register Now
                        </button>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Registration Modal -->
<div id="registrationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-3xl shadow-2xl max-w-4xl w-full mx-4 md:mx-auto max-h-[90vh] overflow-y-auto">
        <div class="p-6 md:p-10">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-3xl font-bold text-gray-800" id="modalWorkshopTitle">Register Interest</h3>
                <button type="button" onclick="closeRegistrationModal()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('workshops.register.interest') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="workshop_id" id="modalWorkshopId">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-input-group">
                        <input type="text" name="parent_name" class="form-input" placeholder="Parent's Name *" required>
                    </div>
                    
                    <div class="form-input-group">
                        <input type="email" name="parent_email" class="form-input" placeholder="Parent's Email *" required>
                    </div>
                    
                    <div class="form-input-group">
                        <input type="tel" name="parent_phone" class="form-input" placeholder="Parent's Phone *" required>
                    </div>
                    
                    <div class="form-input-group">
                        <input type="text" name="child_name" class="form-input" placeholder="Child's Name *" required>
                    </div>
                    
                    <div class="form-input-group">
                        <input type="number" name="child_age" class="form-input" placeholder="Child's Age *" min="3" max="18" required>
                    </div>
                    
                    <div class="form-input-group">
                        <select name="preferred_day" class="form-input" required>
                            <option value="" disabled selected>Preferred Day *</option>
                            <option value="monday">Monday</option>
                            <option value="tuesday">Tuesday</option>
                            <option value="wednesday">Wednesday</option>
                            <option value="thursday">Thursday</option>
                            <option value="friday">Friday</option>
                            <option value="saturday">Saturday</option>
                            <option value="sunday">Sunday</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-input-group">
                    <textarea name="special_requirements" class="form-input" placeholder="Any special requirements or interests?" rows="4"></textarea>
                </div>
                
                <div class="form-input-group">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="privacy_policy" id="privacy_policy" class="h-5 w-5 rounded" required>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="privacy_policy" class="text-gray-700">
                                I agree to the <a href="#" class="text-blue-600 hover:text-blue-800 underline">Privacy Policy</a> and consent to be contacted about workshops.
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <button type="submit" class="register-btn btn-professional">
                        Register Interest
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
                <span class="text-gradient-advanced">Frequently Asked</span> Questions
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Have questions about our workshops? Find answers to commonly asked questions below.
            </p>
        </div>
        
        <div class="max-w-4xl mx-auto">
            <div class="space-y-6">
                <div class="glass-card p-6 rounded-xl card-hover-effect bg-gradient-to-r from-blue-50 to-purple-50">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">What ages are your workshops suitable for?</h3>
                    <p class="text-gray-600">Our workshops are designed for children aged 5-12 years. We sometimes offer specialized sessions for teenagers (13-17) as well.</p>
                </div>
                
                <div class="glass-card p-6 rounded-xl card-hover-effect bg-gradient-to-r from-blue-50 to-purple-50">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Do parents need to stay during the workshop?</h3>
                    <p class="text-gray-600">Parents are welcome but not required to stay. We have trained facilitators who will guide and supervise all activities.</p>
                </div>
                
                <div class="glass-card p-6 rounded-xl card-hover-effect bg-gradient-to-r from-blue-50 to-purple-50">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">What should my child bring to the workshop?</h3>
                    <p class="text-gray-600">All materials are provided! Just bring your child with comfortable clothes that can get a little messy during creative activities.</p>
                </div>
                
                <div class="glass-card p-6 rounded-xl card-hover-effect bg-gradient-to-r from-blue-50 to-purple-50">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">How long do the workshops last?</h3>
                    <p class="text-gray-600">Most of our workshops run for 2-3 hours, with short breaks included. The exact duration is specified in each workshop description.</p>
                </div>
                
                <div class="glass-card p-6 rounded-xl card-hover-effect bg-gradient-to-r from-blue-50 to-purple-50">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">What if my child has special needs?</h3>
                    <p class="text-gray-600">We strive to accommodate all children. Please let us know about any special needs in advance so we can prepare accordingly.</p>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <p class="text-gray-600 mb-6">Still have questions? We're happy to help!</p>
                <a href="contact-us" class="btn-professional bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-3 rounded-full font-bold text-lg hover:shadow-lg">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    // Add smooth scrolling for anchor links
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth scrolling for all anchor links that point to sections on the same page
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        
        anchorLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
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
        document.getElementById('registrationModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
    }
    
    function closeRegistrationModal() {
        document.getElementById('registrationModal').classList.add('hidden');
        document.body.style.overflow = ''; // Re-enable scrolling
    }
    
    // Close modal when clicking outside of it
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('registrationModal');
        const modalContent = modal.querySelector('div');
        
        if (event.target === modal) {
            closeRegistrationModal();
        }
    });
</script>

@endsection