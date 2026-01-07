<x-guest-layout>
    <form method="POST"
          action="{{ route('register') }}"
          enctype="multipart/form-data">
        @csrf

        {{-- First Name --}}
        <div>
            <x-input-label for="first_name" value="First Name" />
            <x-text-input id="first_name"
                          class="block mt-1 w-full"
                          type="text"
                          name="first_name"
                          :value="old('first_name')"
                          required />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        {{-- Last Name --}}
        <div class="mt-4">
            <x-input-label for="last_name" value="Last Name" />
            <x-text-input id="last_name"
                          class="block mt-1 w-full"
                          type="text"
                          name="last_name"
                          :value="old('last_name')"
                          required />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div class="mt-4">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email"
                          class="block mt-1 w-full"
                          type="email"
                          name="email"
                          :value="old('email')"
                          required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Phone --}}
        <div class="mt-4">
            <x-input-label for="phone" value="Phone Number" />
            <x-text-input id="phone"
                          class="block mt-1 w-full"
                          type="text"
                          name="phone"
                          :value="old('phone')"
                          required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        {{-- Date of Birth --}}
        <div class="mt-4">
            <x-input-label for="date_of_birth" value="Date of Birth" />
            <x-text-input id="date_of_birth"
                          class="block mt-1 w-full"
                          type="date"
                          name="date_of_birth"
                          :value="old('date_of_birth')"
                          required />
            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
        </div>

        {{-- Sex --}}
        <div class="mt-4">
            <x-input-label for="sex" value="Sex" />
            <select name="sex"
                    id="sex"
                    class="block mt-1 w-full border-gray-300 rounded-md">
                <option value="">Select</option>
                <option value="male" @selected(old('sex') === 'male')>Male</option>
                <option value="female" @selected(old('sex') === 'female')>Female</option>
            </select>
            <x-input-error :messages="$errors->get('sex')" class="mt-2" />
        </div>

        {{-- Address --}}
        <div class="mt-4">
            <x-input-label for="address" value="Address" />
            <x-text-input id="address"
                          class="block mt-1 w-full"
                          type="text"
                          name="address"
                          :value="old('address')"
                          required />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        {{-- Place of Work --}}
        <div class="mt-4">
            <x-input-label for="place_of_work" value="Place of Work" />
            <x-text-input id="place_of_work"
                          class="block mt-1 w-full"
                          type="text"
                          name="place_of_work"
                          :value="old('place_of_work')" />
        </div>

        {{-- Department --}}
        <div class="mt-4">
            <x-input-label for="department" value="Department" />
            <x-text-input id="department"
                          class="block mt-1 w-full"
                          type="text"
                          name="department"
                          :value="old('department')" />
        </div>

        {{-- Avatar --}}
        <div class="mt-4">
            <x-input-label for="avatar" value="Avatar" />
            <input type="file"
                   name="avatar"
                   id="avatar"
                   class="block w-full text-sm text-gray-600">
            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password"
                          class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input id="password_confirmation"
                          class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation"
                          required />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900"
               href="{{ route('login') }}">
                Already registered?
            </a>

            <x-primary-button class="ms-4">
                Register
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
