<x-app-layout>
    <style>
        #socialShare {
            display: none;
        }

        .metallic {
            background: linear-gradient(45deg,
                    rgba(153, 153, 153, 0.5) 5%,
                    rgba(255, 255, 255, 0.5) 10%,
                    rgba(204, 204, 204, 0.5) 30%,
                    rgba(221, 221, 221, 0.5) 50%,
                    rgba(204, 204, 204, 0.5) 70%,
                    rgba(255, 255, 255, 0.5) 80%,
                    rgba(153, 153, 153, 0.5) 95%);
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .metallic-button:hover {
            transform: translateY(-2px);
        }

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
            text-shadow: -1px -1px 0 #000,
                1px -1px 0 #000,
                -1px 1px 0 #000,
                1px 1px 0 #000;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row space-x-4 lg:space-x-4 space-y-4 lg:space-y-0 lg:grid-cols-4 gap-4">
                <!-- Panel Profil (2xl) -->
                <div
                    class="w-full lg:w-2/6 bg-white dark:bg-zinc-800 overflow-visible shadow-sm sm:rounded-lg p-6 relative">
                    <div class="text-center">
                        <!-- Foto Profil -->
                        <div class="mb-4">
                            <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('default-profile.png') }}"
                                alt="Profile Photo" class="rounded-full w-32 h-32 mx-auto object-cover">
                        </div>

                        <!-- Tombol Pengaturan (Cogs) -->
                        @if (auth()->id() === $user->id)
                            <div class="absolute top-4 right-4">
                                <!-- Tombol Pengaturan -->
                                <a href="{{ route('profile.edit') }}"
                                    class="group text-gray-600 dark:text-white p-2 hover:scale-110 focus:outline-none focus:ring focus:ring-sky-500 transition-transform ease-in-out duration-200"
                                    title="Edit Profile">
                                    <i class="fa-solid fa-cog"></i>

                                    <!-- Tooltip -->
                                    <span
                                        class="absolute top-full mt-2 w-max px-2 py-1 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2 transition-opacity duration-200 ease-in-out">
                                        Edit Profile
                                    </span>
                                </a>
                            </div>
                            <div class="absolute top-12 right-4">
                                {{-- share --}}
                                <a href="#" id="shareProfileBtn"
                                    class="group text-gray-600 dark:text-white p-2 hover:scale-110 focus:outline-none focus:ring focus:ring-sky-500 transition-transform ease-in-out duration-200"
                                    title="Edit Profile">
                                    <i class="fa-solid fa-share-nodes"></i>

                                    <!-- Tooltip -->
                                    <span
                                        class="absolute top-full mt-2 w-max px-2 py-1 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2 transition-opacity duration-200 ease-in-out">
                                        Share
                                    </span>
                                </a>
                            </div>
                        @endif


                        <!-- Data Diri Singkat -->
                        <h1
                            class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100 flex justify-center items-center">
                            {{ $user->name }}
                        </h1>

                        <!-- Nama Farm -->
                        <h1 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $user->farm_name }}
                            @if ($user->is_priority_seller)
                                <i class="fa-solid text-lg fa-check-circle text-sky-500 ml-2 align-middle"></i>
                            @endif
                        </h1>

                        <!-- Follow/Unfollow Button -->
                        <div class="text-center">
                            @if (auth()->check() && auth()->id() !== $user->id)
                                @if (auth()->user()->isFollowing($user->id))
                                    <form action="{{ route('unfollow', $user->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Unfollow
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('follow', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Follow
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>

                        <!-- Total Followers dan Followings -->
                        <div class="flex justify-center items-center mt-4 space-x-6">
                            <div>
                                <p class="text-lg font-bold text-zinc-800 dark:text-zinc-200">
                                    {{ $user->followers->count() }}</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Followers</p>
                            </div>
                            <div>
                                <p class="text-lg font-bold text-zinc-800 dark:text-zinc-200">
                                    {{ $user->followings->count() }}</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Following</p>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <p class="text-zinc-600 dark:text-zinc-400 capitalize">{{ $user->address }},
                            <b>{{ $user->city }}</b>
                        </p>

                        <!-- Bio -->
                        <p class="text-zinc-600 dark:text-zinc-400">
                            <hr>
                            <b>Bio:</b> <br> <i>{{ $user->bio ?? '-' }}</i>
                            <hr>
                        </p>



                        <!-- WhatsApp -->
                        @if ($user->phone_number)
                            <p class="text-zinc-600 dark:text-zinc-400">
                                <a href="https://wa.me/{{ $user->phone_number }}" target="_blank" title="WhatsApp">
                                    <i class="fa-brands fa-square-whatsapp text-green-500"></i> WhatsApp
                                </a>
                            </p>
                        @endif

                        <!-- Instagram -->
                        @if ($user->instagram)
                            <p class="text-zinc-600 dark:text-zinc-400">
                                <a href="{{ $user->instagram }}" target="_blank" title="Instagram">
                                    <i class="fa-brands fa-instagram text-pink-500"></i> Instagram
                                </a>
                            </p>
                        @endif

                        <!-- YouTube -->
                        @if ($user->youtube)
                            <p class="text-zinc-600 dark:text-zinc-400">
                                <a href="{{ $user->youtube }}" target="_blank" title="YouTube">
                                    <i class="fa-brands fa-youtube text-red-500"></i> YouTube
                                </a>
                            </p>
                        @endif


                        {{-- created at --}}
                        <p class="text-zinc-600 dark:text-zinc-400">Member Sejak
                            {{ $user->created_at->format('d M Y') }}</p>
                        <hr>
                        {{-- @if ($user->email_verified_at)
                            <p class="text-zinc-600 dark:text-zinc-400">Email Terverifikasi pada:
                                {{ $user->email_verified_at->format('d M Y') }}</p>
                        @endif --}}

                        <!-- Badge Achievement -->
                        <h2 class="text-md"><b>Achievement :</b></h2>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($user->achievements as $achievement)
                                <div class="flex items-center p-2 rounded-lg shadow-md metallic"
                                    style="background-color: {{ $achievement->badge_color }};">
                                    <!-- Icon Section (1/4) -->
                                    <div class="w-1/4 flex justify-center border-r-2">
                                        <i class="fa-solid {{ $achievement->icon }} text-2xl text-slate-800"></i>
                                    </div>
                                    <!-- Details Section (3/4) -->
                                    <div class="w-3/4 pl-3  justify-start items-start ">
                                        <h3 class="text-md font-semibold text-slate-800">{{ $achievement->name }}</h3>
                                        <p class="text-xs text-slate-800 opacity-80">{{ $achievement->description }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                    </div>
                </div>

                <!-- Main Panel for User Portfolio -->
                <div class="w-full lg:w-5/6 bg-white dark:bg-zinc-800 overflow-visible shadow-sm sm:rounded-lg p-6"
                    x-data="{ activeTab: 'koi' }">

                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 dark:border-zinc-700 mb-4">
                        <nav class="flex space-x-4" aria-label="Tabs">
                            <!-- Tab for Koi -->
                            <button @click="activeTab = 'koi'"
                                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'koi' }"
                                class="px-3 py-2 font-medium text-sm leading-5 text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-200 focus:outline-none border-b-2"
                                :class="{ 'border-indigo-500': activeTab === 'koi' }">
                                Koi
                            </button>
                            <!-- Tab for Lelang -->
                            <button @click="activeTab = 'lelang'"
                                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'lelang' }"
                                class="px-3 py-2 font-medium text-sm leading-5 text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-200 focus:outline-none border-b-2"
                                :class="{ 'border-indigo-500': activeTab === 'lelang' }">
                                Lelang
                            </button>
                            <!-- Tab for Statistik -->
                            <button @click="activeTab = 'statistik'"
                                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'statistik' }"
                                class="px-3 py-2 font-medium text-sm leading-5 text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-200 focus:outline-none border-b-2"
                                :class="{ 'border-indigo-500': activeTab === 'statistik' }">
                                Statistik
                            </button>

                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div>
                        <!-- Koi Tab Content -->
                        <div x-show="activeTab === 'koi'">
                            <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200 leading-tight mb-4">
                                {{ __('Ikan Koi yang Dimiliki Seller') }}</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($kois as $koi)
                                    <x-koi-card :koi="$koi" :total-bids="$totalBids[$koi->id] ?? 0" />
                                @endforeach
                            </div>
                        </div>

                        <!-- Lelang Tab Content -->
                        <div x-show="activeTab === 'lelang'">
                            <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200 leading-tight mb-4">
                                {{ $userStats['lelang_dibuat'] }} Lelang {{ $user->name }}
                            </h2>

                            <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-6">
                                @foreach ($auctions as $lelang)
                                    <div
                                        class="p-6 bg-gray-100 dark:bg-zinc-700 rounded-lg shadow-lg flex flex-col lg:flex-row">

                                        <!-- Informasi Lelang -->
                                        <div class="w-full lg:w-2/3 flex flex-col justify-between">
                                            <!-- Banner Lelang -->
                                            @if ($lelang->banner)
                                                <div class="w-full lg:w-1/3 mb-4 lg:mb-0 lg:mr-4">
                                                    <img src="{{ asset('storage/' . $lelang->banner) }}"
                                                        alt="Banner Lelang"
                                                        class="object-cover rounded-lg h-48 w-full lg:w-auto lg:h-auto">
                                                </div>
                                            @endif
                                            <div>
                                                <!-- Judul Lelang -->
                                                <h3 class="text-2xl font-semibold text-zinc-900 dark:text-white mb-2">
                                                    {{ $lelang->title }}</h3>

                                                <!-- Deskripsi -->
                                                <p class="text-zinc-700 dark:text-zinc-300 mb-4">
                                                    {{ $lelang->description }}</p>

                                                <!-- Informasi Lainnya -->
                                                <div
                                                    class="text-sm text-zinc-600 dark:text-zinc-400 flex flex-col space-y-2">
                                                    <!-- Jenis Lelang -->
                                                    <div class="flex justify-between">
                                                        <span class="font-semibold">Jenis Lelang:</span>
                                                        <span>{{ ucfirst($lelang->jenis) }}</span>
                                                    </div>

                                                    <!-- Tanggal Mulai -->
                                                    <div class="flex justify-between">
                                                        <span class="font-semibold">Tanggal Mulai:</span>
                                                        <span>{{ $lelang->start_time->format('d M Y, H:i') }}</span>
                                                    </div>

                                                    <!-- Tanggal Berakhir -->
                                                    <div class="flex justify-between">
                                                        <span class="font-semibold">Tanggal Berakhir:</span>
                                                        <span>{{ \Carbon\Carbon::parse($lelang->end_time)->format('d M Y, H:i') }}</span>
                                                    </div>

                                                    <!-- Status Lelang -->
                                                    <div class="flex justify-between">
                                                        <span class="font-semibold">Status:</span>
                                                        <span>{{ ucfirst($lelang->status) }}</span>
                                                    </div>

                                                    <!-- Jumlah Ikan di Lelang -->
                                                    <div class="flex justify-between">
                                                        <span class="font-semibold">Jumlah Ikan:</span>
                                                        <span>{{ $lelang->koi->count() }} ikan</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tombol Aksi -->
                                            <div class="mt-4">
                                                <a target="_blank"
                                                    href="{{ route('auctions.show', $lelang->auction_code) }}"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    Lihat Detail Lelang
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        <!-- Statistik Tab Content -->
                        <div x-show="activeTab === 'statistik'">
                            <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200 leading-tight mb-4">
                                Statistik Pengguna</h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- Jumlah Lelang Dibuat -->
                                <div
                                    class="p-4 bg-blue-200 dark:bg-blue-700 text-gray-700 dark:text-gray-200 rounded-lg shadow">
                                    <h3 class="font-semibold">Jumlah Lelang Dibuat</h3>
                                    <p class="text-3xl">{{ $userStats['lelang_dibuat'] }}</p>
                                </div>

                                <!-- Jumlah Lelang Diikuti -->
                                <div
                                    class="p-4 bg-blue-200 dark:bg-blue-700 text-gray-700 dark:text-gray-200 rounded-lg shadow">
                                    <h3 class="font-semibold">Jumlah Lelang Diikuti</h3>
                                    <p class="text-3xl">{{ $userStats['lelang_diikuti'] }}</p>
                                </div>

                                <!-- Jumlah Koi Terlelang -->
                                <div
                                    class="p-4 bg-pink-200 dark:bg-pink-700 text-gray-700 dark:text-gray-200 rounded-lg shadow">
                                    <h3 class="font-semibold">Jumlah Koi Terlelang</h3>
                                    <p class="text-3xl">{{ $userStats['koi_terlelang'] }} /
                                        {{ $userStats['koi_terdaftar'] }}</p>
                                </div>
                                <!-- Total Ikan Dimenangkan -->
                                <div
                                    class="p-4 bg-green-200 dark:bg-green-700 text-gray-700 dark:text-gray-200 rounded-lg shadow">
                                    <h3 class="font-semibold">Total Koi Dimenangkan</h3>
                                    <p class="text-3xl">{{ $userStats['koi_dimenangkan'] }}</p>
                                </div>

                                <!-- Jumlah Pendapatan -->
                                <div
                                    class="p-4 bg-indigo-200 dark:bg-indigo-700 text-gray-700 dark:text-gray-200 rounded-lg shadow">
                                    <h3 class="font-semibold">Total Pendapatan</h3>
                                    <p class="text-3xl">
                                        Rp{{ number_format($userStats['jumlah_pendapatan'], 0, ',', '.') }}</p>
                                </div>
                                <!-- Total Uang Dihabiskan (Pengeluaran) -->
                                <div
                                    class="p-4 bg-yellow-200 dark:bg-yellow-700 text-gray-700 dark:text-gray-200 rounded-lg shadow">
                                    <h3 class="font-semibold">Total Pengeluaran</h3>
                                    <p class="text-3xl">
                                        Rp{{ number_format($userStats['jumlah_pengeluaran'], 0, ',', '.') }}</p>
                                </div>

                                <!-- Jumlah Koi di Kolam -->
                                <div
                                    class="p-4 bg-red-200 dark:bg-red-700 text-gray-700 dark:text-gray-200 rounded-lg shadow">
                                    <h3 class="font-semibold">Jumlah Koi di Kolam</h3>
                                    <p class="text-3xl">{{ $userStats['jumlah_koi'] }}</p>
                                </div>

                                <!-- Jumlah Koi dengan Sertifikat -->
                                <div
                                    class="p-4 bg-purple-200 dark:bg-purple-700 text-gray-700 dark:text-gray-200 rounded-lg shadow">
                                    <h3 class="font-semibold">Jumlah Koi dengan Sertifikat</h3>
                                    <p class="text-3xl">{{ $userStats['jumlah_sertifikat'] }}</p>
                                </div>

                                <!-- Jumlah Kontes Diikuti -->
                                <div
                                    class="p-4 bg-orange-200 dark:bg-orange-700 text-gray-700 dark:text-gray-200 rounded-lg shadow">
                                    <h3 class="font-semibold">Jumlah Kontes Diikuti</h3>
                                    <p class="text-3xl">{{ $userStats['jumlah_kontest_diikuti'] }}</p>
                                </div>

                                <!-- Jumlah Sniping -->
                                <div
                                    class="p-4 bg-teal-200 dark:bg-teal-700 text-gray-700 dark:text-gray-200 rounded-lg shadow">
                                    <h3 class="font-semibold">Jumlah Sniping</h3>
                                    <p class="text-3xl">{{ $userStats['jumlah_sniping'] }}</p>
                                </div>

                                <!-- Jumlah Menang Sniping -->
                                <div
                                    class="p-4 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg shadow">
                                    <h3 class="font-semibold">Jumlah Menang Sniping</h3>
                                    <p class="text-3xl">{{ $userStats['jumlah_menang_sniping'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="socialShare" class="hidden">
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('profile.show', $user->id) }}" target="_blank"
            class="bg-blue-600 text-white font-bold py-2 px-4 rounded inline-block">Share on Facebook</a>

        <a href="https://twitter.com/intent/tweet?url={{ route('profile.show', $user->id) }}&text=Check out this profile on Yuki Koi Auction!"
            target="_blank" class="bg-blue-400 text-white font-bold py-2 px-4 rounded inline-block">Share on
            Twitter</a>

        <a href="https://api.whatsapp.com/send?text=Check out this profile on Yuki Koi Auction! {{ route('profile.show', $user->id) }}"
            target="_blank" class="bg-green-500 text-white font-bold py-2 px-4 rounded inline-block">Share on
            WhatsApp</a>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const kois = @json($kois);

            kois.forEach((koi) => {
                if (koi.auction.status === 'on going') {
                    const countdownElement = document.getElementById(`countdown-${koi.id}`);
                    const countdownWrapper = document.getElementById(`countdown-wrapper-${koi.id}`);

                    // Ensure the DOM elements exist before proceeding
                    if (!countdownElement || !countdownWrapper) {
                        // console.warn(`Countdown elements not found for koi ID: ${koi.id}`);
                        return;
                    }

                    const endTime = new Date(koi.auction.end_time.replace(/-/g, '/')).getTime();

                    const countdownInterval = setInterval(() => {
                        const now = new Date().getTime();
                        const distance = endTime - now;

                        if (distance > 0) {
                            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 *
                                60 * 60));
                            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            // Update countdown display
                            countdownElement.innerHTML =
                                `${days > 0 ? days + ' hari, ' : ''}${hours}:${minutes}:${seconds}`;

                            // Adjust styles based on remaining time
                            if (distance <= 60 * 60 * 1000) { // Less than 1 hour
                                countdownWrapper.classList.remove("bg-yellow-500", "text-black");
                                countdownWrapper.classList.add("bg-red-500", "text-white");
                            } else {
                                countdownWrapper.classList.remove("bg-red-500", "text-white");
                                countdownWrapper.classList.add("bg-yellow-500", "text-black");
                            }
                        } else {
                            // Stop the countdown and update text
                            clearInterval(countdownInterval);
                            countdownElement.innerHTML = 'Lelang Berakhir';
                        }
                    }, 1000);
                }
            });
        });


        @if (session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif

        @if (session('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif

        document.getElementById('shareProfileBtn').addEventListener('click', async () => {
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: '{{ $user->name }} Profile on Yuki Koi Auction',
                        text: 'Check out this awesome Koi seller profile!',
                        url: '{{ route('profile.show', $user->id) }}'
                    });
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Profil telah berhasil dibagikan!',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat mencoba membagikan profil.',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }
            } else {
                // Swal untuk fallback ke media sosial jika Web Share API tidak didukung
                Swal.fire({
                    title: 'Browser tidak mendukung fitur berbagi',
                    html: `
                    <p>Kamu bisa membagikan profil ini melalui:</p>
                    <div style="display: flex; justify-content: space-around; margin-top: 10px;">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('profile.show', $user->id) }}" target="_blank"
                            class="swal2-styled"
                            style="background-color: #3b5998; padding: 10px; border-radius: 5px; color: white;">Facebook</a>

                        <a href="https://twitter.com/intent/tweet?url={{ route('profile.show', $user->id) }}&text=Check out this profile on Yuki Koi Auction!"
                            target="_blank" class="swal2-styled"
                            style="background-color: #1da1f2; padding: 10px; border-radius: 5px; color: white;">Twitter</a>

                        <a href="https://api.whatsapp.com/send?text=Check out this profile on Yuki Koi Auction! {{ route('profile.show', $user->id) }}"
                            target="_blank" class="swal2-styled"
                            style="background-color: #25d366; padding: 10px; border-radius: 5px; color: white;">WhatsApp</a>
                    </div>
                    `,
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.card-navigate').forEach(card => {
                card.addEventListener('click', function(event) {
                    // Cek apakah elemen yang diklik memiliki kelas koi-action
                    if (!event.target.closest('.koi-action')) {
                        window.location.href = this.dataset.url;
                    }
                });
            });
        });
    </script>
</x-app-layout>
