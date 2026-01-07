<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Contributions
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow rounded">

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Recorded By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contributions as $contribution)
                            <tr class="border-b">
                                <td>{{ $contribution->contribution_date->format('d M Y') }}</td>
                                <td>₦{{ number_format($contribution->amount, 2) }}</td>
                                <td>{{ $contribution->recorder?->first_name ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-500">
                                    No contributions yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
