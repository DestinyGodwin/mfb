<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Loans
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Session Status --}}
            @if (session('status'))
                <div class="p-4 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Loan Request Form --}}
            <div class="bg-white p-6 shadow rounded">
                <h3 class="font-semibold mb-4">Request Loan</h3>

                <form method="POST" action="{{ route('loans.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium">Amount</label>
                        <input
                            type="number"
                            name="principal"
                            class="w-full border rounded p-2"
                            min="1"
                            required
                            value="{{ old('principal') }}"
                        >
                        @error('principal')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Duration (years)</label>
                        <input
                            type="number"
                            name="duration_years"
                            class="w-full border rounded p-2"
                            min="1"
                            required
                            value="{{ old('duration_years') }}"
                        >
                        @error('duration_years')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition"
                    >
                        Submit Loan Request
                    </button>
                </form>
            </div>

            {{-- Loan History --}}
            <div class="bg-white p-6 shadow rounded overflow-x-auto">
                <h3 class="font-semibold mb-3">My Loans</h3>

                <table class="w-full text-sm min-w-[600px]">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-3 text-left">Amount</th>
                            <th class="p-3 text-left">Interest</th>
                            <th class="p-3 text-left">Duration</th>
                            <th class="p-3 text-left">Total Payable</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Approved At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($loans as $loan)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="p-3">₦{{ number_format($loan->principal, 2) }}</td>
                                <td class="p-3">{{ $loan->interest_rate }}%</td>
                                <td class="p-3">{{ $loan->duration_years }} yrs</td>
                                <td class="p-3">₦{{ number_format($loan->total_payable, 2) }}</td>
                                <td class="p-3">{{ ucfirst($loan->status) }}</td>
                                <td class="p-3">{{ $loan->approved_at?->format('d M Y') ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-500">
                                    No loans yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $loans->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
