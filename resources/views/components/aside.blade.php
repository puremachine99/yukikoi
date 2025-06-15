<div x-data="{ currentPath: window.location.pathname }" class="w-64 h-screen bg-gray-800 text-white shadow-lg">
    <div class="p-4 text-lg font-bold text-center border-b border-gray-700">
        <i class="fa-solid fa-fish"></i> Lapak Koi
    </div>

    <nav class="mt-4">
        {{ $slot }}
    </nav>
</div>
