@props(['event' => null, 'isModal' => false])

<div class="workshop-registration-form">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
            <p class="font-bold">Success!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
            <p class="font-bold">Error</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="mb-6">
        <div class="inline-flex items-center px-3 py-1 rounded-full {{ $event ? 'bg-green-500' : 'bg-blue-500' }} text-white text-sm" id="registration_badge">
            {{ $event ? 'Event Registration' : 'Interest Registration' }}
        </div>
    </div>

    <form id="registrationForm" action="{{ $event ? route('workshops.register', ['event' => $event->id]) : route('workshops.register', ['event' => 0]) }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="event_id" id="modalWorkshopId" value="{{ $event ? $event->id : '' }}">
        <input type="hidden" name="registration_type" id="registration_type" value="{{ $event ? 'event' : 'interest' }}">
        <input type="hidden" name="event_id" id="event_id" value="{{ $event ? $event->id : '' }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="form-input-group">
                <input type="text" name="parent_name" class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white" placeholder="Parent's Name *" required value="{{ old('parent_name') }}" pattern="[A-Za-z\s\-\.']{2,}" title="Please enter a valid name (letters, spaces, hyphens and apostrophes only)">
                @error('parent_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-input-group">
                <input type="tel" name="parent_contact" class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white text-gray-800" placeholder="Parent's Phone *" required value="{{ old('parent_contact') }}" pattern="[0-9\+\-\s]{6,}" title="Please enter a valid phone number (numbers, plus sign, hyphens and spaces only)">
                @error('parent_contact')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-input-group">
                <input type="text" name="attendee_name" class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white text-gray-800" placeholder="Child's Name *" required value="{{ old('attendee_name') }}" pattern="[A-Za-z\s\-\.']{2,}" title="Please enter a valid name (letters, spaces, hyphens and apostrophes only)">
                @error('attendee_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-input-group" id="preferred_day_group" {{ $event ? 'style=display:none' : '' }}>
                <select name="preferred_day" class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white text-gray-800">
                    <option value="">Preferred Day (Optional)</option>
                    <option value="Monday" {{ old('preferred_day') == 'Monday' ? 'selected' : '' }}>Monday</option>
                    <option value="Tuesday" {{ old('preferred_day') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                    <option value="Wednesday" {{ old('preferred_day') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                    <option value="Thursday" {{ old('preferred_day') == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                    <option value="Friday" {{ old('preferred_day') == 'Friday' ? 'selected' : '' }}>Friday</option>
                    <option value="Saturday" {{ old('preferred_day') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                    <option value="Sunday" {{ old('preferred_day') == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                </select>
                @error('preferred_day')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-input-group">
            <textarea name="special_requirements" class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white text-gray-800" placeholder="Any special requirements or interests?" rows="4" maxlength="500">{{ old('special_requirements') }}</textarea>
            @error('special_requirements')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-8">
            <button type="submit" class="register-btn btn-professional w-full">
                <span id="register_button_text">{{ $event ? 'Register for Event' : 'Register Interest' }}</span>
            </button>
        </div>
    </form>
</div>
