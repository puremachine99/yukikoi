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

    <div class="py-12 p-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($kois as $koi)
                    <x-koi-card :koi="$koi" :total-bids="$totalBids" :wishlist="$wishlist" />
                @endforeach
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
            $('[data-end-time]').each(function() {
                const $wrapper = $(this);
                const koiId = $wrapper.data('koi-id');
                const endTime = new Date($wrapper.data('end-time')).getTime();
                const $countdownElement = $(`#countdown-${koiId}`);

                if (!$countdownElement.length) return;

                const interval = setInterval(() => {
                    const now = new Date().getTime();
                    const distance = endTime - now;

                    if (distance > 0) {
                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 *
                            60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        $countdownElement.html(`${days}Hr ${hours}:${minutes}:${seconds}`);

                        if (distance <= 60 * 60 * 1000) {
                            $wrapper.removeClass('bg-yellow-500 text-black').addClass(
                                'bg-red-500 text-white');
                        } else {
                            $wrapper.removeClass('bg-red-500 text-white').addClass(
                                'bg-yellow-500 text-black');
                        }
                    } else {
                        clearInterval(interval);
                        $countdownElement.html('Lelang Berakhir');
                        $wrapper.removeClass('bg-yellow-500 bg-red-500').addClass(
                            'bg-gray-500 text-white');
                    }
                }, 1000);
            });
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
