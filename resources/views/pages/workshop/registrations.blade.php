@extends('layouts.app')

@section('title', 'Workshop Registrations - Children\'s Treasures')

@section('description', 'View and manage all workshop registrations')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Workshop Registrations</h1>
            <p class="text-gray-600">View all registrations for workshop events</p>
        </div>

        <!-- Search and Filter Section -->
        <div class="mb-6 flex flex-wrap gap-4">
            <form action="{{ route('workshop.registrations') }}" method="GET" class="w-full flex flex-wrap gap-4">
                <div class="flex-grow">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Search by name or email..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ request('search') }}">
                        <button type="submit" class="absolute right-2 top-2 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="w-full md:w-auto flex gap-2">
                    <div class="relative">
                        <select name="status" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 appearance-none pr-8">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="attended" {{ request('status') == 'attended' ? 'selected' : '' }}>Attended</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="relative">
                        <select name="type" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 appearance-none pr-8">
                            <option value="">All Types</option>
                            <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>Registered Users</option>
                            <option value="guest" {{ request('type') == 'guest' ? 'selected' : '' }}>Guests</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Registrations Table -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registration Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($registrations as $registration)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registration->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($registration->user_id)
                                        {{ $registration->user->name }}
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">User</span>
                                    @else
                                        {{ $registration->attendee_name }}
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Guest</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $registration->user_id ? $registration->user->email : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $registration->parent_contact }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $registration->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($registration->status == 'confirmed') bg-green-100 text-green-800 
                                        @elseif($registration->status == 'pending') bg-yellow-100 text-yellow-800 
                                        @elseif($registration->status == 'cancelled') bg-red-100 text-red-800 
                                        @elseif($registration->status == 'attended') bg-blue-100 text-blue-800 
                                        @else bg-gray-100 text-gray-800 
                                        @endif">
                                        {{ ucfirst($registration->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <button type="button" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors" 
                                            onclick="openModal('detailsModal{{ $registration->id }}')">
                                        <i class="fas fa-info-circle"></i> Details
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Registration Details Modal -->
                            <div id="detailsModal{{ $registration->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                                    <div class="flex justify-between items-center border-b pb-3">
                                        <h5 class="text-lg font-medium text-gray-900">Registration Details</h5>
                                        <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeModal('detailsModal{{ $registration->id }}')">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-medium text-gray-900 mb-2">Attendee Information</h5>
                                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                            <div class="sm:col-span-1">
                                                <dt class="text-gray-500">Registration ID:</dt>
                                                <dd class="mt-1 text-gray-900">{{ $registration->id }}</dd>
                                            </div>
                                            
                                            <div class="sm:col-span-1">
                                                <dt class="text-gray-500">Name:</dt>
                                                <dd class="mt-1 text-gray-900">{{ $registration->user_id ? $registration->user->name : $registration->attendee_name }}</dd>
                                            </div>
                                            
                                            <div class="sm:col-span-1">
                                                <dt class="text-gray-500">Email:</dt>
                                                <dd class="mt-1 text-gray-900">{{ $registration->user_id ? $registration->user->email : 'N/A' }}</dd>
                                            </div>
                                            
                                            <div class="sm:col-span-1">
                                                <dt class="text-gray-500">Phone:</dt>
                                                <dd class="mt-1 text-gray-900">{{ $registration->parent_contact }}</dd>
                                            </div>
                                            
                                            <div class="sm:col-span-1">
                                                <dt class="text-gray-500">Registration Type:</dt>
                                                <dd class="mt-1 text-gray-900">{{ $registration->user_id ? 'Registered User' : 'Guest' }}</dd>
                                            </div>
                                            
                                            <div class="sm:col-span-1">
                                                <dt class="text-gray-500">Status:</dt>
                                                <dd class="mt-1">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($registration->status == 'confirmed') bg-green-100 text-green-800 
                                                        @elseif($registration->status == 'pending') bg-yellow-100 text-yellow-800 
                                                        @elseif($registration->status == 'cancelled') bg-red-100 text-red-800 
                                                        @elseif($registration->status == 'attended') bg-blue-100 text-blue-800 
                                                        @else bg-gray-100 text-gray-800 
                                                        @endif">
                                                        {{ ucfirst($registration->status) }}
                                                    </span>
                                                </dd>
                                            </div>
                                            
                                            <div class="sm:col-span-1">
                                                <dt class="text-gray-500">Registered On:</dt>
                                                <dd class="mt-1 text-gray-900">{{ $registration->created_at->format('Y-m-d H:i:s') }}</dd>
                                            </div>
                                            
                                            <div class="sm:col-span-1">
                                                <dt class="text-gray-500">Event:</dt>
                                                <dd class="mt-1 text-gray-900">
                                                    @if($registration->event)
                                                        <a href="{{ route('workshop.event.show', $registration->event->id) }}" class="text-blue-500 hover:underline">
                                                            {{ $registration->event->title }}
                                                        </a>
                                                    @else
                                                        N/A
                                                    @endif
                                                </dd>
                                            </div>
                                            
                                            @if($registration->special_requirements)
                                            <div class="sm:col-span-2">
                                                <dt class="text-gray-500">Special Requirements:</dt>
                                                <dd class="mt-1 text-gray-900">{{ $registration->special_requirements }}</dd>
                                            </div>
                                            @endif
                                        </dl>
                                    </div>
                                    <div class="mt-5 flex justify-end">
                                        <button type="button" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition-colors" 
                                                onclick="closeModal('detailsModal{{ $registration->id }}')">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    No registrations found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @section('styles')
    <style>
        /* Ensure dropdowns appear above all other content */
        select {
            position: relative;
            z-index: 50;
        }
        
        /* Style for dropdown options to ensure they appear above other content */
        select option {
            background-color: white;
            color: #333;
            padding: 8px;
        }
        
        /* Custom styling for dropdown on focus */
        select:focus {
            z-index: 100;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
    </style>
    @endsection

    @section('scripts')
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    </script>
    @endsection
@endsection
