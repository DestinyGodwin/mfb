<x-admin-layout title="Record Contribution">

    <div class="max-w-xl bg-white p-6 rounded shadow">

        <form method="POST" action="{{ route('admin.contributions.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm">Member</label>
                <select name="user_id" class="w-full border rounded">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->first_name }} {{ $user->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm">Amount</label>
                <input type="number" name="amount" class="w-full border rounded" required>
            </div>

            <div>
                <label class="block text-sm">Contribution Date</label>
                <input type="date" name="contribution_date" class="w-full border rounded" required>
            </div>

            <button class="px-4 py-2 bg-blue-600 text-white rounded">
                Save Contribution
            </button>
        </form>

    </div>

</x-admin-layout>
