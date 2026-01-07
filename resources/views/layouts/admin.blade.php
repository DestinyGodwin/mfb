<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r">
            <div class="p-4 font-bold text-lg border-b">
                Admin Panel
            </div>

            <nav class="p-4 space-y-2 text-sm">
                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    Dashboard
                </x-nav-link>

                <x-nav-link :href="route('admin.members.pending')" :active="request()->routeIs('admin.members.*')">
                    Member Approvals
                </x-nav-link>

                <x-nav-link :href="route('admin.loans.pending')" :active="request()->routeIs('admin.loans.*')">
                    Loan Approvals
                </x-nav-link>

                <x-nav-link :href="route('admin.contributions.create')" :active="request()->routeIs('admin.contributions.*')">
                    Record Contribution
                </x-nav-link>

                <x-nav-link :href="route('admin.interest-rates.index')" :active="request()->routeIs('admin.interest-rates.*')">
                    Interest Rates
                </x-nav-link>

                <hr>

                <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-gray-600 hover:bg-gray-100 rounded">
                    ← User Area
                </a>
            </nav>
        </aside>

        {{-- Main --}}
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
