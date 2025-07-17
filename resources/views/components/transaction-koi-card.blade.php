@props(['item', 'isSeller' => false])
<div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border-l-4 border-teal-500 relative overflow-hidden">
    <!-- Wave decorative element -->
    <div class="absolute -bottom-5 -right-5 opacity-10">
        <svg width="150" height="150" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path fill="#0D9488"
                d="M45,-69.2C57.5,-61.3,66.3,-47.9,72.9,-33.1C79.5,-18.3,83.9,-2.1,81.9,13.2C79.9,28.5,71.5,42.9,59.2,55.4C46.9,67.9,30.7,78.4,12.5,85.5C-5.7,92.6,-25.9,96.3,-42.8,88.9C-59.7,81.5,-73.3,63,-80.3,42.2C-87.3,21.3,-87.7,-1.9,-81.7,-22.7C-75.7,-43.5,-63.3,-61.9,-47.9,-68.9C-32.5,-75.9,-14.2,-71.5,1.9,-74.1C18,-76.7,36,-86.3,45,-69.2Z"
                transform="translate(100 100)" />
        </svg>
    </div>

    <!-- Grid 3 Kolom -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Kolom 1: Foto Koi -->
        <div class="flex justify-center">
            <img src="{{ asset('storage/' . ($item->koi->media->first()->url_media ?? 'default.png')) }}"
                class="border-2 border-teal-100 dark:border-gray-600 object-cover rounded-lg w-32 h-42 shadow-sm">
        </div>

        <!-- Kolom 2: Detail Koi -->
        <div class="space-y-2">
            <h4 class="text-lg font-semibold text-cyan-800 dark:text-cyan-100">
                {{ $item->koi->judul }} 
                <small class="text-sm text-teal-600 dark:text-teal-300">{{ $item->koi->kode_ikan }}</small>
            </h4>
            
            <div class="grid grid-cols-2 gap-2 text-sm">
                <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded-lg">
                    <div class="text-gray-500 dark:text-gray-300">Kode Lelang</div>
                    <div class="font-medium text-teal-600 dark:text-teal-300">{{ $item->koi->auction_code }}</div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded-lg">
                    <div class="text-gray-500 dark:text-gray-300">Jenis Lelang</div>
                    <div class="font-medium">{{ ucfirst($item->koi->auction->jenis) }}</div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded-lg">
                    <div class="text-gray-500 dark:text-gray-300">Jenis & Ukuran</div>
                    <div class="font-medium">{{ $item->koi->jenis_koi }} - {{ $item->koi->ukuran }} cm</div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded-lg">
                    <div class="text-gray-500 dark:text-gray-300">Total Bid</div>
                    <div class="font-medium">{{ count($item->koi->bids) }} x</div>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg mt-2">
                <div class="text-gray-500 dark:text-gray-300">Menang Pada</div>
                <div class="font-medium text-cyan-700 dark:text-cyan-100">
                    {{ \Carbon\Carbon::parse($item->transaction->created_at)->format('d M Y H:i') }}
                </div>
            </div>

            <div class="bg-gradient-to-r from-teal-50 to-cyan-50 dark:from-gray-700 dark:to-gray-700 p-3 rounded-lg border border-teal-100 dark:border-gray-600">
                <div class="text-gray-500 dark:text-gray-300">Harga Final</div>
                <div class="font-bold text-lg text-teal-600 dark:text-teal-300">
                    Rp {{ number_format($item->price, 0, ',', '.') }}
                </div>
            </div>

            <div class="flex items-center mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500 dark:text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                </svg>
                <span class="text-xs text-gray-500 dark:text-gray-300">Status:</span>
                <span class="ml-2 px-3 py-1 rounded-full text-xs font-semibold
                    {{ $item->status == 'menunggu konfirmasi' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-100' : '' }}
                    {{ $item->status == 'karantina' ? 'bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100' : '' }}
                    {{ $item->status == 'siap dikirim' ? 'bg-teal-100 dark:bg-teal-900 text-teal-800 dark:text-teal-100' : '' }}
                    {{ $item->status == 'dikirim' ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100' : '' }}
                    {{ $item->status == 'selesai' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100' : '' }}
                    {{ $item->status == 'dibatalkan' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-100' : '' }}
                    {{ $item->status == 'proses pengajuan komplain' ? 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-100' : '' }}
                    {{ $item->status == 'komplain disetujui' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100' : '' }}
                    {{ $item->status == 'komplain ditolak' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-100' : '' }}">
                    {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                </span>
            </div>

            @if ($item->status == 'dibatalkan' || $item->status == 'komplain disetujui' || $item->status == 'komplain ditolak' || $item->status == 'karantina')
                <div class="mt-2 bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                    <div class="text-sm text-gray-500 dark:text-gray-300">Alasan:</div>
                    <div class="text-sm font-medium">
                        {{ $item->karantina_reason }}

                        @if ($item->cancel_reason)
                            @php
                                $cancel = json_decode($item->cancel_reason);
                            @endphp

                            @if (json_last_error() === JSON_ERROR_NONE)
                                {{ $cancel->reason ?? '' }}
                                <a href="javascript:void(0)"
                                    onclick="showCancelVideoModal('{{ $cancel->video_url ?? '' }}')"
                                    class="inline-flex items-center ml-2 px-2 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v8a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z" />
                                    </svg>
                                    Lihat Video
                                </a>
                            @else
                                {{ $item->cancel_reason }}
                            @endif
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Kolom 3: Detail Buyer -->
        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
            <h4 class="text-sm font-semibold text-cyan-700 dark:text-cyan-100 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-teal-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                Informasi Buyer
            </h4>
            
            <div class="mt-3 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-300">Nama:</span>
                    <span class="font-medium">{{ $item->transaction->user->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-300">Alamat:</span>
                    <span class="font-medium text-right">{{ $item->shipping_address ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-300">No. HP:</span>
                    <span class="font-medium">{{ $item->transaction->user->phone_number ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-300">Ongkir:</span>
                    <span class="font-medium text-teal-600 dark:text-teal-300">Rp {{ number_format($item->shipping_fee, 0, ',', '.') }}</span>
                </div>
                
                @if (!$isSeller)
                    <div class="pt-2 mt-2 border-t border-gray-200 dark:border-gray-600 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-300">Fee Payment:</span>
                            <span class="font-medium">Rp {{ number_format($item->transaction->fee_payment_gateway, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-300">Fee Aplikasi:</span>
                            <span class="font-medium">Rp {{ number_format($item->transaction->fee_application, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-300">Fee Rekber:</span>
                            <span class="font-medium">Rp {{ number_format($item->transaction->fee_rekber, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Accordion Riwayat Status -->
    <div class="mt-4">
        <button class="toggle-accordion flex items-center text-teal-600 dark:text-teal-300 hover:text-teal-800 dark:hover:text-teal-200 text-sm font-medium"
            data-target="history-{{ $item->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
            </svg>
            Lihat Riwayat Status
        </button>
        <div id="history-{{ $item->id }}" class="hidden bg-gray-50 dark:bg-gray-700 p-3 mt-2 rounded-lg border border-gray-200 dark:border-gray-600">
            <h4 class="text-sm font-semibold text-cyan-700 dark:text-cyan-100 mb-2">Riwayat Perubahan Status</h4>
            <ul class="space-y-2">
                @foreach ($item->statusHistories as $history)
                    <li class="text-xs p-2 bg-white dark:bg-gray-800 rounded">
                        <span class="font-bold">{{ ucfirst($history->status) }}</span>
                        <span class="text-gray-500 dark:text-gray-400">oleh</span>
                        <span class="text-teal-600 dark:text-teal-300">{{ $history->user->name }}</span>
                        <span class="text-gray-500 dark:text-gray-400">pada</span>
                        {{ \Carbon\Carbon::parse($history->changed_at)->format('d M Y H:i') }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Footer Update Status -->
    @if ($isSeller && $item->status != 'selesai')
        <form action="{{ route('orders.updateStatus') }}" method="POST" data-ajax="true" class="mt-4">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <div class="flex-grow">
                    <x-select name="status" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="">Pilih Status</option>
                        <option value="siap dikirim">Siap Dikirim</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="karantina">Karantina</option>
                        <option value="dibatalkan">Batalkan Pesanan</option>
                    </x-select>
                </div>
                <button type="submit" class="w-full sm:w-auto bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Update Status
                </button>
            </div>
        </form>
    @else
        @if ($item->status == 'dikirim')
            <div class="mt-4 flex flex-wrap gap-2">
                <button onclick="updateStatus('{{ $item->id }}')" class="flex-1 sm:flex-none bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Selesai
                </button>
                <button onclick="showComplaintModal('{{ $item->id }}')" class="flex-1 sm:flex-none bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                    </svg>
                    Komplain
                </button>
            </div>
        @endif
    @endif
</div>