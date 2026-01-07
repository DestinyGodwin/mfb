<x-admin-layout title="Interest Rates">

    @if(session('status'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded shadow space-y-4">

        <form method="POST">
            @csrf
            <label class="block text-sm font-medium">New Interest Rate (%)</label>
            <input type="number" step="0.01" name="rate" class="border rounded w-full p-2" required>
            <x-primary-button class="mt-3">Set Rate</x-primary-button>
        </form>

        <hr>

        <table class="w-full text-sm">
            <thead>
                <tr>
                    <th>Rate</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rates as $rate)
                    <tr>
                        <td>{{ $rate->rate }}%</td>
                        <td>{{ $rate->active ? 'Active' : 'Inactive' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</x-admin-layout>
