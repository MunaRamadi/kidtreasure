@extends('layouts.app')

@section('title', app()->getLocale() == 'en' ? $workshop->name_en . ' - Children\'s Treasures' : $workshop->name_ar . ' - كنوز الأطفال')

@section('description', app()->getLocale() == 'en' 
    ? 'Learn about our ' . $workshop->name_en . ' workshop - ' . Str::limit(strip_tags($workshop->description_en), 150)
    : 'تعرف على ورشة ' . $workshop->name_ar . ' - ' . Str::limit(strip_tags($workshop->description_ar), 150))

@section('content')
<style>
      <style>
      /* Register Button Styles */
      .register-btn {
            width: 100%;
            padding: 1rem;
            border-radius: 0.75rem;
      }

        .register-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
</style>
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('workshops.index') }}" class="flex items-center text-purple-600 hover:text-purple-800">
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
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-500 md:ml-2">{{ app()->getLocale() == 'en' ? $workshop->name_en : $workshop->name_ar }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Column: Workshop Image and Details -->
            <div class="w-full lg:w-2/3">
                <!-- Workshop Header -->
                <div class="bg-white rounded-lg shadow-lg mb-8">
                    <!-- Image Display -->
                    <div class="relative">
                        @if($workshop->image)
                            <div class="relative h-96 overflow-hidden rounded-lg">
                                <img src="{{ asset('storage/' . $workshop->image) }}" 
                                     alt="{{ app()->getLocale() == 'en' ? $workshop->name_en : $workshop->name_ar }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @elseif($workshop->image_path)
                            <div class="relative h-96 overflow-hidden rounded-lg">
                                <img src="{{ asset('storage/' . $workshop->image_path) }}" 
                                     alt="{{ app()->getLocale() == 'en' ? $workshop->name_en : $workshop->name_ar }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="relative h-96 overflow-hidden rounded-lg">
                                <img src="{{ asset('images/default-workshop.jpg') }}" 
                                     alt="{{ app()->getLocale() == 'en' ? $workshop->name_en : $workshop->name_ar }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @endif

                        <!-- Workshop Type Badge -->
                        <div class="absolute top-6 left-6">
                            <span class="bg-purple-600 text-white text-sm px-3 py-1 rounded-full">{{ app()->getLocale() == 'en' ? 'Workshop' : 'ورشة عمل' }}</span>
                        </div>
                    </div>

                    <div class="p-6 md:p-8">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ app()->getLocale() == 'en' ? $workshop->name_en : $workshop->name_ar }}</h1>
                        <p class="text-lg text-indigo-600 mb-4">{{ $workshop->target_age_group }}</p>
                        
                        <div class="prose max-w-none">
                            {!! app()->getLocale() == 'en' ? $workshop->description_en : $workshop->description_ar !!}
                        </div>
                    </div>
                </div>
                
                <!-- Upcoming Events -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('workshops.upcoming_events') }}</h2>
                    
                    @if($workshop->events->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($workshop->events as $event)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                                    @if($event->image_path)
                                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                                    @elseif($workshop->image_path)
                                        <img src="{{ asset('storage/' . $workshop->image_path) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover opacity-80">
                                    @else
                                        <img src="{{ asset('images/default-workshop.jpg') }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                                    @endif
                                    
                                    <div class="p-4">
                                        <h3 class="text-xl font-semibold mb-2">{{ app()->getLocale() == 'en' ? $event->title : $event->title_ar }}</h3>
                                        
                                        <div class="flex items-center text-gray-600 mb-2">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $event->event_date->format('F j, Y - g:i A') }}</span>
                                        </div>
                                        
                                        <div class="flex items-center text-gray-600 mb-2">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ $event->duration_hours }} {{ $event->duration_hours == 1 ? 'hour' : 'hours' }}</span>
                                        </div>
                                        
                                        <div class="flex items-center text-gray-600 mb-2">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span>{{ $event->location }}</span>
                                        </div>
                                        
                                        <div class="flex items-center text-gray-600 mb-4">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ $event->price_jod }} JOD</span>
                                        </div>
                                        
                                        
                                        @if($event->is_open_for_registration)
                                            @if(in_array($event->id, $registeredEventIds ?? []))
                                                <div class="block w-full text-center px-4 py-2 mb-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest event-registration-status-{{ $event->id }}">
                                                    {{ __('Registered') }}
                                                </div>
                                                <a href="{{ $event->getGoogleCalendarUrl() }}" 
                                                    class="block w-full text-center items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md hover:bg-purple-700" 
                                                    target="_blank">
                                                    + Add to Calendar
                                                </a>
                                                <a href="{{ route('workshops.event.show', $event) }}"
                                                    class="block w-full text-center px-4 py-2 my-2 bg-white border border-transparent rounded-md font-semibold text-xs text-indigo-600 uppercase tracking-widest disabled:opacity-25 transition ease-in-out duration-150 event-registration-status-{{ $event->id }}" data-event-id="{{ $event->id }}">
                                                    Details
                                                </a>
                                            @elseif($event->registrations()->active()->count() >= $event->max_attendees)
                                                <div class="block w-full text-center px-4 py-2 mb-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">
                                                    {{ __('FULL') }}
                                                </div>
                                                <a href="{{ route('workshops.event.show', $event->id) }}" type="button" 
                                                    class="block w-full text-center px-4 py-2 my-2 bg-white border border-transparent rounded-md font-semibold text-xs text-indigo-600 uppercase tracking-widest disabled:opacity-25 transition ease-in-out duration-150 event-registration-status-{{ $event->id }}" data-event-id="{{ $event->id }}">
                                                   {{ __('Details') }}
                                                </a>
                                            @else 
                                                <a href="{{ route('workshops.event.show', $event->id) }}" type="button" 
                                                    class="block w-full text-center px-4 py-2 my-2 bg-white border border-transparent rounded-md font-semibold text-xs text-indigo-600 uppercase tracking-widest  disabled:opacity-25 transition ease-in-out duration-150 event-registration-status-{{ $event->id }}" data-event-id="{{ $event->id }}">
                                               {{ __('Details') }}
                                                </a>
                                                <button type="button" 
                                                    onclick="openRegistrationModal('{{ $event->id }}', '{{ $event->title }}')" 
                                                    class="block w-full text-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 event-registration-status-{{ $event->id }}" data-event-id="{{ $event->id }}">
                                                    {{ __('workshops.register') }}
                                                </button>
                                            @endif
                                        @else
                                            <div class="text-center text-sm text-red-600 py-2">
                                                {{ __('workshops.registration_closed') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        {{ __('workshops.no_upcoming_events') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Gallery -->
                @if($workshop->gallery_images && count($workshop->gallery_images) > 0)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('workshops.gallery') }}</h2>
                        
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($workshop->gallery_images as $image)
                                <div class="relative aspect-square overflow-hidden rounded-lg shadow-md">
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ __('workshops.gallery_image') }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            </div>
        </div>
    </div>

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

                <x-workshop-registration-form :event="$workshop->events->first()" :isModal="true" />
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Function to open registration modal
        function openRegistrationModal(eventId, eventTitle) {
            document.getElementById('modalWorkshopTitle').textContent = '{{ __("workshops.register_for") }} ' + eventTitle;
            document.getElementById('registrationModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        }
        
        // Function to close registration modal
        function closeRegistrationModal() {
            document.getElementById('registrationModal').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Re-enable scrolling when modal is closed
        }
        
        // Listen for registration cancellation events
        document.addEventListener('registration-cancelled', function(e) {
            const eventId = e.detail.eventId;
            const currentAttendees = e.detail.currentAttendees;
            const maxAttendees = e.detail.maxAttendees;
            
            // Update attendee count display for this event if it exists on the page
            const attendeeCountElements = document.querySelectorAll('.attendee-count-' + eventId);
            attendeeCountElements.forEach(function(element) {
                element.textContent = currentAttendees + '/' + maxAttendees;
            });
            
            // If the event was full but now has space, update the UI
            if (currentAttendees < maxAttendees) {
                // Find the event card
                const eventCard = document.querySelector('[data-event-id="' + eventId + '"]').closest('.event-card');
                if (eventCard) {
                    // Remove "FULL" status if it exists
                    const fullStatus = eventCard.querySelector('.bg-yellow-600');
                    if (fullStatus) {
                        fullStatus.remove();
                    }
                    
                    // Re-enable registration button
                    const registerBtn = eventCard.querySelector('button[onclick^="openRegistrationModal"]');
                    if (!registerBtn) {
                        // If button doesn't exist, create it
                        const detailsBtn = eventCard.querySelector('a[href*="workshops.event.show"]');
                        if (detailsBtn && detailsBtn.parentNode) {
                            const newBtn = document.createElement('button');
                            newBtn.setAttribute('type', 'button');
                            newBtn.setAttribute('onclick', 'openRegistrationModal("' + eventId + '", "' + e.detail.eventTitle + '")');
                            newBtn.className = 'block w-full text-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 event-registration-status-' + eventId;
                            newBtn.setAttribute('data-event-id', eventId);
                            newBtn.textContent = '{{ __("workshops.register") }}';
                            detailsBtn.parentNode.appendChild(newBtn);
                        }
                    }
                }
            }
        });
    </script>
    @endpush
@endsection
