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
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .watermarked-image:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .koi-image {
            width: 100%;
            height: auto;
            border-radius: 0.75rem;
            object-fit: cover;
            aspect-ratio: 1/1;
        }

        .watermark-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            pointer-events: none;
        }

        .watermark-logo {
            width: 80%;
            max-width: 500px;
            height: auto;
            filter: grayscale(100%);
        }

        .text-outline {
            text-shadow:
                -1px -1px 0 #000,
                1px -1px 0 #000,
                -1px 1px 0 #000,
                1px 1px 0 #000;
        }

        /* Modal styles */
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            max-height: 90vh;
            max-width: 90vw;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Animation for koi cards */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .koi-card {
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }

        .koi-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .koi-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .koi-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .koi-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .koi-card:nth-child(5) {
            animation-delay: 0.5s;
        }

        .koi-card:nth-child(6) {
            animation-delay: 0.6s;
        }

        .koi-card:nth-child(7) {
            animation-delay: 0.7s;
        }

        .koi-card:nth-child(8) {
            animation-delay: 0.8s;
        }
    </style>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-2">
            <div class="flex items-center gap-2">
                <!-- Back button -->
                <a href="{{ route('auctions.index') }}"
                    class="inline-flex items-center px-3 py-1.5 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <i class="fa-solid fa-arrow-left mr-1"></i>
                    <span class="hidden sm:inline">LELANGKU</span>
                </a>

                <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Daftar Koi Lelang ') . $auction_code }}
                </h2>
            </div>

            <div class="flex flex-wrap gap-1 w-full md:w-auto">
                @if ($auction->status === 'draft')
                    <!-- Add Koi button -->
                    <a href="{{ route('koi.create', ['auction_code' => $auction->auction_code]) }}"
                        class="inline-flex items-center px-3 py-1.5 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <i class="fas fa-plus mr-1"></i>
                        <span>{{ __('Tambah Ikan') }}</span>
                    </a>
                @else
                    <span
                        class="inline-flex items-center px-2 py-1 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 text-xs rounded-md">
                        <i class="fas fa-info-circle mr-1"></i>
                        {{ __('Lelang sudah berjalan atau selesai') }}
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6 space-y-4">
            <div class="p-3 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <!-- Filter section -->
                <div class="flex flex-col md:flex-row items-center gap-2 mb-4">
                    <!-- Search input -->
                    <div class="relative w-full md:w-1/3">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                            <i class="fas fa-search text-gray-400 text-sm"></i>
                        </div>
                        <input type="text" id="searchKoi" placeholder="Cari Koi..."
                            class="block w-full pl-8 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            oninput="filterKois()" />
                    </div>

                    <!-- Koi type filter -->
                    <div class="relative w-full md:w-1/3">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                            <i class="fas fa-fish text-gray-400 text-sm"></i>
                        </div>
                        <select id="filterJenisKoi"
                            class="block w-full pl-8 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">{{ __('Semua Jenis') }}</option>
                            <option value="Kohaku">Kohaku</option>
                            <option value="Asagi">Asagi</option>
                            <option value="Showa">Showa</option>
                            <option value="Shiro Utsuri">Shiro Utsuri</option>
                        </select>
                    </div>

                    <!-- Gender filter -->
                    <div class="relative w-full md:w-1/3">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                            <i class="fas fa-venus-mars text-gray-400 text-sm"></i>
                        </div>
                        <select id="filterGenderKoi"
                            class="block w-full pl-8 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            onchange="filterKois()">
                            <option value="">{{ __('Semua Gender') }}</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Unchecked">Unchecked</option>
                        </select>
                    </div>
                </div>

                <div class="container mx-auto px-1">
                    @if ($kois->isEmpty())
                        <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-fish text-2xl mb-2"></i>
                            <p>{{ $message ?? __('Belum ada koi di lelang ini.') }}</p>
                        </div>
                    @else
                        <!-- Koi grid with minimal padding -->
                        <div id="koiContainer" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                            @foreach ($kois as $koi)
                                <x-koi-card :koi="$koi" :total-bids="$totalBids[$koi->id] ?? []" :wishlist="$wishlist" />
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for image preview -->
    <div id="certModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-2">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg relative max-w-4xl w-full m-2">
            <button onclick="closeModal()"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div class="p-2 max-h-[90vh] overflow-auto">
                <img id="certImage" src="" alt="Certificate" class="w-full h-auto rounded">
            </div>
        </div>
    </div>

    <!-- Modal for video preview -->
    <div id="videoModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-2">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg relative max-w-4xl w-full m-2">
            <button onclick="closeVideoModal()"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div class="p-2">
                <video id="modalVideo" controls class="w-full rounded">
                    <source id="videoSource" src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
    @vite(['resources/js/app.js', 'resources/js/koi-card.js'])

</x-app-layout>
