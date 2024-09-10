<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('Daftar Koi untuk Lelang #') . $auction_id }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="container mx-auto px-4">
            @if ($kois->isEmpty())
                <p class="text-zinc-600 dark:text-zinc-400">{{ __('Belum ada koi di lelang ini.') }}</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($kois as $koi)
                        <div class="relative border rounded-lg p-4 dark:bg-zinc-700">
                            <!-- Tombol delete di kanan atas -->
                            <button
                                class="absolute top-2 right-2 bg-zinc-500 text-white rounded-full px-2 py-1 delete-koi-btn transition-transform transform hover:scale-110 active:scale-100"
                                style="z-index: 99" data-koi-id="{{ $koi->id }}"
                                data-koi-name="{{ $koi->jenis_koi }}">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>

                            <!-- Carousel untuk gambar dan video -->
                            <div x-data="{
                                activeSlide: 0,
                                slides: [
                                    @foreach ($koi->media as $media)
                                    '{{ asset('storage/' . $media->url_media) }}', @endforeach
                                ]
                            }" class="relative w-full overflow-hidden rounded-lg shadow-lg">
                                <!-- Carousel wrapper -->
                                <div class="relative h-64">
                                    <template x-for="(slide, index) in slides" :key="index">
                                        <div x-show="activeSlide === index" class="absolute inset-0">
                                            <template x-if="slide.endsWith('.mp4')">
                                                <video controls class="w-full h-full object-cover rounded-lg">
                                                    <source :src="slide" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </template>
                                            <template x-if="!slide.endsWith('.mp4')">
                                                <img :src="slide" alt="Koi Media"
                                                    class="w-full h-full object-cover rounded-lg">
                                            </template>
                                        </div>
                                    </template>
                                </div>

                                <!-- Slider controls -->
                                <div class="absolute inset-0 flex items-center justify-between px-4">
                                    <button
                                        @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1"
                                        class="bg-black bg-opacity-50 text-white p-2 rounded-full">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>
                                    <button
                                        @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1"
                                        class="bg-black bg-opacity-50 text-white p-2 rounded-full">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Detail Koi -->
                            <h3 class="text-lg font-semibold mt-4">{{ $koi->jenis_koi }}</h3>
                            <p class="text-sm">{{ __('Ukuran: ') . $koi->ukuran }} cm</p>
                            <p class="text-sm">{{ __('Gender: ') . ucfirst($koi->gender) }}</p>
                            <p class="text-sm">
                                {{ __('Open Bid: Rp') . number_format($koi->open_bid * 1000, 0, ',', '.') }}</p>
                            <p class="text-sm">
                                {{ __('Kelipatan Bid: Rp') . number_format($koi->kelipatan_bid * 1000, 0, ',', '.') }}
                            </p>
                            @if ($koi->buy_it_now)
                                <p class="text-sm">
                                    {{ __('Buy It Now: Rp') . number_format($koi->buy_it_now * 1000, 0, ',', '.') }}
                                </p>
                            @endif

                            <!-- Tombol Sertifikat -->
                            @if ($koi->certificates->isNotEmpty())
                                <div class="mt-4">
                                    @foreach ($koi->certificates as $index => $certificate)
                                        <button
                                            onclick="openModal('{{ asset('storage/' . $certificate->url_gambar) }}')"
                                            class="bg-blue-500 text-white px-3 py-1 rounded-md text-sm">
                                            Sertifikat {{ $index + 1 }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Modal untuk Sertifikat -->
    <div id="certModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white dark:bg-zinc-800 p-4 rounded-lg max-w-md w-full">
            <button onclick="closeModal()" class="text-right text-red-500 font-bold">X</button>
            <img id="certImage" src="" alt="Certificate Image" class="w-full mt-4 rounded-lg">
        </div>
    </div>

    <!-- Modal and Alpine.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openModal(imageUrl) {
            document.getElementById('certImage').src = imageUrl;
            document.getElementById('certModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('certModal').classList.add('hidden');
        }

        // Fungsi untuk menangani tombol hapus dan sweetalert
        document.querySelectorAll('.delete-koi-btn').forEach(button => {
            button.addEventListener('click', function() {
                const koiId = this.getAttribute('data-koi-id');
                const koiName = this.getAttribute('data-koi-name');

                Swal.fire({
                    title: 'Yakin mau hapus ikan?',
                    text: `Nama Koi: ${koiName}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Lakukan penghapusan via form atau AJAX
                        deleteKoi(koiId);
                    }
                });
            });
        });

        function deleteKoi(koiId) {
            console.log(`Deleting koi with ID: ${koiId}`); // Debugging

            fetch(`/koi/${koiId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Debugging untuk response
                    if (data.success) {
                        location.reload(); // Reload halaman jika sukses
                    } else {
                        Swal.fire('Error', 'Gagal menghapus Koi', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
</x-app-layout>
