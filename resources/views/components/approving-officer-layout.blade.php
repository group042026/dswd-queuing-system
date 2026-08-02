<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} - Approving Officer</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <div class="flex">
                <!-- Sidebar -->
                <aside class="w-64 min-h-screen bg-gray-800 text-white">
                    <div class="p-4 text-lg font-semibold border-b border-gray-700">
                        Approving Officer Panel
                    </div>
                    <nav class="mt-4">
                        <a href="{{ route('approving-officer.dashboard') }}"
                           class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('approving-officer.dashboard') ? 'bg-gray-700' : '' }}">
                            Dashboard
                        </a>
                    </nav>
                </aside>

                <!-- Main Content -->
                <div class="flex-1">
                    @isset($header)
                        <header class="bg-white shadow">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <main class="p-6">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>