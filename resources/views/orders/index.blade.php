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
        $(document).ready(function() {
            $(".toggle-accordion").on("click", function() {
                let target = $(this).data("target");
                $("#" + target).toggleClass("hidden");
            });

            $("select[name='status']").on("change", function() {
                let itemId = $(this).closest("form").find("input[name='item_id']").val();
                let status = $(this).val();

                $("#karantinaFields-" + itemId).toggle(status === "karantina");
                $("#cancelFields-" + itemId).toggle(status === "dibatalkan");
            });

            $("form[data-ajax='true']").on("submit", function(e) {
                e.preventDefault(); // Mencegah redirect ke halaman baru

                let formData = new FormData(this);
                let action = $(this).attr("action");

                $.ajax({
                    url: action,
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
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
                                showRatingModal(formData.get("item_id"));
                            } else if (data.redirect) {
                                window.location.href = data
                                    .redirect; // Redirect ke halaman sesuai peran
                            } else {
                                location.reload(); // Reload halaman setelah sukses
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
            });
            // Trigger modal berdasarkan perubahan select status
            $("select[name='status']").on("change", function() {
                const selected = $(this).val();
                const itemId = $(this).closest("form").find("input[name='item_id']").val();

                if (selected === "karantina") {
                    showKarantinaModal(itemId);
                } else if (selected === "dibatalkan") {
                    showCancelModal(itemId);
                }
            });

            function showKarantinaModal(itemId) {
                Swal.fire({
                    title: 'Alasan Karantina',
                    input: 'select',
                    inputOptions: {
                        'Ikan Sakit (7 hari)': 'Ikan Sakit (7 hari)',
                        'Ikan Buang Kotoran (3 hari)': 'Ikan Buang Kotoran (3 hari)'
                    },
                    inputPlaceholder: 'Pilih alasan karantina',
                    showCancelButton: true,
                    confirmButtonText: 'Karantina',
                    cancelButtonText: 'Batal',
                    preConfirm: (reason) => {
                        if (!reason) {
                            Swal.showValidationMessage('Alasan harus dipilih!');
                            return false;
                        }

                        return $.ajax({
                            url: "{{ route('orders.updateStatus') }}",
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            contentType: "application/json",
                            data: JSON.stringify({
                                item_id: itemId,
                                status: "karantina",
                                reason: reason
                            })
                        }).then(res => {
                            if (!res.success) {
                                throw new Error(res.message);
                            }
                            return res;
                        }).catch(error => {
                            Swal.showValidationMessage(error.message);
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Berhasil!', 'Status diubah menjadi karantina.', 'success')
                            .then(() => location.reload());
                    }
                });
            }

            function showCancelModal(itemId) {
                Swal.fire({
                    title: 'Pembatalan Pesanan',
                    html: `
                        <label class="block text-sm text-left font-medium text-gray-700 mb-1">Alasan Pembatalan:</label>
                        <textarea id="cancel_reason" class="swal2-textarea" placeholder="Tulis alasan pembatalan..."></textarea>

                        <label class="block text-sm text-left font-medium text-gray-700 mt-2 mb-1">Upload Bukti Video:</label>
                        <input type="file" id="cancel_video" class="swal2-file" accept="video/*">
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Kirim Pembatalan',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        const reason = $('#cancel_reason').val().trim();
                        const file = $('#cancel_video')[0].files[0];

                        if (!reason) {
                            Swal.showValidationMessage('Alasan wajib diisi.');
                            return false;
                        }

                        if (!file) {
                            Swal.showValidationMessage('Bukti video wajib diunggah.');
                            return false;
                        }

                        let formData = new FormData();
                        formData.append("video", file);

                        // Upload video dulu
                        return fetch("{{ route('upload.cancel.video') }}", {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                                },
                                body: formData
                            })
                            .then(response => response.json())
                            .then(uploadResult => {
                                if (!uploadResult.success) throw new Error("Gagal upload video");

                                // Lanjut update status
                                return fetch("{{ route('orders.updateStatus') }}", {
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                            "content"),
                                        "Content-Type": "application/json"
                                    },
                                    body: JSON.stringify({
                                        item_id: itemId,
                                        status: "dibatalkan",
                                        reason: JSON.stringify({
                                            reason: reason,
                                            video_url: uploadResult.path
                                        })
                                    })
                                }).then(res => res.json());
                            })
                            .catch(error => {
                                Swal.showValidationMessage(error.message);
                            });
                    }
                }).then((result) => {
                    if (result.isConfirmed && result.value.success) {
                        Swal.fire('Berhasil!', 'Pesanan dibatalkan dengan bukti.', 'success').then(() => {
                            location.reload();
                        });
                    }
                });
            }
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
