<!DOCTYPE html>
<html lang="id" :class="{ 'dark': darkMode }" x-data="{ darkMode: $persist(false) }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Lelangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                        },
                        secondary: {
                            500: '#8b5cf6',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-in',
                        'card-hover': 'cardHover 0.3s ease forwards'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: 0
                            },
                            '100%': {
                                opacity: 1
                            }
                        },
                        cardHover: {
                            '0%': {
                                transform: 'translateY(0)',
                                boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'
                            },
                            '100%': {
                                transform: 'translateY(-4px)',
                                boxShadow: '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)'
                            }
                        }
                    }
                }
            }
        }
    </script>
    
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
    <style type="text/css">
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            animation: cardHover 0.3s ease forwards;
        }

        .auction-image {
            height: 180px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .auction-item:hover .auction-image {
            transform: scale(1.05);
        }

        .status-badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.6rem;
            border-radius: 9999px;
        }

        .floating-input:focus-within label,
        .floating-input input:not(:placeholder-shown)+label,
        .floating-input select:not([value=""])+label {
            top: -0.5rem;
            left: 0.75rem;
            font-size: 0.75rem;
            background: inherit;
            padding: 0 0.25rem;
            z-index: 10;
        }

        .dark .floating-input:focus-within label,
        .dark .floating-input input:not(:placeholder-shown)+label,
        .dark .floating-input select:not([value=""])+label {
            background: #1f2937;
        }

        .pagination .page-item {
            display: inline-flex;
            margin: 0 2px;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
        }
    </style>
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
   </x-

        <!-- Main Content -->
        <main class="flex-grow py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                    <!-- Filter Section -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <form method="GET" action="{{ route('auctions.index') }}" id="auction-filter-form"
                            class="space-y-4 md:space-y-0 md:grid md:grid-cols-5 md:gap-4">
                            <!-- Search Input -->
                            <div class="relative floating-input">
                                <input type="text" name="search" placeholder=" " value="{{ request('search') }}"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <label
                                    class="absolute top-3 left-4 text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-1 transition-all duration-200 pointer-events-none">
                                    <i class="fas fa-search mr-2"></i>Cari lelang...
                                </label>
                            </div>

                            <!-- Jenis Filter -->
                            <div class="relative floating-input">
                                <select name="jenis" id="jenis-filter"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-primary-500 focus:border-transparent appearance-none">
                                    <option value="all"> </option>
                                    <option value="reguler" {{ request('jenis') == 'reguler' ? 'selected' : '' }}>
                                        Reguler</option>
                                    <option value="azukari" {{ request('jenis') == 'azukari' ? 'selected' : '' }}>
                                        Azukari</option>
                                    <option value="keeping" {{ request('jenis') == 'keeping' ? 'selected' : '' }}>
                                        Keeping Contest</option>
                                    <option value="grow_out" {{ request('jenis') == 'grow_out' ? 'selected' : '' }}>Grow
                                        Out</option>
                                </select>
                                <label
                                    class="absolute top-3 left-4 text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-1 transition-all duration-200 pointer-events-none">
                                    <i class="fas fa-tag mr-2"></i>Jenis Lelang
                                </label>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div class="relative floating-input">
                                <select name="status" id="status-filter"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-primary-500 focus:border-transparent appearance-none">
                                    <option value="all"> </option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft
                                    </option>
                                    <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready
                                    </option>
                                    <option value="on going" {{ request('status') == 'on going' ? 'selected' : '' }}>On
                                        Going</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                </select>
                                <label
                                    class="absolute top-3 left-4 text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-1 transition-all duration-200 pointer-events-none">
                                    <i class="fas fa-info-circle mr-2"></i>Status
                                </label>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>

                            <!-- Sort Filter -->
                            <div class="relative floating-input">
                                <select name="sort" id="sort-filter"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-primary-500 focus:border-transparent appearance-none">
                                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbaru
                                    </option>
                                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama
                                    </option>
                                </select>
                                <label
                                    class="absolute top-3 left-4 text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-1 transition-all duration-200 pointer-events-none">
                                    <i class="fas fa-sort mr-2"></i>Urutkan
                                </label>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>

                            <!-- Reset Button -->
                            <button type="button" id="reset-filter"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-300">
                                <i class="fas fa-sync-alt mr-2"></i>Reset Filter
                            </button>
                        </form>
                    </div>

                    <!-- Auction List -->
                    <div id="auction-list" class="p-6">
                        <div class="mb-4 flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                Daftar Lelang
                                <span
                                    class="bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 text-sm font-medium px-2.5 py-0.5 rounded-full ml-2">
                                    {{ $auctions->total() }} item
                                </span>
                            </h2>
                            <div class="flex space-x-2">
                                <button
                                    class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button
                                    class="p-2 rounded-lg bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>

                        @if ($auctions->isEmpty())
                            <div class="py-12 text-center">
                                <div class="mx-auto w-24 h-24 mb-4 text-gray-400">
                                    <i class="fas fa-box-open text-6xl"></i>
                                </div>
                                <h3 class="text-xl font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tidak ada lelang ditemukan
                                </h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-6">
                                    Coba ubah filter pencarian atau buat lelang baru
                                </p>
                                <a href="{{ route('auctions.create') }}"
                                    class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors duration-300">
                                    <i class="fas fa-plus mr-2"></i>
                                    Buat Lelang Baru
                                </a>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                <!-- Auction Item 1 -->
                                <div
                                    class="auction-item bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md card-hover border border-gray-200 dark:border-gray-700">
                                    <div class="relative overflow-hidden">
                                        <div
                                            class="auction-image bg-gray-200 border-b border-gray-200 dark:border-gray-700 w-full h-48 flex items-center justify-center">
                                            <i class="fas fa-fish text-4xl text-gray-400"></i>
                                        </div>
                                        <div class="absolute top-3 right-3">
                                            <span
                                                class="status-badge bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                Draft
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-bold text-lg text-gray-900 dark:text-white truncate">
                                                Ikan Koi Kohaku Premium
                                            </h3>
                                            <span
                                                class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 status-badge">
                                                Reguler
                                            </span>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                            Ikan koi kualitas tinggi, ukuran 45cm, umur 2 tahun, pola warna merah putih
                                            yang sempurna.
                                        </p>
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Harga Awal</p>
                                                <p class="font-bold text-gray-900 dark:text-white">Rp 5.750.000</p>
                                            </div>
                                            <div class="flex space-x-2">
                                                <button
                                                    class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button
                                                    class="p-2 rounded-lg bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Auction Item 2 -->
                                <div
                                    class="auction-item bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md card-hover border border-gray-200 dark:border-gray-700">
                                    <div class="relative overflow-hidden">
                                        <div
                                            class="auction-image bg-gray-200 border-b border-gray-200 dark:border-gray-700 w-full h-48 flex items-center justify-center">
                                            <i class="fas fa-fish text-4xl text-gray-400"></i>
                                        </div>
                                        <div class="absolute top-3 right-3">
                                            <span
                                                class="status-badge bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                On Going
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-bold text-lg text-gray-900 dark:text-white truncate">
                                                Ikan Koi Sanke Size Jumbo
                                            </h3>
                                            <span
                                                class="bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 status-badge">
                                                Azukari
                                            </span>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                            Koi sanke dengan pola merah dan hitam yang indah, ukuran 55cm, hasil
                                            breeding dari Jepang.
                                        </p>
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Harga Awal</p>
                                                <p class="font-bold text-gray-900 dark:text-white">Rp 8.250.000</p>
                                            </div>
                                            <div class="flex space-x-2">
                                                <button
                                                    class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button
                                                    class="p-2 rounded-lg bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Auction Item 3 -->
                                <div
                                    class="auction-item bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md card-hover border border-gray-200 dark:border-gray-700">
                                    <div class="relative overflow-hidden">
                                        <div
                                            class="auction-image bg-gray-200 border-b border-gray-200 dark:border-gray-700 w-full h-48 flex items-center justify-center">
                                            <i class="fas fa-fish text-4xl text-gray-400"></i>
                                        </div>
                                        <div class="absolute top-3 right-3">
                                            <span
                                                class="status-badge bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                Ready
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-bold text-lg text-gray-900 dark:text-white truncate">
                                                Ikan Koi Showa Contest Quality
                                            </h3>
                                            <span
                                                class="bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200 status-badge">
                                                Grow Out
                                            </span>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                            Showa dengan kualitas kontes, pola hitam dominan dengan merah dan putih,
                                            ukuran 60cm.
                                        </p>
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Harga Awal</p>
                                                <p class="font-bold text-gray-900 dark:text-white">Rp 12.500.000</p>
                                            </div>
                                            <div class="flex space-x-2">
                                                <button
                                                    class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button
                                                    class="p-2 rounded-lg bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Auction Item 4 -->
                                <div
                                    class="auction-item bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md card-hover border border-gray-200 dark:border-gray-700">
                                    <div class="relative overflow-hidden">
                                        <div
                                            class="auction-image bg-gray-200 border-b border-gray-200 dark:border-gray-700 w-full h-48 flex items-center justify-center">
                                            <i class="fas fa-fish text-4xl text-gray-400"></i>
                                        </div>
                                        <div class="absolute top-3 right-3">
                                            <span
                                                class="status-badge bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                Completed
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-bold text-lg text-gray-900 dark:text-white truncate">
                                                Ikan Koi Goromo Size 40cm
                                            </h3>
                                            <span
                                                class="bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 status-badge">
                                                Keeping
                                            </span>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                            Koi goromo dengan pola unik, warna biru keunguan, hasil breeding lokal
                                            kualitas premium.
                                        </p>
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Harga Awal</p>
                                                <p class="font-bold text-gray-900 dark:text-white">Rp 3.850.000</p>
                                            </div>
                                            <div class="flex space-x-2">
                                                <button
                                                    class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button
                                                    class="p-2 rounded-lg bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="pagination flex flex-wrap justify-center items-center space-x-1">
                            <a href="#" class="page-item">
                                <span
                                    class="page-link bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 hover:bg-gray-200 dark:hover:bg-gray-600">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            </a>
                            <a href="#" class="page-item">
                                <span
                                    class="page-link bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-600">1</span>
                            </a>
                            <a href="#" class="page-item">
                                <span class="page-link bg-primary-500 text-white rounded-lg px-4 py-2">2</span>
                            </a>
                            <a href="#" class="page-item">
                                <span
                                    class="page-link bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-600">3</span>
                            </a>
                            <span class="page-item">
                                <span class="page-link bg-transparent text-gray-500 px-2">...</span>
                            </span>
                            <a href="#" class="page-item">
                                <span
                                    class="page-link bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-600">8</span>
                            </a>
                            <a href="#" class="page-item">
                                <span
                                    class="page-link bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 hover:bg-gray-200 dark:hover:bg-gray-600">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-8 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center text-gray-600 dark:text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Sistem Lelang Ikan Koi. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    <script>
        $(document).ready(function() {
            // Dark mode toggle persistence
            if (localStorage.getItem('darkMode') === 'true') {
                document.documentElement.classList.add('dark');
            }

            // Filter functionality
            $('#jenis-filter, #status-filter, #sort-filter').on('change', applyFilter);
            $('input[name="search"]').on('keyup', applyFilter);

            // Reset filter
            $('#reset-filter').on('click', function() {
                $('input[name="search"]').val('');
                $('#jenis-filter, #status-filter').val('all');
                $('#sort-filter').val('desc');
                applyFilter();
            });

            function applyFilter() {
                let formData = $('#auction-filter-form').serialize();

                // Show loading state
                $('#auction-list').html(`
                    <div class="py-12 flex flex-col items-center justify-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary-500 mb-4"></div>
                        <p class="text-gray-600 dark:text-gray-400">Memuat data lelang...</p>
                    </div>
                `);

                // Simulate AJAX request
                setTimeout(function() {
                    $('#auction-list').html(`
                        <div class="mb-4 flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                Daftar Lelang
                                <span class="bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 text-sm font-medium px-2.5 py-0.5 rounded-full ml-2">
                                    4 item
                                </span>
                            </h2>
                            <div class="flex space-x-2">
                                <button class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button class="p-2 rounded-lg bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            <!-- Auction items would be loaded here -->
                            ${$('#auction-list .grid').html()}
                        </div>
                    `);
                }, 800);
            }

            // Delete auction function
            window.deleteAuction = function(auctionId) {
                Swal.fire({
                    title: 'Hapus Lelang?',
                    html: `<p class="text-gray-700 dark:text-gray-300 mb-4">Apakah Anda yakin ingin menghapus lelang ini? Tindakan ini tidak dapat dibatalkan.</p>
                           <p class="text-gray-500 dark:text-gray-400 text-sm">Ketik <span class="font-mono bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 px-2 py-1 rounded">Hapus</span> untuk konfirmasi</p>`,
                    icon: 'warning',
                    input: 'text',
                    inputPlaceholder: 'Ketik "Hapus" di sini...',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#4a5568',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    inputValidator: (value) => {
                        if (value !== 'Hapus') {
                            return 'Anda harus mengetik "Hapus" untuk melanjutkan!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Dihapus!',
                            'Lelang telah berhasil dihapus.',
                            'success'
                        );
                        // Here you would normally do an AJAX request to delete the auction
                    }
                });
            };
        });
    </script>
</body>

</html>
