<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    {{-- External Libraries --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
</head>

<body class="font-sans antialiased bg-white dark:bg-zinc-900 text-black dark:text-white">

    {{-- Optional: Top Navigation --}}
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white dark:bg-zinc-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <div class="min-h-screen flex bg-zinc-100 dark:bg-zinc-900">

        {{-- Sidebar --}}
        <x-aside>
            <x-aside-item href="/yukiadmin/dashboard" icon="fa-solid fa-chart-pie">Dashboard</x-aside-item>

            <x-aside-tree title="User" icon="fa-solid fa-users" routePrefix="/yukiadmin/users">
                <x-aside-item href="/yukiadmin/users" icon="fa-solid fa-user">Daftar Pengguna</x-aside-item>
                <x-aside-item href="/yukiadmin/roles" icon="fa-solid fa-user-shield">Role & Izin</x-aside-item>
            </x-aside-tree>

            <x-aside-tree title="Ads" icon="fa-solid fa-bullhorn" routePrefix="/yukiadmin/ads">
                <x-aside-item href="/yukiadmin/ads" icon="fa-solid fa-list">Semua Iklan</x-aside-item>
                <x-aside-item href="/yukiadmin/ads/create" icon="fa-solid fa-plus">Tambah Iklan</x-aside-item>
                <x-aside-item href="/yukiadmin/ads/banners" icon="fa-solid fa-image">Banner & Slot</x-aside-item>
            </x-aside-tree>

            <x-aside-tree title="Auction" icon="fa-solid fa-gavel" routePrefix="/yukiadmin/auctions">
                <x-aside-item href="/yukiadmin/auctions" icon="fa-solid fa-gavel">List Lelang</x-aside-item>
                <x-aside-item href="/yukiadmin/kois" icon="fa-solid fa-fish">Data Koi</x-aside-item>
                <x-aside-item href="/yukiadmin/certificates" icon="fa-solid fa-certificate">Sertifikat</x-aside-item>
            </x-aside-tree>

            <x-aside-tree title="Event" icon="fa-solid fa-calendar-days" routePrefix="/yukiadmin/events">
                <x-aside-item href="/yukiadmin/events" icon="fa-solid fa-list-check">Daftar Event</x-aside-item>
                <x-aside-item href="/yukiadmin/events/azukari" icon="fa-solid fa-water">Azukari / Grow Out</x-aside-item>
                <x-aside-item href="/yukiadmin/events/judging" icon="fa-solid fa-scale-balanced">Penjurian</x-aside-item>
            </x-aside-tree>

            <hr class="my-4 border-zinc-700">

            <x-aside-tree title="Report" icon="fa-solid fa-chart-line" routePrefix="/yukiadmin/reports">
                <x-aside-item href="/yukiadmin/reports/finance" icon="fa-solid fa-money-bill-wave">Keuangan</x-aside-item>
                <x-aside-item href="/yukiadmin/reports/ops" icon="fa-solid fa-gears">Operasional</x-aside-item>
                <x-aside-item href="/yukiadmin/reports/stats" icon="fa-solid fa-signal">Statistik</x-aside-item>
                <x-aside-item href="/yukiadmin/reports/logs" icon="fa-solid fa-user-secret">Aktivitas Admin</x-aside-item>
            </x-aside-tree>

            <x-aside-item href="/yukiadmin/settings" icon="fa-solid fa-gear">Pengaturan</x-aside-item>
        </x-aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-y-auto">
            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Echo Realtime Listener --}}
    <script>
        const userId = @json(auth()->id());
    </script>

    <div x-data="{ transactionId: null, amount: null, message: '' }"
         x-init="Echo.private(`user.${userId}`).listen('PaymentCompleted', (event) => {
            console.log(event);
        })">
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

</body>
</html>
