<x-app-layout>
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
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Lelang: {{ $auction->auction_code }}
        </h2>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
            Seller: <strong>{{ $auction->user->farm_name }}</strong> ({{ $auction->user->city }})
        </p>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- INFO AUCTION (HEADER) --}}
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold text-zinc-800 dark:text-white">Informasi Lelang</h3>
                <div
                    class="mt-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-sm text-zinc-600 dark:text-zinc-300">
                    <div><strong>Kode:</strong> {{ $auction->auction_code }}</div>
                    <div><strong>Jenis:</strong> {{ ucfirst($auction->jenis) }}</div>
                    <div><strong>Status:</strong>
                        <span
                            class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $auction->status == 'on going'
                                ? 'bg-green-500 text-white'
                                : ($auction->status == 'ready'
                                    ? 'bg-blue-500 text-white'
                                    : 'bg-gray-500 text-white') }}">
                            {{ ucfirst($auction->status) }}
                        </span>
                    </div>
                    <div><strong>Tanggal Mulai:</strong>
                        {{ \Carbon\Carbon::parse($auction->start_time)->format('d M Y H:i') }}</div>
                </div>
            </div>

            {{-- KOI LIST (BODY) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($kois as $koi)
                    <x-koi-card :koi="$koi" :total-bids="$koi->total_bids ?? []" :wishlist="$wishlist" />
                @endforeach
            </div>

            {{-- FOOTER / CTA --}}
            <div class="mt-10 text-center text-sm text-zinc-500 dark:text-zinc-400">
                Tampilkan {{ count($kois) }} koi dari lelang <strong>{{ $auction->auction_code }}</strong>.
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
