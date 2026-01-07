<x-admin-layout title="Create Loan">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Create Loan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded">
                <form method="POST" action="{{ route('admin.loans.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label value="Member" />
                        <select name="user_id" class="w-full border rounded" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" />
                    </div>

                    <div>
                        <x-input-label value="Amount" />
                        <x-text-input name="principal" type="number" class="w-full" required />
                        <x-input-error :messages="$errors->get('principal')" />
                    </div>

                    <div>
                        <x-input-label value="Duration (Years)" />
                        <x-text-input name="duration_years" type="number" class="w-full" required />
                        <x-input-error :messages="$errors->get('duration_years')" />
                    </div>

                    <x-primary-button>Save Loan</x-primary-button>
                </form>
            </div>
        </div>
    </div>

</x-admin-layout>
