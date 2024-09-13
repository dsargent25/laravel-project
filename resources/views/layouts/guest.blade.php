<!DOCTYPE html class="min-h-screen">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Chirper') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>

    <body class="font-sans text-gray-900 antialiased" style="background-color:aliceblue;">

        <header>
            <div>
                <nav class="-mx-3 flex flex-1 justify-end"
                    style="padding:1rem;">
                        <a
                            href="{{ route('login') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] text-black dark:hover:text-white/80 dark:focus-visible:ring-white"
                            style="color:#26A7DE;"
                        >
                            Log in
                        </a>

                            <a
                                href="{{ route('register') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] text-black dark:hover:text-white/80 dark:focus-visible:ring-white"
                                style="color:#26A7DE;"
                            >
                                Register
                            </a>
                </nav>
            </div>
        </header>

        <div class=" flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100" style="background-color:aliceblue;">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>

</html>
