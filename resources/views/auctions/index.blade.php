<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('List Lelangku') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-zinc-800 shadow sm:rounded-lg">
                <div class="p-6 text-zinc-900 dark:text-zinc-100">
                    <!-- Search bar, categories and new auction button -->
                    <div class="flex justify-between mb-6">
                        <input type="text" placeholder="Cari lelang..."
                            class="w-3/5 px-4 py-2 border rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-gray-200 border-gray-300 dark:border-zinc-600 focus:ring-indigo-500 focus:border-indigo-500">
                        <div class="flex items-center space-x-4">
                            <select
                                class="w-5/5 border rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-gray-200 border-gray-300 dark:border-zinc-600 focus:ring-indigo-500 focus:border-indigo-500">
                                <option>Semua Kategori</option>
                                <option>Reguler</option>
                                <option>Azukari</option>
                                <option>Keeping Contest</option>
                                <option>Grow Out</option>
                            </select>
                            <a href="{{ route('auctions.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-zinc-800 dark:bg-zinc-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-zinc-800 uppercase tracking-widest hover:bg-zinc-700 dark:hover:bg-white focus:bg-zinc-700 dark:focus:bg-white active:bg-zinc-900 dark:active:bg-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 transition ease-in-out duration-150">
                                {{ __('Buat Lelang') }}
                            </a>
                        </div>
                    </div>

                    @if ($auctions->isEmpty())
                        <p class="text-zinc-600 dark:text-zinc-400">{{ __('Belum ada lelang.') }}</p>
                    @else
                        <!-- Atur grid responsif: 2 kolom di mobile, 4 kolom di desktop -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($auctions as $auction)
                                <div class="border rounded-lg p-4 dark:bg-zinc-700 flex flex-col justify-between">
                                    <!-- Gambar Banner atau Placeholder -->
                                    @if ($auction->banner)
                                        <div class="bg-gray-300 w-full relative overflow-hidden"
                                            style="padding-top: 100%;">
                                            <img src="{{ asset('storage/' . $auction->banner) }}"
                                                alt="{{ $auction->title }}"
                                                class="absolute top-0 left-0 w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="bg-gray-300 w-full relative overflow-hidden"
                                            style="padding-top: 100%;">
                                            <div
                                                class="absolute top-0 left-0 w-full h-full flex items-center justify-center">
                                                {{ __('No Image') }}
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Kode Lelang, Judul dan Jenis -->
                                    <h3 class="text-base font-semibold mt-4">{{ $auction->auction_code }} -
                                        {{ $auction->title }} - {{ ucfirst($auction->jenis) }}</h3>

                                    <!-- Status Lelang -->
                                    <p class="mt-2 text-xs">
                                        <span class="font-bold">{{ __('Status') }}: </span>
                                        <span
                                            class="{{ $auction->status == 'draft' ? 'text-yellow-500' : ($auction->status == 'ready' ? 'text-white' : ($auction->status == 'on going' ? 'text-red-500' : 'text-green-500')) }}">
                                            {{ ucfirst($auction->status) }}
                                        </span>
                                    </p>

                                    <!-- Waktu Lelang -->
                                    <p class="mt-2 text-xs">
                                        <span class="font-bold">{{ __('Waktu') }}: </span>
                                        {{ \Carbon\Carbon::parse($auction->start_time)->format('d M Y H:i') }} -
                                        {{ \Carbon\Carbon::parse($auction->end_time)->format('d M Y H:i') }} +10
                                        menit/bid
                                    </p>

                                    <!-- Deskripsi -->
                                    <p class="mt-4 text-xs">{{ Str::limit($auction->description, 150, '...') }}</p>

                                    <!-- Tombol Aksi dalam 2 kolom 2 baris dengan ikon Font Awesome -->
                                    <div class="grid grid-cols-2 gap-2 mt-6">
                                        <!-- Tombol Edit dengan ikon pensil -->
                                        <a href="{{ route('auctions.edit', ['auction' => $auction->auction_code]) }}"
                                            class="flex items-center justify-center px-4 py-2 bg-zinc-800 dark:bg-zinc-300 border border-zinc-300 dark:border-zinc-500 rounded-md font-sans text-xs text-white uppercase tracking-widest shadow-sm hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <i class="fas fa-pencil-alt mr-2"></i>
                                            {{ __('Edit') }}
                                        </a>

                                        <!-- Tombol Tambah Koi dengan ikon ikan -->
                                        <a href="{{ route('koi.create', ['auction_id' => $auction->id, 'auction_code' => $auction->auction_code]) }}"
                                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-500 rounded-md font-sans text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-widest shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 disabled:opacity-25 transition ease-in-out duration-150">
                                            <i class="fas fa-fish mr-2"></i>
                                            {{ __('+ Koi') }}
                                        </a>

                                        <!-- Tombol Hapus dengan ikon tong sampah -->
                                        <x-danger-button>
                                            <i class="fas fa-trash-alt mr-2"></i>
                                            {{ __('Hapus') }}
                                        </x-danger-button>

                                        <!-- Tombol List Koi dengan ikon daftar -->
                                        <a href="{{ route('koi.index', ['auction_id' => $auction->id]) }}"
                                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-500 rounded-md font-sans text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-widest shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 disabled:opacity-25 transition ease-in-out duration-150">
                                            <i class="fas fa-list mr-2"></i>
                                            {{ __('List Koi') }}
                                        </a>
                                    </div>
                                    <!-- Tombol Start Lelang full width di bawah -->
                                    <form action="{{ route('auctions.start', ['auction' => $auction->id]) }}"
                                        method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center justify-center w-full px-4 py-2 bg-zinc-800 dark:bg-zinc-200 border border-transparent rounded-md font-sans text-xs text-white dark:text-zinc-800 uppercase tracking-widest hover:bg-zinc-700 dark:hover:bg-white focus:bg-zinc-700 dark:focus:bg-white active:bg-zinc-900 dark:active:bg-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 transition ease-in-out duration-150">

                                            <i class="fas fa-flag-checkered mr-2"></i> Start
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script untuk hapus auction menggunakan SweetAlert dengan input -->
    <script>
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
                        )
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan aksi penghapusan dengan fetch
                    fetch(`/auctions/${auctionId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // CSRF Token dari Laravel
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
            })
        }
    </script>
</x-app-layout>
