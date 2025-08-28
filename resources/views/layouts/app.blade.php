<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="w-64 bg-gray-800 text-white flex flex-col h-screen fixed">
            {{-- Logo + App Name --}}
            <div class="h-20 flex items-center justify-center border-b border-gray-700">
                <img src="{{ asset('images/LOGO_INTELKAM_POLRI.png') }}" alt="Logo" class="h-10 w-10 mr-2">
                <span class="font-bold text-lg">{{ 'SKCK Entry' }}</span>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-gray-700">
                    <i class="bi bi-house px-2"></i> {{ __('Dashboard') }}
                </x-nav-link>

                <x-nav-link :href="route('skck.list')" :active="request()->is('skck')" class="text-white hover:bg-gray-700">
                    <i class="bi bi-list px-2"></i> Daftar SKCK
                </x-nav-link>

                <x-nav-link :href="route('skck.create')" :active="request()->is('skck/create')" class="text-white hover:bg-gray-700">
                    <i class="bi bi-plus-circle px-2"></i> Buat SKCK Baru
                </x-nav-link>

                <x-nav-link :href="route('reports.index')" :active="request()->is('reports*')" class="text-white hover:bg-gray-700">
                    <i class="bi bi-cash px-2"></i> Laporan Keuangan
                </x-nav-link>

                <x-nav-link :href="route('settings.index')" :active="request()->is('settings')" class="text-white hover:bg-gray-700">
                    <i class="bi bi-gear px-2"></i> Pengaturan
                </x-nav-link>
            </nav>

            {{-- User Dropdown --}}
            <div class="p-4 border-t border-gray-700">
                <div class="flex items-center justify-between">
                    <a href="{{ route('profile.edit') }}"><i class="bi bi-person px-3"></i><span>{{ Auth::user()->name }}</span></a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-400 hover:text-red-600">Logout</button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col ml-64"> {{-- ml-64 supaya konten geser setelah sidebar --}}
            @isset($header)
                <header class="bg-white shadow p-4">
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        {{ $header }}
                    </h2>
                </header>
            @endisset

            <main class="p-6 overflow-y-auto flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
