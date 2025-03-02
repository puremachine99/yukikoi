<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('Pesanan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-md">

                <!-- Tab Navigation -->
                <div class="mb-4 border-b">
                    <nav class="flex space-x-4">
                        @foreach ($tabs as $key => $label)
                            <a href="{{ route('orders.index', ['status' => $key]) }}"
                                class="px-4 py-2 border-b-2 {{ $status === $key ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-zinc-600 hover:text-indigo-600' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </nav>
                </div>

                <!-- Orders List -->
                @if ($orders->isEmpty())
                    <p class="text-center text-zinc-600 dark:text-zinc-400">Tidak ada pesanan dalam kategori ini.</p>
                @else
                    <div class="space-y-6">
                        @foreach ($orders as $order)
                            <div
                                class="flex flex-col sm:flex-row items-start bg-white hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors duration-200 dark:bg-zinc-800 p-4 rounded-lg shadow-md">

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
                                            Nama Buyer: <span class="font-bold">{{ $order->buyer->name }}</span>
                                        </p>
                                    </div>

                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 font-semibold mt-2">Harga
                                        Pesanan:</p>
                                    <p class="text-lg font-bold text-green-600 dark:text-green-400">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </p>

                                    <!-- Status Pesanan -->
                                    <div class="mt-2 flex items-center space-x-2">
                                        <span
                                            class="px-3 py-1 rounded-full text-white text-xs font-semibold 
                                            {{ $order->status == 'menunggu konfirmasi' ? 'bg-yellow-500' : '' }}
                                            {{ $order->status == 'sedang dikemas' ? 'bg-blue-500' : '' }}
                                            {{ $order->status == 'dikirim' ? 'bg-purple-500' : '' }}
                                            {{ $order->status == 'selesai' ? 'bg-green-500' : '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>

                                    <!-- Tombol Accordion -->
                                    <button onclick="toggleAccordion('history-{{ $order->id }}')"
                                        class="mt-3 text-indigo-500 hover:underline text-sm">
                                        Lihat Riwayat Status
                                    </button>

                                    <!-- Accordion untuk Status History -->
                                    <div id="history-{{ $order->id }}"
                                        class="hidden bg-zinc-100 dark:bg-zinc-700 p-3 mt-2 rounded-md">
                                        <h4 class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Riwayat
                                            Perubahan Status:</h4>
                                        <ul class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">
                                            @foreach ($order->statusHistories as $history)
                                                <li>
                                                    <span class="font-bold">{{ ucfirst($history->status) }}</span>
                                                    oleh <span class="text-blue-500">{{ $history->user->name }}</span>
                                                    pada
                                                    {{ \Carbon\Carbon::parse($history->changed_at)->format('d M Y H:i') }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <!-- Form Update Status -->
                                <div class="mt-4 sm:mt-0 sm:ml-6">
                                    @if ($order->status !== 'selesai')
                                        <form action="{{ route('orders.updateStatus', $order) }}" method="POST">
                                            @csrf
                                            <x-select name="status"
                                                class="border px-2 py-1 rounded text-sm text-zinc-800 dark:text-zinc-200">
                                                <option value="menunggu konfirmasi"
                                                    {{ $order->status === 'menunggu konfirmasi' ? 'selected' : '' }}>
                                                    Menunggu Konfirmasi
                                                </option>
                                                <option value="sedang dikemas"
                                                    {{ $order->status === 'sedang dikemas' ? 'selected' : '' }}>
                                                    Sedang Dikemas
                                                </option>
                                                <option value="dikirim"
                                                    {{ $order->status === 'dikirim' ? 'selected' : '' }}>
                                                    Dikirim
                                                </option>
                                            </x-select>
                                            <button type="submit"
                                                class="mt-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm">
                                                Update
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleAccordion(id) {
            document.getElementById(id).classList.toggle("hidden");
        }
    </script>
</x-app-layout>
