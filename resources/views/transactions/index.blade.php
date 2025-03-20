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
        $(document).ready(function() {
            $(".toggle-accordion").on("click", function() {
                let target = $(this).data("target");
                $("#" + target).toggleClass("hidden");
            });

            function updateStatus(itemId, status) {
                Swal.fire({
                    title: 'Konfirmasi Status',
                    text: "Apakah Anda yakin ingin mengubah status menjadi " + status + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Ubah',
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
                                status: status
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
        });
    </script>


</x-app-layout>
