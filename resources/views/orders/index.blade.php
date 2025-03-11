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
        function toggleAccordion(id) {
            document.getElementById(id).classList.toggle("hidden");
        }

        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif
        });

        // AJAX Update Status dengan SweetAlert
        document.querySelectorAll("form[data-ajax='true']").forEach(form => {
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let action = this.getAttribute("action");

                fetch(action, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json"
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 3000
                            });

                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: "Terjadi kesalahan saat memperbarui status."
                        });
                    });
            });
        });
    </script>

</x-app-layout>
