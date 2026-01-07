<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="p-4 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white p-6 shadow rounded">
                <h3 class="text-lg font-semibold mb-4">Account Overview</h3>

                <p><strong>Name:</strong> {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>

                <p class="mt-3">
                    <strong>Account Status:</strong>
                    <span class="px-2 py-1 text-sm rounded
                        {{ auth()->user()->status === 'active'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst(auth()->user()->status) }}
                    </span>
                </p>
            </div>

            <div class="bg-white p-6 shadow rounded">
                <h3 class="text-lg font-semibold mb-2">
                    Contributions ({{ now()->year }})
                </h3>

                <p class="text-2xl font-bold text-indigo-600">
                    ₦{{ number_format(
                        auth()->user()
                            ->contributions()
                            ->whereYear('contribution_date', now()->year)
                            ->sum('amount'),
                        2
                    ) }}
                </p>
            </div>

        </div>
    </div>
</x-app-layout>