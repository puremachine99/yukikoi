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
                        @foreach ($groupedOrders as $farm => $items)
                            <h3 class="text-lg font-bold">{{ $farm }}</h3>
                            @foreach ($items as $item)
                                <x-transaction-koi-card :item="$item" :isSeller="true" />
                            @endforeach
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

        function toggleAdditionalFields(orderId) {
            // Ambil nilai status
            const status = document.getElementById(`status-${orderId}`).value;

            // Pastikan hanya form yang sesuai yang ditampilkan
            document.querySelectorAll(`[id^="karantinaFields-"]`).forEach(el => el.style.display = 'none');
            document.querySelectorAll(`[id^="cancelFields-"]`).forEach(el => el.style.display = 'none');

            // Tampilkan hanya elemen yang sesuai dengan orderId
            if (status === 'karantina') {
                document.getElementById(`karantinaFields-${orderId}`).style.display = 'block';
            } else if (status === 'dibatalkan') {
                document.getElementById(`cancelFields-${orderId}`).style.display = 'block';
            }
        }
    </script>

</x-app-layout>
