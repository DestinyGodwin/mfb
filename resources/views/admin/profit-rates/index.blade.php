<x-admin-layout title="Profit Rates">

@if(session('status'))
    <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-2">
        {{ session('status') }}
    </div>
@endif

<div class="bg-white rounded shadow p-6 mb-6">
    <h3 class="text-lg font-semibold mb-4">Add Profit Rate</h3>

    <form method="POST" action="{{ route('admin.profit-rates.store') }}"
          class="flex flex-col sm:flex-row gap-4">
        @csrf

        <input
            type="number"
            name="year"
            placeholder="Year"
            required
            class="w-full sm:w-40 border rounded px-3 py-2 focus:outline-none focus:ring"
        >

        <input
            type="number"
            step="0.01"
            name="percentage"
            placeholder="Rate (%)"
            required
            class="w-full sm:w-40 border rounded px-3 py-2 focus:outline-none focus:ring"
        >

        <button
            type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition"
        >
            Add Rate
        </button>
    </form>
</div>

<div class="bg-white rounded shadow p-6">
    <h3 class="text-lg font-semibold mb-4">Existing Rates</h3>

    <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2 border">Year</th>
                    <th class="px-4 py-2 border">Rate (%)</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($rates as $rate)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $rate->year }}</td>
                        <td class="px-4 py-2 border">{{ $rate->percentage }}</td>
                        <td class="px-4 py-2 border">
                            <span class="px-2 py-1 text-xs rounded
                                {{ $rate->active
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-gray-100 text-gray-600' }}">
                                {{ $rate->active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border">
                            @if(!$rate->active)
                                <form method="POST"
                                      action="{{ route('admin.profit-rates.activate', $rate) }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="bg-emerald-600 text-white px-3 py-1 rounded text-xs hover:bg-emerald-700 transition"
                                    >
                                        Activate
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                            No profit rates yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</x-admin-layout>
