<!-- resources/views/koi/index.blade.php -->
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
        <div class="flex justify-between items-center">
            <!-- Tombol Kembali ke Daftar Lelang -->
            <a href="{{ route('auctions.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-300 focus:bg-gray-700 dark:focus:bg-gray-300 active:bg-gray-800 dark:active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 transition ease-in-out duration-150">
                <i class="fa-solid fa-arrow-left"></i> &nbsp;LELANGKU
            </a>
            <h2 class="font-semibold text-xl text-center text-zinc-800 dark:text-zinc-200 leading-tight">
                {{ __('Daftar Koi Lelang ') . $auction_code }}
            </h2>

            <div class="flex space-x-4">
                @if ($auction->status === 'draft')
                    <!-- Tombol tambah Koi jika status lelang adalah 'draft' -->
                    <a href="{{ route('koi.create', ['auction_code' => $auction->auction_code]) }}"
                        class="inline-flex items-center px-4 py-2 bg-zinc-800 dark:bg-zinc-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-zinc-800 uppercase tracking-widest hover:bg-zinc-700 dark:hover:bg-white focus:bg-zinc-700 dark:focus:bg-white active:bg-zinc-900 dark:active:bg-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 transition ease-in-out duration-150">
                        {{ __('+ Ikan') }}
                    </a>
                @else
                    <span class="text-red-500 text-sm">
                        {{ __('Lelang sudah berjalan atau selesai, tidak bisa menambah Koi.') }}
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-zinc-800 shadow sm:rounded-lg">
                <div class="flex items-center space-x-4 mb-6">
                    <!-- Pencarian Koi -->
                    <input type="text" id="searchKoi" placeholder="Cari Koi..."
                        class="border border-gray-300 dark:border-zinc-600 rounded-md p-2 w-1/3 dark:bg-zinc-800 dark:text-zinc-100"
                        oninput="filterKois()" />

                    <!-- Filter Jenis Koi -->
                    <select id="filterJenisKoi"
                        class="border border-gray-300 dark:border-zinc-600 rounded-md p-2 w-1/3 dark:bg-zinc-800 dark:text-zinc-100"
                        onchange="filterKois()">
                        <option value="">{{ __('Semua Jenis') }}</option>
                        <option value="Kohaku">Kohaku</option>
                        <option value="Asagi">Asagi</option>
                        <option value="Showa">Showa</option>
                        <option value="Shiro Utsuri">Shiro Utsuri</option>
                        <!-- Tambahkan opsi lainnya -->
                    </select>

                    <!-- Filter Gender Koi -->
                    <select id="filterGenderKoi"
                        class="border border-gray-300 dark:border-zinc-600 rounded-md p-2 w-1/3 dark:bg-zinc-800 dark:text-zinc-100"
                        onchange="filterKois()">
                        <option value="">{{ __('Semua Gender') }}</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Unchecked">Unchecked</option>
                    </select>
                </div>


                <div class="container mx-auto px-4">
                    @if ($kois->isEmpty())
                        <p class="text-zinc-600 dark:text-zinc-400">{{ $message ?? __('Belum ada koi di lelang ini.') }}
                        </p>
                    @else
                        <div id="koiContainer" class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($kois as $koi)
                                <x-koi-card :koi="$koi" :url="route('koi.show', ['id' => $koi->id])" :totalBids="$totalBids[$koi->id] ?? []">
                                    @auth
                                        <!-- Tombol Edit -->
                                        <button
                                            class="absolute group top-8 -right-4 py-2 px-3 bg-zinc-500 text-white rounded-full hover:bg-zinc-100 hover:text-zinc-950 dark:hover:bg-zinc-200 dark:hover:text-zinc-800 transition-transform transform hover:scale-110 focus:outline-none"
                                            style="z-index: 10"
                                            onclick="window.location.href='{{ route('koi.edit', ['auction_code' => $koi->auction_code, 'id' => $koi->id]) }}'">
                                            <i class="fa-solid fa-pen"></i>
                                            <span
                                                class="absolute right-full mr-2 w-max px-2 py-1 text-xs text-white bg-black dark:bg-zinc-800 rounded hidden group-hover:block transform top-1/2 -translate-y-1/2">
                                                Edit Koi
                                            </span>
                                        </button>


                                        <!-- Tombol Hapus -->
                                        <button
                                            class="absolute group -top-4 -right-4 py-2 px-3 bg-zinc-500 text-white rounded-full hover:bg-zinc-100 hover:text-zinc-950 dark:hover:bg-zinc-200 dark:hover:text-zinc-800 transition-transform transform hover:scale-110 focus:outline-none"
                                            style="z-index: 11" data-koi-id="{{ $koi->id }}"
                                            data-koi-name="{{ $koi->judul }}" onclick="confirmDeleteKoi(this)">
                                            <i class="fas fa-trash-alt"></i>
                                            <span
                                                class="absolute right-full mr-2 w-max px-2 py-1 text-xs text-white bg-black dark:bg-zinc-800 rounded hidden group-hover:block transform top-1/2 -translate-y-1/2">
                                                Hapus Koi
                                            </span>
                                        </button>

                                    @endauth
                                </x-koi-card>
                            @endforeach
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>
    <script>
        function filterKois() {
            // Ambil nilai input filter
            const searchKoi = document.getElementById('searchKoi').value.toLowerCase();
            const filterJenisKoi = document.getElementById('filterJenisKoi').value;
            const filterGenderKoi = document.getElementById('filterGenderKoi').value;

            // Ambil semua item Koi yang ada di halaman
            const koiItems = document.querySelectorAll('.koi-item');
            let isAnyVisible = false;

            koiItems.forEach(item => {
                const jenis = item.getAttribute('data-jenis').toLowerCase();
                const gender = item.getAttribute('data-gender').toLowerCase();
                const searchData = item.getAttribute('data-search').toLowerCase();

                let isVisible = true;

                // Cek berdasarkan pencarian teks
                if (searchKoi && !searchData.includes(searchKoi)) {
                    isVisible = false;
                }

                // Cek berdasarkan filter jenis koi
                if (filterJenisKoi && jenis !== filterJenisKoi.toLowerCase()) {
                    isVisible = false;
                }

                // Cek berdasarkan filter gender koi
                if (filterGenderKoi && gender !== filterGenderKoi.toLowerCase()) {
                    isVisible = false;
                }

                // Tampilkan atau sembunyikan elemen berdasarkan hasil filter
                item.style.display = isVisible ? 'block' : 'none';

                if (isVisible) {
                    isAnyVisible = true;
                }
            });

            // Tampilkan pesan "Data tidak ditemukan" jika tidak ada elemen yang terlihat
            document.getElementById('noDataMessage').style.display = isAnyVisible ? 'none' : 'block';
        }

        // Fungsi delete untuk Koi
        // Add event listener to all delete buttons
        document.querySelectorAll('.delete-koi-btn').forEach(button => {
            button.addEventListener('click', function() {
                const koiId = this.getAttribute('data-koi-id');
                const koiName = this.getAttribute('data-koi-name');

                // Show confirmation dialog
                Swal.fire({
                    title: 'Yakin mau hapus ikan?',
                    text: `Nama Koi: ${koiName}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteKoi(koiId, koiName); // Call the delete function
                    }
                });
            });
        });

        // Delete function with fetch API
        function deleteKoi(koiId, koiName) {
            fetch(`/koi/${koiId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal menghapus Koi');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: `Koi "${koiName}" berhasil dihapus.`,
                            icon: 'success',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            location.reload(); // Reload the page after deletion
                        });
                    } else {
                        throw new Error(data.message || 'Gagal menghapus Koi');
                    }
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire('Error', error.message, 'error');
                });
        }


        let scrollPosition = 0;
        // Script to handle tooltip display on hover
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('mouseenter', () => {
                const tooltip = button.querySelector('.tooltip-text');
                if (tooltip) { // Pastikan elemen tooltip ada
                    tooltip.classList.remove('hidden');
                }
            });
            button.addEventListener('mouseleave', () => {
                const tooltip = button.querySelector('.tooltip-text');
                if (tooltip) { // Pastikan elemen tooltip ada
                    tooltip.classList.add('hidden');
                }
            });
        });

        function openModal(imageUrl) {
            scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            document.getElementById('certImage').src = imageUrl;
            document.getElementById('certModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('certModal').classList.add('hidden');
            document.body.style.overflow = '';
            window.scrollTo(0, scrollPosition);
        }

        function openVideoModal(videoUrl) {
            scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            var video = document.getElementById('modalVideo');
            document.getElementById('videoSource').src = videoUrl;
            video.load();
            video.play();
            document.getElementById('videoModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeVideoModal() {
            var video = document.getElementById('modalVideo');
            video.pause();
            video.currentTime = 0;
            document.getElementById('videoModal').classList.add('hidden');
            document.body.style.overflow = '';
            window.scrollTo(0, scrollPosition);
        }
    </script>

</x-app-layout>
