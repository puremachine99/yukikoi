<x-app-layout>

    <div class="py-8">
        <!-- Banner Utama dengan Carousel -->
        <div class="container mx-auto px-4">
            <div id="bannerCarousel" class="carousel slide relative rounded-lg overflow-hidden shadow-lg" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('storage/banner1.jpg') }}" class="d-block w-full h-64 object-cover" alt="Banner 1">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Promo Lelang Spesial 1</h5>
                            <p>Dapatkan koi terbaik dengan harga terjangkau!</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('storage/banner2.jpg') }}" class="d-block w-full h-64 object-cover" alt="Banner 2">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Promo Lelang Spesial 2</h5>
                            <p>Koi berkualitas hanya di Lelang Koi!</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('storage/banner3.jpg') }}" class="d-block w-full h-64 object-cover" alt="Banner 3">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Promo Lelang Spesial 3</h5>
                            <p>Bergabunglah sekarang dan dapatkan koi impianmu!</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <p class="text-center mt-2 text-gray-500">Dimensi banner yang direkomendasikan: 1280px x 320px</p>
        </div>

        <!-- Kategori Pilihan -->
        <div class="container mx-auto px-4 mt-8">
            <h3 class="text-xl font-semibold mb-4">Kategori Pilihan</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Dummy Categories -->
                <a href="#" class="bg-zinc-200 dark:bg-zinc-700 p-4 rounded-lg flex flex-col items-center hover:bg-zinc-300 dark:hover:bg-zinc-600">
                    <span class="text-lg font-semibold">Reguler (64)</span>
                </a>
                <a href="#" class="bg-zinc-200 dark:bg-zinc-700 p-4 rounded-lg flex flex-col items-center hover:bg-zinc-300 dark:hover:bg-zinc-600">
                    <span class="text-lg font-semibold">Azukari (3)</span>
                </a>
                <a href="#" class="bg-zinc-200 dark:bg-zinc-700 p-4 rounded-lg flex flex-col items-center hover:bg-zinc-300 dark:hover:bg-zinc-600">
                    <span class="text-lg font-semibold">Keeping Contest (1)</span>
                </a>
                <a href="#" class="bg-zinc-200 dark:bg-zinc-700 p-4 rounded-lg flex flex-col items-center hover:bg-zinc-300 dark:hover:bg-zinc-600">
                    <span class="text-lg font-semibold">Grow Out (0)</span>
                </a>
            </div>
        </div>

        <!-- Lelang yang Sedang Berlangsung -->
        <div class="container mx-auto px-4 mt-8">
            <h3 class="text-xl font-semibold mb-4">Lelang yang Sedang Berlangsung</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @if ($auctions->isEmpty())
                    <p class="text-zinc-600 dark:text-zinc-400">{{ __('Tidak ada lelang yang sedang berlangsung.') }}</p>
                @else
                    @foreach ($auctions as $auction)
                        <div class="border rounded-lg p-4 dark:bg-zinc-700 flex flex-col justify-between">
                            <!-- Gambar Banner atau Placeholder -->
                            @if ($auction->banner)
                                <div class="bg-gray-300 w-full relative overflow-hidden" style="padding-top: 100%;">
                                    <img src="{{ asset('storage/' . $auction->banner) }}" alt="{{ $auction->title }}" class="absolute top-0 left-0 w-full h-full object-cover">
                                </div>
                            @else
                                <div class="bg-gray-300 w-full relative overflow-hidden" style="padding-top: 100%;">
                                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center">
                                        {{ __('No Image') }}
                                    </div>
                                </div>
                            @endif

                            <!-- Kode Lelang, Judul, dan Waktu -->
                            <h3 class="text-lg font-semibold mt-4">{{ $auction->auction_code }} - {{ $auction->title }}</h3>
                            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                                Waktu: {{ \Carbon\Carbon::parse($auction->start_time)->format('d M Y H:i') }} - {{ \Carbon\Carbon::parse($auction->end_time)->format('d M Y H:i') }}
                            </p>
                            <p class="mt-4 text-sm text-zinc-600 dark:text-zinc-400">{{ Str::limit($auction->description, 100) }}</p>

                            <!-- Tombol Aksi -->
                            <div class="flex justify-between mt-6">
                                <a href="{{ route('auctions.show', ['auction' => $auction->id]) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md">
                                    {{ __('Lihat Lelang') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Tambahkan SweetAlert dan Carousel JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
