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

        {{-- Profit Distribution --}}
<div class="bg-white p-6 rounded shadow hover:shadow-md transition">
    <p class="text-sm text-gray-500">Profit ({{ $year }})</p>

    @if($profitRate)
        <p class="text-lg font-semibold">
            Rate: {{ $profitRate->percentage }}%
        </p>
    @else
        <p class="text-sm text-red-600">
            No active profit rate
        </p>
    @endif

    <p class="mt-2 text-sm text-gray-600">
        Total Distributed:
        ₦{{ number_format($totalProfitDistributed, 2) }}
    </p>

    <p class="mt-1 text-sm">
        Status:
        <span class="{{ $profitDistributed ? 'text-green-600' : 'text-yellow-600' }}">
            {{ $profitDistributed ? 'Distributed' : 'Not Distributed' }}
        </span>
    </p>

    <div class="mt-3 flex gap-2">
        <a href="{{ route('admin.profits.index', ['year' => $year]) }}"
           class="text-sm text-blue-600 hover:underline">
            View
        </a>

        <a href="{{ route('admin.profit-rates.index') }}"
           class="text-sm text-blue-600 hover:underline">
            Rates
        </a>
    </div>
</div>

    </div>

</x-admin-layout>
