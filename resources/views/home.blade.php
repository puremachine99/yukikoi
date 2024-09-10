<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">

            <div class="relative flex-1 max-w-lg">
                <form method="GET" action="{{ route('home') }}">
                    <input type="text" name="search" placeholder="Cari di Lelang Koi..."
                        class="w-full py-2 px-4 rounded-lg border border-zinc-300 dark:bg-zinc-800 dark:text-zinc-200 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                        value="{{ request('search') }}">
                    <button type="submit"
                        class="absolute top-0 right-0 h-full px-4 bg-zinc-500 text-white rounded-r-lg hover:bg-zinc-600">
                        Cari
                    </button>
                </form>
            </div>


            <a href="{{ route('auctions.create') }}"
                class="ml-4 inline-flex items-center px-4 py-2 bg-zinc-500 dark:bg-zinc-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-zinc-800 uppercase tracking-widest hover:bg-zinc-600 dark:hover:bg-zinc-300 focus:bg-zinc-600 dark:focus:bg-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fa-solid fa-flag-checkered"></i> Mulai Lelang
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-zinc-800 shadow sm:rounded-lg">
                <!-- Banner Utama dengan Carousel -->
                <div class="container mx-auto px-4">
                    <p class="text-center font-extralight mb-2 text-gray-400">Dimensi banner yang direkomendasikan: 1280px x 320px</p>
                    <div x-data="{ activeSlide: 0, slides: ['{{ asset('storage/banner1.jpg') }}', '{{ asset('storage/banner2.jpg') }}', '{{ asset('storage/banner3.jpg') }}'] }" class="relative w-full overflow-hidden rounded-lg shadow-lg">
                        <!-- Carousel wrapper -->
                        <div class="relative h-64">
                            <template x-for="(slide, index) in slides" :key="index">
                                <div x-show="activeSlide === index" class="absolute inset-0">
                                    <a :href="slide === '{{ asset('storage/banner1.jpg') }}' ? 'https://www.tokopedia.com' : (
                                        slide === '{{ asset('storage/banner2.jpg') }}' ?
                                        'https://www.shopee.co.id' : 'https://www.lazada.co.id')"
                                        target="_blank">
                                        <img :src="slide" alt="Banner" class="w-full h-full object-cover">
                                        <div
                                            class="absolute bottom-0 left-0 bg-black bg-opacity-50 w-full p-4 text-white">
                                            <h5
                                                x-text="slide === '{{ asset('storage/banner1.jpg') }}' ? 'Promo Lelang Spesial 1' : (slide === '{{ asset('storage/banner2.jpg') }}' ? 'Promo Lelang Spesial 2' : 'Promo Lelang Spesial 3')">
                                            </h5>
                                            <p
                                                x-text="slide === '{{ asset('storage/banner1.jpg') }}' ? 'Dapatkan koi terbaik dengan harga terjangkau!' : (slide === '{{ asset('storage/banner2.jpg') }}' ? 'Koi berkualitas hanya di Lelang Koi!' : 'Bergabunglah sekarang dan dapatkan koi impianmu!')">
                                            </p>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
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
                    </div>
                    
                </div>

                <!-- Kategori Pilihan -->
                <div class="container mx-auto px-4 mt-8">
                    <h3 class="text-xl font-semibold mb-4">Kategori Pilihan</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="#"
                            class="bg-zinc-200 dark:bg-zinc-700 p-4 rounded-lg flex flex-col items-center hover:bg-zinc-300 dark:hover:bg-zinc-600">
                            <span class="text-lg font-semibold">Reguler (64)</span>
                        </a>
                        <a href="#"
                            class="bg-zinc-200 dark:bg-zinc-700 p-4 rounded-lg flex flex-col items-center hover:bg-zinc-300 dark:hover:bg-zinc-600">
                            <span class="text-lg font-semibold">Azukari (3)</span>
                        </a>
                        <a href="#"
                            class="bg-zinc-200 dark:bg-zinc-700 p-4 rounded-lg flex flex-col items-center hover:bg-zinc-300 dark:hover:bg-zinc-600">
                            <span class="text-lg font-semibold">Keeping Contest (1)</span>
                        </a>
                        <a href="#"
                            class="bg-zinc-200 dark:bg-zinc-700 p-4 rounded-lg flex flex-col items-center hover:bg-zinc-300 dark:hover:bg-zinc-600">
                            <span class="text-lg font-semibold">Grow Out (0)</span>
                        </a>
                    </div>
                </div>

                <!-- Lelang yang Sedang Berlangsung -->
                <div class="container mx-auto px-4 mt-8">
                    <h3 class="text-xl font-semibold mb-4">Lelang yang Sedang Berlangsung</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @if ($auctions->isEmpty())
                            <p class="text-zinc-600 dark:text-zinc-400">
                                {{ __('Tidak ada lelang yang sedang berlangsung.') }}</p>
                        @else
                            @foreach ($auctions as $auction)
                                <a href="{{ route('auctions.show', ['auction' => $auction->id]) }}"
                                    class="block border rounded-lg p-4 dark:bg-zinc-700 hover:shadow-lg transition">
                                    <!-- Gambar Banner atau Placeholder -->
                                    @if ($auction->banner)
                                        <img src="{{ asset('storage/' . $auction->banner) }}"
                                            alt="{{ $auction->title }}" class="w-full h-32 object-cover mb-4">
                                    @else
                                        <div class="bg-gray-300 h-32 flex items-center justify-center mb-4">
                                            {{ __('No Image') }}
                                        </div>
                                    @endif
                                    <!-- Informasi Lelang -->
                                    <h3 class="text-sm font-bold">{{ $auction->auction_code }} - {{ $auction->title }}
                                    </h3>
                                    <p class="text-xs text-gray-500">Farm: {{ $auction->user->farm_name }}</p>
                                    <p class="mt-2 text-xs text-gray-500">Berakhir:
                                        {{ \Carbon\Carbon::parse($auction->end_time)->format('d M Y H:i') }}</p>
                                    <p class="mt-4 text-sm font-semibold text-gray-700">Last Bid:
                                        Rp{{ number_format($auction->last_bid, 0, ',', '.') }}</p>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
