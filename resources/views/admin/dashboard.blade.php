<x-admin-layout>
    <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>
    <div class="bg-white rounded shadow p-6">
        Selamat datang di halaman admin!
    </div>
</x-admin-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Welcome to the Admin Dashboard!") }}
                    {{-- Add your admin-specific content here --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>