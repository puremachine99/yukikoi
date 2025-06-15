<div class="block bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-visible relative card-clickable"
    onclick="redirectToKoiPage(event, '{{ route('koi.show', ['id' => $koi->id]) }}')">
    <!-- Bagian Carousel atau Gambar Utama Koi -->
    <div class="relative">
        <div x-data="{ activeSlide: 0, slides: [@foreach ($koi->media->where('media_type', 'photo') as $media) '{{ asset('storage/' . $media->url_media) }}', @endforeach] }" class="relative w-full overflow-visible rounded-lg shadow-lg h-96">

            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="activeSlide === index" class="absolute inset-0">
                    <img :src="slide" alt="Koi Media" class="object-cover w-full h-full rounded-lg">
                </div>
            </template>

            <!-- Tombol Play untuk Video -->
            @if ($koi->media->where('media_type', 'video')->isNotEmpty())
                <button
                    class="absolute group bottom-2 right-4 w-12 h-12 z-20 bg-white dark:bg-gray-700 text-sky-500 border-2 border-sky-500 rounded-full flex items-center justify-center transition-transform hover:scale-105 hover:bg-sky-500 hover:text-white no-route"
                    onclick="event.stopPropagation(); openVideoModal('{{ asset('storage/' . $koi->media->where('media_type', 'video')->first()->url_media) }}')">
                    <i class="fa-solid fa-play text-xl"></i>
                    <span
                        class="absolute bottom-full mb-1 w-max px-1 py-0.5 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                        Video Ikan 🐟
                    </span>
                </button>
            @endif

            <div class="absolute group top-60 right-0 bg-white dark:bg-gray-700 p-1 px-2 rounded-l-lg shadow-md w-20">
                <!-- Status Lelang dan Jumlah Bids -->
                <div class="text-sm text-gray-700 dark:text-gray-200 mb-1">
                    <!-- Status Lelang dengan Warna dan Tooltip -->
                    <span class="font-semibold 
                        {{ $koi->auction->status == 'ready' ? 'text-blue-600' : ($koi->auction->status == 'on going' ? ($totalBids[(string) $koi->id]['has_winner'] ? 'text-yellow-600' : 'text-red-600') : 'text-green-500') }}">
                        {{ $koi->auction->status == 'ready' ? 'Belum dimulai' : ($koi->auction->status == 'on going' ? ($totalBids[(string) $koi->id]['has_winner'] ? 'Done' : 'On Going') : 'Complete') }}
                    </span>
                    
                    <div class="text-sm text-gray-700 dark:text-gray-200">
                        <span>{{ $totalBids[(string) $koi->id]['total_bids'] ?? 0 }}x Bids</span>
                    </div>
                </div>
            
                <!-- Tooltip Berdasarkan Status Lelang -->
                <span class="absolute bottom-full mb-1 w-max px-1 py-0.5 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                    {{ $koi->auction->status == 'ready' ? 'Belum Mulai' : ($koi->auction->status == 'on going' ? ($totalBids[(string) $koi->id]['has_winner'] ? 'Pemenang BIN' : 'Sedang Berlangsung') : 'Lelang Selesai') }}
                </span>
            </div>
            

            <!-- Timer di Kiri Bawah -->
            <div
                class="absolute bottom-2 left-2 bg-red-500 text-white p-1 rounded-full shadow-md text-center text-xs w-36">
                <span id="countdown-{{ $koi->id }}" class="font-semibold">00:00</span>
            </div>

            <!-- Kapsul Jenis Lelang dengan Tooltip -->
            <div x-data="{ showTooltip: false }" @mouseover="showTooltip = true" @mouseleave="showTooltip = false"
                class="absolute top-2 right-2 p-2 rounded-full shadow-md text-center text-sm w-12 cursor-pointer {{ $koi->auction->jenis == 'reguler' ? 'bg-gray-500' : ($koi->auction->jenis == 'azukari' ? 'bg-red-500' : ($koi->auction->jenis == 'keeping_contest' ? 'bg-orange-500' : 'bg-blue-500')) }}">
                <span class="font-semibold text-white">
                    {{ $koi->auction->jenis == 'reguler' ? 'RG' : ($koi->auction->jenis == 'azukari' ? 'AZ' : ($koi->auction->jenis == 'keeping_contest' ? 'KC' : 'GO')) }}
                </span>
                <div x-show="showTooltip" x-transition
                    class="absolute top-full mt-1 w-max px-2 py-1 text-xs text-white bg-black rounded transform -translate-x-1/2 left-1/2">
                    {{ $koi->auction->jenis == 'reguler' ? 'Reguler' : ($koi->auction->jenis == 'azukari' ? 'Azukari' : ($koi->auction->jenis == 'keeping_contest' ? 'Keeping Contest' : 'Grow Out')) }}
                </div>
            </div>
        </div>

        <!-- Informasi Koi -->
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 truncate">{{ $koi->kode_ikan }}.
                {{ $koi->judul }}</h3>
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-200 truncate">
                {{ Str::ucfirst($koi->gender) }}, {{ $koi->ukuran }} cm</h3>

            <!-- Likes dan Views -->
            <div class="flex justify-between items-center mt-2">
                <!-- Views -->
                <button
                    class="relative group flex items-center text-gray-500 dark:text-gray-400 transition-transform hover:text-blue-600 no-route">
                    <i class="fa-solid fa-eye mr-1"></i>
                    <span>12</span>
                    <span
                        class="absolute bottom-full mb-2 w-max px-2 py-1 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">Dilihat
                        12 kali</span>
                </button>
                <!-- Likes -->
                <button
                    class="relative group flex items-center text-gray-500 dark:text-gray-400 transition-transform hover:text-red-600 no-route">
                    <i class="fa-solid fa-heart mr-1"></i>
                    <span>5</span>
                    <span
                        class="absolute bottom-full mb-2 w-max px-2 py-1 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">Disukai
                        5 kali</span>
                </button>
            </div>

            <hr class="mt-3 mb-3">

            <!-- Koi type and bids -->
            <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400 mt-2">
                <span class="uppercase">{{ $koi->jenis_koi ?? '-' }}</span>
            </div>

            <!-- Sertifikat -->
            <div class="mt-2">
                <p class="text-sm flex space-x-2">Sertifikat:
                    @if ($koi->certificates->isNotEmpty())
                        @foreach ($koi->certificates as $index => $certificate)
                            <a href="#" onclick="openModal('{{ asset('storage/' . $certificate->url_gambar) }}')"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white text-center w-5 h-5 rounded-full flex items-center justify-center focus:ring-2 focus:ring-yellow-500 no-route">
                                {{ $index + 1 }}
                            </a>
                        @endforeach
                    @else
                        Tidak tersedia
                    @endif
                </p>
            </div>

            <!-- OB, KB, Last Bid, dan Pemenang -->
            <div class="grid grid-cols-2 gap-2 mt-3 text-sm">
                <div class="text-gray-600 dark:text-gray-300"><span>OB:</span><span
                        class="font-semibold">{{ number_format($koi->open_bid, 0, ',', '.') }}</span></div>
                <div class="text-gray-600 dark:text-gray-300"><span>KB:</span><span
                        class="font-semibold">{{ number_format($koi->kelipatan_bid, 0, ',', '.') }}</span></div>
                <div class="text-blue-600 font-semibold">Last
                    Bid:<span>{{ number_format($totalBids[(string) $koi->id]['latest_bid'] ?? $koi->open_bid, 0, ',', '.') }}</span>
                </div>
                @if (!empty($totalBids[(string) $koi->id]['has_winner']) && $totalBids[(string) $koi->id]['has_winner'])
                    <div class="text-yellow-600 font-semibold">Winner:
                        <span>{{ $totalBids[(string) $koi->id]['winner_name'] ?? 'N/A' }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<!-- Modal untuk video -->
<div id="videoModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50"
    onclick="closeVideoModal()">
    <div class="bg-white dark:bg-gray-800 p-0 rounded-lg max-w-7xl w-auto max-h-screen overflow-auto">
        <video id="modalVideo" class="w-full h-auto mt-0 rounded-lg" controls style="max-height: 90vh;">
            <source id="videoSource" src="" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</div>


<!-- Modal untuk Sertifikat -->
<div id="certModal" class="fixed inset-0 z-50 items-center flex justify-center hidden bg-black bg-opacity-50"
    onclick="closeModal()">
    <div class="bg-white dark:bg-gray-800 p-0 rounded-lg max-w-7x1 w-full">
        <img id="certImage" src="" alt="Certificate Image" class="w-full mt-0 rounded-lg">
    </div>
</div>
