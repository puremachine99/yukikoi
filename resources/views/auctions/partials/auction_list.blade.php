@foreach ($auctions as $auction)
    <div class="border rounded-lg p-4 dark:bg-zinc-700 relative flex flex-col justify-between">
        <!-- Tombol Hapus di Kanan Atas -->
        @if ($auction->status === 'draft')
            <button onclick="deleteAuction('{{ $auction->auction_code }}')"
                class="absolute top-2 right-2 py-2 px-3 bg-zinc-500 text-white rounded-full hover:bg-zinc-100 hover:text-zinc-950 transition-transform transform hover:scale-110 focus:outline-none"
                style="z-index: 10">
                <i class="fas fa-trash-alt"></i>
            </button>
        @endif

        <!-- Gambar Banner -->
        @if ($auction->banner)
            <div class="bg-gray-300 w-full relative overflow-hidden" style="padding-top: 100%;">
                <img src="{{ asset('storage/' . $auction->banner) }}" alt="{{ $auction->title }}"
                    class="absolute top-0 left-0 w-full h-full object-cover">
            </div>
        @else
            <div class="bg-gray-300 w-full relative overflow-hidden" style="padding-top: 100%;">
                <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center">
                    {{ __('No Image') }}
                </div>
            </div>
        @endif

        <!-- Kode, Judul, dan Status -->
        <h3 class="text-base font-semibold mt-4">{{ $auction->auction_code }} - {{ $auction->title }}</h3>
        <p class="mt-2 text-xs">
            <span class="font-bold">Jenis: </span>
            <span>{{ ucfirst($auction->jenis) }}</span>
        </p>
        <p class="mt-2 text-xs">
            <span class="font-bold">{{ __('Status') }}: </span>
            <span
                class="{{ $auction->status == 'draft' ? 'text-yellow-500' : ($auction->status == 'ready' ? 'text-sky-800' : ($auction->status == 'on going' ? 'text-red-500' : 'text-green-500')) }}">
                {{ ucfirst($auction->status) }}
            </span>
        </p>
        <p class="mt-2 text-xs">
            <span class="font-bold">{{ __('Waktu') }}: </span><br>
            {{ \Carbon\Carbon::parse($auction->start_time)->format('d M Y, H:i') }} -
            {{ \Carbon\Carbon::parse($auction->end_time)->format('d M Y, H:i') }} <br>tambahan waktu 10 menit berkelanjutan
        </p>

        <!-- Jumlah Koi -->
        <p class="mt-2 text-xs">
            <span class="font-bold">{{ __('Jumlah Koi') }}: </span>
            {{ $auction->koi->count() }} <!-- Menampilkan jumlah koi terkait -->
        </p>

        <!-- Tombol Aksi (2 Baris, 2 Kolom) -->
        <div class="grid grid-cols-2 gap-2 mt-6">
            <!-- Tombol Edit -->
            <a href="{{ $auction->status == 'draft' ? route('auctions.edit', ['auction_code' => $auction->auction_code]) : '#' }}"
                class="flex items-center justify-center px-4 py-2 {{ $auction->status == 'draft' ? 'bg-zinc-800 hover:bg-zinc-700' : 'bg-gray-400 cursor-not-allowed' }} dark:bg-zinc-300 border border-zinc-300 dark:border-zinc-500 rounded-md font-sans text-xs text-white uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fas fa-pencil-alt mr-2"></i>{{ __('Edit') }}
            </a>

            

            <!-- Tombol List Koi -->
            <a href="{{ route('koi.index', ['auction_code' => $auction->auction_code]) }}"
                class="inline-flex items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-500 rounded-md font-sans text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-widest shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-list mr-2"></i>{{ __('List Koi') }}
            </a>
        </div>

        <!-- Tombol Start (Full Width) -->
        <form
            action="{{ $auction->status == 'draft' ? route('auctions.start', ['auction_code' => $auction->auction_code]) : '#' }}"
            method="POST" class="mt-2">
            @csrf
            <button type="submit" {{ $auction->status != 'draft' ? 'disabled' : '' }}
                class="flex items-center justify-center w-full px-4 py-2 {{ $auction->status == 'draft' ? 'bg-zinc-800 hover:bg-zinc-700' : 'bg-gray-400 cursor-not-allowed' }} dark:bg-zinc-200 border border-transparent rounded-md font-sans text-xs text-white dark:text-zinc-800 uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 transition ease-in-out duration-150">
                <i class="fas fa-flag-checkered mr-2"></i> {{ __('Start') }}
            </button>
        </form>
    </div>
@endforeach
