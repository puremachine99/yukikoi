<div class="koi-card bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden relative card-navigate transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl"
    data-url="{{ route('koi.show', ['id' => $koi->id]) }}">

    <!-- Header -->
    <div class="card-header flex items-center p-4 border-b dark:border-gray-700">
        <img src="{{ asset('storage/' . $koi->seller_avatar) }}" alt="Farm Profile"
            class="seller-avatar w-12 h-12 rounded-full object-cover border-2 border-blue-500 shadow-md">
        <div class="seller-info ml-3">
            <h5 class="seller-name text-sm font-semibold text-gray-800 dark:text-gray-100 flex items-center">
                {{ Str::ucfirst($koi->farm_name) }}
                <span
                    class="seller-location text-xs text-gray-500 dark:text-gray-400 ml-1">[{{ $koi->seller_city }}]</span>
            </h5>
            <div class="seller-rating flex items-center mt-1 text-yellow-500 text-sm">
                <i class="fas fa-star mr-1"></i>
                <span>{{ number_format($koi->auction->user->overall_rating, 1) }} / 5</span>
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
    <div class="card-body px-4 pb-4 pt-2">
        <h3 class="koi-title flex items-start mb-3">
            <span class="flex-1 min-w-0 font-bold text-gray-800 dark:text-white text-base leading-tight">
                <span class="block truncate" title="{{ $koi->judul }}">{{ $koi->judul }}</span>
                <span class="text-gray-600 dark:text-gray-300 text-sm font-medium">
                    {{ $koi->ukuran }}cm
                </span>
            </span>

            @if ($koi->gender !== 'unchecked')
                <span
                    class="koi-gender text-xs font-bold px-2 py-1 rounded-full ml-2 
                    {{ $koi->gender === 'male'
                        ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300'
                        : 'bg-pink-100 text-pink-800 dark:bg-pink-900/50 dark:text-pink-300' }}">
                    {{ strtoupper(substr($koi->gender, 0, 1)) }}
                </span>
            @endif
        </h3>

        <!-- Stats -->
        <div class="koi-stats flex justify-between mb-1 pb-2">
            <div class="stat-item text-center">
                <div
                    class="stat-icon w-7 h-7 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-500 flex items-center justify-center mx-auto mb-1">
                    <i class="fa-solid fa-eye text-xs"></i>
                </div>
                <div class="stat-value text-xs font-medium text-gray-700 dark:text-gray-300">
                    {{ $koi->views_count }}
                </div>

            </div>

            <div class="stat-item text-center">
                <button class="group relative"
                    onclick="event.stopPropagation(); toggleWishlist('{{ $koi->id }}')">
                    <div
                        class="stat-icon w-7 h-7 rounded-full bg-yellow-50 dark:bg-yellow-900/20 text-yellow-500 flex items-center justify-center mx-auto mb-1">
                        <i id="wishlist-icon-{{ $koi->id }}"
                            class="fa-solid fa-star text-xs {{ in_array((string) $koi->id, (array) $wishlist) ? 'text-yellow-500' : '' }}"></i>
                    </div>
                    <div class="stat-value text-xs font-medium text-gray-700 dark:text-gray-300">
                        Wishlist
                    </div>
                </button>
            </div>

            <div class="stat-item text-center">
                <button class="group relative" onclick="event.stopPropagation(); toggleLike('{{ $koi->id }}')">
                    <div
                        class="stat-icon w-7 h-7 rounded-full bg-red-50 dark:bg-red-900/20 text-red-500 flex items-center justify-center mx-auto mb-1">
                        <i id="like-icon-{{ $koi->id }}"
                            class="fa-solid fa-heart text-xs {{ $koi->user_liked ? 'text-red-500' : '' }}"></i>
                    </div>
                    <div class="stat-value text-xs font-medium text-gray-700 dark:text-gray-300"
                        id="likes-count-{{ $koi->id }}">
                        {{ $koi->likes_count }}
                    </div>
                </button>
            </div>
        </div>

        <!-- Bid Info -->
        <div class="bid-info grid grid-cols-2 gap-3">
            <div class="bid-item bg-gray-50 dark:bg-gray-700/50 p-3 rounded-xl">
                <div class="bid-label text-gray-500 dark:text-gray-400 text-sm">Open Bid</div>
                <div class="bid-value font-bold text-gray-800 dark:text-white">
                    Rp{{ number_format($koi->open_bid, 0, ',', '.') }}
                </div>
            </div>

            <div class="bid-item bg-gray-50 dark:bg-gray-700/50 p-3 rounded-xl">
                <div class="bid-label text-gray-500 dark:text-gray-400 text-sm">Kelipatan</div>
                <div class="bid-value font-bold text-gray-800 dark:text-white">
                    Rp{{ number_format($koi->kelipatan_bid, 0, ',', '.') }}
                </div>
            </div>

            @if ($koi->has_winner)
                <!-- Jika ada pemenang, Last Bid dan Winner sejajar -->
                <div class="bid-item bg-green-50 dark:bg-green-900/20 p-3 rounded-xl">
                    <div class="bid-label text-green-500 dark:text-green-400 text-sm">Last Bid</div>
                    <div class="bid-value font-bold text-green-600 dark:text-green-400">
                        Rp{{ number_format($koi->last_bid ?? 0, 0, ',', '.') }}
                    </div>
                </div>

                <div class="bid-item bg-yellow-50 dark:bg-yellow-900/20 p-3 rounded-xl">
                    <div class="bid-label text-yellow-500 dark:text-yellow-400 text-sm">Winner</div>
                    <div class="bid-value font-bold text-yellow-600 dark:text-yellow-400">
                        {{ $koi->winner_name }}
                    </div>
                </div>
            @else
                <!-- Jika tidak ada pemenang, Last Bid full width -->
                <div class="bid-item bg-blue-50 dark:bg-blue-900/20 p-3 rounded-xl col-span-2">
                    <div class="bid-label text-blue-500 dark:text-blue-400 text-sm">Last Bid</div>
                    <div class="bid-value font-bold text-blue-600 dark:text-blue-400">
                        Rp{{ number_format($koi->last_bid ?? 0, 0, ',', '.') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Video (Tetap sama) -->
    <div id="videoModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50"
        onclick="closeVideoModal()">
        <div class="bg-white dark:bg-gray-800 p-0 rounded-lg max-w-7xl w-auto max-h-screen overflow-auto">
            <video id="modalVideo" class="w-full h-auto mt-0 rounded-lg" controls style="max-height: 90vh;">
                <source id="videoSource" src="" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</div>

