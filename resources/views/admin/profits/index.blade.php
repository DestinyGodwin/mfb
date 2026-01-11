<x-admin-layout title="Annual Profit Distribution">

    @if(session('status'))
        <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-2">
            {{ session('status') }}
        </div>
    @endif

    {{-- Actions --}}
    <div class="bg-white rounded shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-end gap-4">

            <form method="POST"
                  action="{{ route('admin.profits.distribute') }}"
                  class="flex flex-col sm:flex-row gap-4 items-end">
                @csrf

                <div>
                    <label class="block text-sm text-gray-600 mb-1">Year</label>
                    <input
                        type="number"
                        name="year"
                        value="{{ $year }}"
                        required
                        class="w-40 border rounded px-3 py-2 focus:outline-none focus:ring"
                    >
                </div>

                <button
                    type="submit"
                    class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700 transition"
                >
                    Distribute Profit
                </button>
            </form>

            <div class="flex gap-2">
                <a href="{{ route('admin.profits.export.excel', ['year' => $year]) }}"
                   class="px-4 py-2 bg-green-600 text-white rounded">
                    Export Excel
                </a>

                <a href="{{ route('admin.profits.export.pdf', ['year' => $year]) }}"
                   class="px-4 py-2 bg-red-600 text-white rounded">
                    Export PDF
                </a>
            </div>

        </div>
    </div>

    {{-- Distribution Table --}}
    <div class="bg-white rounded shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Distribution Breakdown</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 border">Member</th>
                        <th class="px-4 py-2 border">Total Contribution</th>
                        <th class="px-4 py-2 border">Profit</th>
                        <th class="px-4 py-2 border">Distributed At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($profits as $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">
                                {{ $p->user->first_name }} {{ $p->user->last_name }}
                            </td>
                            <td class="px-4 py-2 border">
                                ₦{{ number_format($p->total_contribution, 2) }}
                            </td>
                            <td class="px-4 py-2 border font-semibold">
                                ₦{{ number_format($p->profit_amount, 2) }}
                            </td>
                            <td class="px-4 py-2 border text-sm text-gray-600">
                                {{ optional($p->distributed_at)->format('Y-m-d') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                No profit distributed for this year.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>
