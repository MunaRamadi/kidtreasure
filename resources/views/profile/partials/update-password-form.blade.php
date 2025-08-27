<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="mb-4">
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#9232E9] focus:border-[#9232E9] focus:outline-none transition duration-150 ease-in-out" />
            @error('current_password', 'updatePassword')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#9232E9] focus:border-[#9232E9] focus:outline-none transition duration-150 ease-in-out" />
            @error('password', 'updatePassword')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#9232E9] focus:border-[#9232E9] focus:outline-none transition duration-150 ease-in-out" />
            @error('password_confirmation', 'updatePassword')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#9232E9] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#7E22CE] focus:bg-[#7E22CE] active:bg-[#7E22CE] focus:outline-none focus:ring-2 focus:ring-[#9232E9] focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
