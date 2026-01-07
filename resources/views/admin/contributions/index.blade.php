<x-admin-layout title="Contributions">

    {{-- Filter + Add --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-2 items-end flex-1">
            <div class="flex flex-col">
                <label class="text-xs text-gray-500">From</label>
                <input type="date" name="from" value="{{ request('from') }}"
                       class="border rounded px-2 py-1">
            </div>

            <div class="flex flex-col">
                <label class="text-xs text-gray-500">To</label>
                <input type="date" name="to" value="{{ request('to') }}"
                       class="border rounded px-2 py-1">
            </div>

            <div class="flex flex-col">
                <label class="text-xs text-gray-500">Member</label>
                <select name="user_id" class="border rounded px-2 py-1">
                    <option value="">All Members</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}" @selected(request('user_id') == $member->id)>
                            {{ $member->first_name }} {{ $member->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="px-4 py-2 bg-gray-800 text-white rounded mt-2 sm:mt-0">
                Filter
            </button>
        </form>

        <a href="{{ route('admin.contributions.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded">
            + Add Contribution
        </a>
    </div>

    {{-- Year Total Card --}}
    <div class="bg-white p-6 rounded shadow hover:shadow-md transition mb-6 w-full md:w-1/3">
        <p class="text-sm text-gray-500">Total Contributions ({{ $year }})</p>
        <p class="text-2xl font-bold mt-1">₦{{ number_format($yearTotal, 2) }}</p>
    </div>

    {{-- Contributions Table --}}
    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full text-sm min-w-[600px]">
            <thead class="border-b bg-gray-50">
                <tr>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Member</th>
                    <th class="p-3 text-left">Amount</th>
                    <th class="p-3 text-left">Recorded By</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contributions as $c)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-3">{{ $c->contribution_date->format('d M Y') }}</td>
                        <td class="p-3">{{ $c->member->first_name }} {{ $c->member->last_name }}</td>
                        <td class="p-3">₦{{ number_format($c->amount, 2) }}</td>
                        <td class="p-3">{{ $c->recorder?->first_name ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500">
                            No contributions found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $contributions->links() }}
    </div>

</x-admin-layout>
