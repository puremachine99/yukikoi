<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('Pesanan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow">
                @if (session('success'))
                    <div class="bg-green-500 text-white p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($orders->isEmpty())
                    <p class="text-center text-zinc-600 dark:text-zinc-400">Tidak ada pesanan masuk.</p>
                @else
                    <div class="space-y-6">
                        @foreach ($orders as $order)
                            <div class="flex flex-col sm:flex-row items-start bg-white hover:bg-zinc-100 
                                        dark:hover:bg-zinc-700 transition-colors duration-200 dark:bg-zinc-800 
                                        p-4 rounded-lg shadow-md">
                                <!-- Gambar Koi -->
                                <div class="flex-shrink-0">
                                    <a href="{{ route('koi.show', ['id' => $order->koi->id]) }}" class="block">
                                        <img src="{{ asset('storage/' . ($order->koi->media->first()->url_media ?? 'default.png')) }}"
                                            alt="Koi Image" class="border object-cover rounded-lg w-24 h-36">
                                    </a>
                                </div>

                                <!-- Detail Pesanan -->
                                <div class="ml-6 flex-1 w-full">
                                    <h4 class="text-lg font-semibold text-zinc-800 dark:text-zinc-200">
                                        {{ $order->koi->judul }}
                                    </h4>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                            Kode Lelang: <span class="font-bold">{{ $order->koi->auction_code }}</span>
                                        </p>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                            Kode Ikan: <span class="font-bold">{{ $order->koi->kode_ikan }}</span>
                                        </p>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                            Nama Buyer: <span class="font-bold">{{ $order->buyer->name }}</span>
                                        </p>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400 overflow-hidden truncate max-w-xs">
                                            Alamat: <span class="font-bold">{{ $order->shipping_address }}</span>
                                        </p>
                                    </div>

                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 font-semibold mt-2">Harga Pesanan:</p>
                                    <p class="text-lg font-bold text-green-600 dark:text-green-400">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </p>

                                    <!-- Status Pesanan -->
                                    <div class="mt-2 flex items-center space-x-2">
                                        <span class="px-3 py-1 rounded-full text-white text-xs font-semibold
                                            {{ $order->status == 'menunggu konfirmasi' ? 'bg-yellow-500' : '' }}
                                            {{ $order->status == 'sedang dikemas' ? 'bg-blue-500' : '' }}
                                            {{ $order->status == 'dikirim' ? 'bg-purple-500' : '' }}
                                            {{ $order->status == 'selesai' ? 'bg-green-500' : '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Form Update Status -->
                                <div class="mt-4 sm:mt-0 sm:ml-6">
                                    <form action="{{ route('orders.updateStatus', $order) }}" method="POST">
                                        @csrf
                                        <select name="status" class="border px-2 py-1 rounded text-sm text-zinc-800 dark:text-zinc-200">
                                            <option value="menunggu konfirmasi" {{ $order->status === 'menunggu konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                            <option value="sedang dikemas" {{ $order->status === 'sedang dikemas' ? 'selected' : '' }}>Sedang Dikemas</option>
                                            <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                            <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                        <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm">
                                            Update
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
