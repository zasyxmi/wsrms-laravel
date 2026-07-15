<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'WSRMS') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased text-slate-900">
        <div class="ws-page-bg min-h-screen">
            @include('layouts.navigation')

            <div class="lg:pl-72">
                @isset($header)
                    <header class="px-4 sm:px-6 lg:px-8 pt-6">
                        <div class="max-w-7xl mx-auto">
                            <div class="ws-card px-6 py-5">
                                {{ $header }}
                            </div>
                        </div>
                    </header>
                @endisset

                <main data-gsap-page>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
