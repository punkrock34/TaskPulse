<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' | ' : '' }}{{ config('app.name', 'TaskPulse') }}</title>
    @vite('resources/css/app.css')
    <script>
        // It's best to inline this in `head` to avoid FOUC (flash of unstyled content) when changing pages or themes
        if (
            localStorage.getItem('color-theme') === 'dark' ||
            (
                !('color-theme' in localStorage) &&
                window.matchMedia('(prefers-color-scheme: dark)').matches
            )
        ) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <x-header />

    <main class="flex-grow flex">
        @yield('content')
    </main>

    <x-footer />

    @vite('resources/js/app.js')
</body>
</html>
