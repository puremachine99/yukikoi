<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                </svg>
                Lelang Koi Premium
            </h1>
            <div class="w-full md:w-auto flex flex-col-reverse md:flex-row items-end md:items-center gap-4">
                <div class="relative w-full md:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="search" placeholder="Cari koi, farm, lelang..."
                        class="block w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-lg">
                    <span class="font-medium">Server:</span> {{ \Carbon\Carbon::now()->toDateTimeString() }}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-8 px-4 sm:px-6 lg:px-8">
        <!-- Promo Carousel -->
        <section class="relative rounded-2xl overflow-hidden shadow-xl">
            <div x-data="{ activeSlide: 0, slides: {{ $carouselAds->toJson() }}, interval: null }" 
                 x-init="interval = setInterval(() => { activeSlide = (activeSlide + 1) % slides.length }, 5000)"
                 @mouseover="clearInterval(interval)" 
                 @mouseleave="interval = setInterval(() => { activeSlide = (activeSlide + 1) % slides.length }, 5000)"
                 class="relative w-full h-64 md:h-80 lg:h-96">
                <!-- Slides -->
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="activeSlide === index" x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0" class="absolute inset-0">
                        <a :href="slide.link" target="_blank" class="block h-full w-full group">
                            <img :src="`/storage/${slide.image}`" :alt="slide.title" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
                                <h3 x-text="slide.title" class="text-xl font-bold text-white"></h3>
                                <p x-text="slide.description" class="text-gray-200 mt-1"></p>
                            </div>
                        </a>
                    </div>
                </template>

                <!-- Indicators -->
                <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index" 
                                class="w-3 h-3 rounded-full transition-all duration-300"
                                :class="activeSlide === index ? 'bg-white w-6' : 'bg-white/50'"></button>
                    </template>
                </div>

                <!-- Navigation -->
                <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1"
                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-2 rounded-full backdrop-blur transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1"
                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-2 rounded-full backdrop-blur transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </section>

        <!-- Main Content Area -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Filters Sidebar -->
            <aside class="lg:w-72 xl:w-80 flex-shrink-0">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-5 sticky top-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Filter Lelang</h2>
                        <button id="resetFilters" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Reset</button>
                    </div>

                    <div class="space-y-6">
                        <!-- Auction Type -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Jenis Lelang
                            </h3>
                            <div class="space-y-2">
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="auction_type" value="reguler" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Reguler</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="auction_type" value="azukari" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Azukari</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="auction_type" value="keeping_contest" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Keeping Contest</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="auction_type" value="grow_out" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Grow Out</span>
                                </label>
                            </div>
                        </div>

                        <!-- Size Range -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                </svg>
                                Ukuran Koi (cm)
                            </h3>
                            <div class="px-1">
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                    <span>10cm</span>
                                    <span>80cm+</span>
                                </div>
                                <div class="flex space-x-4">
                                    <input type="number" id="size_min" placeholder="Min" class="w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <input type="number" id="size_max" placeholder="Max" class="w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Range Harga
                            </h3>
                            <div class="px-1">
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                    <span>Rp100k</span>
                                    <span>Rp100jt+</span>
                                </div>
                                <div class="flex space-x-4">
                                    <input type="number" id="price_min" placeholder="Min" class="w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <input type="number" id="price_max" placeholder="Max" class="w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Breed/Variety -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                Varietas Koi
                            </h3>
                            <select class="w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="">Semua Varietas</option>
                                <option value="kohaku">Kohaku</option>
                                <option value="sanke">Sanke</option>
                                <option value="showa">Showa</option>
                                <option value="utsuri">Utsuri</option>
                                <option value="bekko">Bekko</option>
                                <option value="asagi">Asagi</option>
                                <option value="shusui">Shusui</option>
                                <option value="koromo">Koromo</option>
                                <option value="goromo">Goromo</option>
                                <option value="ginrin">Ginrin</option>
                                <option value="tancho">Tancho</option>
                                <option value="chagoi">Chagoi</option>
                            </select>
                        </div>

                        <button id="applyFilters" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </aside>

            <!-- Auction Listings -->
            <main class="flex-1">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-5">
                    <!-- Sorting and View Options -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Menampilkan <span class="font-medium text-gray-700 dark:text-gray-300" id="resultCount">0</span> hasil
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Urutkan:</span>
                                <select id="sortBy" class="py-2 pl-3 pr-8 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm appearance-none">
                                    <option value="newest">Terbaru</option>
                                    <option value="ending_soon">Berakhir Segera</option>
                                    <option value="price_low">Harga Terendah</option>
                                    <option value="price_high">Harga Tertinggi</option>
                                    <option value="popular">Paling Populer</option>
                                </select>
                            </div>
                            <div class="hidden sm:flex items-center space-x-1">
                                <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>
                                <button class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Auction Grid -->
                    <div id="auctionContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        <!-- Auction cards will be inserted here by JavaScript -->
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 flex justify-center">
                        <nav class="inline-flex rounded-md shadow-sm">
                            <a href="#" class="px-3 py-2 rounded-l-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="px-4 py-2 border-t border-b border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-gray-600">1</a>
                            <a href="#" class="px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">2</a>
                            <a href="#" class="px-4 py-2 border-t border-b border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">3</a>
                            <a href="#" class="px-3 py-2 rounded-r-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <span class="sr-only">Next</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </nav>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Auction Data and Script -->
    <script>
        const auctions = @json($auctions);
        console.log("Auctions data:", auctions);

        function renderAuctions(data) {
            const container = document.getElementById('auctionContainer');
            const resultCount = document.getElementById('resultCount');
            container.innerHTML = '';
            
            if (data.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full text-center py-16">
                        <div class="mx-auto w-20 h-20 mb-4 text-gray-400 dark:text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak ada lelang yang ditemukan</h3>
                        <p class="text-gray-500 dark:text-gray-400">Coba sesuaikan filter pencarian Anda atau coba kata kunci lain</p>
                        <button class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                            Reset Filter
                        </button>
                    </div>
                `;
                resultCount.textContent = '0';
                return;
            }

            resultCount.textContent = data.length;

            data.forEach(auction => {
                const lastBid = auction.last_bid !== undefined ? 
                    new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(auction.last_bid) : 
                    'Belum ada bid';
                
                const endTime = auction.end_time ? new Date(auction.end_time) : null;
                const timeRemaining = endTime ? getTimeRemaining(endTime) : 'Waktu tidak ditentukan';
                
                const farmName = auction.user?.farm_name || 'Unknown Farm';
                const koiCount = auction.koi?.length || 0;
                const bidCount = auction.bids?.length || 0;

                const auctionCard = `
                <div class="group relative bg-white dark:bg-gray-700 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition border border-gray-200 dark:border-gray-600">
                    <!-- Status Badge -->
                    <div class="absolute top-3 left-3 z-10">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${auction.status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'}">
                            ${auction.status === 'active' ? 'Aktif' : 'Segera'}
                        </span>
                    </div>
                    
                    <!-- Auction Image -->
                    <a href="/auctions/${auction.auction_code}" class="block relative h-48 overflow-hidden">
                        <img src="${auction.banner ? '/storage/' + auction.banner : '/images/default-koi-banner.jpg'}" 
                             alt="${auction.title}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                        
                        <!-- Time Remaining -->
                        <div class="absolute bottom-3 left-3 right-3">
                            <div class="text-xs text-white font-medium mb-1">${timeRemaining}</div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-1.5">
                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: ${getProgressPercentage(endTime)}%"></div>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Auction Details -->
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-1">
                            <a href="/auctions/${auction.auction_code}" class="font-bold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition line-clamp-2">
                                ${auction.title}
                            </a>
                            <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            ${farmName}
                        </div>
                        
                        <div class="flex justify-between text-sm mb-4">
                            <div class="flex items-center text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                ${koiCount} Koi
                            </div>
                            <div class="flex items-center text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                ${bidCount} Bid
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center pt-3 border-t border-gray-200 dark:border-gray-600">
                            <div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Harga Tertinggi</div>
                                <div class="font-bold text-blue-600 dark:text-blue-400">${lastBid}</div>
                            </div>
                            <a href="/auctions/${auction.auction_code}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition flex items-center">
                                Lihat Detail
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>`;
                container.insertAdjacentHTML('beforeend', auctionCard);
            });
        }

        function getTimeRemaining(endTime) {
            if (!endTime) return 'Waktu tidak ditentukan';
            
            const now = new Date();
            const diff = endTime - now;
            
            if (diff <= 0) return 'Lelang berakhir';
            
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            
            if (days > 0) {
                return `${days} hari ${hours} jam lagi`;
            } else if (hours > 0) {
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                return `${hours} jam ${minutes} menit lagi`;
            } else {
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                return `${minutes} menit lagi`;
            }
        }

        function getProgressPercentage(endTime) {
            if (!endTime) return 0;
            
            const now = new Date();
            const startTime = new Date(endTime);
            startTime.setDate(startTime.getDate() - 7); // Assuming 7-day auctions
            
            if (now >= endTime) return 100;
            if (now <= startTime) return 0;
            
            const totalDuration = endTime - startTime;
            const elapsed = now - startTime;
            
            return Math.round((elapsed / totalDuration) * 100);
        }

        function applyFilters() {
            let filteredData = auctions;
            const selectedTypes = Array.from(document.querySelectorAll('input[name="auction_type"]:checked')).map(el => el.value);
            const sizeMin = document.getElementById('size_min').value;
            const sizeMax = document.getElementById('size_max').value;
            const priceMin = document.getElementById('price_min').value;
            const priceMax = document.getElementById('price_max').value;
            const sortOption = document.getElementById('sortBy').value;

            // Filter by type
            if (selectedTypes.length > 0) {
                filteredData = filteredData.filter(auction => selectedTypes.includes(auction.jenis));
            }

            // Filter by size
            if (sizeMin) {
                filteredData = filteredData.filter(auction => auction.koi.some(koi => koi.ukuran >= sizeMin));
            }
            if (sizeMax) {
                filteredData = filteredData.filter(auction => auction.koi.some(koi => koi.ukuran <= sizeMax));
            }

            // Filter by price
            if (priceMin) {
                filteredData = filteredData.filter(auction => auction.last_bid >= priceMin);
            }
            if (priceMax) {
                filteredData = filteredData.filter(auction => auction.last_bid <= priceMax);
            }

            // Sort data
            switch (sortOption) {
                case 'ending_soon':
                    filteredData.sort((a, b) => new Date(a.end_time) - new Date(b.end_time));
                    break;
                case 'price_low':
                    filteredData.sort((a, b) => a.last_bid - b.last_bid);
                    break;
                case 'price_high':
                    filteredData.sort((a, b) => b.last_bid - a.last_bid);
                    break;
                case 'popular':
                    filteredData.sort((a, b) => (b.bids?.length || 0) - (a.bids?.length || 0));
                    break;
                default: // 'newest'
                    filteredData.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            }

            renderAuctions(filteredData);
        }

        function resetFilters() {
            document.querySelectorAll('input[name="auction_type"]').forEach(el => el.checked = false);
            document.getElementById('size_min').value = '';
            document.getElementById('size_max').value = '';
            document.getElementById('price_min').value = '';
            document.getElementById('price_max').value = '';
            document.getElementById('sortBy').value = 'newest';
            renderAuctions(auctions);
        }

        // Event listeners
        document.getElementById('applyFilters').addEventListener('click', applyFilters);
        document.getElementById('resetFilters').addEventListener('click', resetFilters);
        document.getElementById('sortBy').addEventListener('change', applyFilters);

        // Initial render
        renderAuctions(auctions);
    </script>
</x-app-layout>