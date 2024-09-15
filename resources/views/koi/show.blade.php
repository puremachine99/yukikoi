<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <!-- Tombol Kembali ke Daftar Lelang -->
            <a href="{{ route('auctions.show', ['auction_code' => $koi->auction->auction_code]) }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-300 focus:bg-gray-700 dark:focus:bg-gray-300 active:bg-gray-800 dark:active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 transition ease-in-out duration-150">
                <i class="fa-solid fa-arrow-left"></i> &nbsp; Lelang {{ $koi->auction->auction_code }}
            </a>
            <h2 class="font-semibold text-xl text-center text-zinc-800 dark:text-zinc-200 leading-tight">
                {{ __('Detail Koi') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6">
                <!-- Bagian Gambar dan Video Koi -->
                <div class="w-full rounded-lg shadow-lg">
                    <!-- Carousel Gambar -->
                    <div x-data="{
                        activeSlide: 0,
                        slides: [
                            @foreach ($koi->media->where('media_type', 'photo') as $media)
                                    '{{ asset('storage/' . $media->url_media) }}', @endforeach
                        ]
                    }" class="relative w-full overflow-visible rounded-lg shadow-lg">
                        <!-- Carousel wrapper -->
                        <div class="relative" style="height: 750px">

                            <template x-for="(slide, index) in slides" :key="index">
                                <div x-show="activeSlide === index" class="absolute inset-0">
                                    <img :src="slide" alt="Koi Media"
                                        class="w-full h-full object-contain rounded-lg">
                                </div>
                            </template>
                            {{-- Panel tiktok haha  --}}
                            <!-- Ikon Tambah -->
                            <button
                                class="absolute group right-8 bottom-96 w-16 h-16 z-20  text-white transition-transform transform hover:scale-110">
                                <i class="fas fa-plus-circle text-3xl"></i>
                                <!-- Tooltip -->
                                <span
                                    class="absolute bottom-full mb-2 w-max px-1 py-0 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                                    Ikuti
                                </span>
                            </button>
                            <!-- Masukin Ke Ember -->
                            <button
                                class="absolute group right-8 bottom-80 w-16 h-16 z-20  text-yellow-400 transition-transform transform hover:scale-110">
                                <i class="fas fa-bucket text-3xl"></i>
                                <!-- Tooltip -->
                                <span
                                    class="absolute bottom-full mb-2 w-max px-1 py-0 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                                    Pantau
                                </span>
                            </button>
                            <!-- Ikon Hati -->
                            <button
                                class="absolute group right-8 bottom-60 w-16 h-16 z-20  text-white transition-transform transform hover:scale-110">
                                <i class="fas fa-heart text-3xl"></i><br>
                                1000

                                <!-- Tooltip -->
                                <span
                                    class="absolute bottom-full mb-2 w-max px-1 py-0 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                                    Sukai
                                </span>
                            </button>

                            <!-- Ikon Share -->
                            <button
                                class="absolute group right-8 bottom-40 w-16 h-16 z-20  text-white transition-transform transform hover:scale-110">
                                <i class="fas fa-share text-3xl"></i> <br>200
                                <!-- Tooltip -->
                                <span
                                    class="absolute bottom-full mb-2 w-max px-1 py-0 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                                    Bagikan
                                </span>
                            </button>

                            {{-- end of panel tiktok --}}
                            <!-- Tombol Play tetap di pojok kanan bawah dari gambar -->
                            @if ($koi->media->where('media_type', 'video')->isNotEmpty())
                                <button
                                    class="absolute group -right-4 -bottom-4 w-16 h-16 z-20 bg-white text-sky-500 border-2 border-sky-500 rounded-full flex items-center justify-center transition-transform transform hover:scale-110 hover:bg-sky-500 hover:text-white hover:border-white"
                                    onclick="openVideoModal('{{ asset('storage/' . $koi->media->where('media_type', 'video')->first()->url_media) }}')">
                                    <i class="fa-solid fa-play text-3xl"></i>
                                    <!-- Tooltip -->
                                    <span
                                        class="absolute bottom-full mb-2 w-max px-2 py-1 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                                        Video Ikan 🐟
                                    </span>
                                </button>
                            @endif
                        </div>


                        <!-- Slider controls (disembunyikan jika hanya ada satu gambar) -->
                        <template x-if="slides.length > 1">
                            <div class="absolute inset-0 flex items-center justify-between px-4">
                                <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1"
                                    class="bg-black bg-opacity-50 text-white p-2 rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7">
                                        </path>
                                    </svg>
                                </button>
                                <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1"
                                    class="bg-black bg-opacity-50 text-white p-2 rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
                <!-- Bagian Detail Koi -->
                <div
                    class="bg-white dark:bg-zinc-800 p-4 sm:rounded-lg w-full rounded-lg shadow-lg relative overflow-visible ">
                    <!-- Badge RG di pojok kanan atas -->
                    {{-- <img src="{{ asset('images/az.png') }}" alt="Your Image"
                        class="absolute -top-8 -right-8 w-24 h-24 mt-2 mr-2"> --}}
                    <div class="absolute group -top-8 -right-8 w-24 h-24 mt-2 mr-2">
                        <img src="{{ asset('images/az.png') }}" alt="Your Image">
                        <span
                            class="absolute top-full mb-2 w-max px-2 py-1 text-white bg-black text-lg rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                            Azukari
                        </span>
                    </div>
                    <h3 class="text-xl font-semibold mt-4 uppercase">{{ $koi->kode_ikan }}. {{ $koi->judul }}
                        {{ $koi->ukuran }}
                        cm
                        - [{{ $koi->gender }}]</h3>
                    <p class="text-sm">{{ __('Jenis: ') . $koi->jenis_koi }}</p>
                    <!-- Jenis Koi ditambahkan sebagai detail -->
                    <hr class="mb-2 mt-2">
                    <!-- Kolom 2 baris untuk Open Bid dan Kelipatan Bid -->
                    <div class="flex justify-between  items-center">
                        <span class="text-md font-bold text-green-600">OB :
                            {{ number_format($koi->open_bid, 0, ',', '.') }}
                            ribu</span>
                        <h2 class="text-xl font-bold">
                            <i class="fa-regular fa-clock text-sm"></i> 00:00:05:36 {{-- Merah kalo kurang dari 1 jam --}}
                        </h2>
                        <span class="text-md font-bold">KB : {{ number_format($koi->kelipatan_bid, 0, ',', '.') }}
                            ribu</span>
                    </div>
                    <hr class="mb-2 mt-2">
                    <!-- Keterangan Koi -->
                    <p class="text-md flex justify-between">
                        <span>
                            <b>Seller : </b>{{ $koi->auction->user->name ?: '-' }}
                            <b>[{{ $koi->auction->user->city }}]</b>
                            <br>
                            <b>Farm : </b>{{ $koi->auction->user->farm_name ?: '-' }}
                            <br>
                            <b>Alamat : </b>{{ $koi->auction->user->address ?: '-' }}
                        </span>
                        <span>
                            <b>Kode Lelang : </b>{{ $koi->auction->auction_code ?: '-' }}
                            <br>
                            <b>Jenis Lelang : </b>{{ Str::upper($koi->auction->jenis ?: '-') }}
                            @if ($koi->buy_it_now)
                                <br>
                                <b>Buy it Now : </b>{{ number_format($koi->buy_it_now, 0, ',', '.') }}
                            @endif
                        </span>
                    </p>
                    {{-- history lelang disini  --}}

                    <div
                        class="bg-white dark:bg-zinc-800 p-4 shadow sm:rounded-lg relative md:h-[520px] lg:h-[520px] sm:h-[720px] flex flex-col justify-between">

                        <!-- Bid History Scrollable Box -->
                        <div id="history" class="overflow-y-auto max-h-full pr-2 mb-4 flex-1">
                            <!-- Other User's Bid (Left) -->
                            <div class="flex justify-start mb-4">
                                <div
                                    class="bg-zinc-200 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-100 p-3 rounded-lg max-w-xs">
                                    <p class="text-sm font-semibold">0812XX84</p>
                                    <p class="text-green-600">Open Bid: Rp 550</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-300">12:01 PM</p>
                                </div>
                            </div>

                            <!-- More dummy bids -->
                            <div class="flex justify-start mb-4">
                                <div
                                    class="bg-zinc-200 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-100 p-3 rounded-lg max-w-xs">
                                    <p class="text-sm font-semibold">0812XX85</p>
                                    <p>Bid: Rp 600</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-300">12:03 PM</p>
                                </div>
                            </div>

                            <!-- Extra Time Notification (Center) -->
                            <div class="flex justify-center mb-4">
                                <div class="text-center text-zinc-600 dark:text-zinc-400 text-sm">
                                    <p>Extra time 10 menit diberikan oleh admin</p>
                                </div>
                            </div>

                            <!-- More bids including user's own bid (Right) -->
                            <div class="flex justify-end mb-4">
                                <div
                                    class="bg-sky-500 text-white dark:bg-sky-500 dark:text-white p-3 rounded-lg max-w-xs">
                                    <p class="text-sm font-semibold">0812XX84 (You)</p>
                                    <p>Bid: Rp 700</p>
                                    <p class="text-xs text-white opacity-75">12:07 PM</p>
                                </div>
                            </div>

                            <!-- Other User's Bid (Left) -->
                            <div class="flex justify-start mb-4">
                                <div
                                    class="bg-zinc-200 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-100 p-3 rounded-lg max-w-xs">
                                    <p class="text-sm font-semibold">0812XX87</p>
                                    <p>Bid: Rp 800</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-300">12:10 PM</p>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Input (Fixed inside the box at Bottom) -->
                        <div class="bg-zinc-100 dark:bg-zinc-900 p-4 rounded-lg shadow-md w-full flex-shrink-0">
                            <div class="flex items-center space-x-2">
                                <!-- Bid Button -->
                                <button class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600">
                                    BIN
                                </button>

                                <!-- Minus Button -->
                                <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                                    -
                                </button>

                                <!-- Bid Amount (Input) -->
                                <input type="text" value="300,000"
                                    class="text-center bg-white border border-gray-300 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-sky-500 flex-grow">

                                <!-- Plus Button -->
                                <button class="bg-sky-500 text-white px-4 py-2 rounded-md hover:bg-sky-600">
                                    +
                                </button>


                                <!-- WhatsApp Button (icon) -->
                                <button
                                    class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 flex items-center">
                                    BID
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- akhir history lelang e --}}
                </div>
            </div>
            <div class="bg-white dark:bg-zinc-800 p-4 shadow sm:rounded-lg mt-4">
                <!-- Panel 1: Ikan di lelang yang sama -->
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Ikan di lelang yang sama</h2>
                <div class="relative">
                    <div class="overflow-x-auto flex space-x-4 scrollbar-hide">
                        @foreach ($koisInSameAuction as $koiInAuction)
                            <div
                                class="min-w-[150px] flex-shrink-0 bg-white dark:bg-zinc-700 p-2 rounded-lg shadow-md">
                                <img src="{{ asset('storage/' . $koiInAuction->media->first()->url_media) }}"
                                    alt="Koi Image" class=" w-40 h-auto object-scale-down rounded-lg mb-2">
                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-200">
                                    {{ $koiInAuction->name }}
                                </h3>
                                <p class="text-md dark:text-gray-400">{{ $koiInAuction->judul }}
                                <div class="flex justify-between">
                                    <span class="text-sm">OB = {{ number_format($koi->open_bid, 0, ',', '.') }}</span>
                                    <span class="text-sm">KB =
                                        {{ number_format($koi->kelipatan_bid, 0, ',', '.') }}</span>
                                </div>
                                <span class="text-gray-500">1 x Bid</span>
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <!-- Slider controls -->
                    <button
                        class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-500 text-white p-2 rounded-full"
                        onclick="scrollLeft()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button
                        class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-500 text-white p-2 rounded-full"
                        onclick="scrollRight()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Panel 2: Ikan Sejenis -->
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mt-6 mb-2">Ikan Sejenis</h2>
                <div class="relative">
                    <div class="overflow-x-auto flex space-x-4 scrollbar-hide">
                        @foreach ($koisInSameAuction as $koiInAuction)
                            <div
                                class="min-w-[150px] flex-shrink-0 bg-white dark:bg-zinc-700 p-2 rounded-lg shadow-md">
                                <img src="{{ asset('storage/' . $koiInAuction->media->first()->url_media) }}"
                                    alt="Koi Image" class=" w-40 h-auto object-scale-down rounded-lg mb-2">
                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-200">
                                    {{ $koiInAuction->name }}
                                </h3>
                                <p class="text-md dark:text-gray-400">{{ $koiInAuction->judul }}
                                <div class="flex justify-between">
                                    <span class="text-sm">OB = {{ number_format($koi->open_bid, 0, ',', '.') }}</span>
                                    <span class="text-sm">KB =
                                        {{ number_format($koi->kelipatan_bid, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">1 x Bid</span>
                                    <span class="text-green-500">300</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500"></span>
                                    <span class="text-gray-500"><i class="fa-regular fa-clock"></i> 05:00:20</span>
                                </div>
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <!-- Slider controls -->
                    <button
                        class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-500 text-white p-2 rounded-full"
                        onclick="scrollLeft()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button
                        class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-500 text-white p-2 rounded-full"
                        onclick="scrollRight()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Panel 3: Ikan Priority Seller -->
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mt-6 mb-2">Ikan Priority Seller</h2>
                <div class="relative">
                    <div class="overflow-x-auto flex space-x-4 scrollbar-hide">
                        @foreach ($koisInSameAuction as $koiInAuction)
                            <div
                                class="min-w-[150px] flex-shrink-0 bg-white dark:bg-zinc-700 p-2 rounded-lg shadow-md">
                                <img src="{{ asset('storage/' . $koiInAuction->media->first()->url_media) }}"
                                    alt="Koi Image" class=" w-40 h-auto object-scale-down rounded-lg mb-2">
                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-200">
                                    {{ $koiInAuction->name }}
                                </h3>
                                <p class="text-md dark:text-gray-400">{{ $koiInAuction->judul }}
                                <div class="flex justify-between">
                                    <span class="text-sm">OB = {{ number_format($koi->open_bid, 0, ',', '.') }}</span>
                                    <span class="text-sm">KB =
                                        {{ number_format($koi->kelipatan_bid, 0, ',', '.') }}</span>
                                </div>
                                <span class="text-gray-500">1 x Bid</span>
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <!-- Slider controls -->
                    <button
                        class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-500 text-white p-2 rounded-full"
                        onclick="scrollLeft()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button
                        class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-500 text-white p-2 rounded-full"
                        onclick="scrollRight()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal untuk video -->
            <div id="videoModal"
                class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50"
                onclick="closeVideoModal()">
                <div class="bg-white dark:bg-zinc-800 p-0 rounded-lg max-w-7xl w-auto max-h-screen overflow-auto">
                    <video id="modalVideo" class="w-full h-auto mt-0 rounded-lg" controls style="max-height: 90vh;">
                        <source id="videoSource" src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>

            <!-- Script untuk Modal Video -->
            <script>
                function scrollLeft() {
                    const container = document.querySelector('.overflow-x-auto');
                    container.scrollBy({
                        left: -200,
                        behavior: 'smooth'
                    });
                }

                function scrollRight() {
                    const container = document.querySelector('.overflow-x-auto');
                    container.scrollBy({
                        left: 200,
                        behavior: 'smooth'
                    });
                }
                document.addEventListener("DOMContentLoaded", function() {
                    var historyDiv = document.getElementById("history");
                    historyDiv.scrollTop = historyDiv.scrollHeight;
                });

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
