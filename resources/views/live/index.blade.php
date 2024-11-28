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
            <div class="grid xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($kois as $koi)
                    <div class="block bg-white dark:bg-zinc-800 rounded-lg shadow-md overflow-hidden relative card-navigate"
                        data-url="{{ route('koi.show', ['id' => $koi->id]) }}">
                        <div class="relative">
                            <img src="{{ asset('storage/' . $koi->media->first()->url_media) }}" alt="Koi Image"
                                class="object-cover w-full h-[400px]">
                            <div class="watermark-overlay">
                                <img src="{{ asset('images/logo.png') }}" alt="Watermark Logo" class="watermark-logo">
                            </div>

                            <div
                                class="absolute opacity-60 hover:opacity-100 group bottom-20 right-0 bg-white dark:bg-zinc-700 p-1 px-2 rounded-l-lg shadow-md w-20">
                                <!-- Status Lelang dan Jumlah Bids -->
                                <div class="text-sm text-gray-700 dark:text-gray-200 mb-0">
                                    <span
                                        class="font-semibold {{ $koi->auction->status == 'ready' ? 'text-blue-600' : ($koi->auction->status == 'on going' ? 'text-green-600' : 'text-red-600') }}">
                                        {{ $koi->auction->status == 'ready' ? 'Belum dimulai' : ($koi->auction->status == 'on going' ? 'On Going' : 'Complete') }}
                                    </span>
                                    <div class="text-sm text-gray-700 dark:text-gray-200">
                                        <span>{{ $totalBids[(string) $koi->id]['total_bids'] ?? 0 }}x Bids</span>
                                    </div>
                                </div>

                                <span
                                    class="absolute  bottom-full mb-1 w-max px-1 py-0.5 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                                    {{ $koi->auction->status == 'ready' ? 'Belum Mulai' : ($koi->auction->status == 'on going' ? 'Sedang Berlangsung' : 'Lelang Selesai') }}
                                </span>
                            </div>


                            {{-- logo yuki koi --}}
                            <div class="absolute top-1 right-2 p-0 rounded-full text-center text-sm">
                                <img src="{{ asset('images/logo.png') }}" alt="yukbid"
                                    class="w-auto h-16 mx-auto mb-1">
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
                                <div x-data="{ showTooltip: false }" @mouseover="showTooltip = true"
                                    @mouseleave="showTooltip = false"
                                    class="absolute bottom-2 right-2 p-0 rounded-full text-center text-sm w-auto cursor-pointer">

                                    <!-- Logo untuk setiap jenis lelang -->
                                    @if ($koi->auction->jenis == 'azukari')
                                        <img src="{{ asset('images/az.png') }}" alt="Azukari Logo"
                                            class="w-auto h-14 mx-auto mb-1">
                                    @elseif ($koi->auction->jenis == 'keeping contest')
                                        <img src="{{ asset('images/kc.png') }}" alt="Keeping Contest Logo"
                                            class="w-auto h-14 mx-auto mb-1">
                                    @elseif ($koi->auction->jenis == 'grow out')
                                        <img src="{{ asset('images/go.png') }}" alt="Grow Out Logo"
                                            class="w-auto h-14 mx-auto mb-1">
                                    @endif

                                    <!-- Tooltip untuk Jenis Lelang -->
                                    <div x-show="showTooltip" x-transition
                                        class="absolute top-full mt-1 w-max px-2 py-1 text-xs text-white bg-black rounded transform -translate-x-1/2 left-1/2">
                                        {{ $koi->auction->jenis == 'azukari' ? 'Azukari' : ($koi->auction->jenis == 'keeping contest' ? 'Keeping Contest' : 'Grow Out') }}
                                    </div>
                                </div>
                            @endif




                            <div class="absolute opacity-60 hover:opacity-100 bottom-2 left-2 bg-red-500 text-white p-1 rounded-full shadow-md text-center text-xs w-36"
                                id="countdown-wrapper-{{ $koi->id }}">
                                @if ($totalBids[(string) $koi->id]['has_winner'] ?? false)
                                    <span class="font-semibold">Sold by BIN</span>
                                @else
                                    <span id="countdown-{{ $koi->id }}" class="font-semibold">00:00</span>
                                @endif
                            </div>

                        </div>

                        <!-- Informasi Koi -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 truncate">
                                {{ $koi->judul }} {{ $koi->ukuran }}cm [{{ Str::ucfirst($koi->gender) }}]</h3>

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

                            <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400 mt-2">
                                <span>Seller : {{ Str::ucfirst($koi->auction->user->farm_name) ?? '-' }}
                                    [{{ $koi->auction->user->city }}]</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 mt-3 text-sm">
                                <div class="text-gray-600 dark:text-gray-300">
                                    <span>OB:</span>
                                    <span class="font-semibold">{{ number_format($koi->open_bid, 0, ',', '.') }}</span>
                                </div>
                                <div class="text-gray-600 dark:text-gray-300">
                                    <span>KB:</span>
                                    <span
                                        class="font-semibold">{{ number_format($koi->kelipatan_bid, 0, ',', '.') }}</span>
                                </div>
                                <div class="text-blue-600 font-semibold">
                                    Last Bid:
                                    <span>{{ number_format($totalBids[(string) $koi->id]['latest_bid'] ?? $koi->open_bid, 0, ',', '.') }}</span>
                                </div>
                                @if (!empty($totalBids[(string) $koi->id]['has_winner']) && $totalBids[(string) $koi->id]['has_winner'])
                                    <div class="text-yellow-600 font-semibold">
                                        Winner:
                                        <span>{{ $totalBids[(string) $koi->id]['winner_name'] ?? 'N/A' }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const kois = @json($kois);

            kois.forEach((koi) => {
                if (koi.auction.status === 'on going') {
                    const countdownElement = document.getElementById(`countdown-${koi.id}`);
                    const countdownWrapper = document.getElementById(`countdown-wrapper-${koi.id}`);

                    // Ensure the DOM elements exist before proceeding
                    if (!countdownElement || !countdownWrapper) {
                        console.warn(`Countdown elements not found for koi ID: ${koi.id}`);
                        return;
                    }

                    const endTime = new Date(koi.auction.end_time.replace(/-/g, '/')).getTime();

                    const countdownInterval = setInterval(() => {
                        const now = new Date().getTime();
                        const distance = endTime - now;

                        if (distance > 0) {
                            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 *
                                60 * 60));
                            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            // Update countdown display
                            countdownElement.innerHTML =
                                `${days > 0 ? days + ' hari, ' : ''}${hours}:${minutes}:${seconds}`;

                            // Adjust styles based on remaining time
                            if (distance <= 60 * 60 * 1000) { // Less than 1 hour
                                countdownWrapper.classList.remove("bg-yellow-500", "text-black");
                                countdownWrapper.classList.add("bg-red-500", "text-white");
                            } else {
                                countdownWrapper.classList.remove("bg-red-500", "text-white");
                                countdownWrapper.classList.add("bg-yellow-500", "text-black");
                            }
                        } else {
                            // Stop the countdown and update text
                            clearInterval(countdownInterval);
                            countdownElement.innerHTML = 'Lelang Berakhir';
                        }
                    }, 1000);
                }
            });
        });


        document.querySelectorAll('.card-navigate').forEach(card => {
            card.addEventListener('click', function(event) {
                if (!event.target.closest('.koi-action')) {
                    window.location.href = this.dataset.url;
                }
            });
        });

        function toggleLike(koiId) {
    // Elemen terkait like
    const likeIcon = document.getElementById(`like-icon-${koiId}`);
    const likesCountElement = document.getElementById(`likes-count-${koiId}`);

    // Optimistic update: cek apakah user sudah like (class 'text-red-600' ada)
    const isLiked = likeIcon.classList.contains('text-red-600');
    let currentLikes = parseInt(likesCountElement.innerText, 10);

    // Update UI instan
    if (isLiked) {
        // Jika sebelumnya sudah like, ubah jadi dislike
        likeIcon.classList.remove('text-red-600'); // Hapus warna merah
        likesCountElement.innerText = currentLikes - 1; // Kurangi jumlah like
    } else {
        // Jika sebelumnya belum like, ubah jadi like
        likeIcon.classList.add('text-red-600'); // Tambahkan warna merah
        likesCountElement.innerText = currentLikes + 1; // Tambah jumlah like
    }

    // Kirim request ke backend
    fetch(`/koi/${koiId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    })
        .then((response) => response.json())
        .then((data) => {
            // Verifikasi dari server, jika gagal bisa revert
            if (!data.success) {
                console.error('Gagal menyimpan perubahan di backend.');
                // Revert perubahan di UI
                if (isLiked) {
                    likeIcon.classList.add('text-red-600');
                    likesCountElement.innerText = currentLikes;
                } else {
                    likeIcon.classList.remove('text-red-600');
                    likesCountElement.innerText = currentLikes;
                }
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            // Revert jika ada error
            if (isLiked) {
                likeIcon.classList.add('text-red-600');
                likesCountElement.innerText = currentLikes;
            } else {
                likeIcon.classList.remove('text-red-600');
                likesCountElement.innerText = currentLikes;
            }
        });
}

    </script>
</x-app-layout>
