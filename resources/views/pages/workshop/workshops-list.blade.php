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
            <div class="grid grid-cols-1 gap-16">
                @forelse($workshops as $workshop)
                    <div class="workshop-card bg-white overflow-hidden">
                        <div class="md:flex">
                            <div class="md:w-1/3 workshop-image">
                            @if($workshop->image)
                                    <img src="{{ asset('storage/' . $workshop->image) }}" 
                                        alt="{{ app()->getLocale() == 'en' ? $workshop->name_en : $workshop->name_ar }}" 
                                        class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('images/placeholder-workshop.jpg') }}" 
                                        alt="{{ app()->getLocale() == 'en' ? $workshop->name_en : $workshop->name_ar }}" 
                                        class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="md:w-2/3 p-6 md:p-8">
                                <div class="flex flex-wrap justify-between items-start mb-4">
                                    <h2 class="text-3xl font-bold text-gray-800 mb-2">
                                        {{ app()->getLocale() == 'en' ? $workshop->name_en : $workshop->name_ar }}
                                    </h2>
                                    <span class="badge bg-purple-100 text-purple-800">{{ $workshop->target_age_group }}</span>
                                </div>

                                <p class="text-gray-600 mb-6">
                                    {{ app()->getLocale() == 'en' ? $workshop->description_en : $workshop->description_ar }}
                                </p>

                                <!-- Upcoming Events Section -->
                                <div class="mt-6">
                                    <h3 class="text-xl font-bold text-gray-800 mb-4">Upcoming Events</h3>

                                    @if($workshop->events->isNotEmpty())
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach($workshop->events->take(4) as $event)
                                                <div class="event-card bg-gray-50 border border-gray-100 w-xl">
                                                    <div class="flex justify-between items-center mb-2">
                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600 mr-2"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            <span
                                                                class="text-gray-700 font-medium">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</span>
                                                        </div>
                                                        <span
                                                            class="text-gray-700">{{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</span>
                                                    </div>

                                                    <div class="flex items-center mb-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600 mr-2"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span class="text-gray-700">
                                                            {{ __('workshops.duration_hours', ['hours' => $event->duration_hours ?? 2]) }}
                                                        </span>
                                                    </div>

                                                    <div class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600 mr-2"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        <span class="text-gray-700">
                                                            {{ $event->location }}
                                                        </span>
                                                    </div>

                                                    <div class="mt-4 flex justify-between items-center">
                                                        <span class="text-sm text-gray-500">
                                                            {{ $event->getCurrentAttendeesAttribute() }}/{{ $event->max_attendees }}
                                                            registered
                                                        </span>

                                                        <div class="flex space-x-2">
                                                        <a href="{{ route('workshops.event.show', $event) }}"
                                                                class="btn-professional bg-indigo-600 text-white px-4 py-2 rounded-full text-sm hover:bg-indigo-700 transition-colors">
                                                                {{ __('workshops.details') }}
                                                            </a>

                                                            @php
                                                                $userRegistered = false;
                                                                $registration = null;

                                                                if (auth()->check() && isset($userRegistrations[$event->id])) {
                                                                    $userRegistered = true;
                                                                    $registration = $userRegistrations[$event->id];
                                                                }
                                                            @endphp

                                                            @if($userRegistered)
                                                                <span
                                                                    class="bg-green-500 text-white px-4 py-2 rounded-full font-bold text-sm">
                                                                    {{ __('workshops.registered') }}
                                                                </span>
                                                                <a href="{{ $event->getGoogleCalendarUrl() }}"
                                                                    class="bg-purple-600 text-white px-2 py-2 rounded-full text-sm hover:bg-purple-700 transition-colors flex items-center"
                                                                    target="_blank">
                                                                    {{ __('workshops.add_to_calendar') }}
                                                                </a>
                                                            @elseif($event->is_open_for_registration)
                                                                <button type="button"
                                                                    class="btn-professional bg-purple-700 text-white px-4 py-2 rounded-full font-bold text-sm hover:bg-purple-800"
                                                                    onclick="openRegistrationModal('{{ $event->id }}', '{{ $event->title }}')">
                                                                    {{ __('workshops.register_now') }}
                                                                </button>
                                                            @else
                                                                <span class="text-sm text-gray-500 italic">{{ __('workshops.registration_closed') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        @if($workshop->events->count() > 4)
                                            <div class="mt-4 text-center">
                                                <span class="text-sm text-gray-500">
                                                    {{ __('workshops.more_events_available', ['count' => $workshop->events->count() - 4]) }}
                                                </span>
                                            </div>
                                        @endif
                                    @else
                                        <p class="text-gray-500 italic">No upcoming events scheduled for this workshop.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
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