<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'CoopFund') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">

    <header class="border-b bg-white">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                {{-- Inline finance SVG logo --}}
                <div class="h-8 w-8 text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="currentColor">
                        <path d="M32 2C15.432 2 2 15.432 2 32s13.432 30 30 30 30-13.432 30-30S48.568 2 32 2zm0 56C17.664 58 6 46.336 6 32S17.664 6 32 6s26 11.664 26 26-11.664 26-26 26z"/>
                        <path d="M44 26H20v4h24v-4zM44 34H20v4h24v-4z"/>
                    </svg>
                </div>

                <span class="font-semibold text-lg text-gray-800">
                    {{ config('app.name', 'CoopFund') }}
                </span>
            </div>

            @if (Route::has('login'))
                <nav class="flex items-center gap-4 text-sm">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="px-4 py-2 rounded-md border text-gray-700 hover:bg-gray-100"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="text-gray-600 hover:text-gray-900"
                        >
                            Login
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800"
                            >
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <main class="flex-1">
        <section class="max-w-6xl mx-auto px-6 py-24 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Empower Your Cooperative Finance
            </h1>

            <p class="text-gray-600 max-w-2xl mx-auto mb-8">
                Manage loans, savings, and member contributions with clarity, security, and transparency.
            </p>

            <div class="flex justify-center gap-4">
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="px-6 py-3 rounded-md bg-gray-900 text-white hover:bg-gray-800"
                    >
                        Go to Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('register') }}"
                        class="px-6 py-3 rounded-md bg-gray-900 text-white hover:bg-gray-800"
                    >
                        Get Started
                    </a>

                    <a
                        href="{{ route('login') }}"
                        class="px-6 py-3 rounded-md border text-gray-700 hover:bg-gray-100"
                    >
                        Sign In
                    </a>
                @endauth
            </div>
        </section>
    </main>

    <footer class="border-t bg-white">
        <div class="max-w-6xl mx-auto px-6 py-4 text-sm text-gray-500 text-center">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </footer>

</body>
</html>
