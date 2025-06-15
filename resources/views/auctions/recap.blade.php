<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
            Rekap Lelang: {{ $auction->auction_code }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                <!-- Informasi Lelang -->
                <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200">Informasi Lelang</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-3 text-sm">
                    <div><strong>Kode Lelang:</strong> {{ $auction->auction_code }}</div>
                    <div><strong>Nama:</strong> {{ $auction->name }}</div>
                    <div><strong>Status:</strong> ✅ Selesai</div>
                    <div><strong>Total Koi:</strong> {{ $kois->count() }} Ekor</div>
                    <div><strong>Total Peserta:</strong> {{ $totalParticipants->count() }} User</div>
                    <div><strong>Total Bid:</strong> {{ $totalBids }} Kali</div>
                    <div><strong>Total Pendapatan:</strong> Rp {{ number_format($totalRevenue * 1000, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- Daftar Koi -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">Rekap Koi dalam Lelang</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">Nama Koi</th>
                                <th class="px-4 py-2">Ukuran</th>
                                <th class="px-4 py-2">Harga Awal</th>
                                <th class="px-4 py-2">Harga Akhir</th>
                                <th class="px-4 py-2">Pemenang</th>
                                <th class="px-4 py-2">Total Bid</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kois as $index => $koi)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2">{{ $koi->judul }}</td>
                                    <td class="px-4 py-2">{{ $koi->ukuran }} cm</td>
                                    <td class="px-4 py-2">Rp {{ number_format($koi->open_bid, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">
                                        Rp {{ number_format($koi->latest_bid ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($koi->winner)
                                            {{ $koi->winner->user->name }} (Rp
                                            {{ number_format($koi->winner->amount, 0, ',', '.') }})
                                        @else
                                            ❌ Tidak Ada Pemenang
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">{{ $koi->total_bids }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Statistik Lelang -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200">Statistik Performa Lelang</h3>
                <ul class="mt-3 text-sm text-gray-600 dark:text-gray-300 space-y-2">
                    <li>🏆 <strong>Total Pemenang:</strong> {{ $kois->whereNotNull('winner')->count() }} User</li>
                    <li>📊 <strong>Rata-rata Harga Koi Naik:</strong>
                        {{ $kois->avg(fn($koi) => ($koi->latest_bid / max($koi->open_bid, 1)) * 100) }}%
                    </li>
                    <li>💰 <strong>Total Pendapatan:</strong> Rp {{ number_format($totalRevenue * 1000, 0, ',', '.') }}
                    </li>
                    <li>🔥 <strong>Koi dengan Bid Tertinggi:</strong>
                        {{ optional($kois->sortByDesc('latest_bid')->first())->judul ?? 'Tidak Ada' }}
                        (Rp
                        {{ number_format(optional($kois->sortByDesc('latest_bid')->first())->latest_bid ?? 0, 0, ',', '.') }})
                    </li>
                    <li>🚀 <strong>Koi yang Terjual Paling Cepat:</strong>
                        {{ optional($kois->sortByDesc('total_bids')->first())->judul ?? 'Tidak Ada' }}
                        ({{ optional($kois->sortByDesc('total_bids')->first())->total_bids ?? 0 }} bid)
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
