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

        .workshop-image {
            height: 200px;
            overflow: hidden;
        }

        .workshop-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .workshop-card:hover .workshop-image img {
            transform: scale(1.1);
        }

        .event-card {
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
    </style>

    <!-- Hero Section -->
    <section class="animated-bg py-24 text-white relative">
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16 fade-in-up">
                <h1 class="text-5xl md:text-7xl font-black mb-8">
                    <span class="text-white">Our</span>
                    <span class="text-gradient-advanced">Workshops</span>
                </h1>
                <p class="text-xl max-w-3xl mx-auto">
                    Explore our complete collection of creative workshops designed to inspire and educate children through
                    hands-on learning experiences.
                </p>
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
                                <img src="{{ asset('images/workshopImg' . ($loop->iteration % 3 + 1) . '.png') }}"
                                    alt="{{ $workshop->name_en }}" class="w-full h-full object-cover">
                            </div>
                            <div class="md:w-2/3 p-6 md:p-8">
                                <div class="flex flex-wrap justify-between items-start mb-4">
                                    <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $workshop->name_en }}</h2>
                                    <span class="badge bg-purple-100 text-purple-800">{{ $workshop->target_age_group }}</span>
                                </div>

                                <p class="text-gray-600 mb-6">{{ $workshop->description_en }}</p>

                                <div class="flex flex-wrap gap-4 mb-6">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-gray-700">Duration: {{ $workshop->duration_hours ?? 2 }} hours</span>
                                    </div>

                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <span class="text-gray-700">{{ $workshop->category ?? 'Creative Workshop' }}</span>
                                    </div>
                                </div>

                                <!-- Upcoming Events Section -->
                                <div class="mt-6">
                                    <h3 class="text-xl font-bold text-gray-800 mb-4">Upcoming Events</h3>

                                    @if($workshop->events->isNotEmpty())
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach($workshop->events->take(4) as $event)
                                                <div class="event-card bg-gray-50 p-4 border border-gray-100">
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
                                                            {{ $event->current_attendees }}/{{ $event->max_attendees }} registered
                                                        </span>

                                                        @if($event->is_open_for_registration)
                                                            <a href="{{ route('workshops.register.form', $event) }}"
                                                                class="btn-professional bg-purple-600 text-white px-4 py-2 rounded-full text-sm hover:bg-purple-700 transition-colors">
                                                                Register
                                                            </a>
                                                        @else
                                                            <span class="text-sm text-gray-500 italic">Registration closed</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        @if($workshop->events->count() > 4)
                                            <div class="mt-4 text-center">
                                                <span class="text-sm text-gray-500">
                                                    +{{ $workshop->events->count() - 4 }} more events available
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
                        <h3 class="text-2xl font-bold mb-4">No workshops available at the moment</h3>
                        <p class="text-gray-600">Please check back soon for new workshop announcements.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-16 bg-purple-700 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Interested in our workshops?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto">
                Register your interest and we'll notify you when new workshops and events become available.
            </p>
            <button type="button"
                class="btn-professional bg-white text-purple-700 px-8 py-3 rounded-full font-bold text-lg hover:bg-opacity-90"
                onclick="openRegistrationModal()">
                Register Interest
            </button>
        </div>
    </section>

    <script>
        function openRegistrationModal(eventId = null, workshopTitle = 'Workshop Interest') {
            // Set the workshop title in the modal
            document.getElementById('modalWorkshopTitle').innerText = workshopTitle;

            // Set the workshop ID in the hidden input if provided
            if (eventId) {
                document.getElementById('modalWorkshopId').value = eventId;
            } else {
                document.getElementById('modalWorkshopId').value = '';
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