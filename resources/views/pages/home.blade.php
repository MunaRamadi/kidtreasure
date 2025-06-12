@extends('layouts.app')
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
</style>

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
                        <span class="block text-white drop-shadow-2xl">Ignite</span>
                        <span class="block text-gradient-advanced text-6xl md:text-8xl">Creativity</span>
                        <span class="block text-white text-3xl md:text-4xl font-bold mt-6 drop-shadow-lg">Embrace Sustainability</span>
                    </h1>
                </div>
                
                <div class="fade-in-left text-center lg:text-right">
                    <p class="text-xl md:text-2xl mb-12 leading-relaxed text-white/95 font-light">
                        Sustainable educational kits that develop your child's skills and environmental awareness through interactive play and engaging learning.
                    </p>
                </div>
                
                <div class="fade-in-right">
                    <div class="flex flex-col sm:flex-row gap-6 justify-center lg:justify-end">
                        <a href="/products" class="btn-professional bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 hover:from-yellow-500 hover:via-orange-600 hover:to-red-600 text-white font-bold py-4 px-10 rounded-3xl text-lg shadow-2xl inline-flex items-center justify-center pulse-advanced">
                            <i class="fas fa-rocket mr-3 text-xl"></i>
                            <span>Explore Our World</span>
                        </a>
                        <a href="/order" class="btn-professional glass-card text-white font-bold py-4 px-10 rounded-3xl text-lg border border-white/30 inline-flex items-center justify-center">
                            <i class="fas fa-magic mr-3 text-xl"></i>
                            <span>Start the Adventure</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="order-1 lg:order-2 fade-in-up">
                <div class="relative max-w-2xl mx-auto lg:mx-0">
                    <div class="absolute -inset-8 bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 rounded-3xl blur-2xl opacity-70 animate-pulse"></div>
                    <div class="relative">
                        <img src="https://media.istockphoto.com/id/473032112/photo/playful-preschoolers-having-fun-making-faces.jpg?s=612x612&w=0&k=20&c=VdLcY3TFnqmx0Pw0l4aFA-dTezKr1AC2CBgm9GE8heA=" 
                             alt="Children playing and learning" 
                             class="relative rounded-3xl shadow-2xl w-full image-hover-effect">
                        <div class="absolute inset-0 rounded-3xl bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 section-bg-pattern bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16 fade-in-up">
            <h2 class="text-5xl md:text-7xl font-black text-gray-800 mb-8">
                <span class="text-gradient-advanced">Children's Treasures</span>
            </h2>
            <div class="flex justify-center mb-8">
                <div class="w-32 h-2 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-full"></div>
            </div>
            <p class="text-2xl text-gray-700 leading-relaxed max-w-4xl mx-auto font-light">
                A sustainable pioneering project in interactive children's education in Jordan. Our goal is to foster creativity, sustainability, and environmental awareness in children through recycled educational toy kits and interactive workshops that combine fun and benefit.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
            <div class="glass-card card-hover-effect p-10 rounded-3xl transition-all duration-500 fade-in-left">
                <div class="bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700 rounded-3xl w-20 h-20 flex items-center justify-center mx-auto mb-8 shadow-2xl">
                    <i class="fas fa-lightbulb text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Creativity and Innovation</h3>
                <p class="text-gray-600 text-lg leading-relaxed">Developing imagination and innovation through interactive activities designed to spark children's curiosity.</p>
                <div class="mt-6 w-full h-1 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full"></div>
            </div>
            
            <div class="glass-card card-hover-effect p-10 rounded-3xl transition-all duration-500 fade-in-up" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-br from-green-500 via-emerald-600 to-teal-700 rounded-3xl w-20 h-20 flex items-center justify-center mx-auto mb-8 shadow-2xl">
                    <i class="fas fa-leaf text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Environmental Sustainability</h3>
                <p class="text-gray-600 text-lg leading-relaxed">Protecting the environment for the future by using recycled materials and teaching environmental awareness.</p>
                <div class="mt-6 w-full h-1 bg-gradient-to-r from-green-500 to-teal-600 rounded-full"></div>
            </div>
            
            <div class="glass-card card-hover-effect p-10 rounded-3xl transition-all duration-500 fade-in-right" style="animation-delay: 0.4s;">
                <div class="bg-gradient-to-br from-purple-500 via-pink-600 to-rose-700 rounded-3xl w-20 h-20 flex items-center justify-center mx-auto mb-8 shadow-2xl">
                    <i class="fas fa-graduation-cap text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Interactive Education</h3>
                <p class="text-gray-600 text-lg leading-relaxed">Fun and interactive learning that combines play and education to develop essential skills.</p>
                <div class="mt-6 w-full h-1 bg-gradient-to-r from-purple-500 to-rose-600 rounded-full"></div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 animated-bg text-white relative overflow-hidden">
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    
    <div class="max-w-6xl mx-auto px-6 text-center relative z-10">
        <div class="fade-in-up">
            <h2 class="text-5xl md:text-7xl font-black mb-8">Start the Learning Journey Today</h2>
            <p class="text-xl md:text-2xl text-white/95 mb-16 leading-relaxed max-w-4xl mx-auto">
                Choose from our unique collection of sustainable educational tools and discover a world of creativity and fun.
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div class="glass-card card-hover-effect rounded-3xl p-10 border border-white/20 fade-in-left">
                <div class="bg-gradient-to-br from-yellow-400 via-orange-500 to-red-500 rounded-3xl w-24 h-24 flex items-center justify-center mx-auto mb-8 shadow-2xl">
                    <i class="fas fa-telescope text-white text-3xl"></i>
                </div>
                <h3 class="text-3xl font-bold mb-6">Explore the World of Creativity</h3>
                <p class="text-white/90 mb-8 text-lg leading-relaxed">Embark on a discovery journey with our diverse range of innovative and sustainable educational tools.</p>
                <a href="/products" class="btn-professional bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 hover:from-yellow-500 hover:via-orange-600 hover:to-red-600 text-white font-bold py-4 px-10 rounded-2xl text-lg inline-flex items-center">
                    <i class="fas fa-rocket mr-3"></i>
                    <span>Start Exploring</span>
                </a>
            </div>
            
            <div class="glass-card card-hover-effect rounded-3xl p-10 border border-white/20 fade-in-right">
                <div class="bg-gradient-to-br from-green-400 via-emerald-500 to-teal-600 rounded-3xl w-24 h-24 flex items-center justify-center mx-auto mb-8 shadow-2xl">
                    <i class="fas fa-comments text-white text-3xl"></i>
                </div>
                <h3 class="text-3xl font-bold mb-6">Talk to Our Experts</h3>
                <p class="text-white/90 mb-8 text-lg leading-relaxed">Get a free consultation from our specialized team to choose the best solutions for your child.</p>
                <div class="space-y-4">
                    <a href="tel:+962-XXX-XXXX" class="btn-professional bg-gradient-to-r from-green-400 via-emerald-500 to-teal-600 text-white font-bold py-4 px-10 rounded-2xl text-lg inline-flex items-center w-full justify-center">
                        <i class="fas fa-phone mr-3"></i>
                        <span>Call Directly</span>
                    </a>
                    <a href="https://wa.me/962XXXXXXXX" class="btn-professional bg-gradient-to-r from-green-600 via-green-700 to-emerald-800 text-white font-bold py-4 px-10 rounded-2xl text-lg inline-flex items-center w-full justify-center">
                        <i class="fab fa-whatsapp mr-3"></i>
                        <span>WhatsApp Now</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="mt-16 fade-in-up" style="animation-delay: 0.5s;">
            <div class="glass-card rounded-3xl p-8 max-w-3xl mx-auto">
                <h4 class="text-2xl font-bold mb-4">🌟 Our Mission 🌟</h4>
                <p class="text-lg text-white/90 leading-relaxed">
                    We believe that every child deserves an opportunity to learn and play in a sustainable and innovative way. Together, we build a better future for our children and our planet.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection