<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Loans
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="p-4 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Request Loan --}}
            <div class="bg-white p-6 shadow rounded">
                <h3 class="font-semibold mb-4">Request Loan</h3>

                <form method="POST" action="{{ route('loans.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium">Amount</label>
                        <input type="number" name="principal" class="w-full border rounded p-2" required>
                        @error('principal') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Duration (years)</label>
                        <input type="number" name="duration_years" class="w-full border rounded p-2" required>
                        @error('duration_years') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <button class="px-4 py-2 bg-indigo-600 text-white rounded">
                        Submit Loan Request
                    </button>
                </form>
            </div>

            {{-- Loan History --}}
            <div class="bg-white p-6 shadow rounded">
                <h3 class="font-semibold mb-3">My Loans</h3>

               <table class="w-full text-sm">
    <thead>
        <tr class="border-b">
            <th>Amount</th>
            <th>Interest</th>
            <th>Duration</th>
            <th>Status</th>
            <th>Approved</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($loans as $loan)
            <tr class="border-b">
                <td>₦{{ number_format($loan->principal, 2) }}</td>
                <td>{{ $loan->interest_rate }}%</td>
                <td>{{ $loan->duration_years }} yrs</td>
                <td>{{ ucfirst($loan->status) }}</td>
                <td>
                    {{ $loan->approved_at?->format('d M Y') ?? '—' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">
                    No loans yet
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

            </div>

        </div>
    </div>
</x-app-layout>
