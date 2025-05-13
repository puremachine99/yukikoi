<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-4 shadow rounded">
            <div class="text-sm text-zinc-500">Total Users</div>
            <div class="text-2xl font-bold">{{ $stats['total_users'] }}</div>
        </div>
        <div class="bg-white p-4 shadow rounded">
            <div class="text-sm text-zinc-500">Total Koi</div>
            <div class="text-2xl font-bold">{{ $stats['total_kois'] }}</div>
        </div>
        <div class="bg-white p-4 shadow rounded">
            <div class="text-sm text-zinc-500">Total Auctions</div>
            <div class="text-2xl font-bold">{{ $stats['total_auctions'] }}</div>
        </div>
    </div>
</x-admin-layout>
