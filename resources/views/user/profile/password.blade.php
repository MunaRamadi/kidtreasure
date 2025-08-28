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
        <span class="text-gray-700">{{ __('Change Password') }}</span>
    </div>

    <!-- Page Title -->
    <h1 class="text-2xl font-bold mb-6" style="color: rgb(147 51 234 / var(--tw-text-opacity, 1));">{{ __('Change Password') }}</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-purple-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Password Change Form -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('profile.password.update') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Current Password') }}</label>
                <div class="relative">
                    <input type="password" name="current_password" id="current_password" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('current_password') border-purple-500 @enderror">
                    <button type="button" class="toggle-password absolute inset-y-0 right-0 px-3 flex items-center" data-target="current_password">
                        <i class="fas fa-eye text-gray-500"></i>
                    </button>
                </div>
                @error('current_password')
                    <p class="text-purple-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">{{ __('New Password') }}</label>
                <div class="relative">
                    <input type="password" name="password" id="password" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-purple-500 @enderror">
                    <button type="button" class="toggle-password absolute inset-y-0 right-0 px-3 flex items-center" data-target="password">
                        <i class="fas fa-eye text-gray-500"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-purple-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Confirm New Password') }}</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <button type="button" class="toggle-password absolute inset-y-0 right-0 px-3 flex items-center" data-target="password_confirmation">
                        <i class="fas fa-eye text-gray-500"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    {{ __('Update Password') }}
                </button>
                <a href="{{ route('profile.account') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all password toggle buttons
        const toggleButtons = document.querySelectorAll('.toggle-password');
        
        // Add click event to each button
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get the target input field
                const targetId = this.getAttribute('data-target');
                const inputField = document.getElementById(targetId);
                
                // Toggle between password and text type
                if (inputField.type === 'password') {
                    inputField.type = 'text';
                    this.innerHTML = '<i class="fas fa-eye-slash text-gray-500"></i>';
                } else {
                    inputField.type = 'password';
                    this.innerHTML = '<i class="fas fa-eye text-gray-500"></i>';
                }
            });
        });
    });
</script>
@endpush