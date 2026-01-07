<x-admin-layout title="Record Contribution">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Record Contribution
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white p-6 shadow rounded">
                <form method="POST" action="{{ url('/admin/contributions') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label value="Member" />
                        <select name="user_id" class="w-full border rounded">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" />
                    </div>

                    <div>
                        <x-input-label value="Amount" />
                        <x-text-input name="amount" type="number" class="w-full" required />
                        <x-input-error :messages="$errors->get('amount')" />
                    </div>

                    <div>
                        <x-input-label value="Contribution Date" />
                        <x-text-input name="contribution_date" type="date" class="w-full" required />
                        <x-input-error :messages="$errors->get('contribution_date')" />
                    </div>

                    <x-primary-button>
                        Save Contribution
                    </x-primary-button>
                </form>
            </div>

        </div>
    </div>
</x-admin-layout>
