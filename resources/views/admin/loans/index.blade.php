<x-admin-layout title="Loans">

    <div class="mb-4 flex justify-between items-center">
        <h2 class="font-semibold text-xl">All Loans</h2>
        <a href="{{ route('admin.loans.create') }}" class="px-3 py-2 bg-green-600 text-white rounded">Create Loan</a>
    </div>

    <div class="bg-white p-6 shadow rounded overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Interest</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Approved At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loans as $loan)
                    <tr>
                        <td>{{ $loan->user->first_name }} {{ $loan->user->last_name }}</td>
                        <td>₦{{ number_format($loan->principal, 2) }}</td>
                        <td>{{ $loan->interest_rate }}%</td>
                        <td>{{ $loan->duration_years }} yrs</td>
                        <td>{{ ucfirst($loan->status) }}</td>
                        <td>{{ $loan->approved_at?->format('d M Y') ?? '—' }}</td>
                        <td>
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
                @endforeach
            </tbody>
        </table>
    </div>

</x-admin-layout>
