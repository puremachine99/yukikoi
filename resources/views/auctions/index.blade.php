<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
                {{ __('List Lelangku') }}
            </h2>
            <a href="{{ route('auctions.create') }}"
                class="inline-flex items-center px-4 py-2 bg-zinc-800 dark:bg-zinc-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-zinc-800 uppercase tracking-widest hover:bg-zinc-700 dark:hover:bg-white focus:bg-zinc-700 dark:focus:bg-white active:bg-zinc-900 dark:active:bg-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 transition ease-in-out duration-150">
                {{ __('+ Lelang') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-zinc-800 shadow sm:rounded-lg">


                <!-- Search bar, filter options, and new auction button -->
                <div class="flex justify-between mb-6">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('auctions.index') }}" id="auction-filter-form"
                        class="flex space-x-4 w-full">
                        <!-- Input Search -->
                        <input type="text" name="search" placeholder="Cari lelang..."
                            value="{{ request('search') }}"
                            class="flex-grow px-4 py-2 border rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-gray-200 border-gray-300 dark:border-zinc-600 focus:ring-indigo-500 focus:border-indigo-500">

                        <!-- Dropdown Jenis -->
                        <select name="jenis"
                            class="w-1/5 px-2 py-2 border rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-gray-200 border-gray-300 dark:border-zinc-600 focus:ring-indigo-500 focus:border-indigo-500"
                            id="jenis-filter">
                            <option value="all">Semua Jenis</option>
                            <option value="reguler" {{ request('jenis') == 'reguler' ? 'selected' : '' }}>Reguler
                            </option>
                            <option value="azukari" {{ request('jenis') == 'azukari' ? 'selected' : '' }}>Azukari
                            </option>
                            <option value="keeping" {{ request('jenis') == 'keeping' ? 'selected' : '' }}>Keeping
                                Contest</option>
                            <option value="grow_out" {{ request('jenis') == 'grow_out' ? 'selected' : '' }}>Grow Out
                            </option>
                        </select>

                        <!-- Dropdown Status -->
                        <select name="status"
                            class="w-1/5 px-2 py-2 border rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-gray-200 border-gray-300 dark:border-zinc-600 focus:ring-indigo-500 focus:border-indigo-500"
                            id="status-filter">
                            <option value="all">Semua Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft
                            </option>
                            <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready
                            </option>
                            <option value="on going" {{ request('status') == 'on going' ? 'selected' : '' }}>On
                                Going</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                Completed</option>
                        </select>

                        <!-- Dropdown Sorting -->
                        <select name="sort"
                            class="w-1/5 px-2 py-2 border rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-gray-200 border-gray-300 dark:border-zinc-600 focus:ring-indigo-500 focus:border-indigo-500"
                            id="sort-filter">
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbaru
                            </option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama
                            </option>
                        </select>
                    </form>

                    <!-- Tombol Buat Lelang -->

                </div>

                <!-- Bagian Daftar Lelang -->
                <div id="auction-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @if ($auctions->isEmpty())
                        <p class="text-center col-span-4 text-zinc-600 dark:text-zinc-400">Tidak ada data.</p>
                    @else
                        @include('auctions.partials.auction_list', ['auctions' => $auctions])
                    @endif

                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $auctions->appends(request()->query())->links() }}
                </div>

                <!-- Script untuk AJAX -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script>
                    $(document).ready(function() {
                        // Ketika dropdown filter berubah
                        $('#jenis-filter, #status-filter, #sort-filter').on('change', function() {
                            applyFilter();
                        });

                        // Fungsi untuk apply filter dengan AJAX
                        function applyFilter() {
                            // Ambil data dari form
                            let formData = $('#auction-filter-form').serialize();

                            // Kirim request AJAX ke server
                            $.ajax({
                                url: "{{ route('auctions.index') }}", // Route ke controller index
                                method: "GET",
                                data: formData,
                                success: function(response) {
                                    // Update daftar lelang (bagian #auction-list)
                                    $('#auction-list').html($(response).find('#auction-list').html());
                                },
                                error: function(xhr) {
                                    alert("Gagal mengambil data lelang.");
                                }
                            });
                        }
                    });
                </script>

            </div>
        </div>
    </div>

    <!-- Tambahkan SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script untuk SweetAlert Konfirmasi Hapus -->
    <script>
        document.querySelector('#searchInput').addEventListener('input', function() {
            let searchTerm = this.value.toLowerCase();
    
            // Periksa apakah .auction-item ada di DOM
            document.querySelectorAll('.auction-item').forEach(function(item) {
                let searchData = item.getAttribute('data-search').toLowerCase(); // Pastikan data-search juga lowercase
                if (searchData.includes(searchTerm)) {
                    item.style.display = ''; // Tampilkan item
                } else {
                    item.style.display = 'none'; // Sembunyikan item
                }
            });
        });
    
        function deleteAuction(auctionId) {
            // Tampilkan modal konfirmasi dengan SweetAlert
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Masukkan 'Hapus' untuk melanjutkan.",
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#4A5568', // Sesuaikan dengan primary color dari Tailwind
                cancelButtonColor: '#E53E3E', // Sesuaikan dengan secondary color dari Tailwind
                preConfirm: (inputValue) => {
                    if (inputValue !== 'Hapus') {
                        Swal.showValidationMessage(
                            `Masukkan kata "Hapus" dengan benar untuk menghapus!`
                        );
                        return false;
                    }
                }
            }).then((result) => {
                if (result.isConfirmed && result.value === 'Hapus') {
                    // Lakukan aksi penghapusan dengan fetch
                    fetch(`/auctions/${auctionId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // CSRF Token dari Laravel
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                Swal.fire(
                                    'Dihapus!',
                                    'Lelang telah dihapus.',
                                    'success'
                                ).then(() => {
                                    location.reload(); // Refresh halaman setelah penghapusan
                                });
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    'Lelang gagal dihapus.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Terjadi Kesalahan!',
                                'Terjadi kesalahan saat menghapus lelang.',
                                'error'
                            );
                            console.error(error);
                        });
                }
            });
        }
    </script>
    
</x-app-layout>
