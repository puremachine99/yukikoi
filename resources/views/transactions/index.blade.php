<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">

                <!-- Tab Navigation -->
                <div class="mb-4 border-b">
                    <nav class="flex space-x-4">
                        @foreach ($tabs as $key => $label)
                            <a href="{{ route('transactions.index', ['status' => $key]) }}"
                                class="px-4 py-2 border-b-2 {{ $status === $key ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </nav>
                </div>

                <!-- Grouped Transactions by Farm -->
                @forelse ($groupedTransactions as $farmName => $transactions)
                    <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                        <!-- Seller Info -->
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                    {{ $farmName }}
                                </h4>
                                @if ($transactions->first()?->transactionItems->first()?->koi?->auction?->user)
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <p>{{ $transactions->first()->transactionItems->first()->koi->auction->user->name }}
                                        </p>
                                        <p>{{ $transactions->first()->transactionItems->first()->koi->auction->user->phone_number ?? '-' }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <div class="mt-4">
                                    <p class="font-semibold text-gray-800 dark:text-gray-100">
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
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        <p>Tidak ada transaksi ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            // **Toggles Accordion untuk Riwayat Status**
            $(".toggle-accordion").on("click", function() {
                let target = $(this).data("target");
                $("#" + target).toggleClass("hidden");
            });

            // **Update Status Pesanan dengan AJAX**
            function updateStatus(itemId) {
                Swal.fire({
                    title: 'Konfirmasi Penyelesaian',
                    text: "Apakah Anda yakin ingin menyelesaikan transaksi ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Selesaikan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('transactions.updateStatus') }}",
                            type: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            data: JSON.stringify({
                                item_id: itemId,
                                status: "selesai"
                            }),
                            contentType: "application/json",
                            beforeSend: function() {
                                Swal.fire({
                                    title: "Memproses...",
                                    text: "Mohon tunggu sebentar",
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    },
                                });
                            },
                            success: function(data) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil!",
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => {
                                    if (data.nextAction === "showRatingModal") {
                                        showRatingModal(itemId);
                                    } else {
                                        location.reload();
                                    }
                                });
                            },
                            error: function(xhr) {
                                let errorMessage = "Terjadi kesalahan saat memperbarui status.";
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    icon: "error",
                                    title: "Gagal!",
                                    text: errorMessage
                                });
                            }
                        });
                    }
                });
            }
            // **Menampilkan Modal Rating**
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
    
                            <input type="hidden" id="rating_quality_value">
                            <input type="hidden" id="rating_shipping_value">
                            <input type="hidden" id="rating_service_value">
                        </div>
                    `,
                    didOpen: () => {
                        $(".rateyo").rateYo({
                            rating: 0,
                            fullStar: true,
                            starWidth: "25px",
                            onSet: function(rating, rateYoInstance) {
                                $(rateYoInstance.node).siblings("input").val(rating);
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
                            review: $("#review").val()
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('transactions.rate') }}",
                            type: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            data: JSON.stringify({
                                transaction_item_id: itemId,
                                rating_quality: result.value.rating_quality,
                                rating_shipping: result.value.rating_shipping,
                                rating_service: result.value.rating_service,
                                review: result.value.review
                            }),
                            contentType: "application/json",
                            success: function() {
                                Swal.fire("Sukses!", "Rating berhasil dikirim.", "success")
                                    .then(() => location.reload());
                            }
                        });
                    }
                });
            }

            // **Menampilkan Modal Komplain**
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
                        const complaintType = $("#complaintType").val();
                        const reason = $("#reason").val().trim();
                        const proof = $("#proof")[0].files[0];

                        if (!reason) {
                            Swal.showValidationMessage('Alasan tidak boleh kosong!');
                            return false;
                        }

                        if (!proof) {
                            Swal.showValidationMessage('Bukti harus diunggah!');
                            return false;
                        }

                        let formData = new FormData();
                        formData.append('item_id', itemId);
                        formData.append('type', complaintType);
                        formData.append('reason', reason);
                        formData.append('proof', proof);
                        formData.append('_token', $('meta[name="csrf-token"]').attr("content"));

                        return $.ajax({
                            url: "{{ route('complaints.store') }}",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false
                        }).then(response => {
                            if (!response.success) {
                                throw new Error(response.message);
                            }
                            return response;
                        }).catch(error => {
                            Swal.showValidationMessage(error.message);
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Berhasil!', 'Permintaan Komplain / Retur telah dikirim.', 'success')
                            .then(() => {
                                location.reload();
                            });
                    }
                });
            }

            // **Expose function ke global scope**
            window.updateStatus = updateStatus;
            window.showRatingModal = showRatingModal;
            window.showComplaintModal = showComplaintModal;
        });

        function showCancelVideoModal(videoUrl) {
            Swal.fire({
                title: 'Bukti Video Pembatalan',
                html: `
                <video controls style="width:100%;border-radius:8px;">
                    <source src="${videoUrl}" type="video/mp4">
                    Browser Anda tidak mendukung video.
                </video>
                `,
                showCloseButton: true,
                showConfirmButton: false,
                width: '600px'
            });
        }
    </script>

</x-app-layout>
