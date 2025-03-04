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
            Kode Lelang: {{ $item->koi->auction_code }}
        </p>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">
            Jenis Koi: {{ $item->koi->jenis_koi }} - {{ $item->koi->ukuran }} cm
        </p>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">
            Harga: Rp {{ number_format($item->price, 0, ',', '.') }}
        </p>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">
            Status:
            <span
                class="px-3 py-1 rounded-full text-white text-xs font-semibold
                {{ $item->status == 'menunggu konfirmasi' ? 'bg-yellow-500' : '' }}
                {{ $item->status == 'sedang dikemas' ? 'bg-blue-500' : '' }}
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
            </button>
        @endif
    </div>

</div>
