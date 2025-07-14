<div class="auction-card bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden relative card-navigate transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl"
    data-url="#">
    {{-- {{ route('auction.show', ['id' => $auction->id]) }} --}}
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
            <div
                class="absolute opacity-80 hover:opacity-100 group bottom-20 right-0 bg-white dark:bg-gray-700 p-1 px-2 rounded-l-lg shadow-md w-20 text-sm text-gray-700 dark:text-gray-200">
                <span
                    class="font-semibold
                    {{ $auction->has_winner
                        ? 'text-red-500'
                        : match ($auction->status) {
                            'ready' => 'text-blue-600',
                            'on going' => 'text-green-600',
                            default => 'text-red-600',
                        } }}">
                    {{ $auction->has_winner
                        ? 'Sold'
                        : match ($auction->status) {
                            'ready' => 'Belum Dimulai',
                            'on going' => 'On Going',
                            'complete' => 'Complete',
                            default => ucfirst($auction->status),
                        } }}
                </span>
                <div>{{ $auction->total_bids ?? 0 }}x Bids</div>
                <span
                    class="absolute bottom-full mb-1 w-max px-1 py-0.5 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                    {{ $auction->has_winner ? 'Terjual' : ucfirst($auction->status) }}
                </span>
            </div>

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

        <!-- Stats -->
        {{-- <div class="flex justify-between mb-1 pb-2">
            <div class="text-center">
                <div
                    class="w-7 h-7 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-500 flex items-center justify-center mx-auto mb-1">
                    <i class="fa-solid fa-eye text-xs"></i>
                </div>
                <div class="text-xs font-medium text-gray-700 dark:text-gray-300">
                    {{ $auction->views_count ?? 0 }}
                </div>
            </div>
            <div class="text-center">
                <div
                    class="w-7 h-7 rounded-full bg-yellow-50 dark:bg-yellow-900/20 text-yellow-500 flex items-center justify-center mx-auto mb-1">
                    <i class="fa-solid fa-star text-xs"></i>
                </div>
                <div class="text-xs font-medium text-gray-700 dark:text-gray-300">
                    Wishlist
                </div>
            </div>
            <div class="text-center">
                <div
                    class="w-7 h-7 rounded-full bg-red-50 dark:bg-red-900/20 text-red-500 flex items-center justify-center mx-auto mb-1">
                    <i class="fa-solid fa-heart text-xs"></i>
                </div>
                <div class="text-xs font-medium text-gray-700 dark:text-gray-300">
                    {{ $auction->likes_count ?? 0 }}
                </div>
            </div>
        </div> --}}

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
            <div class="col-span-2 mt-3 flex flex-col gap-2 sm:flex-row">
                <button
                    class="flex-1 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white text-xs font-bold py-2 px-4 rounded-lg cursor-default"
                    disabled>
                    READY
                </button>

                <a href="{{ route('auctions.recap', ['auction_code' => $auction->auction_code]) }}"
                    class="flex-1 bg-green-500 hover:bg-green-600 text-white text-xs font-bold py-2 px-4 rounded-lg text-center">
                    Rekap Lelang
                </a>
            </div>
        </div>

    </div>
</div>
