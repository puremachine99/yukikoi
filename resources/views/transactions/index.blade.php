<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-cyan-800 dark:text-cyan-100 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            {{ __('Daftar Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-t-4 border-teal-500">

                <!-- Tab Navigation with Aquatic Style -->
                <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex space-x-2">
                        @foreach ($tabs as $key => $label)
                            <a href="{{ route('transactions.index', ['status' => $key]) }}"
                                class="px-4 py-2 rounded-t-lg transition-colors duration-200 {{ $status === $key
                                    ? 'bg-teal-100 dark:bg-teal-900 text-teal-800 dark:text-teal-100 border-b-2 border-teal-500 font-semibold'
                                    : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                {{ $label }}
                                @if ($transactionCounts[$key] ?? false)
                                    <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-teal-500 text-white">
                                        {{ $transactionCounts[$key] }}
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </nav>
                </div>

                <!-- Grouped Transactions by Farm -->
                @forelse ($groupedTransactions as $farmName => $transactions)
                    <div
                        class="mb-8 bg-gradient-to-r from-cyan-50 to-teal-50 dark:from-gray-700 dark:to-gray-800 p-5 rounded-xl shadow-md border border-cyan-100 dark:border-gray-600">
                        <!-- Seller Info with Aquatic Accent -->
                        <div
                            class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 p-3 bg-white dark:bg-gray-700 rounded-lg shadow-sm">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 mr-2 text-cyan-600 dark:text-cyan-400" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <h4 class="text-lg font-semibold text-cyan-800 dark:text-cyan-100">
                                        {{ $farmName }}
                                    </h4>
                                </div>
                                @if ($transactions->first()?->transactionItems->first()?->koi?->auction?->user)
                                    <div class="mt-2 flex flex-wrap gap-x-4">
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $transactions->first()->transactionItems->first()->koi->auction->user->name }}
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            {{ $transactions->first()->transactionItems->first()->koi->auction->user->phone_number ?? '-' }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-3 md:mt-0 text-right">
                                <div class="text-lg font-bold text-teal-600 dark:text-teal-300">
                                    Total Pesanan: Rp
                                    {{ number_format($transactions->sum('total_with_fees'), 0, ',', '.') }}
                                </div>
                                <a href="#"
                                    class="inline-flex items-center mt-2 text-sm text-cyan-600 dark:text-cyan-400 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                    Kunjungi Toko
                                </a>
                            </div>

                        </div>

                        <!-- Transaction List -->
                        <div class="space-y-4">
                            @foreach ($transactions as $transaction)
                                @foreach ($transaction->transactionItems as $item)
                                    <x-transaction-koi-card :item="$item" />

                                    <!-- Accordion Riwayat Status -->
                                    <div class="mt-2 bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden">
                                        <button
                                            class="toggle-accordion w-full flex justify-between items-center p-3 text-sm font-medium text-left text-cyan-700 dark:text-cyan-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200"
                                            data-target="statusHistory-{{ $item->id }}">
                                            <span>Riwayat Status</span>
                                            <svg class="w-4 h-4 transform transition-transform duration-200"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div id="statusHistory-{{ $item->id }}" class="hidden">
                                            <div class="p-4 border-t border-gray-200 dark:border-gray-600">
                                                <ol class="relative border-l border-cyan-200 dark:border-cyan-800">
                                                    @forelse($item->statusHistories->sortByDesc('created_at') as $history)
                                                        <li class="mb-4 ml-4">
                                                            <div
                                                                class="absolute w-3 h-3 bg-cyan-400 dark:bg-cyan-600 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-700">
                                                            </div>
                                                            <time
                                                                class="text-xs text-gray-500 dark:text-gray-400">{{ $history->created_at->format('d M Y, H:i') }}</time>
                                                            <h3
                                                                class="text-sm font-semibold text-gray-900 dark:text-white">
                                                                {{ ucfirst($history->status) }}
                                                                @if ($history->reason)
                                                                    <small
                                                                        class="text-xs font-normal text-gray-500 dark:text-gray-400">({{ $history->reason }})</small>
                                                                @endif
                                                            </h3>
                                                            @if ($history->status === 'dibatalkan' && $history->video_url)
                                                                <button
                                                                    onclick="showCancelVideoModal('{{ $history->video_url }}')"
                                                                    class="mt-1 text-xs text-cyan-600 dark:text-cyan-400 hover:underline">
                                                                    Lihat Bukti Video
                                                                </button>
                                                            @endif
                                                        </li>
                                                    @empty
                                                        <li class="ml-4 text-sm text-gray-500 dark:text-gray-400">Belum
                                                            ada riwayat.</li>
                                                    @endforelse
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>

                    </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="mx-auto w-24 h-24 text-gray-400 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-700 dark:text-gray-300">Tidak ada transaksi
                                ditemukan</h3>
                            <p class="mt-1 text-gray-500 dark:text-gray-400">Transaksi yang sesuai dengan filter akan muncul
                                di sini</p>
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
                    $(this).find('svg').toggleClass('rotate-180');
                });

                // **Update Status Pesanan dengan AJAX**
                function updateStatus(itemId) {
                    Swal.fire({
                        title: 'Konfirmasi Penyelesaian',
                        text: "Apakah Anda yakin ingin menyelesaikan transaksi ini?",
                        icon: 'question',
                        iconColor: '#0d9488',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Selesaikan',
                        confirmButtonColor: '#0d9488',
                        cancelButtonText: 'Batal',
                        background: localStorage.theme === 'dark' ? '#1f2937' : '#ffffff',
                        color: localStorage.theme === 'dark' ? '#ffffff' : '#111827'
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
                                        background: localStorage.theme === 'dark' ?
                                            '#1f2937' : '#ffffff',
                                        color: localStorage.theme === 'dark' ? '#ffffff' :
                                            '#111827',
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
                                        timer: 2000,
                                        background: localStorage.theme === 'dark' ?
                                            '#1f2937' : '#ffffff',
                                        color: localStorage.theme === 'dark' ? '#ffffff' :
                                            '#111827'
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
                                        text: errorMessage,
                                        background: localStorage.theme === 'dark' ?
                                            '#1f2937' : '#ffffff',
                                        color: localStorage.theme === 'dark' ? '#ffffff' :
                                            '#111827'
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
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-3">Kesesuaian Ikan:</label>
                            <div id="rating_quality" class="rateyo"></div>
                            <input type="hidden" id="rating_quality_value">
    
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-3">Kondisi Pengiriman:</label>
                            <div id="rating_shipping" class="rateyo"></div>
                            <input type="hidden" id="rating_shipping_value">
    
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-3">Pelayanan Seller:</label>
                            <div id="rating_service" class="rateyo"></div>
                            <input type="hidden" id="rating_service_value">
    
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-3">Ulasan:</label>
                            <textarea id="review" class="swal2-textarea dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" placeholder="Tulis ulasan..."></textarea>
                        </div>
                    `,
                        didOpen: () => {
                            $(".rateyo").rateYo({
                                rating: 0,
                                fullStar: true,
                                starWidth: "25px",
                                normalFill: "#d1d5db",
                                ratedFill: "#f59e0b",
                                onSet: function(rating, rateYoInstance) {
                                    $(rateYoInstance.node).siblings("input").val(rating);
                                }
                            });
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Kirim Rating',
                        confirmButtonColor: '#0d9488',
                        background: localStorage.theme === 'dark' ? '#1f2937' : '#ffffff',
                        color: localStorage.theme === 'dark' ? '#ffffff' : '#111827',
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
                                    Swal.fire({
                                        title: "Sukses!",
                                        text: "Rating berhasil dikirim.",
                                        icon: "success",
                                        background: localStorage.theme === 'dark' ?
                                            '#1f2937' : '#ffffff',
                                        color: localStorage.theme === 'dark' ? '#ffffff' :
                                            '#111827'
                                    }).then(() => location.reload());
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
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Permintaan:</label>
                            <select id="complaintType" class="swal2-input dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                                <option value="retur">Retur (Barang Tidak Sesuai / Ikan Mati)</option>
                                <option value="komplain">Komplain (Pelayanan Buruk / Lainnya)</option>
                            </select>
    
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-3">Alasan:</label>
                            <textarea id="reason" class="swal2-textarea dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" placeholder="Jelaskan alasan..."></textarea>
    
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-3">Unggah Bukti (Max 50MB, Video/Gambar):</label>
                            <input type="file" id="proof" class="swal2-file dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" accept="video/*,image/*">
                        </div>
                    `,
                        showCancelButton: true,
                        confirmButtonText: 'Kirim Permintaan',
                        confirmButtonColor: '#0d9488',
                        cancelButtonText: 'Batal',
                        background: localStorage.theme === 'dark' ? '#1f2937' : '#ffffff',
                        color: localStorage.theme === 'dark' ? '#ffffff' : '#111827',
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
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Permintaan Komplain / Retur telah dikirim.',
                                icon: 'success',
                                background: localStorage.theme === 'dark' ? '#1f2937' : '#ffffff',
                                color: localStorage.theme === 'dark' ? '#ffffff' : '#111827'
                            }).then(() => {
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
                <div class="bg-black rounded-lg overflow-hidden">
                    <video controls style="width:100%;">
                        <source src="${videoUrl}" type="video/mp4">
                        Browser Anda tidak mendukung video.
                    </video>
                </div>
                `,
                    showCloseButton: true,
                    showConfirmButton: false,
                    width: '600px',
                    background: localStorage.theme === 'dark' ? '#1f2937' : '#ffffff',
                    color: localStorage.theme === 'dark' ? '#ffffff' : '#111827'
                });
            }
        </script>
    </x-app-layout>
