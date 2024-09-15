@foreach ($auctions as $auction)
    <div class="auction-item border rounded-lg p-4 dark:bg-zinc-700 dark:border-zinc-600 relative flex flex-col justify-between"
        data-jenis="{{ strtolower($auction->jenis) }}" data-status="{{ strtolower($auction->status) }}"
        data-search="{{ strtolower($auction->title) }} {{ strtolower($auction->description) }} {{ strtolower($auction->jenis) }} {{ strtolower($auction->auction_code) }} {{ strtolower(\Carbon\Carbon::parse($auction->start_time)->format('d M Y, H:i')) }} {{ strtolower(\Carbon\Carbon::parse($auction->end_time)->format('d M Y, H:i')) }} {{ strtolower($auction->koi->count()) }}">

        <!-- Tombol Hapus dan Edit -->
        @if ($auction->status === 'draft')
            <!-- Tombol Hapus -->
            <button onclick="deleteAuction('{{ $auction->auction_code }}')"
                class="absolute group top-2 right-2 py-2 px-3 bg-zinc-500 text-white rounded-full hover:bg-zinc-100 hover:text-zinc-950 dark:hover:bg-zinc-200 dark:hover:text-zinc-800 transition-transform transform hover:scale-110 focus:outline-none"
                style="z-index: 10">
                <i class="fas fa-trash-alt"></i>
                <span
                    class="absolute bottom-full mb-2 w-max px-2 py-1 text-xs text-white bg-black dark:bg-zinc-800 rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">Hapus
                    Lelang</span>
            </button>

            <!-- Tombol Edit -->
            <button
                class="absolute group top-14 right-2 py-2 px-3 bg-zinc-500 text-white rounded-full hover:bg-zinc-100 hover:text-zinc-950 dark:hover:bg-zinc-200 dark:hover:text-zinc-800 transition-transform transform hover:scale-110 focus:outline-none"
                style="z-index: 10"
                onclick="window.location.href='{{ route('auctions.edit', ['auction_code' => $auction->auction_code]) }}'">
                <i class="fa-solid fa-pen"></i>
                <span
                    class="absolute bottom-full mb-2 w-max px-2 py-1 text-xs text-white bg-black dark:bg-zinc-800 rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">Edit
                    Lelang</span>
            </button>
        @endif

        <!-- Tombol List Ikan -->
        <button
            class="absolute group right-0 w-16 h-16 z-10 bg-white dark:bg-zinc-800 text-sky-500 dark:text-sky-300 border-2 border-sky-500 dark:border-sky-300 rounded-full flex items-center justify-center transition-transform transform hover:scale-110 hover:bg-sky-500 hover:text-white hover:border-white"
            style="top: 61%; z-index: 10;"
            onclick="window.location.href='{{ route('koi.index', ['auction_code' => $auction->auction_code]) }}'">
            <i class="fa-solid fa-fish text-3xl"></i>
            <span
                class="absolute bottom-full mb-2 w-max px-2 py-1 text-xs text-white bg-black dark:bg-zinc-800 rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">List
                Ikan</span>
            <span
                class="absolute mb-2 top-16 w-max px-2 py-1 text-xs text-white bg-black dark:bg-zinc-800 rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">Jumlah
                Ikan {{ $auction->koi->count() }}</span>
        </button>

        <!-- Gambar Banner -->
        @if ($auction->banner)
            <div class="relative w-full overflow-hidden rounded-lg shadow-lg" style="height: 460px">
                <img src="{{ asset('storage/' . $auction->banner) }}" alt="{{ $auction->title }}"
                    class="absolute top-0 left-0 w-full h-full object-cover">
            </div>
        @else
            <div class="bg-gray-300 dark:bg-zinc-800 w-full relative overflow-hidden" style="padding-top: 100%;">
                <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center dark:text-white">
                    {{ __('No Image') }}
                </div>
            </div>
        @endif

        <!-- Detail Auction -->
        <h3 class="text-base font-semibold mt-4 uppercase text-zinc-900 dark:text-zinc-200">
            [{{ $auction->auction_code }}] {{ $auction->title }} <br>
            {{ $auction->jenis }}</h3>
        <p class="mt-2 text-sm text-zinc-800 dark:text-zinc-400">
            <span class="font-bold">{{ __('Status') }}: </span>
            <span id="auction-status-{{ $auction->auction_code }}"
                class="{{ $auction->status == 'draft' ? 'text-yellow-500' : ($auction->status == 'ready' ? 'text-sky-800 dark:text-sky-300' : ($auction->status == 'on going' ? 'text-red-500 dark:text-red-400' : 'text-green-500 dark:text-green-400')) }}">
                {{ ucfirst($auction->status) }}
            </span>
        </p>
        <p class="mt-2 text-sm text-zinc-800 dark:text-zinc-400">
            <span class="font-bold">{{ __('Mulai') }}:</span>
            {{ \Carbon\Carbon::parse($auction->start_time)->format('d M Y, H:i') }}
        </p>
        <p class="mt-2 text-sm text-zinc-800 dark:text-zinc-400">
            <span class="font-bold">{{ __('Selesai') }}:</span>
            {{ \Carbon\Carbon::parse($auction->end_time)->format('d M Y, H:i') }}
        </p>

        <!-- Jumlah Ikan -->
        <p class="mt-2 text-sm text-zinc-800 dark:text-zinc-400">
            <span class="font-bold">{{ __('Jumlah Ikan') }}: </span>
            {{ $auction->koi->count() }}
        </p>

        <!-- Tombol Ready -->
        <form action="{{ route('auctions.start', ['auction_code' => $auction->auction_code]) }}" method="POST"
            class="mt-2">
            @csrf
            <button type="submit" {{ $auction->status != 'draft' ? 'disabled' : '' }}
                class="flex items-center justify-center w-full px-4 py-2 {{ $auction->status == 'draft' ? 'bg-zinc-800 dark:bg-zinc-200 hover:bg-zinc-700 dark:hover:bg-zinc-300' : 'bg-gray-400 dark:bg-zinc-500 cursor-not-allowed' }} border border-transparent rounded-md font-sans text-sm text-white dark:text-zinc-800 uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 transition ease-in-out duration-150">
                <i class="fas fa-flag-checkered mr-2"></i> {{ __('Ready') }}
            </button>
        </form>

        <!-- Countdown Timer -->
        @if ($auction->status == 'ready')
            <div id="countdown" class="text-zinc-800 dark:text-white mt-4 text-lg font-semibold"></div>
        @endif


    </div>
@endforeach
