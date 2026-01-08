<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r flex flex-col">
            <div class="p-4 font-bold text-lg border-b">
                Admin Panel
            </div>

            <nav class="flex-1 p-4 space-y-2 text-sm flex flex-col">
                {{-- Each link is a full-width block --}}
                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    Dashboard
                </x-nav-link>

                <x-nav-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')">
                    Members
                </x-nav-link>

                <x-nav-link :href="route('admin.loans.index')" :active="request()->routeIs('admin.loans.*')">
                    Loans
                </x-nav-link>

                <x-nav-link :href="route('admin.contributions.index')" :active="request()->routeIs('admin.contributions.*')">
                    Contributions
                </x-nav-link>

                <x-nav-link :href="route('admin.interest-rates.index')" :active="request()->routeIs('admin.interest-rates.*')">
                    Interest Rates
                </x-nav-link>

                <x-nav-link :href="route('admin.bank-accounts.index')" :active="request()->routeIs('admin.bank-accounts.*')">
                    Bank Accounts
                </x-nav-link>


                <hr class="my-2">

                <a href="{{ route('dashboard') }}" class="block w-full px-3 py-2 text-gray-600 hover:bg-gray-100 rounded">
                    ← User Area
                </a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1">
            <header class="bg-white shadow p-4">
                <h2 class="font-semibold text-xl text-gray-800">
                    {{ $title ?? 'Admin' }}
                </h2>
            </header>

            <div class="p-6">
                {{ $slot }}
            </div>
        </main>

    </div>
</x-app-layout>
