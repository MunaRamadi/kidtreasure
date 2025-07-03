<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Children's Treasures - Register</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

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
        transition: all 0.4s ease;
    }

    /* Professional Input Fields */
    .input-professional {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        transition: all 0.4s ease;
        color: #374151;
    }

    .input-professional:focus {
        background: rgba(255, 255, 255, 0.95);
        border-color: rgba(102, 126, 234, 0.8);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
        transform: translateY(-2px);
    }

    .input-professional::placeholder {
        color: #9CA3AF;
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

    /* Loading and Animation Effects */
    .fade-in-up {
        animation: fadeInUp 1s ease-out;
    }

    .fade-in-scale {
        animation: fadeInScale 1s ease-out 0.3s both;
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

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
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

    /* Link Styling */
    .link-professional {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        position: relative;
        transition: all 0.3s ease;
    }

    .link-professional:hover {
        color: white;
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }

    .link-professional::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        transition: width 0.3s ease;
    }

    .link-professional:hover::after {
        width: 100%;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .floating-element {
            width: 40px !important;
            height: 40px !important;
        }
        
        .glass-card {
            margin: 1rem;
        }
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
    
    <div class="max-w-7xl mx-auto px-6 py-20 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1 fade-in-scale">
                <div class="glass-card rounded-3xl p-8 md:p-12 max-w-md mx-auto lg:mx-0 pulse-advanced">
                    <div class="text-center mb-8">
                        <h1 class="text-4xl md:text-5xl font-black mb-4">
                            <span class="text-gradient-advanced">Create a New Account</span>
                        </h1>
                        <p class="text-white/90 text-lg">
                            Join the Children's Treasures family and start your journey
                        </p>
                        <div class="flex justify-center mt-6">
                            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-full"></div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="sr-only">{{ __('Name') }}</label>
                            <div class="relative">
                                <x-text-input id="name" 
                                              class="input-professional w-full rounded-2xl p-4 pr-12 text-sm shadow-2xl"
                                              type="text" 
                                              name="name" 
                                              :value="old('name')" 
                                              required 
                                              autofocus 
                                              autocomplete="name" 
                                              placeholder="Enter full name" />

                                <span class="absolute inset-y-0 right-0 grid place-content-center px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                         class="h-5 w-5 text-gray-500" 
                                         fill="none" 
                                         viewBox="0 0 24 24" 
                                         stroke="currentColor">
                                        <path stroke-linecap="round" 
                                              stroke-linejoin="round" 
                                              stroke-width="2" 
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-300" />
                        </div>

                        <div>
                            <label for="email" class="sr-only">{{ __('Email') }}</label>
                            <div class="relative">
                                <x-text-input id="email" 
                                              class="input-professional w-full rounded-2xl p-4 pr-12 text-sm shadow-2xl"
                                              type="email" 
                                              name="email" 
                                              :value="old('email')" 
                                              required 
                                              autocomplete="username" 
                                              placeholder="Enter email address" />

                                <span class="absolute inset-y-0 right-0 grid place-content-center px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                         class="h-5 w-5 text-gray-500" 
                                         fill="none" 
                                         viewBox="0 0 24 24" 
                                         stroke="currentColor">
                                        <path stroke-linecap="round" 
                                              stroke-linejoin="round" 
                                              stroke-width="2" 
                                              d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
                        </div>

                        <div>
                            <label for="password" class="sr-only">{{ __('Password') }}</label>
                            <div class="relative">
                                <x-text-input id="password"
                                              class="input-professional w-full rounded-2xl p-4 pr-12 text-sm shadow-2xl"
                                              type="password"
                                              name="password"
                                              required
                                              autocomplete="new-password"
                                              placeholder="Enter password" />

                                <span class="absolute inset-y-0 right-0 grid place-content-center px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                         class="h-5 w-5 text-gray-500" 
                                         fill="none" 
                                         viewBox="0 0 24 24" 
                                         stroke="currentColor">
                                        <path stroke-linecap="round" 
                                              stroke-linejoin="round" 
                                              stroke-width="2" 
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" 
                                              stroke-linejoin="round" 
                                              stroke-width="2" 
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
                        </div>

                        <div>
                            <label for="password_confirmation" class="sr-only">{{ __('Confirm Password') }}</label>
                            <div class="relative">
                                <x-text-input id="password_confirmation"
                                              class="input-professional w-full rounded-2xl p-4 pr-12 text-sm shadow-2xl"
                                              type="password"
                                              name="password_confirmation"
                                              required
                                              autocomplete="new-password"
                                              placeholder="Confirm password" />

                                <span class="absolute inset-y-0 right-0 grid place-content-center px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                         class="h-5 w-5 text-gray-500" 
                                         fill="none" 
                                         viewBox="0 0 24 24" 
                                         stroke="currentColor">
                                        <path stroke-linecap="round" 
                                              stroke-linejoin="round" 
                                              stroke-width="2" 
                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-300" />
                        </div>

                        <div class="space-y-4">
                            <x-primary-button class="btn-professional w-full justify-center bg-gradient-to-r from-green-400 via-blue-500 to-purple-600 hover:from-green-500 hover:via-blue-600 hover:to-purple-700 text-white font-bold py-4 px-8 rounded-2xl text-lg shadow-2xl border-0">
                                <i class="fas fa-user-plus mr-2"></i>
                                {{ __('Register') }}
                            </x-primary-button>

                            <div class="text-center">
                                <p class="text-white/80">
                                    Already have an account?
                                    <a class="link-professional font-semibold" href="{{ route('login') }}">
                                        Log in
                                    </a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="order-1 lg:order-2 fade-in-up">
                <div class="text-center lg:text-left">
                    <h2 class="text-5xl md:text-7xl font-black mb-8 leading-tight">
                        <span class="block text-white drop-shadow-2xl">Join</span>
                        <span class="block text-gradient-advanced text-6xl md:text-8xl">Children's Treasures</span>
                        <span class="block text-white text-3xl md:text-4xl font-bold mt-6 drop-shadow-lg">and Start the Adventure</span>
                    </h2>
                    
                    <p class="text-xl md:text-2xl mb-12 leading-relaxed text-white/95 font-light">
                        Discover a new world of learning and creativity, and become part of a community that cares about our children's future.
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12">
                        <div class="glass-card rounded-2xl p-6 text-center">
                            <div class="bg-gradient-to-br from-pink-500 via-red-500 to-yellow-500 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <i class="fas fa-child text-white text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">Fun Learning</h3>
                            <p class="text-white/80 text-sm">Interactive educational programs</p>
                        </div>
                        
                        <div class="glass-card rounded-2xl p-6 text-center">
                            <div class="bg-gradient-to-br from-purple-500 via-pink-500 to-red-500 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <i class="fas fa-heart text-white text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">Safe Environment</h3>
                            <p class="text-white/80 text-sm">A protected space for children</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>