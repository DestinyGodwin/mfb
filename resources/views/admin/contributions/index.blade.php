<x-admin-layout title="Contributions">

    {{-- Success message --}}
    @if(session('status'))
        <div class="p-4 mb-4 bg-green-100 text-green-800 rounded">
            {{ session('status') }}
        </div>
    @endif

    {{-- Filter + Actions --}}
    <div class="flex flex-col md:flex-row justify-between items-end gap-4 mb-6">

        <form method="GET" class="flex flex-col sm:flex-row gap-2 items-end flex-1">

            <div class="flex flex-col">
                <label class="text-xs text-gray-500">From</label>
                <input type="date" name="from" value="{{ request('from') }}" class="border rounded px-2 py-1">
            </div>

            <div class="flex flex-col">
                <label class="text-xs text-gray-500">To</label>
                <input type="date" name="to" value="{{ request('to') }}" class="border rounded px-2 py-1">
            </div>

            <div class="flex flex-col w-full sm:w-64">
                <label class="text-xs text-gray-500">Members</label>
                <select name="user_ids[]" multiple id="members-select" class="border rounded px-2 py-1">
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}"
                            @selected(collect(request('user_ids'))->contains($member->id))>
                            {{ $member->first_name }} {{ $member->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="px-4 py-2 bg-gray-800 text-white rounded mt-2 sm:mt-0">Filter</button>
        </form>

        <div class="flex gap-2">
            <a href="{{ route('admin.contributions.export.excel', request()->query()) }}" class="px-4 py-2 bg-green-600 text-white rounded">Export Excel</a>
            <a href="{{ route('admin.contributions.export.pdf', request()->query()) }}" class="px-4 py-2 bg-red-600 text-white rounded">Export PDF</a>
            <a href="{{ route('admin.contributions.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">+ Add Contribution</a>
        </div>
    </div>

    {{-- Summary --}}
    <div class="bg-white p-6 rounded shadow mb-6">
        <p class="text-sm text-gray-500">Summary</p>
        <div class="mt-2 text-sm space-y-1">
            <p><strong>Period:</strong> {{ request('from') ?? 'Beginning' }} → {{ request('to') ?? 'Today' }}</p>
            <p><strong>Members:</strong> {{ $selectedMemberNames }}</p>
            <p class="text-xl font-bold mt-2">Total: ₦{{ number_format($totalAmount, 2) }}</p>
        </div>
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
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $c->contribution_date->format('d M Y') }}</td>
                        <td class="p-3">{{ $c->member->first_name }} {{ $c->member->last_name }}</td>
                        <td class="p-3">₦{{ number_format($c->amount, 2) }}</td>
                        <td class="p-3">{{ $c->recorder?->first_name ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500">No contributions found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">{{ $contributions->links() }}</div>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-container--default .select2-selection--multiple {
                border: 1px solid #d1d5db !important;
                border-radius: 0.375rem !important;
                padding: 0.25rem !important;
                min-height: 38px !important;
            }
            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: #3b82f6;
                color: white;
                border: none;
                border-radius: 0.25rem;
                padding: 0.125rem 0.5rem;
                margin-right: 0.25rem;
                margin-bottom: 0.25rem;
            }
            .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                color: white;
                margin-right: 0.25rem;
            }
            .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
                color: #fbbf24;
            }
        </style>
    @endpush

    @push('scripts')
        <!-- Load jQuery first -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Then load Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#members-select').select2({
                    placeholder: 'Select members...',
                    allowClear: true,
                    width: '100%',
                    closeOnSelect: false
                });
            });
        </script>
    @endpush

</x-admin-layout>