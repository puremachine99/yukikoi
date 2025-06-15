<div class="bg-white dark:bg-gray-800 p-4 shadow sm:rounded-lg mt-4">
    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Ikan di lelang yang sama</h2>
    <div class="relative overflow-x-auto flex space-x-4 scrollbar-hide">
        @foreach ($koisInSameAuction as $koiInAuction)
            <a href="{{ route('koi.show', ['id' => $koiInAuction->id]) }}"> {{-- Perbaikan url --}}
                <div class="min-w-[150px] flex-shrink-0 bg-white dark:bg-gray-700 p-2 rounded-lg shadow-md">
                    <img src="{{ asset('storage/' . $koiInAuction->media->first()->url_media) }}" alt="Koi Image"
                        class=" w-40 h-auto object-scale-down rounded-lg mb-2">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-200">{{ $koiInAuction->name }}</h3>
                    <p class="text-md dark:text-gray-400">{{ $koiInAuction->judul }}</p>
                    <div class="flex justify-between">
                        <span class="text-sm">OB = {{ number_format($koiInAuction->open_bid, 0, ',', '.') }}</span>
                        <span class="text-sm">KB = {{ number_format($koiInAuction->kelipatan_bid, 0, ',', '.') }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>

<div class="bg-white dark:bg-gray-800 p-4 shadow sm:rounded-lg mt-4">
    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Rekomendasi ikan dengan jenis yang sama</h2>
    <div class="relative overflow-x-auto flex space-x-4 scrollbar-hide">
        @if (!$koisSameCategory)
            
        @endif
        @foreach ($koisSameCategory as $koiInAuction)
            <a href="{{ route('koi.show', ['id' => $koiInAuction->id]) }}"> {{-- Perbaikan url --}}
                <div class="min-w-[150px] flex-shrink-0 bg-white dark:bg-gray-700 p-2 rounded-lg shadow-md">
                    <img src="{{ asset('storage/' . $koiInAuction->media->first()->url_media) }}" alt="Koi Image"
                        class=" w-40 h-auto object-scale-down rounded-lg mb-2">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-200">{{ $koiInAuction->name }}</h3>
                    <p class="text-md dark:text-gray-400">{{ $koiInAuction->judul }}</p>
                    <div class="flex justify-between">
                        <span class="text-sm">OB = {{ number_format($koiInAuction->open_bid, 0, ',', '.') }}</span>
                        <span class="text-sm">KB = {{ number_format($koiInAuction->kelipatan_bid, 0, ',', '.') }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>