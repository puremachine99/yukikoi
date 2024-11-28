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
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-6">
                        <!-- Foto Profil Lingkaran -->
                        <img src="{{ $auction->user->profile_photo ? asset('storage/' . $auction->user->profile_photo) : asset('default-profile.png') }}"
                            alt="Profile Photo" class="rounded-full h-16 w-16 object-cover mr-4">
                        <div>
                            <!-- Judul Auction dengan Ikon -->
                            <h2 class="font-semibold text-2xl text-zinc-800 dark:text-zinc-200 mb-1">
                                {{ Str::upper($auction->title) }}
                                <i class="fa-solid fa-circle-check text-sky-500"></i>
                            </h2>

                        </div>
                    </div>

                    <!-- Informasi Lelang -->
                    <div class="space-y-3">
                        <!-- Farm Name -->
                        <div class="flex items-center">
                            <i class="fa-solid fa-leaf text-sky-500 mr-2"></i>
                            <a href="{{ route('profile.show', ['id' => $auction->user->id]) }}"
                                class="text-md font-semibold text-zinc-800 dark:text-zinc-200 hover:underline">
                                {{ __('Seller : ') }}
                                <span class="font-normal text-zinc-700 dark:text-zinc-300">
                                    {{ $auction->user->farm_name ?: '-' }} [{{ $auction->user->city }}]
                                </span>
                            </a>

                        </div>

                        <!-- Domisili -->
                        <div class="flex items-center">
                            <i class="fa-solid fa-location-dot text-red-500 mr-2"></i>
                            <p class="text-md font-semibold text-zinc-800 dark:text-zinc-200">
                                {{ __('Domisili: ') }}
                                <span
                                    class="font-normal text-zinc-700 dark:text-zinc-300">{{ $auction->user->city ?: '-' }}</span>
                            </p>
                        </div>

                        <!-- Waktu Mulai -->
                        <div class="flex items-center">
                            <i class="fa-solid fa-calendar-check text-green-500 mr-2"></i>
                            <p class="text-md font-semibold text-zinc-800 dark:text-zinc-200">
                                {{ __('Waktu Mulai: ') }}
                                <span
                                    class="font-normal text-zinc-700 dark:text-zinc-300">{{ $auction->start_time ? $auction->start_time : '-' }}</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    ({{ $auction->start_time ? $auction->start_time->diffForHumans() : '-' }})
                                </span>
                            </p>
                        </div>

                        <!-- Waktu Berakhir -->
                        <div class="flex items-center">
                            <i class="fa-solid fa-calendar-xmark text-red-500 mr-2"></i>
                            <p class="text-md font-semibold text-zinc-800 dark:text-zinc-200">
                                {{ __('Waktu Berakhir: ') }}
                                <span
                                    class="font-normal text-zinc-700 dark:text-zinc-300">{{ $auction->end_time ? $auction->end_time : '-' }}</span>
                                (<span id="countdown"
                                    class="font-normal text-sm text-gray-600 dark:text-gray-400"></span>)
                            </p>
                        </div>
                    </div>
                </div>


                <hr class="mt-4 mb-4">
                {{-- <div class="flex items-center space-x-4 mb-6">
                    <!-- Pencarian Koi -->
                    <input type="text" id="searchKoi" placeholder="Cari Koi..."
                        class="border border-gray-300 dark:border-zinc-600 rounded-md p-2 w-1/3 dark:bg-zinc-800 dark:text-zinc-100"
                        oninput="filterKois()" />

                    <!-- Filter Jenis Koi -->
                    <select id="filterJenisKoi"
                        class="border border-gray-300 dark:border-zinc-600 rounded-md p-2 w-1/3 dark:bg-zinc-800 dark:text-zinc-100"
                        onchange="filterKois()">
                        <option value="">{{ __('Semua Jenis') }}</option>
                        <!-- Separator: Paling Populer -->
                        <option disabled>--- Paling Populer ---</option>
                        <option value="Kohaku">Kohaku</option>
                        <option value="Asagi">Asagi</option>
                        <option value="Showa Sanshoku (Showa)">Showa</option>
                        <option value="Doitsu">Doitsu</option>
                        <option value="Taisho Sanshoku (Sanke)">Sanke (Taisho Sansoku)</option>
                        <option value="Tancho">Tancho</option>

                        <!-- Separator: Varietas -->
                        <option disabled>--- Varietas ---</option>
                        <option value="Bekko">Bekko</option>
                        <option value="Goshiki">Goshiki</option>
                        <option value="Koromo">Koromo</option>
                        <option value="Kujaku">Kujaku</option>
                        <option value="Shiro Utsuri (Shiro)">Shiro Utsuri (Shiro)</option>
                        <option value="Shusui">Shusui</option>
                        <option value="Ochiba">Ochiba</option>
                        <option value="Hi/Ki Utsurimono">Hi/Ki Utsurimono</option>
                        <option value="Hikari Moyomono">Hikari Moyomono</option>
                        <option value="Hikari Mujimono">Hikari Mujimono</option>
                        <option value="Hikari Utsurimono">Hikari Utsurimono</option>
                        <option value="Kawarimono A">Kawarimono A</option>
                        <option value="Kawarimono B">Kawarimono B</option>
                        <option value="Kinginrin A">Kinginrin A</option>
                        <option value="Kinginrin B">Kinginrin B</option>
                        <option value="Kinginrin C">Kinginrin C</option>

                        <!-- Separator: Sub Varietas -->
                        <option disabled>--- Sub Varietas ---</option>
                        <option value="Shiro Bekko">Shiro Bekko</option>
                        <option value="Ki Bekko">Ki Bekko</option>
                        <option value="Aka Bekko">Aka Bekko</option>
                        <option value="Ai Goromo">Ai Goromo</option>
                        <option value="Sumi Goromo">Sumi Goromo</option>
                        <option value="Budo Goromo">Budo Goromo</option>
                        <option value="Tancho Kohaku">Tancho Kohaku</option>
                        <option value="Tancho Sanke">Tancho Sanke</option>
                        <option value="Tancho Showa">Tancho Showa</option>
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
                </div> --}}



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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const kois = @json($kois);

            kois.forEach((koi) => {
                if (koi.auction.status === 'on going') {
                    const countdownElement = document.getElementById(`countdown-${koi.id}`);
                    const endTime = new Date("{{ $koi->auction->end_time }}".replace(/-/g, '/')).getTime();

                    const countdownInterval = setInterval(() => {
                        const now = new Date().getTime();
                        const distance = endTime - now;

                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 *
                            60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        if (distance > 0) {
                            countdownElement.innerHTML =
                                `${days > 0 ? days + ' hari, ' : ''}${hours}:${minutes}:${seconds}`;
                        } else {
                            clearInterval(countdownInterval);
                            countdownElement.innerHTML = 'Lelang Berakhir';
                        }
                    }, 1000);
                }
            });
        });

        function redirectToKoiPage(event, url) {
            // Jika elemen yang diklik memiliki kelas 'no-route', cegah redirect
            if (event.target.closest('.no-route')) return;
            window.location.href = url;
        }

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

        document.addEventListener("DOMContentLoaded", function() {
            // Get elements for filters and koi items
            const searchInput = document.getElementById('searchKoi');
            const jenisSelect = document.getElementById('filterJenisKoi');
            const genderSelect = document.getElementById('filterGenderKoi');
            const koiItems = document.querySelectorAll('.koi-item');
            const noDataMessage = document.getElementById('noDataMessage');

            function filterKois() {
                // Retrieve filter values
                const searchQuery = searchInput.value.toLowerCase();
                const selectedJenis = jenisSelect.value.toLowerCase();
                const selectedGender = genderSelect.value.toLowerCase();

                let isAnyVisible = false;

                // Loop through each koi item to check if it matches the filters
                koiItems.forEach(item => {
                    // Get data attributes for filtering
                    const jenis = item.getAttribute('data-jenis').toLowerCase();
                    const gender = item.getAttribute('data-gender').toLowerCase();
                    const searchData = item.getAttribute('data-search').toLowerCase();

                    // Initialize item visibility
                    let isVisible = true;

                    // Apply search filter
                    if (searchQuery && !searchData.includes(searchQuery)) {
                        isVisible = false;
                    }
                    // Apply jenis filter
                    if (selectedJenis && jenis !== selectedJenis) {
                        isVisible = false;
                    }
                    // Apply gender filter
                    if (selectedGender && gender !== selectedGender) {
                        isVisible = false;
                    }

                    // Show or hide item based on the combined filters
                    item.style.display = isVisible ? 'block' : 'none';

                    // Check if any item is visible
                    if (isVisible) {
                        isAnyVisible = true;
                    }
                });

                // Display "No Data" message if no items are visible
                noDataMessage.style.display = isAnyVisible ? 'none' : 'block';
            }

            // Attach event listeners for real-time filtering
            searchInput.addEventListener('input', filterKois);
            jenisSelect.addEventListener('change', filterKois);
            genderSelect.addEventListener('change', filterKois);
        });
    </script>


</x-app-layout>
