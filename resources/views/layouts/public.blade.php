<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="flex min-h-screen flex-col bg-gray-100 pt-6 sm:pt-0">
            <header class="bg-gray-900 p-4 text-lg text-gray-50">
                <div class="container mx-auto flex h-12 justify-between">
                    <a rel="noopener noreferrer" href="#" aria-label="Back to homepage" class="flex items-center p-2">
                        <x-application-logo class="h-20 w-20" />
                    </a>

                    <div class="hidden flex-shrink-0 items-center lg:flex">
                        <button class="self-center rounded px-8 py-3">Sign in</button>
                        <button class="self-center rounded bg-orange-600 px-8 py-3 font-semibold text-gray-50">
                            Sign up
                        </button>
                    </div>
                </div>
            </header>

            {{ $slot }}

            <footer class="bg-gray-100 px-4 py-8 text-gray-600">
                <div
                    class="container mx-auto flex flex-wrap items-center justify-center space-y-4 sm:justify-between sm:space-y-0"
                >
                    <div class="flex flex-row space-x-4 pr-3 sm:space-x-8">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-gray-900">
                            <x-application-logo class="h-12 w-12" />
                        </div>
                        <ul class="flex flex-wrap items-center space-x-4 sm:space-x-8">
                            <li>
                                <a rel="noopener noreferrer" href="#">Terms of Use</a>
                            </li>
                            <li>
                                <a rel="noopener noreferrer" href="#">Privacy</a>
                            </li>
                        </ul>
                    </div>
                    <ul class="flex flex-wrap space-x-4 pl-3 sm:space-x-8">
                        <li>
                            <a rel="noopener noreferrer" href="#">Instagram</a>
                        </li>
                        <li>
                            <a rel="noopener noreferrer" href="#">Facebook</a>
                        </li>
                        <li>
                            <a rel="noopener noreferrer" href="#">Twitter</a>
                        </li>
                    </ul>
                </div>
            </footer>
        </div>
    </body>
</html>
