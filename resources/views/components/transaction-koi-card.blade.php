@props(['item', 'isSeller' => false])
<div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-md">
    <!-- Grid 3 Kolom -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Kolom 1: Foto Koi -->
        <div class="flex justify-center">
            <img src="{{ asset('storage/' . ($item->koi->media->first()->url_media ?? 'default.png')) }}"
                class="border object-cover rounded-lg w-32 h-42">
        </div>

        <!-- Kolom 2: Detail Koi -->
        <div>
            <h4 class="text-lg font-semibold">{{ $item->koi->judul }} <small>{{ $item->koi->kode_ikan }}</small></h4>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                Kode Lelang: <span class="font-bold">{{ $item->koi->auction_code }}</span>
            </p>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                jenis Lelang: <span class="font-bold">{{ ucfirst($item->koi->auction->jenis) }}</span>
            </p>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                Jenis: {{ $item->koi->jenis_koi }} - {{ $item->koi->ukuran }} cm
            </p>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                Total Bid: <span class="font-bold">{{ count($item->koi->bids) }} x</span>
            </p>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                Menang Pada: <span
                    class="font-bold">{{ \Carbon\Carbon::parse($item->transaction->created_at)->format('d M Y H:i') }}</span>
            </p>
            <p class="text-sm font-bold text-green-600">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2">
                Status:
                <span
                    class="px-3 py-1 rounded-full text-white text-xs font-semibold
                    {{ $item->status == 'menunggu konfirmasi' ? 'bg-yellow-500' : '' }}
                    {{ $item->status == 'karantina' ? 'bg-gray-500' : '' }}
                    {{ $item->status == 'siap dikirim' ? 'bg-teal-500' : '' }}
                    {{ $item->status == 'dikirim' ? 'bg-blue-500' : '' }}
                    {{ $item->status == 'selesai' ? 'bg-green-500' : '' }}
                    {{ $item->status == 'dibatalkan' ? 'bg-red-500' : '' }}
                    {{ $item->status == 'proses pengajuan komplain' ? 'bg-orange-500' : '' }}
                    {{ $item->status == 'komplain disetujui' ? 'bg-green-600' : '' }}
                    {{ $item->status == 'komplain ditolak' ? 'bg-red-600' : '' }}">
                    {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                </span>
            </p>

            @if (
                $item->status == 'dibatalkan' ||
                    $item->status == 'komplain disetujui' ||
                    $item->status == 'komplain ditolak' ||
                    $item->status == 'karantina')
                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2">
                    Alasan : <span class="font-bold">{{ $item->karantina_reason }}{{ $item->cancel_reason }}</span>
                </p>
            @endif




        </div>

        <!-- Kolom 3: Detail Buyer -->
        <div class="p-3 bg-zinc-100 dark:bg-zinc-700 rounded-lg">
            <h4 class="text-sm font-semibold">Informasi Buyer</h4>
            <p class="text-sm">Nama: <span class="font-bold">{{ $item->transaction->user->name }}</span></p>
            <p class="text-sm">Alamat: <span class="font-bold">{{ $item->shipping_address ?? '-' }}</span></p>
            <p class="text-sm">No. HP: <span
                    class="font-bold">{{ $item->transaction->user->phone_number ?? '-' }}</span></p>
            <p class="text-sm">Ongkir: <span class="font-bold">Rp
                    {{ number_format($item->shipping_fee, 0, ',', '.') }}</span></p>
            @if (!$isSeller)
                <p class="text-sm">Fee Payment Gateway: <span class="font-bold">Rp
                        {{ number_format($item->transaction->fee_payment_gateway, 0, ',', '.') }}</span></p>
                <p class="text-sm">Fee Aplikasi: <span class="font-bold">Rp
                        {{ number_format($item->transaction->fee_application, 0, ',', '.') }}</span></p>
                <p class="text-sm">Fee Rekber: <span class="font-bold">Rp
                        {{ number_format($item->transaction->fee_rekber, 0, ',', '.') }}</span></p>
            @endif

        </div>
    </div>

    <!-- Row Akordion Full Width -->
    <div class="mt-4">
        <button onclick="toggleAccordion('history-{{ $item->id }}')"
            class="text-indigo-500 hover:underline text-sm">
            Lihat Riwayat Status
        </button>
        <div id="history-{{ $item->id }}" class="hidden bg-zinc-100 dark:bg-zinc-700 p-3 mt-2 rounded-md">
            <h4 class="text-sm font-semibold">Riwayat Perubahan Status</h4>
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

    <!-- Footer Update Status -->
    @if ($isSeller)
        <form action="{{ route('orders.updateStatus', ['order' => $item->id]) }}" method="POST">
            @csrf
            <div class="mt-4 flex flex-wrap md:flex-nowrap items-center justify-between" x-data="{
                selectedStatus: '',
                reason: '',
                updateHiddenReason() {
                    if (this.selectedStatus === 'karantina') {
                        this.reason = this.$refs.reasonKarantina?.value || '';
                    } else if (this.selectedStatus === 'dibatalkan') {
                        this.reason = this.$refs.reasonBatal?.value || '';
                    } else {
                        this.reason = '';
                    }
                }
            }">
                <!-- Hidden Input -->
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <input type="hidden" name="reason" x-model="reason">

                <!-- Pilihan Status -->
                <div class="w-full md:w-auto flex items-center space-x-2">
                    <x-select x-model="selectedStatus" name="status" class="border px-3 py-2 rounded text-sm"
                        @change="updateHiddenReason(); checkCancelStatus()">
                        <option value="">Pilih Status</option>
                        <option value="siap dikirim">Siap Dikirim</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="karantina">Karantina</option>
                        <option value="dibatalkan">Batalkan Pesanan</option>
                    </x-select>

                    {{-- tombol pembatalan --}}
                    <button type="button" x-show="selectedStatus === 'dibatalkan'"
                        class="bg-red-500 text-white text-sm px-4 py-2 rounded-md"
                        @click="showCancelModal('{{ $item->id }}')">
                        Ajukan Pembatalan
                    </button>
                    <!-- Pilihan alasan karantina -->
                    <x-select x-show="selectedStatus === 'karantina'" x-ref="reasonKarantina" x-model="reason"
                        @change="updateHiddenReason()" style="display: none;">
                        <option value="Ikan Sakit (7 hari)">Ikan Sakit (7 hari)</option>
                        <option value="Ikan Buang Kotoran (3 hari)">Ikan Buang Kotoran (3 hari)</option>
                    </x-select>

                    <!-- Textarea alasan pembatalan -->
                    <textarea x-show="selectedStatus === 'dibatalkan'" x-ref="reasonBatal" x-model="reason" @input="updateHiddenReason()"
                        placeholder="Alasan Pembatalan..." class="border px-3 py-2 rounded text-sm w-64" style="display: none;"></textarea>
                </div>

                <!-- Tombol Update -->
                <div class="mt-2 md:mt-0">
                    <button type="submit" class="bg-blue-500 text-white text-sm px-4 py-2 rounded-md">
                        Update Status
                    </button>
                </div>
            </div>
        </form>
    @else
        @if ($item->status == 'dikirim')
            <div class="mt-4 flex items-center space-x-2">
                <button class="bg-green-500 text-white px-4 py-2 rounded-md"
                    onclick="updateStatusAndShowRating('{{ $item->id }}')">Selesai</button>

                <button class="bg-red-500 text-white px-4 py-2 rounded-md"
                    onclick="showComplaintModal('{{ $item->id }}')">Komplain</button>
            </div>
        @endif
    @endif



</div>
