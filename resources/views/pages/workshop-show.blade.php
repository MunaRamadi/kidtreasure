@extends('layouts.app')

@section('title', $workshop->name_en . ' - Children\'s Treasures')

@section('description', 'Learn about our ' . $workshop->name_en . ' workshop - ' . Str::limit(strip_tags($workshop->description_en), 150))

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Workshop Header -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            @if($workshop->image_path)
                <div class="relative h-64 md:h-80 overflow-hidden">
                    <img src="{{ asset('storage/' . $workshop->image_path) }}" alt="{{ $workshop->name_en }}" class="w-full h-full object-cover">
                </div>
            @endif
            
            <div class="p-6">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">{{ $workshop->name_en }}</h1>
                <p class="text-lg text-indigo-600 mb-4">{{ $workshop->target_age_group }}</p>
                
                <div class="prose max-w-none">
                    {!! $workshop->description_en !!}
                </div>
            </div>
        </div>
        
        <!-- Upcoming Events -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Upcoming Events</h2>
            
            @if($workshop->events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($workshop->events as $event)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                            @if($event->image_path)
                                <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                            @elseif($workshop->image_path)
                                <img src="{{ asset('storage/' . $workshop->image_path) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover opacity-80">
                            @endif
                            
                            <div class="p-4">
                                <h3 class="text-xl font-semibold mb-2">{{ $event->title }}</h3>
                                
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
                                    <span>{{ $event->duration_minutes }} minutes</span>
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
                                    <a href="{{ route('workshops.register.form', $event) }}" class="block w-full text-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Register
                                    </a>
                                @else
                                    <div class="text-center text-sm text-red-600 py-2">
                                        Registration Closed
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
                                No upcoming events scheduled for this workshop at the moment. Check back later or contact us for more information.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Gallery -->
        @if($workshop->gallery_images && count($workshop->gallery_images) > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Gallery</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($workshop->gallery_images as $image)
                        <div class="relative aspect-square overflow-hidden rounded-lg shadow-md">
                            <img src="{{ asset('storage/' . $image) }}" alt="Workshop Gallery Image" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Contact/Interest Form -->
        <div class="bg-indigo-50 rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Interested in this Workshop?</h2>
            <p class="mb-4">Fill out the form below to register your interest, and we'll notify you when new events are scheduled.</p>
            
            <form action="{{ route('workshops.register.interest') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="workshop_id" value="{{ $workshop->id }}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                        <input type="text" name="name" id="name" class="form-input" required>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" class="form-input" required>
                    </div>
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="tel" name="phone" id="phone" class="form-input">
                </div>
                
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message (Optional)</label>
                    <textarea name="message" id="message" rows="3" class="form-input"></textarea>
                </div>
                
                <div>
                    <button type="submit" class="w-full md:w-auto px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        Register Interest
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
