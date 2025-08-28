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

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Account Management Section -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">{{ __('My Account') }}</h2>
        
        <ul class="space-y-4">
            <li>
                <a href="{{ route('profile.edit') }}" class="flex items-center text-gray-700 hover:text-purple-600">
                    <span class="mr-2">›</span>
                    <span>{{ __('Edit your account information') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('password.request') }}" class="flex items-center text-gray-700 hover:text-purple-600">
                    <span class="mr-2">›</span>
                    <span>{{ __('Change your password') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('profile.address') }}" class="flex items-center text-gray-700 hover:text-purple-600">
                    <span class="mr-2">›</span>
                    <span>{{ __('Modify your address book entries') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('password.request') }}" class="flex items-center text-gray-700 hover:text-purple-600">
                    <span class="mr-2">›</span>
                    <span>{{ __('Recover your password') }}</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Account Summary -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">{{ __('Account Summary') }}</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">{{ __('Account Information') }}</h3>
                <p class="text-gray-600">{{ $user->name }}</p>
                <p class="text-gray-600">{{ $user->email }}</p>
                <p class="text-gray-600">{{ $user->phone ?? __('No phone number') }}</p>
            </div>
            
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">{{ __('Default Shipping Address') }}</h3>
                @if($defaultAddress)
                    <p class="text-gray-600">{{ $defaultAddress->name }}</p>
                    <p class="text-gray-600">{{ $defaultAddress->address_line1 }}</p>
                    <p class="text-gray-600">{{ $defaultAddress->city }}, {{ $defaultAddress->state }} {{ $defaultAddress->postal_code }}</p>
                    <p class="text-gray-600">{{ $defaultAddress->country }}</p>
                    <p class="text-gray-600">{{ $defaultAddress->phone }}</p>
                @else
                    <p class="text-gray-600">{{ __('No default address set') }}</p>
                    <a href="{{ route('profile.address') }}" class="text-purple-600 hover:text-purple-700 text-sm">
                        {{ __('Add an address') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
