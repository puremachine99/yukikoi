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
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 shadow-md rounded-lg">
                            <thead>
                                <tr class="bg-zinc-200 dark:bg-zinc-700 text-zinc-800 dark:text-zinc-200">
                                    <th class="py-2 px-4 border">Kode Koi</th>
                                    <th class="py-2 px-4 border">Nama Buyer</th>
                                    <th class="py-2 px-4 border">Alamat Pengiriman</th>
                                    <th class="py-2 px-4 border">Status</th>
                                    <th class="py-2 px-4 border">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr class="border-b border-zinc-300 dark:border-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition">
                                        <td class="py-2 px-4 text-center">{{ $order->koi->kode_ikan ?? 'N/A' }}</td>
                                        <td class="py-2 px-4 text-center">{{ $order->buyer->name ?? 'N/A' }}</td>
                                        <td class="py-2 px-4 text-center">{{ $order->shipping_address ?? 'N/A' }}</td>
                                        <td class="py-2 px-4 text-center">
                                            <span class="px-3 py-1 rounded-full text-white text-xs font-semibold
                                                {{ $order->status == 'menunggu konfirmasi' ? 'bg-yellow-500' : '' }}
                                                {{ $order->status == 'sedang dikemas' ? 'bg-blue-500' : '' }}
                                                {{ $order->status == 'dikirim' ? 'bg-purple-500' : '' }}
                                                {{ $order->status == 'selesai' ? 'bg-green-500' : '' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="py-2 px-4 text-center">
                                            <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="flex items-center space-x-2">
                                                @csrf
                                                <select name="status" class="border px-2 py-1 rounded text-sm text-zinc-800 dark:text-zinc-200">
                                                    <option value="menunggu konfirmasi" {{ $order->status === 'menunggu konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                                    <option value="sedang dikemas" {{ $order->status === 'sedang dikemas' ? 'selected' : '' }}>Sedang Dikemas</option>
                                                    <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                                    <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                </select>
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                    Update
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
