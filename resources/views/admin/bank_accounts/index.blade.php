<x-admin-layout title="Bank Accounts">

    <div class="flex justify-end gap-3 mb-4">
        <a href="{{ route('admin.bank-accounts.export.excel') }}"
           class="px-4 py-2 bg-green-600 text-white rounded">
            Export Excel
        </a>

        <a href="{{ route('admin.bank-accounts.export.pdf') }}"
           class="px-4 py-2 bg-red-600 text-white rounded">
            Export PDF
        </a>
    </div>

    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-3 text-left">Member</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Phone</th>
                    <th class="p-3 text-left">Bank</th>
                    <th class="p-3 text-left">Account Number</th>
                </tr>
            </thead>
            <tbody>
                @forelse($accounts as $account)
                    <tr class="border-b">
                        <td class="p-3">
                            {{ $account->user->first_name }}
                            {{ $account->user->last_name }}
                        </td>
                        <td class="p-3">{{ $account->user->email }}</td>
                        <td class="p-3">{{ $account->user->phone }}</td>
                        <td class="p-3">{{ $account->bank_name }}</td>
                        <td class="p-3">{{ $account->account_number }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">
                            No bank accounts found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $accounts->links() }}
        </div>
    </div>

</x-admin-layout>
