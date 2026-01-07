<x-admin-layout title="Loans">

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500">Total Loans</p>
            <p class="text-2xl font-bold">{{ $totalLoans }}</p>
            <p class="text-sm text-gray-500 mt-1">
                Total Amount: ₦{{ number_format($totalLoanAmount, 2) }}
            </p>
        </div>

        <div class="bg-white p-6 rounded shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500">Pending Loans</p>
            <p class="text-2xl font-bold">{{ $pendingLoans }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500">Approved Loans</p>
            <p class="text-2xl font-bold">{{ $approvedLoans }}</p>
        </div>
    </div>

    {{-- Filter Panel --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-2 items-end flex-1">
            <div class="flex flex-col">
                <label class="text-xs text-gray-500">From</label>
                <input type="date" name="from" value="{{ request('from') }}" class="border rounded px-2 py-1">
            </div>
            <div class="flex flex-col">
                <label class="text-xs text-gray-500">To</label>
                <input type="date" name="to" value="{{ request('to') }}" class="border rounded px-2 py-1">
            </div>
            <div class="flex flex-col">
                <label class="text-xs text-gray-500">User</label>
                <select name="user_id" class="border rounded px-2 py-1">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>
                            {{ $user->first_name }} {{ $user->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button class="px-4 py-2 bg-gray-800 text-white rounded mt-2 sm:mt-0">
                Filter
            </button>
        </form>

        <a href="{{ route('admin.loans.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">
            + Create Loan
        </a>
    </div>

    {{-- Loans Table --}}
    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full text-sm min-w-[800px]">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-3 text-left">User</th>
                    <th class="p-3 text-left">Amount</th>
                    <th class="p-3 text-left">Interest</th>
                    <th class="p-3 text-left">Duration</th>
                    <th class="p-3 text-left">Total Payable</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Approved At</th>
                    <th class="p-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-3">{{ $loan->user->first_name }} {{ $loan->user->last_name }}</td>
                        <td class="p-3">₦{{ number_format($loan->principal, 2) }}</td>
                        <td class="p-3">{{ $loan->interest_rate }}%</td>
                        <td class="p-3">{{ $loan->duration_years }} yrs</td>
                        <td class="p-3">₦{{ number_format($loan->total_payable, 2) }}</td>
                        <td class="p-3">{{ ucfirst($loan->status) }}</td>
                        <td class="p-3">{{ $loan->approved_at?->format('d M Y') ?? '—' }}</td>
                        <td class="p-3">
                            @if($loan->status === 'pending')
                                <form method="POST" action="{{ route('admin.loans.approve', $loan) }}">
                                    @csrf
                                    <x-primary-button>Approve</x-primary-button>
                                </form>
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">
                            No loans found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $loans->links() }}
    </div>

</x-admin-layout>
