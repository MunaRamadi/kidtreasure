@extends('layouts.app')

@section('title', 'Contact Us')

@section('meta')
    <meta name="description" content="تواصل معنا للحصول على الدعم أو لأي استفسارات. نحن هنا لمساعدتك في أي وقت.">
    <meta name="keywords" content="تواصل, دعم, استفسارات, خدمة العملاء">
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

    /* Form Styling */
    .form-input-glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        transition: all 0.3s ease;
    }

    .form-input-glass:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
    }

    .form-input-glass::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    /* Success Message */
    .success-message-glass {
        background: rgba(16, 185, 129, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    /* Error Message */
    .error-message {
        background: rgba(239, 68, 68, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
</style>

<section class="animated-bg min-h-screen py-20 relative overflow-hidden">
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-12 relative z-10">
        <div class="text-center mb-16 fade-in-up">
            <h1 class="text-5xl md:text-7xl font-black text-white mb-6">
                <span class="text-gradient-advanced">Contact Us</span>
            </h1>
            <div class="flex justify-center mb-8">
                <div class="w-32 h-2 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-full"></div>
            </div>
            <p class="text-xl md:text-2xl text-white/90 leading-relaxed max-w-3xl mx-auto">
                We are here to listen to you. Share your thoughts and inquiries with us, and we will be happy to respond as soon as possible.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
            <div class="glass-card card-hover-effect rounded-3xl p-8 lg:p-10 fade-in-left">
                @if(session('success'))
                    <div class="success-message-glass rounded-2xl p-6 mb-8 relative overflow-hidden">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 ml-3">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-green-100 font-semibold text-lg mb-1">Message sent successfully!</h3>
                                <p class="text-green-50">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6" novalidate>
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label for="sender_name" class="block text-sm font-semibold text-white/90 mb-2">
                                Full Name <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                        id="sender_name" 
                                        name="sender_name" 
                                        value="{{ old('sender_name') }}"
                                        class="w-full px-4 py-3 form-input-glass rounded-xl text-white @error('sender_name') border-red-400 @enderror"
                                        placeholder="Enter your full name"
                                        required>
                                @error('sender_name')
                                    <p class="mt-2 text-sm text-red-300 flex items-center">
                                        <svg class="w-4 h-4 ml-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sender_email" class="block text-sm font-semibold text-white/90 mb-2">
                                Email Address <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="email" 
                                        id="sender_email" 
                                        name="sender_email" 
                                        value="{{ old('sender_email') }}"
                                        class="w-full px-4 py-3 form-input-glass rounded-xl text-white @error('sender_email') border-red-400 @enderror"
                                        placeholder="example@email.com"
                                        required>
                                @error('sender_email')
                                    <p class="mt-2 text-sm text-red-300 flex items-center">
                                        <svg class="w-4 h-4 ml-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label for="sender_phone" class="block text-sm font-semibold text-white/90 mb-2">
                                Phone Number
                            </label>
                            <div class="relative">
                                <input type="tel" 
                                        id="sender_phone" 
                                        name="sender_phone" 
                                        value="{{ old('sender_phone') }}"
                                        class="w-full px-4 py-3 form-input-glass rounded-xl text-white @error('sender_phone') border-red-400 @enderror"
                                        placeholder="+962 7X XXX XXXX">
                                @error('sender_phone')
                                    <p class="mt-2 text-sm text-red-300 flex items-center">
                                        <svg class="w-4 h-4 ml-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="subject" class="block text-sm font-semibold text-white/90 mb-2">
                                Subject
                            </label>
                            <div class="relative">
                                <input type="text" 
                                        id="subject" 
                                        name="subject" 
                                        value="{{ old('subject') }}"
                                        class="w-full px-4 py-3 form-input-glass rounded-xl text-white @error('subject') border-red-400 @enderror"
                                        placeholder="Message Subject">
                                @error('subject')
                                    <p class="mt-2 text-sm text-red-300 flex items-center">
                                        <svg class="w-4 h-4 ml-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message" class="block text-sm font-semibold text-white/90 mb-2">
                            Message <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <textarea id="message" 
                                      name="message" 
                                      rows="6"
                                      class="w-full px-4 py-3 form-input-glass rounded-xl text-white resize-none @error('message') border-red-400 @enderror"
                                      placeholder="Write your message here... Share the details of your inquiry or suggestion"
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-2 text-sm text-red-300 flex items-center">
                                    <svg class="w-4 h-4 ml-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full btn-professional bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 text-white font-bold py-4 px-8 rounded-xl hover:from-blue-700 hover:via-purple-700 hover:to-indigo-700 transform hover:scale-[1.02] transition-all duration-300 shadow-lg hover:shadow-xl text-lg relative overflow-hidden group">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <span class="relative flex items-center justify-center">
                                <svg class="w-6 h-6 ml-2 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Send Message
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-6 fade-in-right">
                <div class="glass-card card-hover-effect rounded-3xl p-8">
                    <h3 class="text-2xl font-bold text-white mb-6">Contact Information</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4 space-x-reverse group">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white mb-1">Address</h4>
                                <p class="text-white/80 leading-relaxed">Amman, Jordan<br>King Abdullah II Street</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 space-x-reverse group">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white mb-1">Phone</h4>
                                <p class="text-white/80" dir="ltr">+962 7 9779 3944</p>
                                <p class="text-sm text-white/60">Available 24/7</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 space-x-reverse group">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white mb-1">Email</h4>
                                <p class="text-white/80">munaramadi@yahoo.com</p>
                                <p class="text-sm text-white/60">Reply within 1 hour</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 space-x-reverse group">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white mb-1">Working Hours</h4>
                                <p class="text-white/80">Sunday - Thursday</p>
                                <p class="text-sm text-white/60">9:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-card card-hover-effect rounded-3xl p-8">
                    <h3 class="text-2xl font-bold text-white mb-6">Frequently Asked Questions</h3>
                    
                    <div class="space-y-4">
                        <div class="p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-colors duration-300 cursor-pointer group">
                            <h4 class="font-semibold text-white group-hover:text-blue-300 transition-colors duration-300">How long does it take to reply to an inquiry?</h4>
                            <p class="text-sm text-white/80 mt-2">We reply to all inquiries within a maximum of 24 hours.</p>
                        </div>
                        
                        <div class="p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-colors duration-300 cursor-pointer group">
                            <h4 class="font-semibold text-white group-hover:text-blue-300 transition-colors duration-300">Can I contact you by phone?</h4>
                            <p class="text-sm text-white/80 mt-2">Yes, phone service is available 24/7 for your convenience.</p>
                        </div>
                        
                        <div class="p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-colors duration-300 cursor-pointer group">
                            <h4 class="font-semibold text-white group-hover:text-blue-300 transition-colors duration-300">Is my data protected?</h4>
                            <p class="text-sm text-white/80 mt-2">Yes, we protect all personal data with the highest security standards.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4">
                    Why Choose Us?
                </h2>
                <p class="text-gray-600 text-lg leading-relaxed max-w-2xl mx-auto">
                    We are committed to providing the best customer service and ensuring your complete comfort and satisfaction.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Fast Response</h3>
                    <p class="text-gray-600">We respond to all inquiries within 24 hours.</p>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Total Security</h3>
                    <p class="text-gray-600">Your data is protected with the highest security standards.</p>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Specialized Team</h3>
                    <p class="text-gray-600">A team of experts is ready to assist you.</p>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Always Available</h3>
                    <p class="text-gray-600">Customer service is available 24 hours a day.</p>
                </div>
            </div>
        </div>
    </div>
</section>



<script>
    // Smooth scrolling for anchor links
    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.querySelector('form');
        if (contactForm) {
            contactForm.setAttribute('id', 'contact-form');
        }

        // Add smooth scroll behavior for anchor links
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

        // Form validation enhancement
        const form = document.querySelector('#contact-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('border-red-400');
                    } else {
                        field.classList.remove('border-red-400');
                    }
                });

                // Email validation
                const emailField = form.querySelector('input[type="email"]');
                if (emailField && emailField.value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(emailField.value)) {
                        isValid = false;
                        emailField.classList.add('border-red-400');
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    // Show error message
                    const firstError = form.querySelector('.border-red-400');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.focus();
                    }
                }
            });
        }

        // Add loading state to submit button
        const submitBtn = document.querySelector('button[type="submit"]');
        if (submitBtn && form) {
            form.addEventListener('submit', function() {
                if (form.checkValidity()) {
                    submitBtn.innerHTML = `
                        <svg class="animate-spin w-6 h-6 ml-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        جاري الإرسال...
                    `;
                    submitBtn.disabled = true;
                }
            });
        }

        // FAQ accordion functionality
        const faqItems = document.querySelectorAll('.glass-card .space-y-4 > div');
        faqItems.forEach(item => {
            item.addEventListener('click', function() {
                const content = this.querySelector('p');
                const isExpanded = content.style.maxHeight && content.style.maxHeight !== '0px';
                
                // Close other FAQ items
                faqItems.forEach(otherItem => {
                    if (otherItem !== this) {
                        const otherContent = otherItem.querySelector('p');
                        otherContent.style.maxHeight = '0px';
                        otherContent.style.opacity = '0';
                        otherItem.classList.remove('bg-white/20');
                    }
                });

                // Toggle current item
                if (isExpanded) {
                    content.style.maxHeight = '0px';
                    content.style.opacity = '0';
                    this.classList.remove('bg-white/20');
                } else {
                    content.style.maxHeight = content.scrollHeight + 'px';
                    content.style.opacity = '1';
                    this.classList.add('bg-white/20');
                }
            });
        });

        // Initialize FAQ items
        faqItems.forEach(item => {
            const content = item.querySelector('p');
            content.style.transition = 'max-height 0.3s ease, opacity 0.3s ease';
            content.style.maxHeight = content.scrollHeight + 'px';
            content.style.opacity = '1';
        });
    });

    // Add intersection observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);

    // Observe elements for animation
    document.addEventListener('DOMContentLoaded', function() {
        const animatedElements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right');
        animatedElements.forEach(el => observer.observe(el));
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out forwards;
    }

    /* Enhanced button hover effects */
    .btn-professional:active {
        transform: translateY(-2px) rotateX(5deg);
    }

    /* Improved mobile responsiveness */
    @media (max-width: 640px) {
        .text-5xl {
            font-size: 2.5rem;
        }
        
        .text-7xl {
            font-size: 3rem;
        }
        
        .glass-card {
            margin: 0 1rem;
        }
        
        .floating-element {
            display: none;
        }
    }

    /* Print styles */
    @media print {
        .animated-bg,
        .floating-elements,
        .btn-professional {
            background: white !important;
            color: black !important;
        }
        
        .glass-card {
            border: 1px solid #ccc !important;
            background: white !important;
        }
    }

    /* High contrast mode support */
    @media (prefers-contrast: high) {
        .form-input-glass {
            background: white;
            color: black;
            border: 2px solid black;
        }
        
        .text-white {
            color: black;
        }
        
        .glass-card {
            background: white;
            color: black;
            border: 2px solid black;
        }
    }

    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
        .floating-element,
        .pulse-advanced,
        .text-gradient-advanced {
            animation: none;
        }
        
        .btn-professional:hover {
            transform: none;
        }
        
        .card-hover-effect:hover {
            transform: none;
        }
    }
</style>
@endsection