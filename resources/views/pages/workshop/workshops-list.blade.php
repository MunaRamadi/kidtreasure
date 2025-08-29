@extends('layouts.app')

@section('title', 'All Workshops - Children\'s Treasures')

@section('description', 'Explore our complete collection of Treasure and Creativity workshops for children - fostering creativity and environmental awareness through engaging educational activities.')

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

        /* Success Message Styles */
        .success-message {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(56, 249, 215, 0.3);
            animation: fadeInDown 0.5s ease-out forwards, fadeOut 0.5s ease-in forwards 5s;
            position: fixed;
            top: 100px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            max-width: 90%;
            width: auto;
        }

        /* Workshop image styles for list view */
        .workshop-card .workshop-image {
            overflow: hidden;
            min-height: 300px;
            position: relative;
            background-color: rgba(0, 0, 0, 0.05);
        }

        .workshop-card .workshop-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform 0.5s ease;
        }

        @media (max-width: 768px) {
            .workshop-card .workshop-image {
                height: 240px;
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate(-50%, -20px);
            }

            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
                visibility: hidden;
            }
        }

        /* Workshop Card Styles */
        .workshop-card {
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .workshop-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .event-card {
            padding: 1rem;
            width: 30rem;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Badge Styles */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Animated Background */
        .animated-bg {
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Form Input Group Styles */
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

        /* Register Button Styles */
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

    <!-- Success Message -->
    @if(session('success'))
        <div class="success-message px-6 py-4 text-white font-medium shadow-lg">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="animated-bg py-24 text-white relative">
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16 fade-in-up">
                <h1 class="text-5xl md:text-7xl font-black mb-8">
                    <span class="text-white">{{ __('workshops.our_workshops') }}</span>
                </h1>
                <p class="text-xl max-w-3xl mx-auto">
                    {{ __('workshops.explore_workshops') }}
                </p>
                <div class="mt-8">
                    <a href="{{ route('workshops.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 rounded-full shadow-lg hover:bg-indigo-600 hover:text-white transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span>Back to Workshop Page</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Workshops Listing Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($workshops as $workshop)
                    <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-xl overflow-hidden shadow-2xl">
                        <div class="relative h-48 overflow-hidden">
                            @if($workshop->image)
                                <img src="{{ asset('storage/' . $workshop->image) }}" 
                                    alt="{{ app()->getLocale() == 'en' ? $workshop->name_en : $workshop->name_ar }}" 
                                    class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('images/default-workshop.jpg') }}" 
                                    alt="{{ app()->getLocale() == 'en' ? $workshop->name_en : $workshop->name_ar }}" 
                                    class="w-full h-full object-cover">
                            @endif
                            <div class="absolute top-0 right-0 mt-4 mr-4">
                                <span class="inline-block bg-purple-500 bg-opacity-80 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $workshop->target_age_group }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 text-gray-800">
                                {{ app()->getLocale() == 'en' ? $workshop->name_en : $workshop->name_ar }}
                            </h3>
                            
                            <p class="text-gray-600 mb-4 h-20 overflow-hidden">
                                {{ \Illuminate\Support\Str::limit(app()->getLocale() == 'en' ? $workshop->description_en : $workshop->description_ar, 120) }}
                            </p>
                            
                            <div class="flex flex-wrap gap-4 mb-4">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm text-gray-600">{{ $workshop->events->count() }} Events</span>
                                </div>
                                
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span class="text-sm text-gray-600">{{ $workshop->events->sum(function($event) { return $event->registrations->count(); }) ?? 0 }} Participants</span>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex justify-between items-center">
                                <a href="{{ route('workshops.show', $workshop->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-purple-800 bg-white border border-purple-200 rounded-full  transition-colors">
                                    {{ __('Details') }}
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                    </svg>
                                </a>
                                
                                @if($workshop->events->where('is_open_for_registration', true)->count() > 0)
                                    <a href="{{ route('workshops.show', $workshop->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-purple-600 rounded-full hover:bg-purple-700 transition-colors">
                                        {{ __('Register') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <h3 class="text-2xl font-bold mb-4">{{ __('workshops.no_workshops_available') }}</h3>
                        <p class="text-gray-600">{{ __('workshops.check_back_soon') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Registration Modal -->
    <div id="registrationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-gray-100 rounded-3xl shadow-2xl max-w-4xl w-full mx-4 md:mx-auto max-h-[90vh] overflow-y-auto">
            <div class="p-6 md:p-10">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-3xl font-bold text-gray-800" id="modalWorkshopTitle">{{ __('workshops.register_interest') }}</h3>
                    <button type="button" onclick="closeRegistrationModal()" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form id="registrationForm" action="{{ route('workshops.register', ['event' => 0]) }}" method="POST"
                    class="space-y-6">
                    @csrf
                    <input type="hidden" name="event_id" id="modalWorkshopId">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-input-group">
                            <input type="text" name="parent_name"
                                class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white "
                                placeholder="{{ __('workshops.parent_name') }}" required>
                        </div>

                        <div class="form-input-group">
                            <input type="tel" name="parent_contact"
                                class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white text-gray-800"
                                placeholder="{{ __('workshops.parent_phone') }}" required>
                        </div>

                        <div class="form-input-group">
                            <input type="text" name="attendee_name"
                                class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white text-gray-800"
                                placeholder="{{ __('workshops.child_name') }}" required>
                        </div>
                    </div>

                    <div class="form-input-group">
                        <textarea name="special_requirements"
                            class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white text-gray-800"
                            placeholder="{{ __('workshops.special_requirements') }}" rows="4"></textarea>
                    </div>


                    <div class="mt-8">
                        <button type="submit" class="register-btn btn-professional w-full">
                            {{ __('workshops.register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRegistrationModal(workshopId, workshopTitle) {
            document.getElementById('modalWorkshopId').value = workshopId;
            document.getElementById('modalWorkshopTitle').textContent = '{{ __('workshops.register_for') }}'.replace(':title', workshopTitle);

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
@endsection