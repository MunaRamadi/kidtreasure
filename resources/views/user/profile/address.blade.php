@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb Navigation -->
    <div class="flex items-center text-sm mb-6">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600">
            <i class="fas fa-home mr-1"></i> {{ __('Home') }}
        </a>
        <span class="mx-2 text-gray-400">&gt;</span>
        <a href="{{ route('profile.account') }}" class="text-gray-500 hover:text-indigo-600">
            {{ __('Account') }}
        </a>
        <span class="mx-2 text-gray-400">&gt;</span>
        <span class="text-gray-700">{{ __('Address Book') }}</span>
    </div>

    <!-- Page Title -->
    <h1 class="text-2xl font-bold mb-6" style="color: rgb(147 51 234 / var(--tw-text-opacity, 1));">{{ __('Address Book') }}</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Address List -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">{{ __('Your Addresses') }}</h2>
            <button id="addAddressBtn" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                {{ __('Add New Address') }}
            </button>
        </div>

        @if($addresses->isEmpty())
            <div class="bg-gray-100 p-4 rounded text-center">
                <p class="text-gray-600">{{ __('You have no saved addresses.') }}</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($addresses as $address)
                    <div class="border rounded p-4 relative {{ $address->is_default ? 'border-purple-500' : 'border-gray-200' }}">
                        @if($address->is_default)
                            <span class="absolute top-2 right-2 bg-purple-600 text-white text-xs px-2 py-1 rounded">{{ __('Default') }}</span>
                        @endif
                        
                        <h3 class="font-bold text-gray-800">{{ $address->name }}</h3>
                        <p class="text-gray-600">{{ $address->address_line1 }}</p>
                        @if($address->address_line2)
                            <p class="text-gray-600">{{ $address->address_line2 }}</p>
                        @endif
                        <p class="text-gray-600">{{ $address->city }}, {{ $address->postal_code }}</p>
                        <p class="text-gray-600">{{ $address->country }}</p>
                        <p class="text-gray-600">{{ $address->phone }}</p>
                        
                        <div class="mt-4 flex space-x-2">
                            <button type="button" class="text-purple-600 hover:text-purple-800 delete-address-btn" 
                                data-address-id="{{ $address->id }}" 
                                data-address-name="{{ $address->name }}">
                                {{ __('Delete') }}
                            </button>
                            
                            @if(!$address->is_default)
                                <form action="{{ route('profile.address.default', $address) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-800">
                                        {{ __('Set as Default') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Add Address Form (Hidden by default) -->
    <div id="addAddressForm" class="bg-white rounded-lg shadow-lg p-6 hidden">
        <h2 class="text-xl font-bold mb-4 text-gray-800">{{ __('Add New Address') }}</h2>
        
        <form action="{{ route('profile.address.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Full Name') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-purple-500 @enderror">
                @error('name')
                    <p class="text-purple-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="address_line1" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Address Line 1') }}</label>
                <input type="text" name="address_line1" id="address_line1" value="{{ old('address_line1') }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('address_line1') border-purple-500 @enderror">
                @error('address_line1')
                    <p class="text-purple-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="address_line2" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Address Line 2') }} ({{ __('Optional') }})</label>
                <input type="text" name="address_line2" id="address_line2" value="{{ old('address_line2') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('address_line2') border-purple-500 @enderror">
                @error('address_line2')
                    <p class="text-purple-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="city" class="block text-gray-700 text-sm font-bold mb-2">{{ __('City') }}</label>
                    <input type="text" name="city" id="city" value="{{ old('city') }}" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('city') border-purple-500 @enderror">
                    @error('city')
                        <p class="text-purple-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="postal_code" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Postal Code') }}</label>
                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('postal_code') border-purple-500 @enderror">
                    @error('postal_code')
                        <p class="text-purple-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mb-4">
                <label for="country" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Country') }}</label>
                <input type="text" name="country" id="country" value="{{ old('country') }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('country') border-purple-500 @enderror">
                @error('country')
                    <p class="text-purple-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Phone Number') }}</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-purple-500 @enderror">
                @error('phone')
                    <p class="text-purple-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_default" class="form-checkbox h-5 w-5 text-purple-600" {{ old('is_default') ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700">{{ __('Set as default address') }}</span>
                </label>
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    {{ __('Save Address') }}
                </button>
                <button type="button" id="cancelAddAddress" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                    {{ __('Cancel') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Delete Address Confirmation Modal -->
    <div id="deleteAddressModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">{{ __('Confirm Deletion') }}</h3>
                <button type="button" id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <p class="text-gray-600 mb-6">{{ __('Are you sure you want to delete this address?') }} <span id="addressToDelete" class="font-semibold"></span></p>
            
            <div class="flex justify-end space-x-3">
                <button type="button" id="cancelDelete" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded">
                    {{ __('Cancel') }}
                </button>
                
                <form id="deleteAddressForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addAddressBtn = document.getElementById('addAddressBtn');
        const addAddressForm = document.getElementById('addAddressForm');
        const cancelAddAddress = document.getElementById('cancelAddAddress');
        const deleteAddressModal = document.getElementById('deleteAddressModal');
        const deleteAddressForm = document.getElementById('deleteAddressForm');
        const addressToDelete = document.getElementById('addressToDelete');
        const cancelDelete = document.getElementById('cancelDelete');
        const closeModal = document.getElementById('closeModal');
        
        addAddressBtn.addEventListener('click', function() {
            addAddressForm.classList.remove('hidden');
        });
        
        cancelAddAddress.addEventListener('click', function() {
            addAddressForm.classList.add('hidden');
        });
        
        document.querySelectorAll('.delete-address-btn').forEach(button => {
            button.addEventListener('click', function() {
                const addressId = button.getAttribute('data-address-id');
                const addressName = button.getAttribute('data-address-name');
                
                deleteAddressForm.action = `/profile/address/${addressId}`;
                addressToDelete.textContent = addressName;
                
                deleteAddressModal.classList.remove('hidden');
            });
        });
        
        cancelDelete.addEventListener('click', function() {
            deleteAddressModal.classList.add('hidden');
        });
        
        closeModal.addEventListener('click', function() {
            deleteAddressModal.classList.add('hidden');
        });
    });
</script>
@endpush
@endsection
