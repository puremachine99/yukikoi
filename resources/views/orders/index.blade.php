<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('Pesanan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-zinc-800 p-6 rounded-lg">
            @forelse ($orders as $order)
                <div class="border-b py-4">
                    <p><strong>Kode Koi:</strong> {{ $order->koi->kode_ikan }}</p>
                    <p><strong>Nama Buyer:</strong> {{ $order->buyer->name }}</p>
                    <p><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>Status:</strong> {{ $order->status }}</p>

                    <form action="{{ route('orders.updateStatus', $order) }}" method="post">
                        @csrf
                        <select name="status">
                            <option value="sedang dikemas" {{ $order->status === 'sedang dikemas' ? 'selected' : '' }}>Sedang Dikemas</option>
                            <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Update</button>
                    </form>
                </div>
            @empty
                <p>Tidak ada pesanan masuk.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
