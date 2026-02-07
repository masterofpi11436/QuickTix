<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      class="bg-gray-100 dark:bg-gray-900 {{ auth()->check() && auth()->user()->theme === 'dark' ? 'dark' : '' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" href="{{ asset('favicon.svg') }}">

        <title>{{ config('app.name', 'QuickTix') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireScripts
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 min-h-dvh">
        <div class="min-h-dvh bg-gray-100 dark:bg-gray-900">
            <livewire:layout.admin-navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="min-h-dvh">
                {{ $slot }}
            </main>
        </div>

        @stack('scripts')
        <script src="{{ asset('javascript/flash-message-expiry.js') }}"></script>

        // Notifying of tickets that are crucial for the organization
    </body>
</html>
