
@extends('layouts.app')

@section('title', 'About Us - Children\'s Treasures')

@section('description', 'Learn about Children\'s Treasures - a pioneering project aimed at fostering creativity and environmental awareness in children in Jordan through sustainable educational solutions.')

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

    /* Responsive Design for Mobile */
    @media (max-width: 768px) {
        .floating-element {
            width: 40px !important;
            height: 40px !important;
        }
        
        .card-hover-effect:hover {
            transform: none;
        }
        
        .order-1, .order-2 {
            order: 0;
        }
        
        .lg\:text-right {
            text-align: center !important;
        }
        
        .lg\:justify-end {
            justify-content: center !important;
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

    /* Image Hover Effects */
    .image-hover-effect {
        transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        filter: brightness(0.9);
    }

    .image-hover-effect:hover {
        filter: brightness(1.1) contrast(1.1);
        transform: scale(1.05) rotateZ(2deg);
    }

    /* Team Cards Specific Styles */
    .team-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .team-card:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
    }

    /* Values list styling */
    .values-list li {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }

    .values-list li:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateX(10px);
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

    <div class="stars">
        <div class="star" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
        <div class="star" style="top: 40%; left: 30%; animation-delay: 1s;"></div>
        <div class="star" style="top: 60%; left: 70%; animation-delay: 2s;"></div>
        <div class="star" style="top: 80%; left: 20%; animation-delay: 3s;"></div>
        <div class="star" style="top: 30%; left: 80%; animation-delay: 0.5s;"></div>
        <div class="star" style="top: 70%; left: 50%; animation-delay: 1.5s;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-6 py-20 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1">
                <div class="fade-in-up text-center lg:text-right">
                    <h1 class="text-5xl md:text-7xl font-black mb-8 leading-tight">
                        <span class="block text-white drop-shadow-2xl">About</span>
                        <span class="block text-gradient-advanced text-6xl md:text-8xl">Children's</span>
                        <span class="block text-white text-4xl md:text-5xl font-bold mt-6 drop-shadow-lg">Treasures</span>
                    </h1>
                </div>
                
                <div class="fade-in-left text-center lg:text-right">
                    <p class="text-xl md:text-2xl mb-12 leading-relaxed text-white/95 font-light">
                        A pioneering project dedicated to fostering creativity and environmental awareness in children across Jordan through sustainable educational solutions.
                    </p>
                </div>
                
                <div class="fade-in-right">
                    <div class="flex flex-col sm:flex-row gap-6 justify-center lg:justify-end">
                        <a href="/products" class="btn-professional bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 hover:from-yellow-500 hover:via-orange-600 hover:to-red-600 text-white font-bold py-4 px-10 rounded-3xl text-lg shadow-2xl inline-flex items-center justify-center pulse-advanced">
                            <i class="fas fa-rocket mr-3 text-xl"></i>
                            <span>Explore Our Products</span>
                        </a>
                        <a href="/contact-us" class="btn-professional glass-card text-white font-bold py-4 px-10 rounded-3xl text-lg border border-white/30 inline-flex items-center justify-center">
                            <i class="fas fa-envelope mr-3 text-xl"></i>
                            <span>Contact Us</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="order-1 lg:order-2 fade-in-up">
                <div class="relative max-w-2xl mx-auto lg:mx-0">
                    <div class="absolute -inset-8 bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 rounded-3xl blur-2xl opacity-70 animate-pulse"></div>
                    <div class="relative">
                        <img src="{{ asset('https://t4.ftcdn.net/jpg/04/55/00/61/360_F_455006173_rD3HrutiXXahbpt28sIr5MCBQf9amgOo.jpg') }}" 
                             alt="Children using educational tools" 
                             class="relative rounded-3xl shadow-2xl w-full image-hover-effect">
                        <div class="absolute inset-0 rounded-3xl bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-24 section-bg-pattern bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16 fade-in-up">
            <h2 class="text-5xl md:text-7xl font-black text-gray-800 mb-8">
                <span class="text-gradient-advanced">Our Story</span>
            </h2>
            <div class="flex justify-center mb-8">
                <div class="w-32 h-2 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="glass-card card-hover-effect rounded-3xl p-12 bg-white/10 backdrop-filter backdrop-blur-20 border border-white/20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="fade-in-left">
                    <div class="relative">
                        <div class="absolute -inset-4 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-2xl blur-xl opacity-30"></div>
                        <img src="{{ asset('https://www.brookings.edu/wp-content/uploads/2021/11/2021-11-02T201727Z_1781731426_MT1USATODAY17079839_RTRMADP_3_KINDERGARDEN-STUDENTS-WORK-IN-CLASSROOMS-AT-ROSS-ELEMENTARY.jpg?quality=75&w=1500') }}" 
                             alt="Classroom sketch" 
                             class="relative rounded-2xl shadow-xl image-hover-effect">
                    </div>
                </div>
                
                <div class="fade-in-right">
                    <div class="space-y-6">
                        <p class="text-gray-700 leading-relaxed text-lg">
                            The journey of <span class="font-semibold text-blue-800">Children's Treasures</span> began in 2021 when Mona Al-Ramadi, the founder and director, recognized the need for innovative and sustainable educational tools for children in Jordan.
                        </p>
                        <p class="text-gray-700 leading-relaxed text-lg">
                            As a former teacher and a mother, Mona understood the power of play-based learning and its positive impact on child development.
                        </p>
                        <p class="text-gray-700 leading-relaxed text-lg">
                            Today, we are proud to serve thousands of children annually through our products, workshops, and educational programs, continually innovating and developing new solutions.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission, Vision, Values Section -->
<section class="py-24 animated-bg text-white relative overflow-hidden">
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    
    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16 fade-in-up">
            <h2 class="text-5xl md:text-7xl font-black mb-8">Mission, Vision & Values</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="glass-card card-hover-effect rounded-3xl p-10 border border-white/20 fade-in-left">
                <div class="bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700 rounded-3xl w-20 h-20 flex items-center justify-center mx-auto mb-8 shadow-2xl">
                    <i class="fas fa-eye text-white text-3xl"></i>
                </div>
                <h3 class="text-3xl font-bold mb-6 text-center">Our Vision</h3>
                <p class="text-white/90 text-lg leading-relaxed text-center">
                Our vision for "Kids' Treasures" is to be an inspiring creative platform that breathes new life into used toys, fostering a love for discovery, environmental awareness, and sustainable innovation in every home and school
                </p>
            </div>
            
            <div class="glass-card card-hover-effect rounded-3xl p-10 border border-white/20 fade-in-up" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-br from-green-500 via-emerald-600 to-teal-700 rounded-3xl w-20 h-20 flex items-center justify-center mx-auto mb-8 shadow-2xl">
                    <i class="fas fa-bullseye text-white text-3xl"></i>
                </div>
                <h3 class="text-3xl font-bold mb-6 text-center">Our Mission</h3>
                <p class="text-white/90 text-lg leading-relaxed text-center">
                    We provide interactive, upcycled boxes filled with carefully selected toys, artistic tools, and educational materials that empower children to learn through play, fostering creativity, environmental responsibility, and design thinking.

                </p>
            </div>
            
            <div class="glass-card card-hover-effect rounded-3xl p-10 border border-white/20 fade-in-right" style="animation-delay: 0.4s;">
                <div class="bg-gradient-to-br from-purple-500 via-pink-600 to-rose-700 rounded-3xl w-20 h-20 flex items-center justify-center mx-auto mb-8 shadow-2xl">
                    <i class="fas fa-heart text-white text-3xl"></i>
                </div>
                <h3 class="text-3xl font-bold mb-6 text-center">Our Values</h3>
               <p class="text-white/90 text-lg leading-relaxed text-center">
                  
From every forgotten toy a new treasure awaits
We believe every old toy holds a fresh opportunity for learning and creativity — and that children are the true changemakers toward a smarter, more sustainable world.

                </p>
            </div>
        </div>
    </div>
</section>

<!-- Our Team Section -->
<section class="py-24 section-bg-pattern bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16 fade-in-up">
            <h2 class="text-5xl md:text-7xl font-black text-gray-800 mb-8">
                <span class="text-gradient-advanced">Our Team</span>
            </h2>
            <div class="flex justify-center mb-8">
                <div class="w-32 h-2 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-full"></div>
            </div>
        </div>
        
       <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
            <!-- Mona Al-Ramadi -->
            <div class="team-card card-hover-effect rounded-3xl p-8 text-center shadow-xl fade-in-left">
                <div class="mb-6">
                    <div class="relative">
                        <div class="absolute -inset-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full blur opacity-75"></div>
                        <img src="{{ asset('images/36f9f17c-ea58-4750-8512-ef1401e71ecc.jfif') }}" 
                             alt="Mona Al-Ramadi" 
                             class="relative rounded-full w-32 h-32 mx-auto object-cover border-4 border-white shadow-xl">
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Mona<br>Al-Ramadi</h3>
                <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                    Founder and CEO. She holds a Master's degree in Management from Yarmouk University. Mona has experience in administrative work, marketing, and financial collection.
                </p>
            </div>
            
            <div class="team-card card-hover-effect rounded-3xl p-8 text-center shadow-xl fade-in-up" style="animation-delay: 0.2s;">
                <div class="mb-6">
                    <div class="relative">
                        <div class="absolute -inset-2 bg-gradient-to-r from-green-500 to-teal-600 rounded-full blur opacity-75"></div>
                        <img src="{{ asset('images/754dd7a0-05fa-4382-a07b-2c0085a26e27.jfif') }}" 
                             alt="Laila Abdullah" 
                             class="relative rounded-full w-32 h-32 mx-auto object-cover border-4 border-white shadow-xl">
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Faisal<br> Al-Shalabi</h3>
                <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                   Holds a Master's degree in Management from Yarmouk University. He has experience in administrative and financial work, handicrafts, maintenance, and sales.
                </p>
            
            </div>
            
            <div class="team-card card-hover-effect rounded-3xl p-8 text-center shadow-xl fade-in-right" style="animation-delay: 0.4s;">
                <div class="mb-6">
                    <div class="relative">
                        <div class="absolute -inset-2 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full blur opacity-75"></div>
                        <img src="{{ asset('images/433221b2-f364-4f22-9f6b-a03aa1e9bacd.jfif') }}" 
                             alt="Ahmed Al-Khatib" 
                             class="relative rounded-full w-32 h-32 mx-auto object-cover border-4 border-white shadow-xl">
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Hassan <br>Al-Shalabi </h3>
                <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                   Holds a Bachelor's degree in Computer Science from Al-Balqa Applied University. He handles technical and IT support.
                </p>
            
            </div>
            
            <div class="team-card card-hover-effect rounded-3xl p-8 text-center shadow-xl fade-in-left" style="animation-delay: 0.6s;">
                <div class="mb-6">
                    <div class="relative">
                        <div class="absolute -inset-2 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-full blur opacity-75"></div>
                        <img src="{{ asset('images/58c2957e-5c77-438c-b3bb-9faba32a834e.jfif') }}" 
                             alt="Sarah Al-Qasim" 
                             class="relative rounded-full w-32 h-32 mx-auto object-cover border-4 border-white shadow-xl">
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Noor<br>Al-Shalabi</h3>
                <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                  Holds a Bachelor's degree in Business Administration from Al-Balqa Applied University. She performs administrative tasks and sales
                </p>
             
            </div>

             <div class="team-card card-hover-effect rounded-3xl p-8 text-center shadow-xl fade-in-left" style="animation-delay: 0.6s;">
                <div class="mb-6">
                    <div class="relative">
                        <div class="absolute -inset-2 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-full blur opacity-75"></div>
                        <img src="{{ asset('images/24f1ad5e-9b8d-49cc-9fcc-b7b94c5d5105.jfif') }}" 
                             alt="Sarah Al-Qasim" 
                             class="relative rounded-full w-32 h-32 mx-auto object-cover border-4 border-white shadow-xl">
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Mohammad<br>Al-Shalabi</h3>
                <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                 A high school student who assists with sorting, classifying, and packaging toys.
                </p>
             
            </div>
        </div>
    </div>
</section>
  <!-- Call to Action Section -->
<section class="py-24 animated-bg text-white relative overflow-hidden">
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    
    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <div class="text-center fade-in-up">
            <h2 class="text-4xl md:text-6xl font-black mb-8">Ready to Join Our Mission?</h2>
            <p class="text-xl md:text-2xl mb-12 leading-relaxed text-white/90 max-w-4xl mx-auto">
                Together, we can create a brighter future for children in Jordan through innovative and sustainable education.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
              
                <a href="/products" class="btn-professional glass-card text-white font-bold py-4 px-10 rounded-3xl text-lg border border-white/30 inline-flex items-center justify-center">
                    <i class="fas fa-shopping-cart mr-3 text-xl"></i>
                    <span>Shop Our Products</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Impact Section -->
<section class="py-24 section-bg-pattern bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16 fade-in-up">
            <h2 class="text-5xl md:text-7xl font-black text-gray-800 mb-8">
                <span class="text-gradient-advanced">Our Impact</span>
            </h2>
            <div class="flex justify-center mb-8">
                <div class="w-32 h-2 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-16">
            <div class="glass-card card-hover-effect rounded-3xl p-8 text-center fade-in-left">
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6 shadow-xl">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-blue-600 mb-2">500+</div>
                <div class="text-gray-700 font-medium">Children Reached</div>
            </div>
            
            <div class="glass-card card-hover-effect rounded-3xl p-8 text-center fade-in-up" style="animation-delay: 0.1s;">
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6 shadow-xl">
                    <i class="fas fa-school text-white text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-green-600 mb-2">120+</div>
                <div class="text-gray-700 font-medium">Schools Partnered</div>
            </div>
            
            <div class="glass-card card-hover-effect rounded-3xl p-8 text-center fade-in-right" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6 shadow-xl">
                    <i class="fas fa-box text-white text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-purple-600 mb-2">50+</div>
                <div class="text-gray-700 font-medium">Educational Products</div>
            </div>
            
            <div class="glass-card card-hover-effect rounded-3xl p-8 text-center fade-in-left" style="animation-delay: 0.3s;">
                <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6 shadow-xl">
                    <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-orange-600 mb-2">12</div>
                <div class="text-gray-700 font-medium">Governorates Covered</div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 fade-in-up">
            <div class="glass-card card-hover-effect rounded-3xl overflow-hidden shadow-xl">
                <div class="relative">
                    <div class="absolute -inset-4 bg-gradient-to-r from-blue-500 to-purple-600 rounded-3xl blur opacity-30"></div>
                    <img src="{{ asset('https://thumbs.dreamstime.com/z/children-funny-face-paintings-participating-art-craft-outdoor-workshop-zaporozhia-ukraine-june-charity-family-festival-131830549.jpg?ct=jpeg') }}" 
                         alt="Workshop session" 
                         class="relative w-full h-64 object-cover image-hover-effect">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Interactive Workshops</h3>
                    <p class="text-gray-600">Engaging hands-on learning experiences for children across Jordan.</p>
                </div>
            </div>
            
            <div class="glass-card card-hover-effect rounded-3xl overflow-hidden shadow-xl">
                <div class="relative">
                    <div class="absolute -inset-4 bg-gradient-to-r from-green-500 to-teal-600 rounded-3xl blur opacity-30"></div>
                    <img src="{{ asset('https://thumbs.dreamstime.com/z/group-children-making-crafts-out-colored-paper-lifestyl-lifestyle-scene-hand-made-goods-together-having-fun-61710823.jpg?ct=jpeg') }}" 
                         alt="Children creating" 
                         class="relative w-full h-64 object-cover image-hover-effect">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Creative Learning</h3>
                    <p class="text-gray-600">Fostering creativity and imagination through sustainable educational tools.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Video Section -->


<!-- Join Us Section -->
<section class="py-24 animated-bg text-white relative overflow-hidden">
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    
    <div class="stars">
        <div class="star" style="top: 15%; left: 20%; animation-delay: 0s;"></div>
        <div class="star" style="top: 35%; left: 60%; animation-delay: 1s;"></div>
        <div class="star" style="top: 65%; left: 30%; animation-delay: 2s;"></div>
        <div class="star" style="top: 85%; left: 80%; animation-delay: 3s;"></div>
    </div>
    
    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <div class="glass-card card-hover-effect rounded-3xl p-12 border border-white/20 fade-in-up">
            <div class="text-center">
                <div class="bg-gradient-to-br from-yellow-400 via-orange-500 to-red-500 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-8 shadow-2xl pulse-advanced">
                    <i class="fas fa-rocket text-white text-4xl"></i>
                </div>
                
                <h2 class="text-4xl md:text-6xl font-black mb-8">Join Our Journey</h2>
                <p class="text-xl md:text-2xl mb-12 leading-relaxed text-white/90 max-w-4xl mx-auto">
                    We are always looking for passionate volunteers, partners, and educators to join our mission of providing creative and sustainable education for children in Jordan.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <div class="glass-card rounded-2xl p-6 border border-white/20">
                        <i class="fas fa-hands-helping text-yellow-400 text-3xl mb-4"></i>
                        <h3 class="text-xl font-bold mb-3">Volunteer</h3>
                        <p class="text-white/80 text-sm">Join our workshops and help educate children</p>
                    </div>
                    
                    <div class="glass-card rounded-2xl p-6 border border-white/20">
                        <i class="fas fa-handshake text-green-400 text-3xl mb-4"></i>
                        <h3 class="text-xl font-bold mb-3">Partner</h3>
                        <p class="text-white/80 text-sm">Collaborate with us on educational initiatives</p>
                    </div>
                    
                    <div class="glass-card rounded-2xl p-6 border border-white/20">
                        <i class="fas fa-chalkboard-teacher text-blue-400 text-3xl mb-4"></i>
                        <h3 class="text-xl font-bold mb-3">Educate</h3>
                        <p class="text-white/80 text-sm">Share your expertise with our community</p>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row justify-center gap-6">
             
                    <a href="/contact" class="btn-professional glass-card text-white font-bold py-4 px-10 rounded-3xl text-lg border border-white/30 inline-flex items-center justify-center">
                        <i class="fas fa-envelope mr-3 text-xl"></i>
                        <span>Contact Us</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="py-24 section-bg-pattern bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16 fade-in-up">
            <h2 class="text-5xl md:text-7xl font-black text-gray-800 mb-8">
                <span class="text-gradient-advanced">Our Partners</span>
            </h2>
            <div class="flex justify-center mb-8">
                <div class="w-32 h-2 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="glass-card card-hover-effect rounded-3xl p-12 bg-white/10 backdrop-filter backdrop-blur-20 border border-white/20 fade-in-up">
            <p class="text-gray-700 leading-relaxed mb-12 text-center text-lg max-w-3xl mx-auto">
                We are proud to work with a range of leading organizations and institutions that share our vision and values in creating a better educational future for children.
            </p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="glass-card card-hover-effect rounded-2xl p-6 flex items-center justify-center bg-white/50 border border-white/30">
                    <img src="{{ asset('https://d2az9qivg16qd4.cloudfront.net/s3fs-public/Ministry%20of%20Education%20Logo-01_0.png') }}" 
                         alt="Ministry of Education" 
                         class="max-h-16 w-auto grayscale hover:grayscale-0 transition duration-500 image-hover-effect">
                </div>
                <div class="glass-card card-hover-effect rounded-2xl p-6 flex items-center justify-center bg-white/50 border border-white/30">
                    <img src="{{ asset('https://grc-jordan.org/wp-content/uploads/2022/08/Ministry-of-Environment.png') }}" 
                         alt="Ministry of Environment" 
                         class="max-h-16 w-auto grayscale hover:grayscale-0 transition duration-500 image-hover-effect">
                </div>
                <div class="glass-card card-hover-effect rounded-2xl p-6 flex items-center justify-center bg-white/50 border border-white/30">
                    <img src="{{ asset('https://amman.clustermappinginitiative.org/sites/default/files/The%20Children%27s%20Museum%20Jordan.png') }}" 
                         alt="The Children's Museum Jordan" 
                         class="max-h-16 w-auto grayscale hover:grayscale-0 transition duration-500 image-hover-effect">
                </div>
                <div class="glass-card card-hover-effect rounded-2xl p-6 flex items-center justify-center bg-white/50 border border-white/30">
                    <img src="{{ asset('https://media.licdn.com/dms/image/v2/D4E0BAQGyMJr7YeYu_Q/company-logo_200_200/B4EZZTBtcgHYAM-/0/1745149681356/orange_jordan_logo?e=1755734400&v=beta&t=Bn81SUJzdbnSYsp-JoJe6v54lX0MAEg3eBvKBFezNDE') }}" 
                         alt="Orange Platform" 
                         class="max-h-16 w-auto grayscale hover:grayscale-0 transition duration-500 image-hover-effect">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Smooth scrolling for anchor links
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

    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);

    // Observe all fade-in elements
    document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right').forEach(el => {
        observer.observe(el);
    });

    // Lazy loading for images
    if ('loading' in HTMLImageElement.prototype) {
        const images = document.querySelectorAll('img[loading="lazy"]');
        images.forEach(img => {
            if (img.dataset.src) {
                img.src = img.dataset.src;
            }
        });
    } else {
        // Fallback for browsers that don't support lazy loading
        const lazyImages = document.querySelectorAll('img[data-src]');
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        lazyImages.forEach(img => imageObserver.observe(img));
    }

    // Add scroll-based parallax effect for floating elements
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.floating-element');
        
        parallaxElements.forEach((element, index) => {
            const speed = 0.5 + (index * 0.1);
            const yPos = -(scrolled * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
    });

    // Enhanced button hover effects
    document.querySelectorAll('.btn-professional').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.05)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Team card interaction effects
    document.querySelectorAll('.team-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) scale(1.02) rotateY(5deg)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1) rotateY(0deg)';
        });
    });

    // Add dynamic stars
    function createStar() {
        const star = document.createElement('div');
        star.className = 'star';
        star.style.left = Math.random() * 100 + '%';
        star.style.top = Math.random() * 100 + '%';
        star.style.animationDelay = Math.random() * 4 + 's';
        return star;
    }

    // Add more stars dynamically
    document.querySelectorAll('.stars').forEach(starsContainer => {
        for (let i = 0; i < 10; i++) {
            starsContainer.appendChild(createStar());
        }
    });

    // Performance optimization: Debounce scroll events
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Apply debounce to scroll handler
    const debouncedScrollHandler = debounce(() => {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.floating-element');
        
        parallaxElements.forEach((element, index) => {
            const speed = 0.5 + (index * 0.1);
            const yPos = -(scrolled * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
    }, 10);

    window.addEventListener('scroll', debouncedScrollHandler);
</script>
@endsection      
      