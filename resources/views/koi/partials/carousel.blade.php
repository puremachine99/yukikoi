<div class="w-full h-auto rounded-lg shadow-lg">
    <div x-data="{
        activeSlide: 0,
        slides: [
            @foreach ($koi->media->where('media_type', 'photo') as $media)
                '{{ asset('storage/' . $media->url_media) }}', @endforeach
        ]
    }" class="relative w-full overflow-visible rounded-lg shadow-lg">
        <!-- Carousel wrapper -->
        <div class="relative flex items-center justify-center" style="height: 750px;">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="activeSlide === index" class="absolute inset-0 flex items-center justify-center">
                    <img :src="slide" alt="Koi Media" class="max-h-full max-w-full object-contain rounded-lg">
                </div>
            </template>

            {{-- logo yuki koi --}}
            <div class="absolute top-1 right-2 p-0 rounded-full text-center text-sm">
                <img src="{{ asset('images/logo.png') }}" alt="yukbid" class="w-auto h-16 mx-auto mb-1">
            </div>
            <div
                class="absolute top-1/2 left-4 transform -translate-y-1/2 -translate-x-1/2 text-md font-bold text-white px-2 py-1 z-50">
                <span class="vertical-text font-onsen text-center text-outline "
                    style="font-family: 'OnsenJapanDemoRegular'; font-size: 11px;">
                    {{ Str::replace(['(', ')'], '', $koi->jenis_koi) }}
                </span>
            </div>
            <div
                class="absolute top-1/2 left-8 transform -translate-y-1/2 -translate-x-1/2 text-sm font-bold rotate-90 uppercase text-white px-2 py-1 leading-none">
                <span class="text-outline">
                    {{ $koi->ukuran }} cm
                </span>
            </div>

            <h3 class="absolute bottom-8 left-1 z-10 text-xs font-bold text-white px-2 py-1">
                <b class="text-outline">Support by Yuki Auction</b>
            </h3>


            <!-- Kapsul Jenis Lelang dengan Tooltip dan Logo -->
            @if (in_array($koi->auction->jenis, ['azukari', 'keeping contest', 'grow_out']))
                <div x-data="{ showTooltip: false }" @mouseover="showTooltip = true" @mouseleave="showTooltip = false"
                    class="absolute bottom-2 right-2 p-0 rounded-full text-center text-sm w-auto cursor-pointer">

                    <!-- Logo untuk setiap jenis lelang -->
                    @if ($koi->auction->jenis == 'azukari')
                        <img src="{{ asset('images/az.png') }}" alt="Azukari Logo" class="w-auto h-14 mx-auto mb-1">
                    @elseif ($koi->auction->jenis == 'keeping contest')
                        <img src="{{ asset('images/kc.png') }}" alt="Keeping Contest Logo"
                            class="w-auto h-14 mx-auto mb-1">
                    @elseif ($koi->auction->jenis == 'grow out')
                        <img src="{{ asset('images/go.png') }}" alt="Grow Out Logo" class="w-auto h-14 mx-auto mb-1">
                    @endif

                    <!-- Tooltip untuk Jenis Lelang -->
                    <div x-show="showTooltip" x-transition
                        class="absolute top-full mt-1 w-max px-2 py-1 text-xs text-white bg-black rounded transform -translate-x-1/2 left-1/2">
                        {{ $koi->auction->jenis == 'azukari' ? 'Azukari' : ($koi->auction->jenis == 'keeping contest' ? 'Keeping Contest' : 'Grow Out') }}
                    </div>
                </div>
            @endif





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
</div>
