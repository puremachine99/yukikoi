<div class="auction-card bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden relative card-navigate transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl"
    data-url="{{ route('auctions.recap', ['auction_code' => $auction->auction_code]) }}">

    <!-- Header -->
    <div class="card-header flex items-center p-4">
        <img src="{{ asset('storage/' . $auction->user->profile_photo) }}" alt="Seller Avatar"
            class="w-12 h-12 rounded-full object-cover border-2 border-blue-500 shadow-md">
        <div class="ml-3">
            <h5 class="text-sm font-semibold text-gray-800 dark:text-gray-100 flex items-center">
                {{ Str::ucfirst($auction->user->farm_name ?? '-') }}
                <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">[{{ $auction->user->city ?? '-' }}]</span>
            </h5>
            <div class="flex items-center mt-1 text-yellow-500 text-sm">
                <i class="fas fa-star mr-1"></i>
                <span>{{ number_format($auction->user->overall_rating ?? 0, 1) }} / 5</span>
            </div>
        </div>
    </div>

    <!-- Body -->
    <div class="p-4 relative">
        <div class="relative">
            <img src="{{ asset('storage/' . $auction->banner) }}" alt="Auction Banner"
                class="object-cover w-full h-auto md:h-96 lg:h-[400px]">

            <div class="absolute top-1 right-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-auto h-16">
            </div>

            <!-- Status dan Jumlah Bids -->


            <!-- Jenis Lelang -->
            @if (in_array($auction->jenis, ['azukari', 'keeping contest', 'grow out']))
                <div x-data="{ showTooltip: false }" @mouseover="showTooltip = true" @mouseleave="showTooltip = false"
                    class="absolute bottom-2 right-2 cursor-pointer">
                    <img src="{{ asset('images/' . ($auction->jenis === 'azukari' ? 'az' : ($auction->jenis === 'keeping contest' ? 'kc' : 'go')) . '.png') }}"
                        alt="{{ ucfirst($auction->jenis) }} Logo" class="w-auto h-14">
                    <div x-show="showTooltip" x-transition
                        class="absolute top-full mt-1 w-max px-2 py-1 text-xs text-white bg-black rounded transform -translate-x-1/2 left-1/2">
                        {{ ucfirst($auction->jenis) }}
                    </div>
                </div>
            @endif

            <!-- Countdown -->
            <div class="absolute opacity-60 hover:opacity-100 bottom-2 left-2 bg-red-500 text-white p-1 rounded-full shadow-md text-center text-xs w-36"
                id="countdown-wrapper-{{ $auction->id }}" data-koi-id="{{ $auction->id }}"
                data-end-time="{{ $auction->end_time }}">
                @if ($auction->has_winner)
                    <span class="font-semibold">Sold by BIN</span>
                @else
                    <span id="countdown-{{ $auction->id }}" class="font-semibold">00:00</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="px-4 pb-4 pt-2">
        <h3 class="flex items-start mb-3">
            <span class="flex-1 min-w-0 font-bold text-gray-800 dark:text-white text-base leading-tight truncate"
                title="{{ $auction->title }}">
                {{ $auction->title }}
            </span>
        </h3>

        <!-- Bid Info -->
        <div class="grid grid-cols-2 gap-3 text-sm">
            <div>
                <div class="text-gray-500 dark:text-gray-400">Status:</div>
                <div class="font-bold text-green-600 dark:text-green-400">
                    {{ ucfirst($auction->status) }}
                </div>
            </div>
            <div>
                <div class="text-gray-500 dark:text-gray-400">Jumlah Ikan:</div>
                <div class="font-bold text-gray-800 dark:text-white">
                    {{ $auction->koi_count ?? 0 }}
                </div>
            </div>
            <div>
                <div class="text-gray-500 dark:text-gray-400">Mulai:</div>
                <div class="font-bold text-gray-800 dark:text-white">
                    {{ \Carbon\Carbon::parse($auction->start_time)->format('d M Y, H:i') }}
                </div>
            </div>

            <div>
                <div class="text-gray-500 dark:text-gray-400">Selesai:</div>
                <div class="font-bold text-gray-800 dark:text-white">
                    {{ \Carbon\Carbon::parse($auction->end_time)->format('d M Y, H:i') }}
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="col-span-2 mt-3 flex flex-col gap-2 sm:flex-row flex-wrap">

                {{-- Tombol READY (hanya saat draft dan ada koi) --}}
                @if ($auction->status === 'draft' && $auction->koi_count > 0)
                    <form action="{{ route('auctions.start', $auction->auction_code) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold py-2 px-4 rounded-lg">
                            READY
                        </button>
                    </form>
                @else
                    <button
                        class="flex-1 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white text-xs font-bold py-2 px-4 rounded-lg cursor-default"
                        disabled>
                        {{ strtoupper($auction->status) }}
                    </button>
                @endif

                {{-- Tombol Rekap --}}
                <a href="{{ route('auctions.recap', ['auction_code' => $auction->auction_code]) }}"
                    class="flex-1 bg-green-500 hover:bg-green-600 text-white text-xs font-bold py-2 px-4 rounded-lg text-center">
                    Rekap Lelang
                </a>

                {{-- Tombol Tambah Koi --}}
                <a href="{{ route('koi.create', ['auction_code' => $auction->auction_code]) }}"
                    class="flex-1 bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-bold py-2 px-4 rounded-lg text-center">
                    Tambah Koi
                </a>

                {{-- Tombol List Koi --}}
                <a href="{{ route('koi.index', ['auction_code' => $auction->auction_code]) }}"
                    class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-bold py-2 px-4 rounded-lg text-center">
                    List Koi
                </a>
            </div>



        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.querySelectorAll('.card-navigate').forEach(card => {
            card.addEventListener('click', function(e) {
                if (!e.target.closest('button') && !e.target.closest('a') && !e.target.closest('form')) {
                    const url = card.getAttribute('data-url');
                    if (url) window.location.href = url;
                }
            });
        });
    </script>
@endpush
