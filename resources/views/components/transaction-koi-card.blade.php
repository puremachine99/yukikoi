@props(['item', 'isSeller' => false])

<div
    class="itemcart flex items-start bg-white hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors duration-200 dark:bg-zinc-800 p-4 rounded-lg shadow-md cursor-pointer">

    <!-- Gambar Koi -->
    <div class="flex-shrink-0 ml-4">
        <a href="{{ route('koi.show', ['id' => $item->koi->id]) }}" class="block">
            <img src="{{ asset('storage/' . ($item->koi->media->first()->url_media ?? 'default.png')) }}" alt="Koi Image"
                class="border object-cover rounded-lg w-24 h-36">
        </a>
    </div>

    <!-- Detail Koi -->
    <div class="ml-6 flex-1">
        <h4 class="text-lg font-semibold text-zinc-800 dark:text-zinc-200">
            {{ $item->koi->judul }}
        </h4>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">
            Kode Lelang: <span class="font-bold">{{ $item->koi->auction_code }}</span>
        </p>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">
            Jenis Koi: {{ $item->koi->jenis_koi }} - {{ $item->koi->ukuran }} cm
        </p>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">
            Harga: <span class="font-bold text-green-600 dark:text-green-400">Rp
                {{ number_format($item->price, 0, ',', '.') }}</span>
        </p>

        <!-- Detail Buyer (Hanya untuk Seller) -->
        @if ($isSeller && isset($item->transaction->user))
            <div class="mt-2 p-3 bg-zinc-100 dark:bg-zinc-700 rounded-md">
                <h4 class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Informasi Buyer:</h4>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    Nama: <span class="font-bold">{{ $item->transaction->user->name }}</span>
                </p>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    Alamat: <span class="font-bold">{{ $item->transaction->user->address ?? '-' }}</span>
                </p>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    No. HP: <span class="font-bold">{{ $item->transaction->user->phone_number ?? '-' }}</span>
                </p>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    Order Dibuat: <span
                        class="font-bold">{{ \Carbon\Carbon::parse($item->transaction->created_at)->format('d M Y H:i') }}</span>
                </p>
            </div>
        @endif

        <!-- Status -->
        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2">
            Status:
            <span
            class="px-3 py-1 rounded-full text-white text-xs font-semibold
            {{ $item->status == 'menunggu konfirmasi' ? 'bg-yellow-500' : '' }}
            {{ $item->status == 'karantina' ? 'bg-gray-500' : '' }}
            {{ $item->status == 'siap dikirim' ? 'bg-blue-500' : '' }}
            {{ $item->status == 'dikirim' ? 'bg-purple-500' : '' }}
            {{ $item->status == 'selesai' ? 'bg-green-500' : '' }}
            {{ $item->status == 'dibatalkan' ? 'bg-red-500' : '' }}
            {{ $item->status == 'proses pengajuan komplain' ? 'bg-orange-500' : '' }}
            {{ $item->status == 'komplain disetujui' ? 'bg-green-600' : '' }}
            {{ $item->status == 'komplain ditolak' ? 'bg-red-600' : '' }}">
            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
        </span>
        
        </p>

        <!-- Tombol Accordion -->
        <button onclick="toggleAccordion('history-{{ $item->id }}')"
            class="mt-3 text-indigo-500 hover:underline text-sm">
            Lihat Riwayat Status
        </button>

        <!-- Accordion untuk Status History -->
        <div id="history-{{ $item->id }}" class="hidden bg-zinc-100 dark:bg-zinc-700 p-3 mt-2 rounded-md">
            <h4 class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Riwayat Perubahan Status:</h4>
            <ul class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">
                @foreach ($item->statusHistories as $history)
                    <li>
                        <span class="font-bold">{{ ucfirst($history->status) }}</span>
                        oleh <span class="text-blue-500">{{ $history->user->name }}</span>
                        pada {{ \Carbon\Carbon::parse($history->changed_at)->format('d M Y H:i') }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="mt-4 flex space-x-4">
        @if (!$isSeller && $item->status === 'dikirim')
            <!-- Tombol Selesai -->
            <button class="py-2 px-4 bg-green-500 text-white rounded-lg hover:bg-green-600"
                onclick="updateStatus('{{ $item->id }}', 'selesai')">
                Selesai
            </button>

            <!-- Tombol Komplain -->
            <button class="py-2 px-4 bg-red-500 text-white rounded-lg hover:bg-red-600"
                onclick="showComplaintModal('{{ $item->id }}')">
                Komplain
        @endif
    </div>
    <div class="mt-4 flex space-x-4">
        @if ($isSeller)
        <form action="{{ route('orders.updateStatus', ['order' => $item->id]) }}" method="POST">
            @csrf
            @method('PUT') {{-- Gunakan method PUT karena ini update --}}
            
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-zinc-200">Ubah Status</label>
            <x-select name="status" id="status"
                class="border px-2 py-1 rounded text-sm text-zinc-800 dark:text-zinc-200"
                onchange="toggleAdditionalFields()">
                <option value="siap dikirim" {{ $item->status === 'siap dikirim' ? 'x-selected' : '' }}>Siap Dikirim</option>
                <option value="dikirim" {{ $item->status === 'dikirim' ? 'x-selected' : '' }}>Dikirim</option>
                <option value="karantina" {{ $item->status === 'karantina' ? 'x-selected' : '' }}>Karantina</option>
                <option value="dibatalkan" {{ $item->status === 'dibatalkan' ? 'x-selected' : '' }}>Batalkan Pesanan</option>
            </x-select>
    
            <!-- Form Karantina -->
            <div id="karantinaFields" style="display: none;">
                <label class="block text-sm font-medium text-gray-700 mt-2 dark:text-zinc-200">Alasan Karantina</label>
                <x-select name="reason" class="border px-2 py-1 rounded text-sm text-zinc-800 dark:text-zinc-200">
                    <option value="Ikan Sakit (7 hari)">Ikan Sakit (7 hari)</option>
                    <option value="Ikan Buang Kotoran (3 hari)">Ikan Buang Kotoran (3 hari)</option>
                </x-select>
            </div>
    
            <!-- Form Pembatalan -->
            <div id="cancelFields" style="display: none;">
                <label class="block text-sm font-medium text-gray-700 mt-2 dark:text-zinc-200">Alasan Pembatalan</label>
                <textarea name="reason" class="border px-2 py-1 rounded text-sm text-zinc-800 dark:text-zinc-200"
                    placeholder="Alasan pembatalan..."></textarea>
            </div>
    
            <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm">
                Update Status
            </button>
        </form>
    
        <script>
            function toggleAdditionalFields() {
                const status = document.getElementById('status').value;
                document.getElementById('karantinaFields').style.display = (status === 'karantina') ? 'block' : 'none';
                document.getElementById('cancelFields').style.display = (status === 'dibatalkan') ? 'block' : 'none';
            }
        </script>
    @endif
    

    </div>
</div>
