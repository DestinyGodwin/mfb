<x-admin-layout title="Add Member">

    <div class="bg-white p-6 rounded shadow max-w-3xl mx-auto">

        <h3 class="text-lg font-semibold mb-6">Add New Member</h3>

        {{-- Success / Temp Password --}}
        @if(session('success'))
            <div class="p-4 mb-2 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('temp_password'))
            <div class="p-4 mb-6 bg-yellow-100 text-yellow-800 rounded">
                Temporary Password: <strong>{{ session('temp_password') }}</strong>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.members.store') }}" class="space-y-4">
            @csrf

            {{-- Names --}}
            <div>
                <label class="block text-sm font-medium">First Name</label>
                <input type="text" name="first_name" class="w-full border rounded p-2" value="{{ old('first_name') }}" required>
                @error('first_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Last Name</label>
                <input type="text" name="last_name" class="w-full border rounded p-2" value="{{ old('last_name') }}" required>
                @error('last_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email & Phone --}}
            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" class="w-full border rounded p-2" value="{{ old('email') }}" required>
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Phone</label>
                <input type="text" name="phone" class="w-full border rounded p-2" value="{{ old('phone') }}" required>
                @error('phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Date of Birth --}}
            <div>
                <label class="block text-sm font-medium">Date of Birth</label>
                <input type="date" name="date_of_birth" class="w-full border rounded p-2" value="{{ old('date_of_birth') }}" required>
                @error('date_of_birth') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Sex --}}
            <div>
                <label class="block text-sm font-medium">Sex</label>
                <select name="sex" class="w-full border rounded p-2" required>
                    <option value="">Select Sex</option>
                    <option value="male" @selected(old('sex') === 'male')>Male</option>
                    <option value="female" @selected(old('sex') === 'female')>Female</option>
                </select>
                @error('sex') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Address --}}
            <div>
                <label class="block text-sm font-medium">Address</label>
                <input type="text" name="address" class="w-full border rounded p-2" value="{{ old('address') }}" required>
                @error('address') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Department & Place of Work --}}
            <div>
                <label class="block text-sm font-medium">Department</label>
                <input type="text" name="department" class="w-full border rounded p-2" value="{{ old('department') }}">
                @error('department') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Place of Work</label>
                <input type="text" name="place_of_work" class="w-full border rounded p-2" value="{{ old('place_of_work') }}">
                @error('place_of_work') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                Add Member
            </button>
        </form>
    </div>

</x-admin-layout>
