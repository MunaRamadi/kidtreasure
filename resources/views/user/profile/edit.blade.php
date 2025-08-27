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
        <span class="text-gray-700">{{ __('Edit Profile') }}</span>
    </div>

    <!-- Page Title -->
    <h1 class="text-2xl font-bold mb-6" style="color: rgb(147 51 234 / var(--tw-text-opacity, 1));">{{ __('Edit Profile') }}</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Profile Edit Form -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-purple-500 @enderror">
                @error('name')
                    <p class="text-purple-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Email') }}</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-purple-500 @enderror">
                @error('email')
                    <p class="text-purple-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Phone') }}</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-purple-500 @enderror">
                @error('phone')
                    <p class="text-purple-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    {{ __('Save Changes') }}
                </button>
                <a href="{{ route('profile.account') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
