<div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg shadow-md w-full flex-shrink-0 text-center">
    <h2 class="text-lg font-bold text-yellow-600">
        {{ __('Lelang belum dimulai. Mulai pada:') }}
        {{ \Carbon\Carbon::parse($koi->auction->start_time)->format('d M Y, H:i') }}
    </h2>
</div>
