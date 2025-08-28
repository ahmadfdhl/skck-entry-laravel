<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistem SKCK Online') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-100 to-gray-300">
        
        {{-- Logo + Title --}}
        <div class="flex flex-col items-center">
            <a href="/">
                <img src="{{ asset('images/Lambang_Polri.png') }}" alt="Logo POLRI" class="w-24 h-24">
            </a>
            <h1 class="mt-3 text-xl font-bold text-gray-800">{{ 'Sistem SKCK Entry' }}</h1>
            <p class="text-sm text-gray-500">Silakan login untuk melanjutkan</p>
        </div>

        {{-- Card Form --}}
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-lg sm:rounded-xl">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
