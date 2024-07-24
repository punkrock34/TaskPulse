<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Include JS and CSS via vite, see https://laravel.com/docs/11.x/vite -->
    @vite('resources/css/app.css')
</head>

<body>

    <h1 class="text-4xl text-center mt-10">Welcome to TaskPulse</h1>
    <!-- text stack list, laravel, vite, tailwindcss, flowbite, lighthouse, more -->
    <div class="flex justify-center mt-10">
        <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
            <li class="pb-3 sm:pb-4">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="https://laravel.com/img/logomark.min.svg" alt="">
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Laravel</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">The PHP Framework For Web Artisans.</p>
                    </div>
                </div>
            </li>
            <li class="pb-3 sm:pb-4">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="https://lighthouse-php.com/logo.svg" alt="">
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Lighthouse</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">A PHP package to serve as a simple, extensible and fast PHP router.</p>
                    </div>
                </div>
            </li>
            <li class="pb-3 sm:pb-4">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="https://tailwindui.com/img/logos/workflow-mark.svg?color=rose&shade=500" alt="">
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">TailwindCSS</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">A utility-first CSS framework for rapid UI development.</p>
                    </div>
                </div>
            </li>
            <li class="pb-3 sm:pb-4">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="https://vitejs.dev/logo.svg" alt="">
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Vite</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">A build tool that aims to provide a faster and leaner development experience for modern web projects.</p>
                    </div>
                </div>
            </li>
            <li class="pb-3 sm:pb-4">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="https://flowbite.com/images/logo.svg" alt="">
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Flowbite</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">A free Tailwind CSS components and templates to build beautiful landing pages.</p>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    @vite('resources/js/app.js')
</body>
</html>
