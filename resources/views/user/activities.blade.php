@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-[#9232E9] text-center">{{ __('My Activities') }}</h1>
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif
    
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar Filters -->
        <div class="w-full md:w-1/4">
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('Filter Events') }}</h3>
                <form action="{{ route('profile.activities') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Status') }}</label>
                            <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">{{ __('All Statuses') }}</option>
                                @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">{{ __('From Date') }}</label>
                            <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="mt-1 block w-full border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                        
                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">{{ __('To Date') }}</label>
                            <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="mt-1 block w-full border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                    </div>
                    
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#9232E9] hover:bg-[#7E22CE] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#9232E9]">
                            {{ __('Filter') }}
                        </button>
                        <a href="{{ route('profile.activities') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#9232E9]">
                            {{ __('Reset') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Activities Content -->
        <div class="w-full md:w-3/4">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-4">{{ __('My Workshop Registrations') }}</h2>
                    
                    @if($registrations->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Event') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Date & Time') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Location') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Status') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($registrations as $registration)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($registration->event->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($registration->event->image_path))
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $registration->event->image_path) }}" alt="{{ $registration->event->title }}">
                                                        </div>
                                                    @endif
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $registration->event->title }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $registration->event->event_date->format('Y-m-d') }}</div>
                                                <div class="text-sm text-gray-500">{{ $registration->event->event_time }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $registration->event->location }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($registration->status === \App\Models\WorkshopRegistration::STATUS_CONFIRMED) bg-green-100 text-green-800 
                                                    @elseif($registration->status === \App\Models\WorkshopRegistration::STATUS_PENDING) bg-yellow-100 text-yellow-800 
                                                    @elseif($registration->status === \App\Models\WorkshopRegistration::STATUS_CANCELED) bg-red-100 text-red-800 
                                                    @endif">
                                                    @if(app()->getLocale() == 'ar')
                                                        {{ $registration->status_name }}
                                                    @else
                                                        @if($registration->status === \App\Models\WorkshopRegistration::STATUS_PENDING)
                                                            {{ __('Pending') }}
                                                        @elseif($registration->status === \App\Models\WorkshopRegistration::STATUS_CONFIRMED)
                                                            {{ __('Done') }}
                                                        @elseif($registration->status === \App\Models\WorkshopRegistration::STATUS_CANCELED)
                                                            {{ __('Canceled') }}
                                                        @else
                                                            {{ $registration->status }}
                                                        @endif
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button" class="text-[#9232E9] hover:text-[#7E22CE] font-medium toggle-details mr-3" data-registration-id="{{ $registration->id }}">
                                                    {{ __('Details') }}
                                                </button>
                                                
                                                @if($registration->status !== \App\Models\WorkshopRegistration::STATUS_CANCELED && $registration->event->event_date->isFuture())
                                                    <form action="{{ route('profile.activities.cancel', $registration->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium" onclick="return confirm('{{ __('Are you sure you want to cancel this registration?') }}')">
                                                            {{ __('Cancel') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="registration-details hidden" id="details-{{ $registration->id }}">
                                            <td colspan="5" class="px-6 py-4 bg-gray-50">
                                                <div class="registration-details-content">
                                                    <div class="flex flex-col md:flex-row">
                                                        <div class="md:w-1/3 mb-4 md:mb-0">
                                                            @if($registration->event->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($registration->event->image_path))
                                                                <img src="{{ asset('storage/' . $registration->event->image_path) }}" alt="{{ $registration->event->title }}" class="w-full h-auto rounded-lg">
                                                            @elseif($registration->event->workshop && $registration->event->workshop->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($registration->event->workshop->image_path))
                                                                <img src="{{ asset('storage/' . $registration->event->workshop->image_path) }}" alt="{{ $registration->event->title }}" class="w-full h-auto rounded-lg">
                                                            @else
                                                                <div class="bg-gray-200 rounded-lg w-full h-48 flex items-center justify-center">
                                                                    <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2"></path>
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="md:w-2/3 md:pl-6">
                                                            <h3 class="text-lg font-semibold mb-2">{{ $registration->event->title }}</h3>
                                                            <p class="text-gray-700 mb-4">{{ $registration->event->description }}</p>
                                                            
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                                <div>
                                                                    <p class="text-sm text-gray-600">
                                                                        <span class="font-medium">{{ __('Date') }}:</span> 
                                                                        {{ $registration->event->event_date->format('Y-m-d') }}
                                                                    </p>
                                                                    <p class="text-sm text-gray-600">
                                                                        <span class="font-medium">{{ __('Time') }}:</span> 
                                                                        {{ $registration->event->event_time }}
                                                                    </p>
                                                                    <p class="text-sm text-gray-600">
                                                                        <span class="font-medium">{{ __('Location') }}:</span> 
                                                                        {{ $registration->event->location }}
                                                                    </p>
                                                                </div>
                                                                <div>
                                                                    <p class="text-sm text-gray-600">
                                                                        <span class="font-medium">{{ __('Duration') }}:</span> 
                                                                        {{ $registration->event->duration }} {{ __('hours') }}
                                                                    </p>
                                                                    <p class="text-sm text-gray-600">
                                                                        <span class="font-medium">{{ __('Age Group') }}:</span> 
                                                                        {{ $registration->event->age_group }}
                                                                    </p>
                                                                    <p class="text-sm text-gray-600">
                                                                        <span class="font-medium">{{ __('Registration Date') }}:</span> 
                                                                        {{ $registration->registration_date->format('Y-m-d') }}
                                                                    </p>
                                                                    <div class="flex items-center mt-2">
                                                                        <span class="text-sm font-medium mr-2">{{ __('Status') }}:</span>
                                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                            @if($registration->status === \App\Models\WorkshopRegistration::STATUS_CONFIRMED) bg-green-100 text-green-800 
                                                                            @elseif($registration->status === \App\Models\WorkshopRegistration::STATUS_PENDING) bg-yellow-100 text-yellow-800 
                                                                            @elseif($registration->status === \App\Models\WorkshopRegistration::STATUS_CANCELED) bg-red-100 text-red-800 
                                                                            @endif">
                                                                            @if(app()->getLocale() == 'ar')
                                                                                {{ $registration->status_name }}
                                                                            @else
                                                                                @if($registration->status === \App\Models\WorkshopRegistration::STATUS_PENDING)
                                                                                    {{ __('Pending') }}
                                                                                @elseif($registration->status === \App\Models\WorkshopRegistration::STATUS_CONFIRMED)
                                                                                    {{ __('Done') }}
                                                                                @elseif($registration->status === \App\Models\WorkshopRegistration::STATUS_CANCELED)
                                                                                    {{ __('Canceled') }}
                                                                                @else
                                                                                    {{ $registration->status }}
                                                                                @endif
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="flex flex-wrap gap-2 mt-4">
                                                                @if($registration->event->getGoogleCalendarUrl() && $registration->status !== \App\Models\WorkshopRegistration::STATUS_CONFIRMED)
                                                                    <a href="{{ $registration->event->getGoogleCalendarUrl() }}" target="_blank" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-[#9232E9] hover:bg-[#7E22CE] focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                                                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                                                        </svg>
                                                                        {{ __('Add to Google Calendar') }}
                                                                    </a>
                                                                @endif
                                                                
                                                                @if($registration->status !== \App\Models\WorkshopRegistration::STATUS_CANCELED && $registration->event->event_date->isFuture())
                                                                    <form action="{{ route('profile.activities.cancel', $registration->id) }}" method="POST">
                                                                        @csrf
                                                                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition ease-in-out duration-150" onclick="return confirm('{{ __('Are you sure you want to cancel this registration?') }}')">
                                                                            <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                                            </svg>
                                                                            {{ __('Cancel Registration') }}
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $registrations->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('No registrations found') }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ __('You have not registered for any workshop events yet.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle event details visibility
        const viewEventButtons = document.querySelectorAll('.toggle-details');
        viewEventButtons.forEach(button => {
            button.addEventListener('click', function() {
                const registrationId = this.getAttribute('data-registration-id');
                const detailsRow = document.querySelector(`#details-${registrationId}`);
                
                if (detailsRow.classList.contains('hidden')) {
                    detailsRow.classList.remove('hidden');
                    this.textContent = '{{ __("Hide Details") }}';
                } else {
                    detailsRow.classList.add('hidden');
                    this.textContent = '{{ __("Details") }}';
                }
            });
        });
    });
</script>
@endpush
@endsection
