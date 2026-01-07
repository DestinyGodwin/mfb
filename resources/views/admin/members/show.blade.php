<x-admin-layout title="Member Profile">

    <div class="bg-white p-6 rounded shadow max-w-3xl">
        <h3 class="text-lg font-semibold mb-4">
            {{ $user->first_name }} {{ $user->last_name }}
        </h3>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><strong>Email:</strong> {{ $user->email }}</div>
            <div><strong>Phone:</strong> {{ $user->phone }}</div>
            <div><strong>Status:</strong> {{ ucfirst($user->status) }}</div>
            <div><strong>Approved:</strong> {{ $user->approved ? 'Yes' : 'No' }}</div>
            <div><strong>Department:</strong> {{ $user->department ?? '—' }}</div>
            <div><strong>Place of Work:</strong> {{ $user->place_of_work ?? '—' }}</div>
        </div>
    </div>

</x-admin-layout>
