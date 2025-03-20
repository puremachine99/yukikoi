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
            // Menampilkan form alasan jika status dipilih "karantina" atau "dibatalkan"
            $("select[name='status']").on("change", function() {
                let itemId = $(this).closest("form").find("input[name='item_id']").val();
                let status = $(this).val();

                $("#karantinaFields-" + itemId).toggle(status === "karantina");
                $("#cancelFields-" + itemId).toggle(status === "dibatalkan");
            });

            // Handle form submission dengan AJAX
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

        });
    </script>



</x-app-layout>
