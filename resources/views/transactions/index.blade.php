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
                                <a href="#" class="text-indigo-600 hover:underline" target="_blank">Kunjungi
                                    Toko</a>
                            </div>
                        </div>

                        <!-- Transaction List -->
                        @foreach ($transactions as $transaction)
                            @foreach ($transaction->transactionItems as $item)
                                <div
                                    class="itemcart flex items-start bg-white hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors duration-200 dark:bg-zinc-800 p-4 rounded-lg shadow-md cursor-pointer">
                                    <div class="flex-shrink-0">
                                        <input type="checkbox" class="select-koi" data-id="{{ $transaction->id }}"
                                            data-price="{{ $item->price }}" style="transform: scale(1.2);">
                                    </div>

                                    <!-- Gambar Koi -->
                                    <div class="flex-shrink-0 ml-4">
                                        <a href="{{ route('koi.show', ['id' => $item->koi->id]) }}" class="block">
                                            <img src="{{ asset('storage/' . ($item->koi->media->first()->url_media ?? 'default.png')) }}"
                                                alt="Koi Image" class="border object-cover rounded-lg w-24 h-36">
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
                                            Status: <span
                                                class="px-3 py-1 rounded-full text-white text-xs font-semibold 
                                            {{ $item->status == 'menunggu konfirmasi' ? 'bg-yellow-500' : '' }}
                                            {{ $item->status == 'sedang dikemas' ? 'bg-blue-500' : '' }}
                                            {{ $item->status == 'dikirim' ? 'bg-purple-500' : '' }}
                                            {{ $item->status == 'selesai' ? 'bg-green-500' : '' }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </p>
                                        <!-- Tombol Accordion -->
                                        <button onclick="toggleAccordion('history-{{ $item->id }}')"
                                            class="mt-3 text-indigo-500 hover:underline text-sm">
                                            Lihat Riwayat Status
                                        </button>

                                        <!-- Accordion untuk Status History -->
                                        <div id="history-{{ $item->id }}"
                                            class="hidden bg-zinc-100 dark:bg-zinc-700 p-3 mt-2 rounded-md">
                                            <h4 class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Riwayat
                                                Perubahan Status:</h4>
                                            <ul class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">
                                                @foreach ($item->statusHistories as $history)
                                                    <li>
                                                        <span class="font-bold">{{ ucfirst($history->status) }}</span>
                                                        oleh <span
                                                            class="text-blue-500">{{ $history->user->name }}</span>
                                                        pada
                                                        {{ \Carbon\Carbon::parse($history->changed_at)->format('d M Y H:i') }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Tombol Aksi -->
                                    <div class="mt-4 flex space-x-4">
                                        @if ($item->status === 'dikirim')
                                            <!-- Tombol Selesai -->
                                            <button
                                                class="py-2 px-4 bg-green-500 text-white rounded-lg hover:bg-green-600"
                                                onclick="updateStatus('{{ $item->id }}', 'selesai')">
                                                Selesai
                                            </button>

                                            <!-- Tombol Retur -->
                                            <button class="py-2 px-4 bg-red-500 text-white rounded-lg hover:bg-red-600"
                                                onclick="showReturModal('{{ $item->id }}')">
                                                Retur
                                            </button>
                                        @endif
                                    </div>

                                </div>
                            @endforeach
                        @endforeach

                        <!-- Total and Actions -->
                        <div class="mt-4">
                            <p class="font-semibold text-zinc-800 dark:text-zinc-100">
                                Total Pesanan: Rp
                                {{ number_format($transactions->sum('total_with_fees'), 0, ',', '.') }}
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
    <script>
        function toggleAccordion(id) {
            document.getElementById(id).classList.toggle("hidden");
        }

        function updateStatus(itemId, status) {
            Swal.fire({
                title: 'Konfirmasi Status',
                text: "Apakah Anda yakin ingin mengubah status item ini menjadi " + status + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ubah',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('transactions.updateStatus') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                item_id: itemId,
                                status: status
                            })
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                    if (status === "selesai") {
                                        showRatingModal(itemId); // Tampilkan rating jika selesai
                                    } else {
                                        location.reload();
                                    }
                                });
                            } else {
                                Swal.fire('Gagal!', data.message, 'error');
                            }
                        });
                }
            });
        }

        function showReturModal(itemId) {
            Swal.fire({
                title: 'Form Retur',
                html: `
            <label class="block text-sm font-medium text-gray-700">Alasan Retur:</label>
            <select id="reason" class="swal2-input">
                <option value="rusak">DoA (Dead on Arrival) - Koi Mati</option>
                <option value="tidak sesuai">Ikan Tidak Sesuai</option>
                <option value="lainnya">Lainnya</option>
            </select>
            <label class="block text-sm font-medium text-gray-700 mt-2">Unggah Bukti (Max 50MB, Video):</label>
            <input type="file" id="proof" class="swal2-file" accept="video/*">
        `,
                showCancelButton: true,
                confirmButtonText: 'Kirim Retur',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    const reason = document.getElementById('reason').value;
                    const proof = document.getElementById('proof').files[0];

                    if (!proof || proof.size > 50 * 1024 * 1024) {
                        Swal.showValidationMessage('File harus berupa video dan maksimal 50MB');
                        return false;
                    }

                    let formData = new FormData();
                    formData.append('item_id', itemId);
                    formData.append('reason', reason);
                    formData.append('proof', proof);
                    formData.append('_token', "{{ csrf_token() }}");

                    return fetch("{{ route('transactions.retur') }}", {
                            method: "POST",
                            body: formData
                        }).then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                throw new Error(data.message);
                            }
                            return data;
                        }).catch(error => Swal.showValidationMessage(error));
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Berhasil!', 'Permintaan retur telah dikirim.', 'success').then(() => {
                        location.reload();
                    });
                }
            });
        }

        function showRatingModal(itemId) {
            Swal.fire({
                title: 'Beri Rating',
                html: `
            <label>Rating (1-5):</label>
            <input type="range" id="rating" min="1" max="5" step="0.5" value="5" class="swal2-input">
            <label>Review:</label>
            <textarea id="review" class="swal2-input"></textarea>
        `,
                showCancelButton: true,
                confirmButtonText: 'Kirim',
                preConfirm: () => {
                    return {
                        rating: document.getElementById('rating').value,
                        review: document.getElementById('review').value
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('transactions.rate') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            transaction_item_id: itemId,
                            rating: result.value.rating,
                            review: result.value.review
                        })
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            Swal.fire('Sukses!', 'Rating berhasil dikirim.', 'success').then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }
    </script>

</x-app-layout>
