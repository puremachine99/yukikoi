<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <a href="{{ route('koi.index', ['auction_code' => $auction_code]) }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <i class="fas fa-arrow-left mr-2"></i> List Koi
            </a>

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tambah Koi Lelang #') . $auction_code }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="container mx-auto px-4">
                    <form action="{{ route('koi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="auction_code" value="{{ $auction_code }}">

                        <!-- Wrapper untuk form koi dinamis -->
                        <div id="koiFormWrapper" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Form Koi pertama -->
                            <div class="koi-form p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                <h3 class="text-lg font-semibold mb-4">Koi A</h3>
                                <!-- Input Judul Koi -->
                                <div class="mb-4">
                                    <x-input-label for="judul_koi" :value="__('Judul Koi')" />
                                    <x-text-input name="judul[]" placeholder="Masukkan judul untuk koi"
                                        class="block w-full" />
                                </div>

                                <input type="hidden" name="kode_ikan[]" value="{{ $newKoiCode }}">
                                <!-- Jenis Koi -->
                                <div class="mb-4">
                                    <x-input-label for="jenis_koi" :value="__('Jenis Koi')" />
                                    <x-dropdown-jenis-koi name="jenis_koi[]" ></x-dropdown-jenis-koi>
                                </div>


                                <!-- Ukuran -->
                                <div class="mb-4">
                                    <x-input-label for="ukuran" :value="__('Ukuran (cm)')" />
                                    <x-number-input name="ukuran[]" class="block w-full" required />
                                </div>

                                <!-- Gender -->
                                <div class="mb-4">
                                    <x-input-label :value="__('Gender')" />
                                    <div class="space-y-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="gender[0]" value="Male"
                                                class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                            <span class="ml-2 text-gray-700 dark:text-gray-200">Male</span>
                                        </label>
                                        <label class="inline-flex items-center ml-2">
                                            <input type="radio" name="gender[0]" value="Female"
                                                class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                            <span class="ml-2 text-gray-700 dark:text-gray-200">Female</span>
                                        </label>
                                        <label class="inline-flex items-center ml-2">
                                            <input type="radio" name="gender[0]" value="Unchecked" checked
                                                class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                            <span class="ml-2 text-gray-700 dark:text-gray-200">Unchecked</span>
                                        </label>
                                    </div>
                                </div>


                                <!-- Open Bid -->
                                <div class="mb-4">
                                    <x-input-label for="open_bid" :value="__('Open Bid (dalam ribuan)')" />
                                    <x-number-input name="open_bid[]" class="block w-full"
                                        placeholder="500 untuk Rp500.000" required />
                                </div>

                                <!-- Kelipatan Bid -->
                                <div class="mb-4">
                                    <x-input-label for="kelipatan_bid" :value="__('Kelipatan Bid (dalam ribuan)')" />
                                    <x-number-input name="kelipatan_bid[]" class="block w-full"
                                        placeholder="50 untuk Rp50.000" required />
                                </div>

                                <!-- Buy It Now -->
                                <div class="mb-4">
                                    <x-input-label for="buy_it_now" :value="__('Buy It Now (dalam ribuan)')" />
                                    <x-number-input name="buy_it_now[]" class="block w-full"
                                        placeholder="1000 untuk Rp1.000.000" />
                                </div>

                                <!-- Input Keterangan -->
                                <div class="mb-4">
                                    <x-input-label for="keterangan" :value="__('Keterangan')" />
                                    <textarea name="keterangan[]" rows="2" placeholder="Deskripsi tentang koi"
                                        class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:border-indigo-300 focus:ring-indigo-200 dark:focus:ring-indigo-700"></textarea>
                                </div>

                                <!-- Input Breeder -->
                                <div class="mb-4">
                                    <x-input-label for="breeder" :value="__('Breeder')" />
                                    <x-text-input name="breeder[]" placeholder="Nama Breeder Koi"
                                        class="block w-full" />
                                </div>

                                <!-- Upload Video -->
                                <div class="mb-4">
                                    <x-input-label for="video_koi" :value="__('Video Koi (Max 1)')" />
                                    <x-file-input name="video_koi[0]" class="block w-full video-koi" accept="video/*" />
                                    <!-- Preview video -->
                                    <div class="preview-video mt-2"></div>
                                </div>

                                <!-- Upload Gambar -->
                                <div class="mb-4">
                                    <x-input-label for="gambar_koi" :value="__('Gambar Koi')" />
                                    <x-file-input name="gambar_koi[0][]" class="block w-full gambar-koi"
                                        accept="image/*" multiple />
                                    <!-- Preview gambar -->
                                    <div class="preview-gambar mt-2 grid grid-cols-4 gap-2"></div>
                                </div>

                                <!-- Upload Sertifikat -->
                                <div class="mb-4">
                                    <x-input-label for="sertifikat_koi" :value="__('Sertifikat (Jika Ada)')" />
                                    <x-file-input name="sertifikat_koi[0][]" class="block w-full sertifikat-koi"
                                        accept="image/*" multiple />
                                    <!-- Preview sertifikat -->
                                    <div class="preview-sertifikat mt-2 grid grid-cols-4 gap-2"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Tambah Koi -->
                        <div class="my-4">
                            <x-secondary-button type="button"
                                id="addKoiButton">{{ __('Tambah Koi') }}</x-secondary-button>
                            <x-primary-button type="submit">{{ __('Submit') }}</x-primary-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menghitung kode urutan (A-Z, AA-ZZ, dst.)
        function getKoiCode(index) {
            let code = '';
            while (index >= 0) {
                code = String.fromCharCode(index % 26 + 65) + code;
                index = Math.floor(index / 26) - 1;
            }
            return code;
        }

        // Fungsi untuk menampilkan preview gambar atau sertifikat
        function previewFiles(input, previewElement) {
            previewElement.innerHTML = ''; // Kosongkan preview sebelumnya
            const files = input.files;
            if (files) {
                [...files].forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('w-32', 'h-32', 'object-cover',
                            'rounded'); // Tambahkan class Tailwind
                        previewElement.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        // Fungsi untuk menampilkan preview video
        function previewVideo(input, previewElement) {
            previewElement.innerHTML = ''; // Kosongkan preview sebelumnya
            const file = input.files[0]; // Ambil file pertama (hanya 1 video)
            if (file) {
                const video = document.createElement('video');
                video.src = URL.createObjectURL(file);
                video.classList.add('w-64', 'h-64', 'object-cover', 'rounded'); // Tambahkan class Tailwind
                video.controls = true; // Tambahkan kontrol video
                previewElement.appendChild(video);
            }
        }

        document.getElementById('addKoiButton').addEventListener('click', function() {
            let wrapper = document.getElementById('koiFormWrapper');
            let newKoiForm = wrapper.children[0].cloneNode(true); // Clone form pertama
            let totalForms = wrapper.children.length;
            newKoiForm.querySelector('h3').textContent = `Koi ${getKoiCode(totalForms)}`; // Update heading

            // Update semua "name" dengan index baru
            let inputs = newKoiForm.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                let name = input.getAttribute('name');
                if (name.includes('[0]')) {
                    input.setAttribute('name', name.replace('[0]', `[${totalForms}]`));
                }
            });

            // Set kode ikan (hidden input) menggunakan getKoiCode()
            newKoiForm.querySelector('input[name="kode_ikan[]"]').value = getKoiCode(totalForms);

            wrapper.appendChild(newKoiForm); // Append form baru
            newKoiForm.scrollIntoView({
                behavior: 'smooth'
            }); // Scroll ke form yang baru

            // Tambahkan event listener untuk gambar koi di form baru
            newKoiForm.querySelector('.gambar-koi').addEventListener('change', function() {
                previewFiles(this, newKoiForm.querySelector('.preview-gambar'));
            });

            // Tambahkan event listener untuk sertifikat di form baru
            newKoiForm.querySelector('.sertifikat-koi').addEventListener('change', function() {
                previewFiles(this, newKoiForm.querySelector('.preview-sertifikat'));
            });

            // Tambahkan event listener untuk video koi di form baru
            newKoiForm.querySelector('.video-koi').addEventListener('change', function() {
                previewVideo(this, newKoiForm.querySelector('.preview-video'));
            });
        });

        // Initial preview gambar, sertifikat, dan video untuk form pertama
        document.querySelector('.gambar-koi').addEventListener('change', function() {
            previewFiles(this, document.querySelector('.preview-gambar'));
        });

        document.querySelector('.sertifikat-koi').addEventListener('change', function() {
            previewFiles(this, document.querySelector('.preview-sertifikat'));
        });

        document.querySelector('.video-koi').addEventListener('change', function() {
            previewVideo(this, document.querySelector('.preview-video'));
        });
    </script>

</x-app-layout>
