<x-app-layout>
    <style>
        #socialShare {
            display: none;
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
                        <div class="mt-4 flex justify-start">

                            <img src="{{ asset('images/kc.png') }}" alt="Achievement Badge"
                                class="w-auto h-16 mx-auto">
                            <img src="{{ asset('images/az.png') }}" alt="Achievement Badge"
                                class="w-auto h-16 mx-auto">
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
                                    <div class="block bg-white dark:bg-zinc-800 rounded-lg shadow-md overflow-hidden relative card-navigate"
                                        data-url="{{ route('koi.show', ['id' => $koi->id]) }}">
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $koi->media->first()->url_media) }}"
                                                alt="Koi Image" class="object-cover w-full h-96">

                                            <div
                                                class="absolute group top-60 right-0 bg-white dark:bg-zinc-700 p-1 px-2 rounded-l-lg shadow-md w-20">
                                                <!-- Status Lelang dan Jumlah Bids -->
                                                <div class="text-sm text-gray-700 dark:text-gray-200 mb-1">
                                                    <span
                                                        class="font-semibold {{ $koi->auction->status == 'ready' ? 'text-blue-600' : ($koi->auction->status == 'on going' ? ($totalBids[(string) $koi->id]['has_winner'] ? 'text-yellow-600' : 'text-red-600') : 'text-green-500') }}">
                                                        {{ $koi->auction->status == 'ready' ? 'Belum dimulai' : ($koi->auction->status == 'on going' ? ($totalBids[(string) $koi->id]['has_winner'] ? 'Done' : 'On Going') : 'Complete') }}
                                                    </span>
                                                    <div class="text-sm text-gray-700 dark:text-gray-200">
                                                        <span>{{ $totalBids[(string) $koi->id]['total_bids'] ?? 0 }}x
                                                            Bids</span>
                                                    </div>
                                                </div>

                                                <span
                                                    class="absolute bottom-full mb-1 w-max px-1 py-0.5 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">
                                                    {{ $koi->auction->status == 'ready' ? 'Belum Mulai' : ($koi->auction->status == 'on going' ? ($totalBids[(string) $koi->id]['has_winner'] ? 'Pemenang BIN' : 'Sedang Berlangsung') : 'Lelang Selesai') }}
                                                </span>
                                            </div>

                                            <!-- Kapsul Jenis Lelang dengan Tooltip -->
                                            <div x-data="{ showTooltip: false }" @mouseover="showTooltip = true"
                                                @mouseleave="showTooltip = false"
                                                class="absolute top-2 right-2 p-2 rounded-full shadow-md text-center text-sm w-12 cursor-pointer {{ $koi->auction->jenis == 'reguler' ? 'bg-gray-500' : ($koi->auction->jenis == 'azukari' ? 'bg-red-500' : ($koi->auction->jenis == 'keeping_contest' ? 'bg-orange-500' : 'bg-blue-500')) }}">
                                                <span
                                                    class="font-semibold text-white">{{ $koi->auction->jenis == 'reguler' ? 'RG' : ($koi->auction->jenis == 'azukari' ? 'AZ' : ($koi->auction->jenis == 'keeping_contest' ? 'KC' : 'GO')) }}</span>

                                                <div x-show="showTooltip" x-transition
                                                    class="absolute top-full mt-1 w-max px-2 py-1 text-xs text-white bg-black rounded transform -translate-x-1/2 left-1/2">
                                                    {{ $koi->auction->jenis == 'reguler' ? 'Reguler' : ($koi->auction->jenis == 'azukari' ? 'Azukari' : ($koi->auction->jenis == 'keeping_contest' ? 'Keeping Contest' : 'Grow Out')) }}
                                                </div>
                                            </div>

                                            <div
                                                class="absolute bottom-2 left-2 bg-red-500 text-white p-1 rounded-full shadow-md text-center text-xs w-36">
                                                <span id="countdown-{{ $koi->id }}"
                                                    class="font-semibold">00:00</span>
                                            </div>
                                        </div>

                                        <!-- Informasi Koi -->
                                        <div class="p-4">
                                            <h3
                                                class="text-lg font-semibold text-gray-700 dark:text-gray-200 truncate">
                                                {{ $koi->judul }} [{{ Str::ucfirst($koi->gender) }}, {{ $koi->ukuran }} cm]</h3>

                                            <div class="flex justify-between items-center mt-2">
                                                <!-- Views -->
                                                <button
                                                    class="relative group flex items-center text-gray-500 dark:text-gray-400 transition-transform hover:text-blue-600 koi-action">
                                                    <i class="fa-solid fa-eye mr-1"></i>
                                                    <span>12</span> <!-- Placeholder untuk jumlah view -->
                                                    <span
                                                        class="absolute bottom-full mb-2 w-max px-2 py-1 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">Dilihat
                                                        12 kali</span>
                                                </button>

                                                <!-- Likes -->
                                                <button
                                                    class="relative group flex items-center text-gray-500 dark:text-gray-400 transition-transform hover:text-red-600 koi-action">
                                                    <i class="fa-solid fa-heart mr-1"></i>
                                                    <span>5</span> <!-- Placeholder untuk jumlah likes -->
                                                    <span
                                                        class="absolute bottom-full mb-2 w-max px-2 py-1 text-xs text-white bg-black rounded hidden group-hover:block transform -translate-x-1/2 left-1/2">Disukai
                                                        5 kali</span>
                                                </button>
                                            </div>

                                            <hr class="mt-3 mb-3">

                                            <div
                                                class="flex justify-between text-sm text-gray-500 dark:text-gray-400 mt-2">
                                                <span class="uppercase">{{ $koi->jenis_koi ?? '-' }}</span>
                                            </div>

                                            <div class="mt-2">
                                                <p class="text-sm flex space-x-2">Sertifikat:
                                                    @if ($koi->certificates->isNotEmpty())
                                                        @foreach ($koi->certificates as $index => $certificate)
                                                            <a href="#"
                                                                onclick="openModal('{{ asset('storage/' . $certificate->url_gambar) }}')"
                                                                class="bg-yellow-500 hover:bg-yellow-600 text-white text-center w-5 h-5 rounded-full flex items-center justify-center focus:ring-2 focus:ring-yellow-500">
                                                                {{ $index + 1 }}
                                                            </a>
                                                        @endforeach
                                                    @else
                                                        Tidak tersedia
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="grid grid-cols-2 gap-2 mt-3 text-sm">
                                                <div class="text-gray-600 dark:text-gray-300">
                                                    <span>OB:</span>
                                                    <span
                                                        class="font-semibold">{{ number_format($koi->open_bid, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="text-gray-600 dark:text-gray-300">
                                                    <span>KB:</span>
                                                    <span
                                                        class="font-semibold">{{ number_format($koi->kelipatan_bid, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="text-blue-600 font-semibold">
                                                    Last Bid:
                                                    <span>{{ number_format($totalBids[(string) $koi->id]['latest_bid'] ?? $koi->open_bid, 0, ',', '.') }}</span>
                                                </div>
                                                @if (!empty($totalBids[(string) $koi->id]['has_winner']) && $totalBids[(string) $koi->id]['has_winner'])
                                                    <div class="text-yellow-600 font-semibold">
                                                        Winner:
                                                        <span>{{ $totalBids[(string) $koi->id]['winner_name'] ?? 'N/A' }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
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
                    const endTime = new Date("{{ $koi->auction->end_time }}".replace(/-/g, '/')).getTime();

                    const countdownInterval = setInterval(() => {
                        const now = new Date().getTime();
                        const distance = endTime - now;

                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 *
                            60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        if (distance > 0) {
                            countdownElement.innerHTML =
                                `${days > 0 ? days + ' hari, ' : ''}${hours}:${minutes}:${seconds}`;
                        } else {
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
