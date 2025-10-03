@props(['koi', 'totalBids' => [], 'wishlist' => []])

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
            /* Adjust spacing between letters if needed */
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
        }

        .koi-image {
            width: 100%;
            height: auto;
        }

        .watermark-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            /* Adjust opacity to make it look like a watermark */
            pointer-events: none;
            /* Make watermark unclickable */
        }

        .watermark-logo {
            width: 80%;
            /* Adjust size as needed */
            max-width: 500px;
            height: auto;
            filter: grayscale(100%);
            /* Optional: make the watermark grayscale */
        }


        .text-outline {
            text-shadow:
                -1px -1px 0 #000,
                1px -1px 0 #000,
                -1px 1px 0 #000,
                1px 1px 0 #000;
        }
    </style>
    <div class="p-2">
        <div class="max-w-7xl mx-auto">
            <div x-data="{ open: true }" class="grid grid-cols-1 gap-4">

                {{-- 🧭 Tombol Toggle Filter --}}
                <button @click="open = !open"
                    class="flex items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold mb-2">
                    <i :class="open ? 'fa-solid fa-chevron-up' : 'fa-solid fa-chevron-down'"></i>
                    <span>Filter Pencarian</span>
                </button>

                {{-- 🎯 Form Filter --}}
                <form method="GET" action="{{ route('live.index') }}" x-show="open" x-transition x-cloak
                    class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
                        <!-- 🔍 Input Pencarian -->
                        <div class="relative md:col-span-2">
                            <input type="text" name="q" placeholder="Cari koi..." value="{{ request('q') }}"
                                class="w-full p-2 pl-10 border rounded-lg focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-white">
                            <i
                                class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>

                        <!-- 🐟 Filter Gender -->
                        <div class="md:col-span-1">
                            <label class="text-gray-600 text-sm dark:text-gray-300">Gender Koi</label>
                            <x-select name="gender" class="w-full">
                                <option value="">Semua Gender</option>
                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Jantan
                                </option>
                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Betina
                                </option>
                            </x-select>
                        </div>

                        <!-- 💰 Harga Minimum -->
                        <div class="md:col-span-1">
                            <label class="text-gray-600 text-sm dark:text-gray-300">Harga Min</label>
                            <input type="number" name="min_price" placeholder="Rp 0" value="{{ request('min_price') }}"
                                class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- 💰 Harga Maksimum -->
                        <div class="md:col-span-1">
                            <label class="text-gray-600 text-sm dark:text-gray-300">Harga Max</label>
                            <input type="number" name="max_price" placeholder="Rp 10.000.000"
                                value="{{ request('max_price') }}"
                                class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- 🔄 Tombol Reset -->
                        <div class="md:col-span-1 flex gap-2">
                            <button type="submit"
                                class="w-full p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                <i class="fa-solid fa-search"></i> Cari
                            </button>
                            <a href="{{ route('live.index') }}"
                                class="p-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                                <i class="fa-solid fa-refresh"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            {{-- core : card renderer --}}
            <div x-data="{ isMobile: window.innerWidth < 768 }" x-init="window.addEventListener('resize', () => isMobile = window.innerWidth < 768)">
                <!-- Mobile: 2x2 Cards per Fullscreen Scroll -->
                <template x-if="isMobile">
                    <div class="h-screen overflow-y-scroll snap-y snap-mandatory bg-gray-100 dark:bg-gray-900">
                        @foreach ($kois->chunk(4) as $group)
                            <div class="snap-start h-screen grid grid-cols-2 grid-rows-2 gap-2 p-2">
                                @foreach ($group as $koi)
                                    <x-koi-card-mobile :koi="$koi" :total-bids="$totalBids[$koi->id] ?? []" :wishlist="$wishlist" />
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </template>


                <template x-if="!isMobile">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 p-4">
                        @foreach ($kois as $koi)
                            <x-koi-card :koi="$koi" :total-bids="$totalBids[$koi->id] ?? []" :wishlist="$wishlist" />
                        @endforeach
                    </div>
                </template>
            </div>

            <!-- Pagination -->
            {{-- <div class="mt-4">
                {{ $kois->links('pagination::tailwind') }} 
            </div> --}}

        </div>
    </div>

    @vite('resources/js/koi-card.js')


</x-app-layout>
