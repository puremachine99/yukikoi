<div class="block bg-white dark:bg-zinc-800 rounded-lg shadow-md overflow-visible relative card-navigate"
    data-url="{{ route('koi.show', ['id' => $koi->id]) }}">

    <!-- Header -->
    <div class="flex items-center p-4 border-b dark:border-zinc-700">
        <img src="{{ asset('storage/' . $koi->seller_avatar) }}" alt="Farm Profile"
            class="w-12 h-12 rounded-full object-cover">
        <div class="ml-3">
            <h5 class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                {{ Str::ucfirst($koi->farm_name) }} [{{ $koi->seller_city }}]</h5>

            <div class="text-sm text-yellow-500">
                ⭐ {{ number_format($koi->auction->user->overall_rating, 1) }} / 5
            </div>

        </div>

    </div>

    <!-- Body -->
    <div class="p-4 relative">
        <div class="relative">
            <img src="{{ asset('storage/' . $koi->media->first()->url_media) }}" alt="Koi Image"
                class="object-cover w-full h-auto md:h-96 lg:h-[400px]">
            <div class="watermark-overlay">
                <img src="{{ asset('images/logo.png') }}" alt="Watermark Logo" class="watermark-logo">
            </div>

            <div
                class="absolute opacity-80 hover:opacity-100 group bottom-20 right-0 bg-white dark:bg-zinc-700 p-1 px-2 rounded-l-lg shadow-md w-20">
                <!-- Status Lelang dan Jumlah Bids -->
                <div class="text-sm text-gray-700 dark:text-gray-200 mb-0">
                    <span
                        class="font-semibold 
                        {{ $koi->has_winner
                            ? 'text-red-500'
                            : ($koi->auction->status == 'ready'
                                ? 'text-blue-600'
                                : ($koi->auction->status == 'on going'
                                    ? 'text-green-600'
                                    : 'text-red-600')) }}">

                        {{ $koi->has_winner
                            ? 'Sold'
                            : ($koi->auction->status == 'ready'
                                ? 'Belum Dimulai'
                                : ($koi->auction->status == 'on going'
                                    ? 'On Going'
                                    : 'Complete')) }}
                    </span>

                    <div class="text-sm text-gray-700 dark:text-gray-200">
                        <span>{{ $koi->total_bids ?? 0 }}x Bids</span>
                    </div>
                </div>

                <span
                    class="absolute bottom-full mb-1 w-max px-1 py-0.5 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                    {{ $koi->has_winner
                        ? 'Terjual'
                        : ($koi->auction->status == 'ready'
                            ? 'Belum Mulai'
                            : ($koi->auction->status == 'on going'
                                ? 'Sedang Berlangsung'
                                : 'Lelang Selesai')) }}
                </span>

            </div>

            {{-- logo yuki koi --}}
            <div class="absolute top-1 right-2 p-0 rounded-full text-center text-sm">
                <img src="{{ asset('images/logo.png') }}" alt="yukbid" class="w-auto h-16 mx-auto mb-1">
            </div>
            <div
                class="absolute top-1/2 left-4 transform -translate-y-1/2 -translate-x-1/2 text-md font-bold text-white px-2 py-1 z-50">
                <span class="vertical-text font-onsen text-center text-outline "
                    style="font-family: 'OnsenJapanDemoRegular'; font-size: 11px;">
                    {{ Str::replace(['(', ')'], '', $koi->jenis_koi) }}
                </span>
            </div>
            <div
                class="absolute top-1/2 left-8 transform -translate-y-1/2 -translate-x-1/2 text-sm font-bold rotate-90 uppercase text-white px-2 py-1 leading-none">
                <span class="text-outline">
                    {{ $koi->ukuran }} cm
                </span>
            </div>

            <h3 class="absolute bottom-8 left-1 z-10 text-xs font-bold text-white px-2 py-1">
                <b class="text-outline">Support by Yuki Auction</b>
            </h3>


            <!-- Kapsul Jenis Lelang dengan Tooltip dan Logo -->
            @if (in_array($koi->auction->jenis, ['azukari', 'keeping contest', 'grow_out']))
                <div x-data="{ showTooltip: false }" @mouseover="showTooltip = true" @mouseleave="showTooltip = false"
                    class="absolute bottom-2 right-2 p-0 rounded-full text-center text-sm w-auto cursor-pointer">

                    <!-- Logo untuk setiap jenis lelang -->
                    @if ($koi->auction->jenis == 'azukari')
                        <img src="{{ asset('images/az.png') }}" alt="Azukari Logo" class="w-auto h-14 mx-auto mb-1">
                    @elseif ($koi->auction->jenis == 'keeping contest')
                        <img src="{{ asset('images/kc.png') }}" alt="Keeping Contest Logo"
                            class="w-auto h-14 mx-auto mb-1">
                    @elseif ($koi->auction->jenis == 'grow out')
                        <img src="{{ asset('images/go.png') }}" alt="Grow Out Logo" class="w-auto h-14 mx-auto mb-1">
                    @endif

                    <!-- Tooltip untuk Jenis Lelang -->
                    <div x-show="showTooltip" x-transition
                        class="absolute top-full mt-1 w-max px-2 py-1 text-xs text-white bg-black rounded transform -translate-x-1/2 left-1/2">
                        {{ $koi->auction->jenis == 'azukari'
                            ? 'Azukari'
                            : ($koi->auction->jenis == 'keeping contest'
                                ? 'Keeping Contest'
                                : 'Grow Out') }}
                    </div>
                </div>
            @endif
            <!-- Tombol Play untuk Video -->
            @if ($koi->media->where('media_type', 'video')->isNotEmpty())
                <button
                    class="absolute group bottom-2 right-4 w-12 h-12 z-20 bg-white dark:bg-zinc-700 text-sky-500 border-2 border-sky-500 rounded-full flex items-center justify-center transition-transform hover:scale-105 hover:bg-sky-500 hover:text-white no-route"
                    onclick="event.stopPropagation(); openVideoModal('{{ asset('storage/' . $koi->media->where('media_type', 'video')->first()->url_media) }}')">
                    <i class="fa-solid fa-play text-xl"></i>
                    <span
                        class="absolute bottom-full mb-1 w-max px-1 py-0.5 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                        Video Ikan 🐟
                    </span>
                </button>
            @endif
            <!-- Modal untuk video -->
            <div id="videoModal"
                class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50"
                onclick="closeVideoModal()">
                <div class="bg-white dark:bg-zinc-800 p-0 rounded-lg max-w-7xl w-auto max-h-screen overflow-auto">
                    <video id="modalVideo" class="w-full h-auto mt-0 rounded-lg" controls style="max-height: 90vh;">
                        <source id="videoSource" src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>


            <!-- Modal untuk Sertifikat -->
            <div id="certModal"
                class="fixed inset-0 z-50 items-center flex justify-center hidden bg-black bg-opacity-50"
                onclick="closeModal()">
                <div class="bg-white dark:bg-zinc-800 p-0 rounded-lg max-w-7x1 w-full">
                    <img id="certImage" src="" alt="Certificate Image" class="w-full mt-0 rounded-lg">
                </div>
            </div>
            <div class="absolute opacity-80 hover:opacity-100 bottom-2 left-2 bg-red-500 text-white p-1 rounded-full shadow-md text-center text-xs w-36"
                id="countdown-wrapper-{{ $koi->id }}" data-koi-id="{{ $koi->id }}"
                data-end-time="{{ $koi->end_time }}">
                @if ($totalBids[(string) $koi->id]['has_winner'] ?? false)
                    <span class="font-semibold">Sold by BIN</span>
                @else
                    <span id="countdown-{{ $koi->id }}" class="font-semibold">00:00</span>
                @endif
            </div>
            <!-- Slot untuk Tombol -->
            <div class="absolute top-2 right-2 flex space-x-2">
                {{ $slot }}
            </div>

        </div>
    </div>

    <!-- Footer -->
    <div class="p-4 border-t dark:border-zinc-700">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 truncate" data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="{{ $koi->judul }} - {{ $koi->ukuran }}cm 
    {{ $koi->gender !== 'unchecked' ? '[' . strtoupper(substr($koi->gender, 0, 1)) . ']' : '' }}">
            {{ $koi->judul }} - {{ $koi->ukuran }}cm
            {{ $koi->gender !== 'unchecked' ? '[' . strtoupper(substr($koi->gender, 0, 1)) . ']' : '' }}
        </h3>

        <div class="flex justify-between items-center mt-2">
            <!-- Views -->
            <button
                class="relative group flex items-center text-gray-500 dark:text-gray-400 transition-transform hover:text-blue-600 koi-action"
                onclick="event.stopPropagation();">
                <i class="fa-solid fa-eye mr-1"></i>
                <span>{{ $koi->views_count }}</span>
                <span
                    class="absolute bottom-full mb-2 w-max px-2 py-1 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                    Dilihat {{ $koi->views_count }} kali
                </span>
            </button>
            <!-- Wishlist -->
            @props(['koi', 'totalBids', 'wishlist' => []])

            <!-- Wishlist -->
            <button
                class="relative group flex items-center text-gray-500 dark:text-gray-400 transition-transform hover:text-yellow-500 koi-action"
                onclick="event.stopPropagation(); toggleWishlist('{{ $koi->id }}')">
                <!-- Icon Wishlist -->

                <i id="wishlist-icon-{{ $koi->id }}"
                    class="fa-solid fa-star mr-1 {{ in_array((string) $koi->id, (array) $wishlist) ? 'text-yellow-500' : '' }}">
                </i>


                <span
                    class="absolute bottom-full mb-2 w-max px-2 py-1 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                    Masukkan Wishlist
                </span>
            </button>



            <!-- Likes -->
            <button
                class="relative group flex items-center text-gray-500 dark:text-gray-400 transition-transform hover:text-red-600 koi-action"
                onclick="event.stopPropagation(); toggleLike('{{ $koi->id }}')">
                <!-- Icon Like -->
                <i id="like-icon-{{ $koi->id }}"
                    class="fa-solid fa-heart mr-1 {{ $koi->user_liked ? 'text-red-600' : '' }}"></i>
                <!-- Jumlah Like -->
                <span id="likes-count-{{ $koi->id }}">{{ $koi->likes_count }}</span>
                <!-- Tooltip -->
                <span
                    class="absolute bottom-full mb-2 w-max px-2 py-1 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                    Disukai {{ $koi->likes_count }} kali
                </span>
            </button>

        </div>

        <hr class="mt-3 mb-3">

        <div class="grid grid-cols-2 gap-2 mt-3 text-sm">
            <div class="text-gray-600 dark:text-gray-300">
                <span>OB:</span>
                <span class="font-semibold">{{ number_format($koi->open_bid, 0, ',', '.') }}</span>
            </div>
            <div class="text-gray-600 dark:text-gray-300">
                <span>KB:</span>
                <span class="font-semibold">{{ number_format($koi->kelipatan_bid, 0, ',', '.') }}</span>
            </div>
            <div class="text-blue-600 font-semibold">
                Last Bid:
                <span>{{ number_format($koi->last_bid ?? 0, 0, ',', '.') }}</span>
            </div>
            @if ($koi->has_winner)
                <div class="text-yellow-600 font-semibold">
                    Winner: <span>{{ $koi->winner_name }}</span>
                </div>
            @endif


        </div>
    </div>
</div>
