<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="relative flex-1 max-w-lg">
                <input type="text" id="search" placeholder="Cari di Lelang Koi..."
                    class="w-full py-2 px-4 rounded-lg border border-zinc-300 dark:bg-zinc-800 dark:text-zinc-200 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="ml-4 text-sm text-zinc-600 dark:text-zinc-400">
                Waktu Server: {{ \Carbon\Carbon::now()->toDateTimeString() }}
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">
        <!-- Carousel Banner -->
        <section class="container mx-auto px-4 mb-6 bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-lg">
            <div x-data="{ activeSlide: 0, slides: {{ $carouselAds->toJson() }} }" class="relative w-full overflow-hidden rounded-lg shadow-lg">
                <!-- Carousel wrapper -->
                <div class="relative h-64">
                    <template x-for="(slide, index) in {{ $carouselAds->toJson() }}" :key="index">
                        <div x-show="activeSlide === index" class="absolute inset-0">
                            <a :href="slide.link" target="_blank">
                                <img :src="`/storage/${slide.image}`" alt="Banner" class="w-full h-full object-cover">
                                <div class="absolute bottom-0 left-0 bg-black bg-opacity-50 w-full p-4 text-white">
                                    <h5 x-text="slide.title"></h5>
                                    <p x-text="slide.description"></p>
                                </div>
                            </a>
                        </div>
                    </template>
                </div>

                <!-- Slider controls -->
                <div class="absolute inset-0 flex items-center justify-between px-4">
                    <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1"
                        class="bg-black bg-opacity-50 text-white p-2 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>
                    <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1"
                        class="bg-black bg-opacity-50 text-white p-2 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </section>


        <div class="flex">
            <!-- Sidebar untuk Filter -->
            <aside class="w-1/4 p-4 bg-white dark:bg-zinc-800 shadow sm:rounded-lg space-y-4">
                <h3 class="text-lg font-semibold">Filter Kategori</h3>
                <form id="filterForm" class="space-y-4">
                    <!-- Filter Jenis Lelang -->
                    <div>
                        <label for="jenis_lelang"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Lelang</label>
                        <select id="jenis_lelang"
                            class="w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg">
                            <option value="">Semua Jenis</option>
                            <option value="reguler">Reguler</option>
                            <option value="azukari">Azukari</option>
                            <option value="keeping_contest">Keeping Contest</option>
                            <option value="grow_out">Grow Out</option>
                        </select>
                    </div>
                    <!-- Filter Ukuran -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ukuran (cm)</label>
                        <input type="number" id="ukuran_min" placeholder="Min"
                            class="w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg">
                        <input type="number" id="ukuran_max" placeholder="Max"
                            class="w-full mt-2 py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg">
                    </div>
                    <!-- Filter Harga -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga (Rp)</label>
                        <input type="number" id="harga_min" placeholder="Min"
                            class="w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg">
                        <input type="number" id="harga_max" placeholder="Max"
                            class="w-full mt-2 py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg">
                    </div>
                    <button type="button" id="applyFilter"
                        class="w-full py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600">Terapkan
                        Filter</button>
                </form>
            </aside>

            <!-- Main Content -->
            <main class="w-3/4 p-4 bg-white dark:bg-zinc-800 shadow sm:rounded-lg space-y-4">
                <!-- Sort Dropdown -->
                <div class="flex justify-end">
                    <select id="sort" class="py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg">
                        <option value="latest">Terbaru</option>
                        <option value="price_low">Harga Terendah</option>
                        <option value="price_high">Harga Tertinggi</option>
                    </select>
                </div>

                <!-- Kontainer Lelang -->
                <div id="auctionContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Konten lelang akan ditambahkan di sini oleh JavaScript -->
                </div>
            </main>
        </div>
    </div>

    <!-- Menyimpan data lelang sebagai JSON -->
    <script>
        const auctions = @json($auctions);
        console.log("Auctions data:", auctions);

        function renderAuctions(data) {
            const container = document.getElementById('auctionContainer');
            container.innerHTML = '';
            data.forEach(auction => {
                const lastBid = auction.last_bid !== undefined ? auction.last_bid.toLocaleString() : 'N/A';
                const endTime = auction.end_time ? new Date(auction.end_time).toLocaleString() : 'N/A';
                const farmName = auction.user && auction.user.farm_name ? auction.user.farm_name : 'Unknown';

                const statusText = auction.status === 'ready' ?
                    `Dimulai pada: ${new Date(auction.start_time).toLocaleTimeString()}` :
                    `Berakhir pada: ${new Date(auction.end_time).toLocaleTimeString()}`;

                const auctionCard = `
            <a href="/auctions/${auction.auction_code}" class="block border rounded-lg p-4 dark:bg-zinc-700 hover:shadow-lg transition">
                <img src="${auction.banner ? '/storage/' + auction.banner : ''}" alt="${auction.title}" class="w-full h-32 object-cover mb-4">
                <h3 class="text-sm font-bold">${auction.auction_code} - ${auction.title}</h3>
                <p class="text-xs text-gray-500">Farm: ${farmName}</p>
                <p class="mt-2 text-xs text-gray-500">${statusText}</p>
                <p class="mt-4 text-sm font-semibold text-gray-700">Last Bid: Rp${lastBid}</p>
            </a>`;
                container.insertAdjacentHTML('beforeend', auctionCard);
            });
        }

        function applyFilters() {
            let filteredData = auctions;
            const jenisLelang = document.getElementById('jenis_lelang').value;
            const ukuranMin = document.getElementById('ukuran_min').value;
            const ukuranMax = document.getElementById('ukuran_max').value;
            const hargaMin = document.getElementById('harga_min').value;
            const hargaMax = document.getElementById('harga_max').value;
            const sortOption = document.getElementById('sort').value;

            if (jenisLelang) {
                filteredData = filteredData.filter(auction => auction.jenis === jenisLelang);
            }
            if (ukuranMin) {
                filteredData = filteredData.filter(auction => auction.koi.some(koi => koi.ukuran >= ukuranMin));
            }
            if (ukuranMax) {
                filteredData = filteredData.filter(auction => auction.koi.some(koi => koi.ukuran <= ukuranMax));
            }
            if (hargaMin) {
                filteredData = filteredData.filter(auction => auction.last_bid >= hargaMin);
            }
            if (hargaMax) {
                filteredData = filteredData.filter(auction => auction.last_bid <= hargaMax);
            }

            if (sortOption === 'price_low') {
                filteredData.sort((a, b) => a.last_bid - b.last_bid);
            } else if (sortOption === 'price_high') {
                filteredData.sort((a, b) => b.last_bid - a.last_bid);
            } else {
                filteredData.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            }

            renderAuctions(filteredData);
        }

        document.getElementById('applyFilter').addEventListener('click', applyFilters);
        document.getElementById('sort').addEventListener('change', applyFilters);

        renderAuctions(auctions);
    </script>
</x-app-layout>
