<x-admin-layout title="Dashboard">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded shadow">
            <p class="text-sm text-gray-500">Pending Members</p>
            <p class="text-2xl font-bold">{{ $pendingMembers }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-sm text-gray-500">Pending Loans</p>
            <p class="text-2xl font-bold">{{ $pendingLoans }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-sm text-gray-500">Total Contributions ({{ now()->year }})</p>
            <p class="text-2xl font-bold">
                ₦{{ number_format($totalThisYear, 2) }}
            </p>
        </div>

    </div>
</x-admin-layout>
