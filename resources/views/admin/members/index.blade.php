<x-admin-layout title="Members">

    <div class="mb-4 flex justify-between items-center">
        <h2 class="font-semibold text-xl">Members</h2>
        <a href="{{ route('admin.members.pending') }}" class="px-3 py-2 bg-yellow-500 text-white rounded">Pending Members</a>
    </div>

    {{-- Search / Filter --}}
    <form method="GET" class="mb-4 flex gap-2 items-end">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email" class="border rounded p-1">
        <select name="status" class="border rounded p-1">
            <option value="">All</option>
            <option value="approved" @selected(request('status') === 'approved')>Approved</option>
            <option value="pending" @selected(request('status') === 'pending')>Pending</option>
        </select>
        <button class="px-3 py-2 bg-indigo-600 text-white rounded">Filter</button>
    </form>

    <div class="space-y-2">
        @foreach($users as $user)
            <div class="bg-white p-4 shadow rounded flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <img class="w-10 h-10 rounded-full"
                         src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('images/default-avatar.png') }}">
                    <div>
                        <p class="font-semibold">{{ $user->first_name }} {{ $user->last_name }}</p>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="flex gap-2">
                    @if(!$user->approved)
                        <form method="POST" action="{{ route('admin.members.approve', $user) }}">
                            @csrf
                            <x-primary-button>Approve</x-primary-button>
                        </form>
                        <form method="POST" action="{{ route('admin.members.reject', $user) }}">
                            @csrf
                            <x-danger-button>Reject</x-danger-button>
                        </form>
                    @else
                        <span class="text-green-600 font-semibold">Approved</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</x-admin-layout>
