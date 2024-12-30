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
                    <x-koi-card :koi="$koi" :total-bids="$totalBids" />
                @endforeach
            </div>
        </div>
    </div>

    <script>
        // timer
        document.addEventListener("DOMContentLoaded", function() {
            const countdownWrappers = document.querySelectorAll("[data-end-time]");

            countdownWrappers.forEach(wrapper => {
                const koiId = wrapper.dataset.koiId;
                const endTime = new Date(wrapper.dataset.endTime).getTime();
                const countdownElement = wrapper.querySelector(`#countdown-${koiId}`);

                // Jika countdownElement tidak ditemukan, skip proses ini
                if (!countdownElement) {
                    return;
                }

                const interval = setInterval(() => {
                    const now = new Date().getTime();
                    const distance = endTime - now;

                    if (distance > 0) {
                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 *
                            60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // Tambahkan 0 di depan angka jika kurang dari 10
                        const formattedDays = days.toString().padStart(2, '0');
                        const formattedHours = hours.toString().padStart(2, '0');
                        const formattedMinutes = minutes.toString().padStart(2, '0');
                        const formattedSeconds = seconds.toString().padStart(2, '0');

                        // Update countdown text
                        countdownElement.innerHTML =
                            `${formattedDays}Hr ${formattedHours}:${formattedMinutes}:${formattedSeconds}`;

                        // Update wrapper color based on time remaining
                        if (distance <= 60 * 60 * 1000) { // Less than 1 hour
                            wrapper.classList.remove("bg-yellow-500", "text-black");
                            wrapper.classList.add("bg-red-500", "text-white");
                        } else {
                            wrapper.classList.remove("bg-red-500", "text-white");
                            wrapper.classList.add("bg-yellow-500", "text-black");
                        }
                    } else {
                        clearInterval(interval);
                        countdownElement.innerHTML = "Lelang Berakhir";
                        wrapper.classList.remove("bg-yellow-500", "bg-red-500");
                        wrapper.classList.add("bg-gray-500", "text-white");
                    }
                }, 1000);
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
