<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Bank Account
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Update your bank details for payouts and refunds.
        </p>
    </header>

    <form method="POST" action="{{ route('profile.bank-account') }}" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        <div>
            <x-input-label for="bank_name" value="Bank Name" />
            <x-text-input
                id="bank_name"
                name="bank_name"
                type="text"
                class="mt-1 block w-full"
                value="{{ old('bank_name', auth()->user()->bankAccount?->bank_name) }}"
                required
            />
            <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="account_number" value="Account Number" />
            <x-text-input
                id="account_number"
                name="account_number"
                type="text"
                class="mt-1 block w-full"
                value="{{ old('account_number', auth()->user()->bankAccount?->account_number) }}"
                required
            />
            <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
        </div>

        <x-primary-button>Save</x-primary-button>
    </form>
</section>
