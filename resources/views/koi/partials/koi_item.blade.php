<div class="koi-item relative border rounded-lg p-4 dark:bg-zinc-700" data-jenis="{{ strtolower($koi->jenis_koi) }}"
    data-gender="{{ strtolower($koi->gender) }}"
    data-search="{{ strtolower($koi->judul) }} {{ strtolower($koi->jenis_koi) }} {{ strtolower($koi->gender) }} {{ strtolower($koi->ukuran) }} {{ strtolower($koi->breeder) }}">
    <!-- Tombol delete di kanan atas -->
    <button
        class="absolute top-2 right-2 bg-zinc-500 text-white rounded-full px-2 py-1 delete-koi-btn transition-transform transform hover:scale-110 active:scale-100"
        style="z-index: 10" data-koi-id="{{ $koi->id }}" data-koi-name="{{ $koi->judul }}">
        <i class="fa-solid fa-trash-can"></i>
    </button>
    <button
        class="absolute top-12 right-2 bg-zinc-500 text-white rounded-full px-2 py-1 transition-transform transform hover:scale-110 active:scale-100"
        style="z-index: 10" onclick="window.location.href='{{ route('koi.edit', $koi->id) }}'">
        <i class="fa-solid fa-pen"></i>
    </button>

    <!-- Tombol Play di pojok kanan bawah -->
    @if ($koi->media->where('media_type', 'video')->isNotEmpty())
        <button
            class="absolute right-0 w-16 h-16 z-10 bg-white text-sky-500 border-2 border-sky-500 rounded-full flex items-center justify-center transition-transform transform hover:scale-110 hover:bg-sky-500 hover:text-white hover:border-white"
            style="top: 61%" style="z-index: 10"
            onclick="openVideoModal('{{ asset('storage/' . $koi->media->where('media_type', 'video')->first()->url_media) }}')">
            <i class="fa-solid fa-play text-3xl"></i>
        </button>
    @endif

    <!-- Tombol Hati di pojok kiri bawah -->
    <button
        class="absolute bottom-3 right-3 w-12 h-12 z-10 bg-white text-red-500 border-2 border-red-500 rounded-full flex items-center justify-center transition-transform transform hover:scale-110 hover:bg-red-500 hover:text-white hover:border-white"
        style="z-index: 10" onclick="return false">
        <i class="fa-solid fa-heart text-xl"></i>
        <!-- Tooltip -->
        <span
            class="tooltip-text absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden px-2 py-1 text-xs text-white bg-black rounded">
            Preview Like
        </span>
    </button>
    <!-- Carousel untuk gambar -->
    <div x-data="{
        activeSlide: 0,
        slides: [
            @foreach ($koi->media->where('media_type', 'photo') as $media)
                '{{ asset('storage/' . $media->url_media) }}', @endforeach
        ]
    }" class="relative w-full overflow-hidden rounded-lg shadow-lg">
        <!-- Carousel wrapper -->
        <div class="relative" style="height: 460px">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="activeSlide === index" class="absolute inset-0">
                    <img :src="slide" alt="Koi Media" class="w-full h-full object-contain rounded-lg">
                </div>
            </template>
        </div>


        <!-- Slider controls (disembunyikan jika hanya ada satu gambar) -->
        <template x-if="slides.length > 1">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </template>
    </div>

    <!-- Detail Koi -->
    <h3 class="text-lg font-semibold mt-4 uppercase">{{ $koi->kode_ikan }}. {{ $koi->judul }} {{ $koi->ukuran }}
        cm
        - [{{ $koi->gender }}]</h3>
    <p class="text-sm">{{ __('Jenis: ') . $koi->jenis_koi }}</p> <!-- Jenis Koi ditambahkan sebagai detail -->
    <hr class="mb-2 mt-2">
    <!-- Kolom 2 baris untuk Open Bid dan Kelipatan Bid -->
    <div class="flex justify-between">
        <span class="text-md font-bold">OB : {{ number_format($koi->open_bid, 0, ',', '.') }} ribu</span>
        <span class="text-md font-bold">KB : {{ number_format($koi->kelipatan_bid, 0, ',', '.') }} ribu</span>
    </div>
    <hr class="mb-2 mt-2">

    <!-- Buy It Now (BIN) tetap menggunakan format rupiah dan dikali 1000 -->
    @if ($koi->buy_it_now)
        <p class="text-sm">
            {{ __('Buy It Now : Rp ') . number_format($koi->buy_it_now * 1000, 0, ',', '.') }}
        </p>
    @endif

    <!-- Keterangan Koi -->
    <p class="text-sm">
        {{ __('Keterangan: ') . ($koi->keterangan ?: '-') }}
        <br>
        {{ __('Breed by: ') . ($koi->breeder ?: '-') }}
    </p>

    <!-- Sertifikat -->
    <div class="mt-0">
        <p class="text-sm flex space-x-2">Sertifikat :
            @if ($koi->certificates->isNotEmpty())

                @foreach ($koi->certificates as $index => $certificate)
                    <a href="#" onclick="openModal('{{ asset('storage/' . $certificate->url_gambar) }}')"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white text-center text-md font-semibold w-5 h-5 flex items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                        {{ $index + 1 }}
                    </a>
                @endforeach
            @else
                Tidak tersedia
            @endif
        </p>
    </div>


</div>

<!-- Modal untuk video -->
<div id="videoModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50"
    onclick="closeVideoModal()">
    <div class="bg-white dark:bg-zinc-800 p-0 rounded-lg max-w-7xl w-full">
        <video id="modalVideo" class="w-full h-auto mt-0 rounded-lg" controls>
            <source id="videoSource" src="" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</div>

<!-- Modal untuk Sertifikat -->
<div id="certModal" class="fixed inset-0 z-50 items-center flex justify-center hidden bg-black bg-opacity-50"
    onclick="closeModal()">
    <div class="bg-white dark:bg-zinc-800 p-0 rounded-lg max-w-7x1 w-full">
        <img id="certImage" src="" alt="Certificate Image" class="w-full mt-0 rounded-lg">
    </div>
</div>
<script>
    let scrollPosition = 0;
    // Script to handle tooltip display on hover
    document.querySelectorAll('button').forEach(button => {
        button.addEventListener('mouseenter', () => {
            const tooltip = button.querySelector('.tooltip-text');
            tooltip.classList.remove('hidden');
        });
        button.addEventListener('mouseleave', () => {
            const tooltip = button.querySelector('.tooltip-text');
            tooltip.classList.add('hidden');
        });
    });

    function openModal(imageUrl) {
        scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        document.getElementById('certImage').src = imageUrl;
        document.getElementById('certModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('certModal').classList.add('hidden');
        document.body.style.overflow = '';
        window.scrollTo(0, scrollPosition);
    }

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
