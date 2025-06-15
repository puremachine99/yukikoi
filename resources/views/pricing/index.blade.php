<!-- resources/views/subscription/compare.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Perbandingan Free User vs Seller Prioritas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">Fasilitas</th>
                            <th class="border px-4 py-2">Free User</th>
                            <th class="border px-4 py-2">Seller Prioritas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-4 py-2">Akses ke Lelang Prioritas</td>
                            <td class="border px-4 py-2">Tidak</td>
                            <td class="border px-4 py-2">Ya</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Fee App Lelang</td>
                            <td class="border px-4 py-2">7.5% per Transaksi</td>
                            <td class="border px-4 py-2">2.5% per Transaksi</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Tampilan di Halaman Utama</td>
                            <td class="border px-4 py-2">Standar</td>
                            <td class="border px-4 py-2">Ditonjolkan</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Proses Persetujuan Lelang</td>
                            <td class="border px-4 py-2">Normal</td>
                            <td class="border px-4 py-2">Diprioritaskan</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Analitik Penjualan</td>
                            <td class="border px-4 py-2">Terbatas</td>
                            <td class="border px-4 py-2">Lengkap</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Badge Seller</td>
                            <td class="border px-4 py-2">Tidak</td>
                            <td class="border px-4 py-2">Ya (Trusted Seller)</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Dukungan Pelanggan</td>
                            <td class="border px-4 py-2">Standar</td>
                            <td class="border px-4 py-2">Diprioritaskan</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Akses ke Event & Promo</td>
                            <td class="border px-4 py-2">Tidak</td>
                            <td class="border px-4 py-2">Ya</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
