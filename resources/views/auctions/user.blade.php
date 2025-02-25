<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('Lelang Saya') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @forelse ($auctions as $auction)
                <div class="bg-white dark:bg-zinc-800 shadow-md rounded-lg p-6">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-200">
                        {{ $auction->auction_code }}
                    </h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        Dimulai: {{ $auction->start_time }} - Berakhir: {{ $auction->end_time }}
                    </p>

                    <table class="w-full mt-4 border-collapse border border-zinc-300 dark:border-zinc-700">
                        <thead>
                            <tr class="bg-zinc-100 dark:bg-zinc-700 text-zinc-800 dark:text-zinc-200">
                                <th class="border p-2">Koi</th>
                                <th class="border p-2">Harga Terakhir</th>
                                <th class="border p-2">Jumlah Bid</th>
                                <th class="border p-2">Pelelang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($auction->koi as $koi)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                                    <td class="border p-2">
                                        <a href="{{ route('koi.show', $koi->id) }}" class="text-blue-500 dark:text-blue-300">
                                            {{ $koi->judul }}
                                        </a>
                                    </td>
                                    <td class="border p-2">
                                        Rp {{ number_format($koi->bids->max('amount') ?? $koi->open_bid, 0, ',', '.') }}
                                    </td>
                                    <td class="border p-2">
                                        {{ $koi->bids->count() }}
                                    </td>
                                    <td class="border p-2">
                                        @foreach ($koi->bids as $bid)
                                            <span class="text-xs text-zinc-600 dark:text-zinc-300">
                                                {{ $bid->user->name }}
                                            </span>,
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @empty
                <div class="bg-white dark:bg-zinc-800 shadow-md rounded-lg p-6 text-center">
                    <p class="text-zinc-600 dark:text-zinc-300">Kamu belum memiliki lelang.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
