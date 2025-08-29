@extends('layouts.app')

@section('title', $event->title . ' - Children\'s Treasures')

@section('description', 'Details for ' . $event->title . ' - ' . Str::limit(strip_tags($event->description), 150))

@section('content')
    <style>
        /* Register Button Styles */
        .register-btn {
            width: 100%;
            padding: 1rem;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        .btn-professional {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('workshops.show', $event->workshop->id) }}" class="flex items-center text-purple-600 hover:text-purple-800">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span>Go Back</span>
                    </a>
                </li>
                <li class="inline-flex items-center">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('home') }}" class="ml-1 text-gray-700 hover:text-purple-600">
                            <span>Home</span>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('workshops.index') }}"
                            class="ml-1 text-gray-700 hover:text-purple-600 md:ml-2">Workshops</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('workshops.show', $event->workshop->id) }}"
                            class="ml-1 text-gray-700 hover:text-purple-600 md:ml-2">{{ $event->workshop->name_en }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-500 md:ml-2">{{ $event->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Column: Event Image and Details -->
            <div class="w-full lg:w-2/3">
                <!-- Event Header -->
                <div class="bg-white rounded-lg shadow-lg mb-8">
                    <!-- Image Display - Similar to first image -->
                    <div class="relative">
                        @if($event->image_path)
                            <div class="relative h-96 overflow-hidden rounded-lg">
                                <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @elseif($event->featured_image_path)
                            <div class="relative h-96 overflow-hidden rounded-lg">
                                <img src="{{ asset('storage/' . $event->featured_image_path) }}" alt="{{ $event->title }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @elseif($event->workshop && $event->workshop->image_path)
                            <div class="relative h-96 overflow-hidden rounded-lg">
                                <img src="{{ asset('storage/' . $event->workshop->image_path) }}" alt="{{ $event->title }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="relative h-96 overflow-hidden rounded-lg">
                                <img src="{{ asset('images/default-workshop.jpg') }}" alt="{{ $event->title }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @endif

                        <!-- Workshop Type Badge -->
                        <div class="absolute top-6 left-6">
                            <span class="bg-purple-600 text-white text-sm px-3 py-1 rounded-full">{{ $event->workshop->name_en }}</span>
                        </div>
                    </div>

                    <div class="p-6 md:p-8">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $event->title }}</h1>

                        <!-- Event Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="flex items-center">
                                <div class="bg-purple-100 rounded-full p-3 mr-4">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-500">Date</p>
                                    <p class="font-medium">{{ $event->event_date->format('F j, Y') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="bg-indigo-100 rounded-full p-3 mr-4">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-500">Time</p>
                                    <p class="font-medium">{{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="bg-green-100 rounded-full p-3 mr-4">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-500">Duration</p>
                                    <p class="font-medium">{{ $event->duration_hours }}
                                        {{ $event->duration_hours == 1 ? 'hour' : 'hours' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="bg-yellow-100 rounded-full p-3 mr-4">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0zM7 10a2 2 0 11-4 0 2 2 0 014 0zM7 10H1"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-500">Location</p>
                                    <p class="font-medium">{{ $event->location }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="bg-red-100 rounded-full p-3 mr-4">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-500">Price</p>
                                    <p class="font-medium">{{ $event->price_jod }} JOD</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="bg-purple-100 rounded-full p-3 mr-4">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-500">Calendar</p>
                                    <a href="{{ $event->getGoogleCalendarUrl() }}" 
                                       class="inline-flex items-center px-3 py-1 bg-purple-600 text-white text-sm font-medium rounded-md hover:bg-purple-700" 
                                       target="_blank">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add to Calendar
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-full p-3 mr-4">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-500">Attendees</p>
                                    <p class="font-medium">{{ $event->getCurrentAttendeesAttribute() }}/{{ $event->max_attendees }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Event Description -->
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">About This Event</h2>
                            <div class="prose max-w-none">
                                {!! $event->description !!}
                            </div>
                        </div>

                        <!-- Gallery Images Section -->
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">Gallery</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @if($event->gallery_images && is_array($event->gallery_images) && count($event->gallery_images) > 0)
                                    @foreach($event->gallery_images as $index => $image)
                                        <div class="overflow-hidden rounded-lg shadow-md">
                                            <img src="{{ asset('storage/' . $image) }}" alt="Event Gallery Image" 
                                                class="w-full h-40 object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                                                onclick="openLightbox({{ $index }}, 'event')">
                                        </div>
                                    @endforeach
                                @elseif($event->workshop && $event->workshop->gallery_images && is_array($event->workshop->gallery_images) && count($event->workshop->gallery_images) > 0)
                                    @foreach($event->workshop->gallery_images as $index => $image)
                                        <div class="overflow-hidden rounded-lg shadow-md">
                                            <img src="{{ asset('storage/' . $image) }}" alt="Workshop Gallery Image" 
                                                class="w-full h-40 object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                                                onclick="openLightbox({{ $index }}, 'workshop')">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-span-full text-center py-8 text-gray-500">
                                        <p>No gallery images available for this event.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Age Group -->
                        @if($event->age_group)
                            <div class="mb-8">
                                <h2 class="text-2xl font-bold text-gray-800 mb-4">Target Age Group</h2>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p>{{ $event->age_group }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Registration Section -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-200 sticky top-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Registration</h2>

                    @if(isset($userRegistered) && $userRegistered && $registration && $registration->status != 'cancelled')
                        <div class="flex items-center mb-4">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-green-600 font-medium">You are registered for this event</span>
                        </div>

                        @if($registration && $registration->status)
                            <div class="mt-2 mb-4 p-3 bg-blue-50 rounded-lg">
                                <p class="text-blue-800">
                                    <strong>Registration Status:</strong>
                                    @if($registration->status == 'pending')
                                        <span class="capitalize text-yellow-600">Pending</span>
                                    @else
                                        <span class="capitalize">{{ $registration->status }}</span>
                                    @endif
                                </p>
                            </div>
                        @endif
                        @elseif($event->registrations()->active()->count() >= $event->max_attendees)
                        <div class="flex items-center mb-4">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                            <span class="text-yellow-600 font-medium">Event is Full</span>
                        </div>
                        
                        <div class="mt-2 mb-4 p-3 bg-yellow-50 rounded-lg">
                            <p class="text-yellow-800">
                                This event has reached its maximum capacity of {{ $event->max_attendees }} attendees.
                            </p>
                        </div>
                    @elseif($event->is_open_for_registration)
                        <div class="flex items-center mb-4">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-green-600 font-medium">Open for Registration</span>
                        </div>

                        <button onclick="openRegistrationModal('{{ $event->id }}', '{{ $event->title }}')"
                            class="block w-full text-center px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors">
                            Register Now
                        </button>
                    @else
                        <div class="flex items-center mb-4">
                            <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                            <span class="text-red-600 font-medium">Registration Closed</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Registration Modal -->
<div id="registrationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-2xl max-w-4xl w-full mx-4 md:mx-auto max-h-[90vh] overflow-y-auto">
        <div class="p-6 md:p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800" id="modalWorkshopTitle">{{ __('workshops.register_for') }}</h3>
                <button type="button" onclick="closeRegistrationModal()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <x-workshop-registration-form :event="$event" :isModal="true" />
        </div>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightbox-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 flex items-center justify-center">
    <div class="relative w-full max-w-6xl mx-auto px-4">
        <!-- Close button -->
        <button id="lightbox-close" class="absolute top-4 right-4 text-white text-2xl z-10 hover:text-gray-300">
            <i class="fas fa-times"></i>
        </button>
        
        <!-- Navigation buttons -->
        <button id="lightbox-prev" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white text-4xl z-10 hover:text-gray-300">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button id="lightbox-next" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-4xl z-10 hover:text-gray-300">
            <i class="fas fa-chevron-right"></i>
        </button>
        
        <!-- Image container -->
        <div class="flex items-center justify-center h-screen py-10">
            <img id="lightbox-image" src="" alt="Gallery image" class="max-h-full max-w-full object-contain">
        </div>
        
        <!-- Image counter -->
        <div class="absolute bottom-4 left-0 right-0 text-center text-white">
            <span id="lightbox-counter">1/1</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Store gallery images
        let galleryImages = {
            event: @json($event->gallery_images ?? []),
            workshop: @json($event->workshop->gallery_images ?? [])
        };
        
        let currentType = '';
        let currentIndex = 0;
        const modal = document.getElementById('lightbox-modal');
        const lightboxImage = document.getElementById('lightbox-image');
        const counter = document.getElementById('lightbox-counter');
        
        // Function to open lightbox
        window.openLightbox = function(index, type) {
            currentIndex = index;
            currentType = type;
            updateLightboxImage();
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }
        
        // Function to close lightbox
        function closeLightbox() {
            modal.classList.add('hidden');
            document.body.style.overflow = ''; // Restore scrolling
        }
        
        // Function to update lightbox image
        function updateLightboxImage() {
            const images = galleryImages[currentType];
            if (images && images.length > 0) {
                lightboxImage.src = "{{ asset('storage') }}/" + images[currentIndex];
                counter.textContent = `${currentIndex + 1}/${images.length}`;
            }
        }
        
        // Function to navigate to previous image
        function prevImage() {
            const images = galleryImages[currentType];
            if (images && images.length > 0) {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                updateLightboxImage();
            }
        }
        
        // Function to navigate to next image
        function nextImage() {
            const images = galleryImages[currentType];
            if (images && images.length > 0) {
                currentIndex = (currentIndex + 1) % images.length;
                updateLightboxImage();
            }
        }
        
        // Event listeners
        document.getElementById('lightbox-close').addEventListener('click', closeLightbox);
        document.getElementById('lightbox-prev').addEventListener('click', prevImage);
        document.getElementById('lightbox-next').addEventListener('click', nextImage);
        
        // Close on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeLightbox();
            } else if (event.key === 'ArrowLeft') {
                prevImage();
            } else if (event.key === 'ArrowRight') {
                nextImage();
            }
        });
        
        // Close when clicking outside the image
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeLightbox();
            }
        });
    });
</script>

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
        document.body.style.overflow = 'auto'; // Re-enable scrolling when modal is closed
    }

    // Close modal when clicking outside of it
    document.addEventListener('click', function (event) {
        const modal = document.getElementById('registrationModal');
        const modalContent = modal.querySelector('div');

        if (event.target === modal) {
            closeRegistrationModal();
        }
    });
    
    // Listen for registration cancellation events
    document.addEventListener('registration-cancelled', function(e) {
        const eventId = e.detail.eventId;
        const currentAttendees = e.detail.currentAttendees;
        const maxAttendees = e.detail.maxAttendees;
        
        // Update attendee count display
        const attendeeCountElement = document.querySelector('.attendee-count');
        if (attendeeCountElement) {
            attendeeCountElement.textContent = currentAttendees + '/' + maxAttendees;
        }
        
        // If this is the event page for the cancelled event
        if (window.location.href.includes('/event/' + eventId)) {
            // If the event was full but now has space, update the UI
            if (currentAttendees < maxAttendees) {
                // Check if there's a "Full" status message
                const fullStatusElement = document.querySelector('.text-yellow-600.font-medium');
                if (fullStatusElement && fullStatusElement.textContent.includes('Full')) {
                    // Replace with "Open for Registration" message
                    fullStatusElement.innerHTML = '<span class="text-green-600 font-medium">Open for Registration</span>';
                    
                    // Replace the full message with registration button
                    const fullMessageElement = document.querySelector('.mt-2.mb-4.p-3.bg-yellow-50.rounded-lg');
                    if (fullMessageElement) {
                        // Create registration button
                        const registerBtn = document.createElement('button');
                        registerBtn.setAttribute('onclick', `openRegistrationModal('${eventId}', '${e.detail.eventTitle}')`);
                        registerBtn.className = 'block w-full text-center px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors';
                        registerBtn.textContent = 'Register Now';
                        
                        // Replace the full message with the button
                        fullMessageElement.parentNode.replaceChild(registerBtn, fullMessageElement);
                    }
                }
            }
        }
    });
</script>
@endpush