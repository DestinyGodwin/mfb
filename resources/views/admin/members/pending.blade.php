<x-admin-layout title="Pending Members">

    <div class="space-y-4">
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
                    <form method="POST" action="{{ route('admin.members.approve', $user) }}">
                        @csrf
                        <x-primary-button>Approve</x-primary-button>
                    </form>

                    <form method="POST" action="{{ route('admin.members.reject', $user) }}">
                        @csrf
                        <x-danger-button>Reject</x-danger-button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

</x-admin-layout>
