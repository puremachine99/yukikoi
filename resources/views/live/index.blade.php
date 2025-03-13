<x-app-layout>
    <x-slot name="header">
        <style>
            @font-face {
                font-family: 'OnsenJapanDemoRegular';
                src: url('/fonts/OnsenJapanDemoRegular.ttf') format('truetype');
            }

            .vertical-text {
                writing-mode: vertical-rl;
                text-orientation: upright;
                letter-spacing: -0.2rem;
                z-index: 99;
                /* Adjust spacing between letters if needed */
            }

            .vertical-text-jp {
                font-family: 'OnsenJapanDemoRegular', sans-serif;
                writing-mode: vertical-rl;
                text-orientation: upright;
                letter-spacing: -0.2rem;
                z-index: 99;
            }

            .watermarked-image {
                position: relative;
                display: inline-block;
                overflow: hidden;
            }

            .koi-image {
                width: 100%;
                height: auto;
            }

            .watermark-overlay {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                opacity: 0.1;
                /* Adjust opacity to make it look like a watermark */
                pointer-events: none;
                /* Make watermark unclickable */
            }

            .watermark-logo {
                width: 80%;
                /* Adjust size as needed */
                max-width: 500px;
                height: auto;
                filter: grayscale(100%);
                /* Optional: make the watermark grayscale */
            }


            .text-outline {
                text-shadow:
                    -1px -1px 0 #000,
                    1px -1px 0 #000,
                    -1px 1px 0 #000,
                    1px 1px 0 #000;
            }
        </style>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Live Lelang') }}
        </h2>


    </x-slot>

    <div class="p-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                <form method="GET" action="{{ route('live.index') }}"
                    class="bg-white dark:bg-zinc-800 p-4 rounded-lg shadow-md mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
                        <!-- 🔍 Input Pencarian -->
                        <div class="relative md:col-span-2">

                            <input type="text" name="q" placeholder="Cari koi..." value="{{ request('q') }}"
                                class="w-full p-2 pl-10 border rounded-lg focus:ring focus:ring-blue-300 dark:bg-zinc-700 dark:text-white">
                            <i
                                class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>

                        <!-- 🐟 Filter Gender -->
                        <div class="md:col-span-1">
                            <label class="text-gray-600 text-sm dark:text-gray-300">Gender Koi</label>
                            <x-select name="gender" class="w-full">
                                <option value="">Semua Gender</option>
                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Jantan
                                </option>
                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Betina
                                </option>
                            </x-select>
                        </div>

                        <!-- 💰 Harga Minimum -->
                        <div class="md:col-span-1">
                            <label class="text-gray-600 text-sm dark:text-gray-300">Harga Min</label>
                            <input type="number" name="min_price" placeholder="Rp 0" value="{{ request('min_price') }}"
                                class="w-full p-2 border rounded-lg dark:bg-zinc-700 dark:text-white">
                        </div>

                        <!-- 💰 Harga Maksimum -->
                        <div class="md:col-span-1">
                            <label class="text-gray-600 text-sm dark:text-gray-300">Harga Max</label>
                            <input type="number" name="max_price" placeholder="Rp 10.000.000"
                                value="{{ request('max_price') }}"
                                class="w-full p-2 border rounded-lg dark:bg-zinc-700 dark:text-white">
                        </div>

                        <!-- 🔄 Tombol Reset -->
                        <div class="md:col-span-1 flex gap-2">
                            <button type="submit"
                                class="w-full p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                <i class="fa-solid fa-search"></i> Cari
                            </button>
                            <a href="{{ route('live.index') }}"
                                class="p-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                                <i class="fa-solid fa-refresh"></i>
                            </a>
                        </div>
                    </div>
                </form>


            </div>
            <div class="grid grid-cols-1 xs:grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($kois as $koi)
                    <x-koi-card :koi="$koi" :total-bids="$totalBids[$koi->id] ?? 0" :wishlist="in_array($koi->id, $wishlist)" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $kois->links('pagination::tailwind') }} {{-- Jika pakai Tailwind --}}

            </div>

        </div>
    </div>

    <script>
        // ============================== CONFIGURATIONS ===============================
        const CONFIG = {
            csrfToken: document.querySelector('meta[name="csrf-token"]').content,
            routes: {
                toggleLike: '/koi/{id}/like',
                toggleWishlist: '/wishlist/toggle'
            }
        };

        // ============================== TIMER FUNCTIONALITY ===============================
        $(document).ready(function() {
            function updateCountdown() {
                $('[data-end-time]').each(function() {
                    const $wrapper = $(this);
                    const koiId = $wrapper.data('koi-id');
                    const endTime = new Date($wrapper.data('end-time')).getTime();
                    const $countdownElement = $(`#countdown-${koiId}`);

                    if (!$countdownElement.length) return;

                    const now = new Date().getTime();
                    const distance = endTime - now;

                    if (distance > 0) {
                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        $countdownElement.text(`${days}Hr ${hours}:${minutes}:${seconds}`);

                        if (distance <= 60 * 60 * 1000) {
                            $wrapper.removeClass('bg-yellow-500 text-black').addClass(
                                'bg-red-500 text-white');
                        } else {
                            $wrapper.removeClass('bg-red-500 text-white').addClass(
                                'bg-yellow-500 text-black');
                        }
                    } else {
                        $countdownElement.text('Lelang Berakhir');
                        $wrapper.removeClass('bg-yellow-500 bg-red-500').addClass('bg-gray-500 text-white');
                    }
                });

                // Recursive update setiap detik
                setTimeout(updateCountdown, 1000);
            }

            // Jalankan pertama kali saat halaman dimuat
            updateCountdown();
        });


        // ============================== NAVIGATION FUNCTIONALITY ===============================
        $('.card-navigate').click(function(event) {
            if (!$(event.target).closest('.koi-action').length) {
                window.location.href = $(this).data('url');
            }
        });

        // ============================== LIKE FUNCTIONALITY ===============================
        function toggleLike(koiId) {
            const likeIcon = $(`#like-icon-${koiId}`);
            const likesCountElement = $(`#likes-count-${koiId}`);
            const isLiked = likeIcon.hasClass('text-red-600');
            let currentLikes = parseInt(likesCountElement.text(), 10) || 0; // Default ke 0 jika NaN

            likeIcon.toggleClass('text-red-600');
            likesCountElement.text(isLiked ? currentLikes - 1 : currentLikes + 1);

            $.post(CONFIG.routes.toggleLike.replace('{id}', koiId), {
                _token: CONFIG.csrfToken
            }).fail(() => {
                likeIcon.toggleClass('text-red-600');
                likesCountElement.text(currentLikes); // Kembalikan ke nilai sebelumnya jika gagal
            });
        }


        // ============================== WISHLIST FUNCTIONALITY ===============================
        function toggleWishlist(koiId) {
            const wishlistIcon = $(`#wishlist-icon-${koiId}`);
            const isWishlisted = wishlistIcon.hasClass('text-yellow-500');

            wishlistIcon.toggleClass('text-yellow-500');

            $.post(CONFIG.routes.toggleWishlist, {
                _token: CONFIG.csrfToken,
                koi_id: koiId
            }).fail(() => {
                wishlistIcon.toggleClass('text-yellow-500');
            });
        }
    </script>
</x-app-layout>
