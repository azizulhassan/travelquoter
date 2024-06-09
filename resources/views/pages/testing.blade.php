<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />

        <meta name="application-name" content="{{ config('app.name') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        @yield('seo')

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles
        @vite('resources/css/app.css')
    </head>

    <body class="antialiased bg-gray-300 container mx-auto">

        <main class="max-w-screen-xl mx-auto p-6">
            {{-- <livewire:flight.add-options flight_type="oneway" id="primary" />
            <livewire:flight.add-options flight_type="roundway" id="primary" />
            <livewire:flight.add-options flight_type="multicity" id="1" /> --}}
            <livewire:working-with-test-component />
            {{-- <livewire:testing-out-search-api /> --}}
        </main>

        <livewire:chat.client-and-client-chat id=1 />

        {{-- <livewire:chat.client-and-agent /> --}}

        @livewire('notifications')

        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html>
