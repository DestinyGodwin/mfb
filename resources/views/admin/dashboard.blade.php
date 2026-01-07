<x-admin-layout title="Dashboard">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Members --}}
        <div class="bg-white p-6 rounded shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500">Members</p>
            <p class="text-2xl font-bold">{{ $totalMembers }}</p>
            <p class="text-sm text-gray-500 mt-1">
                Pending: {{ $pendingMembers }}
            </p>
        </div>

        {{-- Loans --}}
        <div class="bg-white p-6 rounded shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500">Loans</p>
            <p class="text-2xl font-bold">{{ $totalLoans }}</p>
            <p class="text-sm text-gray-500 mt-1">
                Pending: {{ $pendingLoans }}
            </p>
            <p class="text-sm text-gray-500 mt-1">
                Total Amount: ₦{{ number_format($totalLoanAmount, 2) }}
            </p>
        </div>

        {{-- Contributions --}}
        <div class="bg-white p-6 rounded shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500">Contributions ({{ now()->year }})</p>
            <p class="text-2xl font-bold">₦{{ number_format($totalThisYear, 2) }}</p>
        </div>

    </div>

</x-admin-layout>
