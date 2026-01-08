<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Profile Information
        </h2>
    </header>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        <x-text-input name="first_name" class="w-full" value="{{ auth()->user()->first_name }}" />
        <x-text-input name="last_name" class="w-full" value="{{ auth()->user()->last_name }}" />

        <x-text-input name="date_of_birth" type="date" class="w-full"
            value="{{ auth()->user()->date_of_birth }}" />

        <select name="sex" class="w-full border rounded p-2">
            <option value="male" @selected(auth()->user()->sex === 'male')>Male</option>
            <option value="female" @selected(auth()->user()->sex === 'female')>Female</option>
        </select>

        <x-text-input name="phone" class="w-full" value="{{ auth()->user()->phone }}" />
        <x-text-input name="address" class="w-full" value="{{ auth()->user()->address }}" />

        <x-text-input name="place_of_work" class="w-full"
            value="{{ auth()->user()->place_of_work }}" />

        <x-text-input name="department" class="w-full"
            value="{{ auth()->user()->department }}" />

        <x-primary-button>Save</x-primary-button>
    </form>
</section>
