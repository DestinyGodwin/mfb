<x-admin-layout title="Pending Loans">

    <div class="bg-white p-6 shadow rounded">
        <table class="w-full text-sm">
    <thead>
        <tr>
            <th>User</th>
            <th>Amount</th>
            <th>Interest</th>
            <th>Duration</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($loans as $loan)
            <tr>
                <td>{{ $loan->user->first_name }} {{ $loan->user->last_name }}</td>
                <td>₦{{ number_format($loan->principal, 2) }}</td>
                <td>{{ $loan->interest_rate }}%</td>
                <td>{{ $loan->duration_years }} yrs</td>
                <td>
                    <form method="POST" action="{{ route('admin.loans.approve', $loan) }}">
                        @csrf
                        <x-primary-button>Approve</x-primary-button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    </div>

</x-admin-layout>
