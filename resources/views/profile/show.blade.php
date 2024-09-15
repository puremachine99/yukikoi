<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row space-x-4 lg:space-x-4 space-y-4 lg:space-y-0 lg:grid-cols-4 gap-4">
                <!-- Panel Profil (2xl) -->
                <div class="w-full lg:w-2/6 bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-center">
                        <!-- Foto Profil -->
                        <div class="mb-4">
                            <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('default-profile.png') }}"
                                alt="Profile Photo" class="rounded-full w-32 h-32 mx-auto object-cover">
                        </div>

                        <!-- Data Diri Singkat -->
                        <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100 flex justify-center items-center">
                            {{ $user->name }}
                            @if($user->is_seller)
                                <i class="fa-solid fa-check-circle text-green-500 text-sm ml-2 align-middle"></i>
                            @endif
                        </h1>
                        
                        <!-- Nama Farm -->
                        <h1 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $user->farm_name }}</h1>
                        <!-- Alamat -->
                        <p class="text-zinc-600 dark:text-zinc-400 capitalize">{{ $user->address }}, <b>{{ $user->city }}</b></p>

                        <!-- Bank Name -->
                        <p class="text-zinc-600 dark:text-zinc-400">Bank: {{ $user->bank_name ? $user->bank_name : '-' }}</p>

                        <!-- Phone Number -->
                        <p class="text-zinc-600 dark:text-zinc-400"><i class="fa-brands fa-square-whatsapp text-green-500"></i> {{ $user->phone_number }}</p>

                        <!-- Apakah Seller -->
                        <p class="text-zinc-600 dark:text-zinc-400">

                        </p>


                        <!-- Tanggal Verifikasi Email -->
                        @if ($user->email_verified_at)
                            <p class="text-zinc-600 dark:text-zinc-400">
                                Email Terverifikasi pada: {{ $user->email_verified_at->format('d M Y') }}
                            </p>
                        @endif

                        <!-- Tanggal Pendaftaran (jika ingin menampilkan deleted_at jika menggunakan soft delete) -->
                        @if ($user->deleted_at)
                            <p class="text-zinc-600 dark:text-zinc-400">
                                Akun Dihapus pada: {{ $user->deleted_at->format('d M Y') }}
                            </p>
                        @endif

                        <!-- Badge Achievement (Hardcoded Example) -->
                        <div class="mt-4 flex justify-start">
                            <img src="{{ asset('images/kc.png') }}" alt="Achievement Badge"
                                class="w-auto h-16 mx-auto">
                            <img src="{{ asset('images/az.png') }}" alt="Achievement Badge"
                                class="w-auto h-16 mx-auto">
                        </div>
                        <!-- Container Scrollable untuk tabel -->
                        <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200 leading-tight mt-6 mb-4">
                            {{ __('Rp Total') }}
                        </h2>

                        <div class="max-h-64 overflow-y-auto bg-white dark:bg-zinc-800 rounded-lg shadow-sm">
                            <table class="min-w-full bg-white dark:bg-zinc-800 text-left border-collapse">
                                <thead class="sticky top-0 z-10">
                                    <tr>
                                        <th class="py-2 px-4 bg-zinc-100 dark:bg-zinc-700">Judul Lelang</th>
                                        <th class="py-2 px-4 bg-zinc-100 dark:bg-zinc-700">Total Keuntungan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($auctions as $auction)
                                        <tr class="border-t dark:border-zinc-700">
                                            <td class="py-2 px-4">{{ $auction->title }}</td>
                                            <td class="py-2 px-4">
                                                {{ number_format($auction->total_profit, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Panel Ikan Koi Seller (5xl) -->
                <div class="w-full lg:w-4/6 bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200 leading-tight mb-4">
                        {{ __('Ikan Koi yang Dimiliki Seller') }}
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($kois as $koi)
                            <div class="min-w-[150px] flex-shrink-0 bg-white dark:bg-zinc-700 p-2 rounded-lg shadow-md">
                                <img src="{{ asset('storage/' . $koi->media->first()->url_media) }}" alt="Koi Image"
                                    class=" w-40 h-auto object-scale-down rounded-lg mb-2">
                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-200">
                                    {{ $koi->name }}
                                </h3>
                                <p class="text-md dark:text-gray-400">{{ $koi->judul }}</p>
                                <div class="flex justify-between">
                                    <span class="text-sm">OB = {{ number_format($koi->open_bid, 0, ',', '.') }}</span>
                                    <span class="text-sm">KB =
                                        {{ number_format($koi->kelipatan_bid, 0, ',', '.') }}</span>
                                </div>
                                <span class="text-gray-500">1 x Bid</span>
                            </div>
                        @endforeach
                    </div>



                </div>
            </div>
        </div>
    </div>
</x-app-layout>
