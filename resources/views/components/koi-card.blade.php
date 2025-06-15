<div class="block bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-visible relative card-navigate"
    data-url="{{ route('koi.show', ['id' => $koi->id]) }}">

    <!-- Header -->
    <div class="flex items-center p-4 border-b dark:border-gray-700">
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
            <img src="{{ asset('storage/' . $koi->photo_url) }}" alt="Koi Image"
                class="object-cover w-full h-auto md:h-96 lg:h-[400px]">
            <div class="watermark-overlay">
                <img src="{{ asset('images/logo.png') }}" alt="Watermark Logo" class="watermark-logo">
            </div>

            <div
                class="absolute opacity-80 hover:opacity-100 group bottom-20 right-0 bg-white dark:bg-gray-700 p-1 px-2 rounded-l-lg shadow-md w-20">
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
                    class="absolute group bottom-2 right-4 w-12 h-12 z-20 bg-white dark:bg-gray-700 text-sky-500 border-2 border-sky-500 rounded-full flex items-center justify-center transition-transform hover:scale-105 hover:bg-sky-500 hover:text-white no-route"
                    onclick="event.stopPropagation(); openVideoModal('{{ asset('storage/' . $koi->koi_vid) }}')">
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
                <div class="bg-white dark:bg-gray-800 p-0 rounded-lg max-w-7xl w-auto max-h-screen overflow-auto">
                    <video id="modalVideo" class="w-full h-auto mt-0 rounded-lg" controls style="max-height: 90vh;">
                        <source id="videoSource" src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <div class="p-5 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-b-lg space-y-4">

        {{-- Judul Koi --}}
        <h3 class="text-base lg:text-lg font-bold text-gray-800 dark:text-white truncate"
            title="{{ $koi->judul }} - {{ $koi->ukuran }}cm {{ $koi->gender !== 'unchecked' ? '[' . strtoupper(substr($koi->gender, 0, 1)) . ']' : '' }}">
            {{ $koi->judul }} - {{ $koi->ukuran }}cm
            {{ $koi->gender !== 'unchecked' ? '[' . strtoupper(substr($koi->gender, 0, 1)) . ']' : '' }}
        </h3>

        {{-- Stats: Views / Wishlist / Likes --}}
        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
            {{-- Views --}}
            <button class="group flex items-center gap-1 hover:text-blue-600" onclick="event.stopPropagation();">
                <i class="fa-solid fa-eye"></i>
                <span>{{ $koi->views_count }}</span>
                <span
                    class="group-hover:block hidden absolute -top-7 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-black text-white text-xs rounded">
                    Dilihat {{ $koi->views_count }} kali
                </span>
            </button>

            {{-- Wishlist --}}
            <button class="group flex items-center gap-1 hover:text-yellow-500"
                onclick="event.stopPropagation(); toggleWishlist('{{ $koi->id }}')">
                <i id="wishlist-icon-{{ $koi->id }}"
                    class="fa-solid fa-star {{ in_array((string) $koi->id, (array) $wishlist) ? 'text-yellow-500' : '' }}"></i>
                <span>Wishlist</span>
                <span
                    class="group-hover:block hidden absolute -top-7 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-black text-white text-xs rounded">
                    Tambah ke Wishlist
                </span>
            </button>

            {{-- Likes --}}
            <button class="group flex items-center gap-1 hover:text-red-500"
                onclick="event.stopPropagation(); toggleLike('{{ $koi->id }}')">
                <i id="like-icon-{{ $koi->id }}"
                    class="fa-solid fa-heart {{ $koi->user_liked ? 'text-red-600' : '' }}"></i>
                <span id="likes-count-{{ $koi->id }}">{{ $koi->likes_count }}</span>
                <span
                    class="group-hover:block hidden absolute -top-7 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-black text-white text-xs rounded">
                    Disukai {{ $koi->likes_count }} kali
                </span>
            </button>
        </div>

        <hr class="border-t border-dashed border-gray-300 dark:border-gray-600">

        {{-- Bid Info --}}
        <div class="grid grid-cols-2 gap-y-3 gap-x-4 text-sm text-gray-600 dark:text-gray-300">
            <div class="flex justify-between">
                <span>Open Bid:</span>
                <span class="font-bold text-gray-800 dark:text-white">
                    Rp{{ number_format($koi->open_bid, 0, ',', '.') }}
                </span>
            </div>
            <div class="flex justify-between">
                <span>Kelipatan:</span>
                <span class="font-bold text-gray-800 dark:text-white">
                    Rp{{ number_format($koi->kelipatan_bid, 0, ',', '.') }}
                </span>
            </div>
            <div class="flex justify-between col-span-2">
                <span>Last Bid:</span>
                <span class="font-bold text-blue-600">
                    Rp{{ number_format($koi->last_bid ?? 0, 0, ',', '.') }}
                </span>
            </div>
            @if ($koi->has_winner)
                <div class="flex justify-between col-span-2 text-yellow-600 font-semibold">
                    <span>Winner:</span>
                    <span>{{ $koi->winner_name }}</span>
                </div>
            @endif
        </div>

    </div>

</div>
