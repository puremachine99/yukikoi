<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('Daftar Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-md">
                <!-- Tab Navigation -->
                <div class="mb-4 border-b">
                    <nav class="flex space-x-4">
                        @foreach ($tabs as $key => $label)
                            <a href="{{ route('transactions.index', ['status' => $key]) }}"
                                class="px-4 py-2 border-b-2 {{ $status === $key ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-zinc-600 hover:text-indigo-600' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </nav>
                </div>

                <!-- Grouped Transactions by Farm -->
                @forelse ($groupedTransactions as $farmName => $transactions)
                    <div class="mb-6 bg-zinc-50 dark:bg-zinc-700 p-4 rounded-lg shadow-md">
                        <!-- Seller Info -->
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h4 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">
                                    {{ $farmName }}
                                </h4>
                                @if ($transactions->first()?->transactionItems->first()?->koi?->auction?->user)
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        <p>{{ $transactions->first()->transactionItems->first()->koi->auction->user->name }}
                                        </p>
                                        <p>{{ $transactions->first()->transactionItems->first()->koi->auction->user->phone_number ?? '-' }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <a href="#" class="text-indigo-600 hover:underline" target="_blank">Kunjungi Toko</a>
                            </div>
                        </div>

                        <!-- Transaction List -->
                        @foreach ($transactions as $transaction)
                            <div class="mt-4">
                                @foreach ($transaction->transactionItems as $item)
                                    <div class="flex mb-4 items-center">
                                        <!-- Koi Image -->
                                        <div class="w-1/4">
                                            <img src="{{ asset('storage/' . ($item->koi->media->first()->url_media ?? 'placeholder.jpg')) }}"
                                                alt="Koi Image" class="w-full h-32 object-cover rounded-md">
                                        </div>
                                        <!-- Koi Details -->
                                        <div class="w-3/4 ml-4">
                                            <h4 class="font-semibold text-zinc-800 dark:text-zinc-100">
                                                {{ $item->koi->judul }}
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                                {{ $item->koi->jenis_koi }} - {{ $item->koi->ukuran }} cm
                                            </p>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                                Harga: Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        <!-- Total and Actions -->
                        <div class="mt-4">
                            <p class="font-semibold text-zinc-800 dark:text-zinc-100">
                                Total Pesanan: Rp {{ number_format($transactions->sum('total_with_fees'), 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                Status: {{ ucwords(str_replace('_', ' ', $transactions->first()->status)) }}
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-4 flex space-x-4">
                            <a href="#"
                                class="py-2 px-4 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-400">
                                Retur
                            </a>
                            <a href="{{ route('transactions.show', $transaction->id) }}"
                                class="py-2 px-4 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600">
                                Invoice
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-zinc-500 dark:text-zinc-400">
                        <p>Tidak ada transaksi ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
