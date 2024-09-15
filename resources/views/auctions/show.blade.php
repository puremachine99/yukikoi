<!-- resources/views/koi/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-items-start">
            <!-- Tombol Kembali ke Daftar Lelang -->
            <a href="{{ route('auctions.index') }}"
                class="inline-flex items-center mr-4 px-4 py-2 bg-gray-600 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-300 focus:bg-gray-700 dark:focus:bg-gray-300 active:bg-gray-800 dark:active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 transition ease-in-out duration-150">
                <i class="fa-solid fa-arrow-left"></i> &nbsp;LELANG
            </a>
            <h2 class="font-semibold text-xl text-center text-zinc-800 dark:text-zinc-200 leading-tight">
                {{ __('DAFTAR KOI ') }} #{{ $auction_code }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-zinc-800 shadow sm:rounded-lg">
                <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight mb-4">
                    {{ Str::upper($auction->title) }} <i class="fa-solid fa-circle-check text-sky-500"></i></h2>

                <div class="flex flex-col">
                    <p class="text-md font-semibold text-zinc-800 dark:text-zinc-200">
                        {{ __('Pemilik Lelang: ') }} <span class="font-normal">{{ $auction->user->name ?: '-' }}</span>
                    </p>
                    <p class="text-md font-semibold text-zinc-800 dark:text-zinc-200">
                        {{ __('Farm: ') }} <span class="font-normal">{{ $auction->user->farm_name ?: '-' }}</span>
                    </p>
                    <p class="text-md font-semibold text-zinc-800 dark:text-zinc-200">
                        {{ __('Domisili: ') }} <span class="font-normal">{{ $auction->user->city ?: '-' }}</span>
                    </p>
                    <p class="text-md font-semibold text-zinc-800 dark:text-zinc-200">
                        {{ __('Waktu Mulai: ') }}
                        <span
                            class="font-normal">{{ $auction->start_time ? $auction->start_time->format('d M Y, H:i') : '-' }}</span>
                        <span
                            class="text-sm text-gray-600 dark:text-gray-400">({{ $auction->start_time ? $auction->start_time->diffForHumans() : '-' }})</span>
                    </p>
                    <p class="text-md font-semibold text-zinc-800 dark:text-zinc-200">
                        {{ __('Waktu Berakhir: ') }}
                        <span class="font-normal">{{ $auction->end_time ? $auction->end_time : '-' }}</span>
                        (<span id="countdown" class="font-normal text-sm text-gray-600 dark:text-gray-400"></span>)
                    </p>
                </div>

                <hr class="mt-4 mb-4">
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
                        <p class="text-zinc-600 dark:text-zinc-400">
                            {{ $message ?? __('Belum ada koi di lelang ini.') }}
                        </p>
                    @else
                        <div id="koiContainer" class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($kois as $koi)
                                @include('auctions.partials.koi_list', ['koi' => $koi])
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>



    <!-- Modal and Alpine.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function markKoi(koiId, button) {
            console.log("Menandai Koi dengan ID:", koiId); // Memastikan koiId diterima dengan benar
            $.ajax({
                url: "{{ route('ember.store') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    koi_id: koiId, // Gunakan koiId dari parameter
                },
                success: function(response) {
                    console.log("Response diterima:", response);
                    if (response.status === 'success' || response.status === 'already_marked') {
                        // Disable the button if marked successfully or if it's already marked
                        $(button).prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Terjadi kesalahan:", textStatus, errorThrown); // Log error jika terjadi
                }
            });
        }



        function filterKois() {
            const searchKoi = document.getElementById('searchKoi').value.toLowerCase();
            const filterJenisKoi = document.getElementById('filterJenisKoi').value;
            const filterGenderKoi = document.getElementById('filterGenderKoi').value;

            const koiItems = document.querySelectorAll('.koi-item');
            let isAnyVisible = false;

            koiItems.forEach(item => {
                const jenis = item.getAttribute('data-jenis').toLowerCase();
                const gender = item.getAttribute('data-gender').toLowerCase();
                const searchData = item.getAttribute('data-search').toLowerCase();

                let isVisible = true;

                if (searchKoi && !searchData.includes(searchKoi)) {
                    isVisible = false;
                }
                if (filterJenisKoi && jenis !== filterJenisKoi.toLowerCase()) {
                    isVisible = false;
                }
                if (filterGenderKoi && gender !== filterGenderKoi.toLowerCase()) {
                    isVisible = false;
                }

                item.style.display = isVisible ? 'block' : 'none';

                if (isVisible) {
                    isAnyVisible = true;
                }
            });

            document.getElementById('noDataMessage').style.display = isAnyVisible ? 'none' : 'block';
        }

        // Fungsi delete untuk Koi
        document.querySelectorAll('.delete-koi-btn').forEach(button => {
            button.addEventListener('click', function() {
                const koiId = this.getAttribute('data-koi-id');
                const koiName = this.getAttribute('data-koi-name');

                Swal.fire({
                    title: 'Yakin mau hapus ikan?',
                    text: `Nama Koi: ${koiName}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteKoi(koiId);
                    }
                });
            });
        });

        function deleteKoi(koiId) {
            fetch(`/koi/${koiId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        Swal.fire('Error', 'Gagal menghapus Koi', 'error');
                    }
                });
        }

        let scrollPosition = 0;
        // Script to handle tooltip display on hover
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('mouseenter', () => {
                const tooltip = button.querySelector('.tooltip-text');
                if (tooltip) {
                    tooltip.classList.remove('hidden');
                }
            });
            button.addEventListener('mouseleave', () => {
                const tooltip = button.querySelector('.tooltip-text');
                if (tooltip) {
                    tooltip.classList.add('hidden');
                }
            });
        });

        function openModal(imageUrl) {
            scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            const certImage = document.getElementById('certImage');
            const certModal = document.getElementById('certModal');
            if (certImage && certModal) {
                certImage.src = imageUrl;
                certModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal() {
            const certModal = document.getElementById('certModal');
            if (certModal) {
                certModal.classList.add('hidden');
                document.body.style.overflow = '';
                window.scrollTo(0, scrollPosition);
            }
        }

        function openVideoModal(videoUrl) {
            scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            const video = document.getElementById('modalVideo');
            const videoSource = document.getElementById('videoSource');
            const videoModal = document.getElementById('videoModal');
            if (video && videoSource && videoModal) {
                videoSource.src = videoUrl;
                video.load();
                video.play();
                videoModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeVideoModal() {
            const video = document.getElementById('modalVideo');
            const videoModal = document.getElementById('videoModal');
            if (video && videoModal) {
                video.pause();
                video.currentTime = 0;
                videoModal.classList.add('hidden');
                document.body.style.overflow = '';
                window.scrollTo(0, scrollPosition);
            }
        }
    </script>

    <script>
        // Mengambil end_time dari database dalam format Y-m-d H:i:s
        var endTime = new Date("{{ $auction->end_time }}".replace(/-/g, '/')).getTime();

        var countdownInterval = setInterval(function() {
            var now = new Date().getTime();
            var distance = endTime - now;

            // Perhitungan hari, jam, menit, detik dari sisa waktu
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Jika sisa waktu masih ada, tampilkan countdown
            if (distance > 0) {
                document.getElementById("countdown").innerHTML = days + " hari, " + hours + ":" + minutes + ":" +
                    seconds + "";
            } else {
                // Jika waktu habis, hentikan countdown dan tampilkan "Lelang Berakhir"
                clearInterval(countdownInterval);
                document.getElementById("countdown").innerHTML = now + "  |  " + endTime;
            }
        }, 1000);
    </script>


</x-app-layout>
