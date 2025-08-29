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
                                                    @elseif($registration->status === \App\Models\WorkshopRegistration::STATUS_CANCELLED) bg-red-100 text-red-800 
                                                    @endif">
                                                    @if(app()->getLocale() == 'ar')
                                                        {{ $registration->status_name }}
                                                    @else
                                                        @if($registration->status === \App\Models\WorkshopRegistration::STATUS_PENDING)
                                                            {{ __('Pending') }}
                                                        @elseif($registration->status === \App\Models\WorkshopRegistration::STATUS_CONFIRMED)
                                                            {{ __('Done') }}
                                                        @elseif($registration->status === \App\Models\WorkshopRegistration::STATUS_CANCELLED)
                                                            {{ __('Canceled') }}
                                                        @else
                                                            {{ $registration->status }}
                                                        @endif
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button" class="text-[#9232E9] hover:text-[#7E22CE] font-medium toggle-details mr-3" data-registration-id="{{ $registration->id }}" onclick="toggleDetails({{ $registration->id }})">
                                                    {{ __('Details') }}
                                                </button>
                                                
                                                @if($registration->status !== \App\Models\WorkshopRegistration::STATUS_CANCELLED && $registration->event->event_date->isFuture())
                                                    <button type="button" onclick="openCancelModal({{ $registration->id }})" class="text-red-600 hover:text-red-900 font-medium">
                                                        {{ __('Cancel') }}
                                                    </button>
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
                                                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
                                                                            @elseif($registration->status === \App\Models\WorkshopRegistration::STATUS_CANCELLED) bg-red-100 text-red-800 
                                                                            @endif">
                                                                            @if(app()->getLocale() == 'ar')
                                                                                {{ $registration->status_name }}
                                                                            @else
                                                                                @if($registration->status === \App\Models\WorkshopRegistration::STATUS_PENDING)
                                                                                    {{ __('Pending') }}
                                                                                @elseif($registration->status === \App\Models\WorkshopRegistration::STATUS_CONFIRMED)
                                                                                    {{ __('Done') }}
                                                                                @elseif($registration->status === \App\Models\WorkshopRegistration::STATUS_CANCELLED)
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
                                                                @if($registration->event->getGoogleCalendarUrl() && $registration->status !== \App\Models\WorkshopRegistration::STATUS_CANCELLED)
                                                                    <a href="{{ $registration->event->getGoogleCalendarUrl() }}" target="_blank" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-[#9232E9] hover:bg-[#7E22CE] focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                                                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                                                        </svg>
                                                                        {{ __('Add to Google Calendar') }}
                                                                    </a>
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

<!-- Cancellation Modal -->
<div id="cancelRegistrationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 md:mx-auto">
        <div class="p-6 relative">
            <button type="button" onclick="closeCancelModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Cancel Registration') }}</h3>
            <p class="text-gray-600 mb-6">{{ __('Are you sure you want to cancel this registration? This action cannot be undone.') }}</p>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeCancelModal()" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#9232E9]">
                    {{ __('No, Keep Registration') }}
                </button>
                <button type="button" onclick="submitCancelForm(document.getElementById('cancelRegistrationForm'))" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    {{ __('Yes, Cancel Registration') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Form for cancellation submission -->
<form id="cancelRegistrationForm" action="" method="POST" class="hidden" onsubmit="return submitCancelForm(this);">
    @csrf
    <input type="hidden" name="registration_id" value="">
</form>

@push('scripts')
    <script>
    // Function to open the cancel modal
    function openCancelModal(registrationId) {
        WorkshopRegistration.modal.open(registrationId);
    }
    
    // Function to close the cancel modal
    function closeCancelModal() {
        WorkshopRegistration.modal.close();
    }
    
    // Function to submit the cancel form
    function submitCancelForm(form) {
        return WorkshopRegistration.submitCancelForm(form);
    }
    
    // Function to toggle details visibility
    function toggleDetails(registrationId) {
        const detailsRow = document.getElementById(`details-${registrationId}`);
        if (detailsRow) {
            detailsRow.classList.toggle('hidden');
        }
    }
    
    // Workshop Registration Management
const WorkshopRegistration = {
    // DOM Elements
    elements: {
        cancelModal: document.getElementById('cancelRegistrationModal'),
        cancelForm: document.getElementById('cancelRegistrationForm')
    },
    
    // Initialize the module
    init: function() {
        // Set up event listeners
        document.addEventListener('DOMContentLoaded', this.setupEventListeners.bind(this));
    },
    
    // Set up all event listeners
    setupEventListeners: function() {
        // Listen for registration cancellation events from other pages
        document.addEventListener('registration-cancelled', this.handleExternalCancellation.bind(this));
        
        // Set up toggle details buttons
        const detailsButtons = document.querySelectorAll('.toggle-details');
        detailsButtons.forEach(button => {
            button.addEventListener('click', function() {
                const registrationId = this.getAttribute('data-registration-id');
                const detailsRow = document.getElementById(`details-${registrationId}`);
                if (detailsRow) {
                    detailsRow.classList.toggle('hidden');
                }
            });
        });
    },
    
    // Modal Management
    modal: {
        open: function(registrationId) {
            const form = WorkshopRegistration.elements.cancelForm;
            form.action = '/profile/activities/' + registrationId + '/cancel';
            form.querySelector('input[name="registration_id"]').value = registrationId;
            WorkshopRegistration.elements.cancelModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        },
        
        close: function() {
            WorkshopRegistration.elements.cancelModal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Re-enable scrolling when modal is closed
        }
    },
    
    // Form Submission
    submitCancelForm: function(form) {
        const formAction = form.action;
        const eventId = formAction.split('/').slice(-2)[0]; // Extract event ID from URL
        
        // Submit the form using fetch to handle it via AJAX
        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams(new FormData(form))
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Close the modal
            this.modal.close();
            
            // Update the UI to reflect the cancellation
            this.updateUIAfterCancel(eventId);
            
            // Show success message using the global toast function
            if (typeof showToast === 'function') {
                showToast('Success', data.message || '{{ __("Registration successfully cancelled") }}', 'success');
            }
            
            // Dispatch custom event for other pages to listen to
            this.dispatchCancellationEvent(eventId, data.event_title || '', data.current_attendees, data.max_attendees);
            
            // Show snackbar notification
            if (typeof showSnackbar === 'function') {
                showSnackbar(data.message || '{{ __("Registration successfully cancelled") }}');
            }
            
            // Reload the page after a short delay to show updated status
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Close the modal
            this.modal.close();
            
            // Show error message using the global toast function
            if (typeof showToast === 'function') {
                showToast('Error', '{{ __("An error occurred while cancelling your registration") }}', 'error');
            }
        });
        
        return false; // Prevent form submission
    },
    
    // UI Updates
    updateUIAfterCancel: function(registrationId) {
        try {
            // Find the row for this registration - more compatible selector
            const buttons = document.querySelectorAll('button[data-registration-id]');
            let row = null;
            
            // Find the button with matching registration ID and get its parent row
            for (const button of buttons) {
                if (button.getAttribute('data-registration-id') === registrationId) {
                    row = button.closest('tr');
                    break;
                }
            }
            
            if (row) {
                // Update status badge to show cancelled
                const statusBadge = row.querySelector('.px-2.inline-flex.text-xs.leading-5.font-semibold.rounded-full');
                if (statusBadge) {
                    statusBadge.textContent = '{{ __("Canceled") }}';
                    statusBadge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800';
                }
                
                // Hide cancel button
                const cancelButton = row.querySelector('button[onclick^="openCancelModal"]');
                if (cancelButton) {
                    cancelButton.style.display = 'none';
                }
            }
            
            // Also update the details section if it's open
            const detailsRow = document.getElementById(`details-${registrationId}`);
            if (detailsRow) {
                const detailsStatusBadge = detailsRow.querySelector('.px-2.inline-flex.text-xs.leading-5.font-semibold.rounded-full');
                if (detailsStatusBadge) {
                    detailsStatusBadge.textContent = '{{ __("Canceled") }}';
                    detailsStatusBadge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800';
                }
                
                // Hide Google Calendar button if it exists
                const calendarButton = detailsRow.querySelector('a[href*="google.com/calendar"]');
                if (calendarButton) {
                    calendarButton.style.display = 'none';
                }
            }
        } catch (error) {
            console.error('Error updating UI after cancel:', error);
        }
    },
    
    // Event Dispatching
    dispatchCancellationEvent: function(eventId, eventTitle, currentAttendees, maxAttendees) {
        document.dispatchEvent(new CustomEvent('registration-cancelled', {
            detail: {
                eventId: eventId,
                eventTitle: eventTitle,
                currentAttendees: currentAttendees,
                maxAttendees: maxAttendees
            },
            bubbles: true
        }));
    },
    
    // Handle cancellation events from other pages
    handleExternalCancellation: function(e) {
        const eventId = e.detail.eventId;
        console.log('External cancellation received for event ID:', eventId);
        this.updateUIAfterCancel(eventId);
    }
};
    </script>
@endpush
@endsection
