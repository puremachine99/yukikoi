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
                                <div class="mt-4">
                                    <p class="font-semibold text-zinc-800 dark:text-zinc-100">
                                        Total Pesanan: Rp
                                        {{ number_format($transactions->sum('total_with_fees'), 0, ',', '.') }}
                                    </p>
                                </div>
                                <a href="#" class="text-indigo-600 hover:underline" target="_blank">Kunjungi
                                    Toko</a>
                                {{-- <a href="{{ route('transactions.show', $transaction->id) }}">
                                    Invoice
                                </a> --}}
                            </div>
                        </div>

                        <!-- Transaction List -->
                        @foreach ($transactions as $transaction)
                            @foreach ($transaction->transactionItems as $item)
                                <x-transaction-koi-card :item="$item" />
                            @endforeach
                        @endforeach

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

        function showComplaintModal(itemId) {
            Swal.fire({
                title: 'Form Komplain / Retur',
                html: `
                        <label class="block text-sm font-medium text-gray-700">Jenis Permintaan:</label>
                        <select id="complaintType" class="swal2-input">
                            <option value="retur">Retur (Barang Tidak Sesuai / Ikan Mati)</option>
                            <option value="komplain">Komplain (Pelayanan Buruk / Lainnya)</option>
                        </select>

                        <label class="block text-sm font-medium text-gray-700 mt-2">Alasan:</label>
                        <textarea id="reason" class="swal2-textarea" placeholder="Jelaskan alasan..."></textarea>

                        <label class="block text-sm font-medium text-gray-700 mt-2">Unggah Bukti (Max 50MB, Video/Gambar):</label>
                        <input type="file" id="proof" class="swal2-file" accept="video/*,image/*">
                    `,
                showCancelButton: true,
                confirmButtonText: 'Kirim Permintaan',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    const complaintType = document.getElementById('complaintType').value;
                    const reason = document.getElementById('reason').value.trim();
                    const proof = document.getElementById('proof').files[0];

                    if (!reason) {
                        Swal.showValidationMessage('Alasan tidak boleh kosong!');
                        return false;
                    }

                    if (!proof) {
                        Swal.showValidationMessage('Bukti harus diunggah!');
                        return false;
                    }

                    console.log("File yang akan dikirim:", proof);
                    console.log("Tipe File:", proof.type);
                    console.log("Ukuran File:", proof.size);

                    let formData = new FormData();
                    formData.append('item_id', itemId);
                    formData.append('type', complaintType);
                    formData.append('reason', reason);
                    formData.append('proof', proof);
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                    return fetch("{{ route('complaints.store') }}", {
                        method: "POST",
                        body: formData
                    }).then(response => {
                        if (!response.ok) {
                            // Jika server error, cek apakah respons HTML
                            return response.text().then(text => {
                                console.error("Server Response:", text);
                                throw new Error(
                                    "Server mengembalikan error. Cek Network tab untuk detail."
                                );
                            });
                        }
                        return response.json();
                    }).then(data => {
                        if (!data.success) {
                            throw new Error(data.message);
                        }
                        return data;
                    }).catch(error => {
                        console.error("Error Response:", error);
                        Swal.showValidationMessage(error);
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Berhasil!', 'Permintaan Komplain / Retur telah dikirim.', 'success').then(() => {
                        location.reload();
                    });
                }
            });
        }




        function showRatingModal(itemId) {
            Swal.fire({
                title: 'Beri Rating',
                html: `
            <div style="text-align: left;">
                <label><strong>Kesesuaian Ikan:</strong></label>
                <div id="rating_quality" class="rateyo"></div>

                <label><strong>Kondisi Pengiriman:</strong></label>
                <div id="rating_shipping" class="rateyo"></div>

                <label><strong>Pelayanan Seller:</strong></label>
                <div id="rating_service" class="rateyo"></div>

                <label><strong>Ulasan:</strong></label>
                <textarea id="review" class="swal2-textarea" placeholder="Tulis ulasan..."></textarea>

                <!-- Hidden input untuk menyimpan nilai rating -->
                <input type="hidden" id="rating_quality_value">
                <input type="hidden" id="rating_shipping_value">
                <input type="hidden" id="rating_service_value">
            </div>
        `,
                didOpen: () => {
                    // Periksa apakah jQuery sudah dimuat
                    if (typeof $.fn.rateYo === 'undefined') {
                        console.error('RateYo is not loaded!');
                        return;
                    }

                    // Inisialisasi RateYo untuk setiap kategori rating
                    $("#rating_quality").rateYo({
                        rating: 0,
                        fullStar: true,
                        starWidth: "25px",
                        onSet: function(rating) {
                            $("#rating_quality_value").val(rating);
                        }
                    });

                    $("#rating_shipping").rateYo({
                        rating: 0,
                        fullStar: true,
                        starWidth: "25px",
                        onSet: function(rating) {
                            $("#rating_shipping_value").val(rating);
                        }
                    });

                    $("#rating_service").rateYo({
                        rating: 0,
                        fullStar: true,
                        starWidth: "25px",
                        onSet: function(rating) {
                            $("#rating_service_value").val(rating);
                        }
                    });
                },
                showCancelButton: true,
                confirmButtonText: 'Kirim Rating',
                preConfirm: () => {
                    return {
                        rating_quality: $("#rating_quality_value").val(),
                        rating_shipping: $("#rating_shipping_value").val(),
                        rating_service: $("#rating_service_value").val(),
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
                            rating_quality: result.value.rating_quality,
                            rating_shipping: result.value.rating_shipping,
                            rating_service: result.value.rating_service,
                            review: result.value.review
                        })
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            Swal.fire('Sukses!', 'Rating berhasil dikirim.', 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                        }
                    });
                }
            });
        }
    </script>

</x-app-layout>
