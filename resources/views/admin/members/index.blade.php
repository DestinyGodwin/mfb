<x-admin-layout title="Members">

    {{-- Top Bar --}}
    <div class="flex justify-between items-center mb-6">
        {{-- Filters --}}
        <form method="GET" class="flex gap-3">
            <select name="approved" class="border rounded px-3 py-2">
                <option value="">Approval</option>
                <option value="0" @selected(request('approved') === '0')>Pending</option>
                <option value="1" @selected(request('approved') === '1')>Approved</option>
            </select>

            <select name="status" class="border rounded px-3 py-2">
                <option value="">Status</option>
                <option value="active" @selected(request('status') === 'active')>Active</option>
                <option value="suspended" @selected(request('status') === 'suspended')>Suspended</option>
                <option value="blocked" @selected(request('status') === 'blocked')>Blocked</option>
            </select>

            <button class="px-4 py-2 bg-gray-800 text-white rounded">
                Filter
            </button>
        </form>

        {{-- Create Member Button --}}
        <a href="{{ route('admin.members.create') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            + Add Member
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-center">Approval</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($members as $member)
                    <tr class="border-b hover:bg-gray-50 cursor-pointer"
                        onclick="window.location='{{ route('admin.members.show', $member) }}'">

                        <td class="p-3">
                            {{ $member->first_name }} {{ $member->last_name }}
                        </td>

                        <td class="p-3 text-center">
                            @if ($member->approved)
                                <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded">
                                    Approved
                                </span>
                            @else
                                <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded">
                                    Pending
                                </span>
                            @endif
                        </td>

                        <td class="p-3 text-center">
                            <span class="text-xs px-2 py-1 bg-gray-100 rounded">
                                {{ ucfirst($member->status) }}
                            </span>
                        </td>

                        <td class="p-3 text-right" onclick="event.stopPropagation()">
                            @if (! $member->approved)
                                <form method="POST"
                                      action="{{ route('admin.members.approve', $member) }}">
                                    @csrf
                                    <button class="px-3 py-1 text-xs bg-green-600 text-white rounded">
                                        Approve
                                    </button>
                                </form>
                            @else
                                <form method="POST"
                                      action="{{ route('admin.members.status', $member) }}">
                                    @csrf
                                    @method('PATCH')

                                    <select name="status"
                                            onchange="this.form.submit()"
                                            class="text-xs border rounded">
                                        @foreach (['active', 'suspended', 'blocked'] as $status)
                                            <option value="{{ $status }}"
                                                @selected($member->status === $status)>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500">
                            No members found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $members->links() }}
    </div>

</x-admin-layout>
