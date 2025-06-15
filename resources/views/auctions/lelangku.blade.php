<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lelangku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @foreach ($auctions as $auction)
                    <div class="accordion mb-4" id="accordionAuction{{ $auction->id }}">
                        <div class="accordion-header bg-gray-200 dark:bg-gray-700 p-4 flex justify-between items-center cursor-pointer" data-toggle="collapse" data-target="#collapse{{ $auction->id }}">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $auction->title }}</h3>
                                <p>Nomor Lelang: {{ $auction->auction_code }}</p>
                                <p>Jumlah Ikan: {{ $auction->koi->count() }}</p>
                                <p>Dibuat pada: {{ $auction->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <form action="{{ route('auctions.destroy', $auction->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Hapus Lelang</button>
                                </form>
                            </div>
                        </div>

                        <div id="collapse{{ $auction->id }}" class="accordion-collapse collapse">
                            <div class="accordion-body bg-white dark:bg-gray-800 p-4">
                                <div class="mb-4">
                                    <a href="{{ route('koi.create', $auction->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Koi</a>
                                </div>

                                <table class="min-w-full bg-white dark:bg-gray-800">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2">Jenis Koi</th>
                                            <th class="px-4 py-2">Ukuran</th>
                                            <th class="px-4 py-2">Gender</th>
                                            <th class="px-4 py-2">Open Bid</th>
                                            <th class="px-4 py-2">Kelipatan Bid</th>
                                            <th class="px-4 py-2">Buy It Now</th>
                                            <th class="px-4 py-2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($auction->koi as $koi)
                                            <tr class="border-t">
                                                <td class="px-4 py-2">{{ $koi->jenis_koi }}</td>
                                                <td class="px-4 py-2">{{ $koi->ukuran }} cm</td>
                                                <td class="px-4 py-2">{{ ucfirst($koi->gender) }}</td>
                                                <td class="px-4 py-2">Rp {{ number_format($koi->open_bid, 0, ',', '.') }}</td>
                                                <td class="px-4 py-2">Rp {{ number_format($koi->kelipatan_bid, 0, ',', '.') }}</td>
                                                <td class="px-4 py-2">Rp {{ number_format($koi->buy_it_now, 0, ',', '.') }}</td>
                                                <td class="px-4 py-2">
                                                    <form action="{{ route('koi.destroy', $koi->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
