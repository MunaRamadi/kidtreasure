@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb Navigation -->
    <div class="flex items-center text-sm mb-6">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600">
            <i class="fas fa-home mr-1"></i> {{ __('Home') }}
        </a>
        <span class="mx-2 text-gray-400">&gt;</span>
        <span class="text-gray-700">{{ __('Account') }}</span>
    </div>

    <!-- Page Title -->
    <h1 class="text-2xl font-bold mb-6" style="color: rgb(147 51 234 / var(--tw-text-opacity, 1));">{{ __('My Account') }}</h1>

    <!-- Account Section -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-bold mb-6 text-gray-800">{{ __('My Account') }}</h2>

        <div class="space-y-4">
            <div class="border-l-4 border-gray-300 pl-4 py-1 hover:border-purple-600">
                <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-purple-600">
                    <i class="fas fa-user-edit mr-2"></i> {{ __('Edit your account information') }}
                </a>
            </div>
            
            <div class="border-l-4 border-gray-300 pl-4 py-1 hover:border-purple-600">
                <a href="{{ route('profile.password') }}" class="text-gray-700 hover:text-purple-600">
                    <i class="fas fa-key mr-2"></i> {{ __('Change your password') }}
                </a>
            </div>
            
            <div class="border-l-4 border-gray-300 pl-4 py-1 hover:border-purple-600">
                <a href="{{ route('profile.address') }}" class="text-gray-700 hover:text-purple-600">
                    <i class="fas fa-address-book mr-2"></i> {{ __('Modify your address book entries') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Orders Section -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-bold mb-6 text-gray-800">{{ __('My Orders') }}</h2>

        <div class="space-y-4">
            <div class="border-l-4 border-gray-300 pl-4 py-1 hover:border-purple-600">
                <a href="{{ route('profile.orders') }}" class="text-gray-700 hover:text-purple-600">
                    <i class="fas fa-shopping-bag mr-2"></i> {{ __('View your order history') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Additional styles to match the template */
    .border-l-4 {
        transition: border-color 0.2s ease;
    }
</style>
@endpush
