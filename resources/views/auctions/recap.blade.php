<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-cyan-800 dark:text-cyan-100 tracking-wide">
            Rekap Lelang: <span class="text-teal-600 dark:text-teal-300">{{ $auction->auction_code }}</span>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Auction Info Card with Wave Pattern -->
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border-t-4 border-teal-500 relative overflow-hidden">
                <div class="absolute -bottom-5 -right-5 opacity-10">
                    <svg width="150" height="150" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#0D9488"
                            d="M45,-69.2C57.5,-61.3,66.3,-47.9,72.9,-33.1C79.5,-18.3,83.9,-2.1,81.9,13.2C79.9,28.5,71.5,42.9,59.2,55.4C46.9,67.9,30.7,78.4,12.5,85.5C-5.7,92.6,-25.9,96.3,-42.8,88.9C-59.7,81.5,-73.3,63,-80.3,42.2C-87.3,21.3,-87.7,-1.9,-81.7,-22.7C-75.7,-43.5,-63.3,-61.9,-47.9,-68.9C-32.5,-75.9,-14.2,-71.5,1.9,-74.1C18,-76.7,36,-86.3,45,-69.2Z"
                            transform="translate(100 100)" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-cyan-700 dark:text-cyan-100 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z"
                            clip-rule="evenodd" />
                    </svg>
                    Informasi Lelang
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mt-4 text-sm">
                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                        <div class="text-gray-500 dark:text-gray-300">Kode Lelang</div>
                        <div class="font-medium text-teal-600 dark:text-teal-300">{{ $auction->auction_code }}</div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                        <div class="text-gray-500 dark:text-gray-300">Nama</div>
                        <div class="font-medium">{{ $auction->title }}</div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                        <div class="text-gray-500 dark:text-gray-300">Status</div>
                        <div class="font-medium text-green-500 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Selesai
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                        <div class="text-gray-500 dark:text-gray-300">Total Koi</div>
                        <div class="font-medium">{{ $kois->count() }} Ekor</div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                        <div class="text-gray-500 dark:text-gray-300">Total Peserta</div>
                        <div class="font-medium">{{ $totalParticipants->count() }} User</div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                        <div class="text-gray-500 dark:text-gray-300">Total Pendapatan</div>
                        <div class="font-medium text-teal-600 dark:text-teal-300">Rp
                            {{ number_format($totalRevenue * 1000, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- Koi List with Modern Table -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-cyan-700 dark:text-cyan-100 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                clip-rule="evenodd" />
                        </svg>
                        Rekap Koi dalam Lelang
                    </h3>
                    <span
                        class="text-xs px-3 py-1 bg-teal-100 dark:bg-teal-900 text-teal-800 dark:text-teal-100 rounded-full">
                        {{ $kois->count() }} Items
                    </span>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    No</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nama Koi</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Ukuran</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Harga Awal</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Harga Akhir</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Pemenang</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Total Bid</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($kois as $index => $koi)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $koi->judul }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $koi->ukuran }} cm</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Rp
                                        {{ number_format($koi->open_bid, 0, ',', '.') }}</td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-teal-600 dark:text-teal-300">
                                        Rp {{ number_format($koi->latest_bid ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if ($koi->winner)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100">
                                                {{ $koi->winner->user->name }} (Rp
                                                {{ number_format($koi->winner->amount, 0, ',', '.') }})
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-100">
                                                ❌ Tidak Ada Pemenang
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <span
                                            class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100 rounded-full text-xs">
                                            {{ $koi->total_bids }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Statistics Card with Aquatic Accents -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border-l-4 border-cyan-500">
                <h3 class="text-lg font-semibold text-cyan-700 dark:text-cyan-100 flex items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-cyan-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                    </svg>
                    Statistik Performa Lelang
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div
                        class="bg-gradient-to-r from-cyan-50 to-teal-50 dark:from-gray-700 dark:to-gray-700 p-4 rounded-lg border border-cyan-100 dark:border-gray-600">
                        <div class="flex items-center">
                            <div
                                class="p-2 rounded-full bg-cyan-100 dark:bg-cyan-900 text-cyan-600 dark:text-cyan-300 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-300">Total Pemenang</div>
                                <div class="font-semibold">{{ $kois->whereNotNull('winner')->count() }} User</div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-r from-cyan-50 to-teal-50 dark:from-gray-700 dark:to-gray-700 p-4 rounded-lg border border-cyan-100 dark:border-gray-600">
                        <div class="flex items-center">
                            <div
                                class="p-2 rounded-full bg-teal-100 dark:bg-teal-900 text-teal-600 dark:text-teal-300 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-300">Rata-rata Harga Naik</div>
                                <div class="font-semibold">
                                    {{ number_format($kois->avg(fn($koi) => ($koi->latest_bid / max($koi->open_bid, 1)) * 100), 2) }}%
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-r from-cyan-50 to-teal-50 dark:from-gray-700 dark:to-gray-700 p-4 rounded-lg border border-cyan-100 dark:border-gray-600">
                        <div class="flex items-center">
                            <div
                                class="p-2 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-300">Total Pendapatan</div>
                                <div class="font-semibold text-teal-600 dark:text-teal-300">Rp
                                    {{ number_format($totalRevenue * 1000, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-r from-cyan-50 to-teal-50 dark:from-gray-700 dark:to-gray-700 p-4 rounded-lg border border-cyan-100 dark:border-gray-600">
                        <div class="flex items-center">
                            <div
                                class="p-2 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-300">Koi dengan Bid Tertinggi</div>
                                <div class="font-semibold">
                                    {{ optional($kois->sortByDesc('latest_bid')->first())->judul ?? 'Tidak Ada' }}
                                    <span class="text-teal-600 dark:text-teal-300">
                                        (Rp
                                        {{ number_format(optional($kois->sortByDesc('latest_bid')->first())->latest_bid ?? 0, 0, ',', '.') }})
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
