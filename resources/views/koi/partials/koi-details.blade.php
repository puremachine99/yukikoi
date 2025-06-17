<div class="space-y-4 mt-4 text-gray-800 dark:text-gray-100">

    {{-- Judul dan Kode Lelang --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-2">
        <h3 class="text-lg md:text-xl font-semibold uppercase leading-snug tracking-wide">
            {{ $koi->kode_ikan }}. {{ $koi->judul }}
            <span class="text-blue-600 dark:text-blue-400">{{ $koi->ukuran }} cm</span>
            <span class="text-gray-500 dark:text-gray-400">[{{ strtoupper($koi->gender) }}]</span>
        </h3>
        <div class="text-sm md:text-base font-semibold uppercase text-gray-500 dark:text-gray-400">
            #{{ $koi->auction->auction_code ?: '-' }}
        </div>
    </div>

    {{-- Jenis Koi --}}
    <p class="text-sm text-gray-600 dark:text-gray-300">
        <span class="font-medium">Jenis:</span> {{ $koi->jenis_koi }}
    </p>

    <hr class="border-gray-300 dark:border-gray-700">

    {{-- OB, Timer, KB --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <span class="text-green-600 text-sm md:text-base font-semibold">
            OB: {{ number_format($koi->open_bid, 0, ',', '.') }} ribu
        </span>

        <div class="flex items-center space-x-2 text-gray-700 dark:text-white">
            <i class="fa-regular fa-clock text-sm text-gray-500 dark:text-gray-400"></i>
            <span id="timer-display" class="font-bold text-lg">00:00:00:00</span>
        </div>

        <span class="text-sm md:text-base font-semibold text-gray-800 dark:text-white">
            KB: {{ number_format($koi->kelipatan_bid, 0, ',', '.') }} ribu
        </span>
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    {{-- Farm & Auction Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300">
        <div>
            <p><span class="font-semibold">Farm:</span> {{ $koi->auction->user->farm_name ?: '-' }}
                [{{ $koi->auction->user->city }}]</p>
            <p><span class="font-semibold">Rating:</span> 4.5 / 5.0</p>
        </div>
        <div class="text-right">
            <p><span class="font-semibold">Jenis Lelang:</span> {{ Str::upper($koi->auction->jenis ?: '-') }}</p>
            @if ($koi->buy_it_now)
                <p><span class="font-semibold">Buy it Now:</span> {{ number_format($koi->buy_it_now, 0, ',', '.') }}
                    ribu</p>
            @endif
        </div>
    </div>


</div>
