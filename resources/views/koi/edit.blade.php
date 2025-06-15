{{-- Route::get('/koi/{auction_code}/{id}/edit', [KoiController::class, 'edit'])->name('koi.edit') --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Koi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form action="{{ route('koi.update', $koi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="auction_code" value="{{ $auction_code }}">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Informasi Dasar -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 border-b-2">Informasi Koi
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Judul -->
                            <div>
                                <x-input-label for="judul" :value="__('Judul')" />
                                <x-text-input name="judul" id="judul" value="{{ $koi->judul }}"
                                    class="block w-full" required />
                            </div>

                            <!-- Jenis Koi -->
                            <div>
                                <x-input-label for="jenis_koi" :value="__('Jenis Koi')" />
                                <x-dropdown-jenis-koi name="jenis_koi" selected="{{ $koi->jenis_koi }}"
                                    class="block w-full" />
                            </div>

                            <!-- Ukuran -->
                            <div>
                                <x-input-label for="ukuran" :value="__('Ukuran (cm)')" />
                                <x-text-input name="ukuran" id="ukuran" value="{{ $koi->ukuran }}"
                                    class="block w-full" required />
                            </div>

                            <!-- Gender -->
                            <div>
                                <x-input-label for="gender" :value="__('Gender')" />
                                <x-select name="gender" id="gender" class="block w-full">
                                    <option value="Male" {{ $koi->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $koi->gender == 'Female' ? 'selected' : '' }}>Female
                                    </option>
                                    <option value="Unchecked" {{ $koi->gender == 'Unchecked' ? 'selected' : '' }}>
                                        Unchecked</option>
                                </x-select>
                            </div>
                        </div>
                    </div>

                    <!-- Bid dan Buy It Now -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 border-b-2">Bid dan Harga
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="open_bid" :value="__('OB / Open Bid (ribu)')" />
                                <x-text-input name="open_bid" id="open_bid"
                                    value="{{ number_format($koi->open_bid, 0, '.', '') }}" class="block w-full"
                                    min="0" step="5" type="number" required />
                            </div>

                            <div>
                                <x-input-label for="kelipatan_bid" :value="__('KB / Kelipatan Bid (ribu)')" />
                                <x-text-input name="kelipatan_bid" id="kelipatan_bid"
                                    value="{{ number_format($koi->kelipatan_bid, 0, '.', '') }}" class="block w-full"
                                    min="0" step="5" type="number" required />
                            </div>

                            <div>
                                <x-input-label for="buy_it_now" :value="__('BIN / Buy It Now (ribu)')" />
                                <x-text-input name="buy_it_now" id="buy_it_now"
                                    value="{{ number_format($koi->buy_it_now, 0, '.', '') }}" class="block w-full"
                                    min="0" step="5" type="number" />
                            </div>
                        </div>
                    </div>

                    <!-- Media (Foto & Video) -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Media</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($media as $item)
                                <div class="relative" id="media-{{ $item->id }}">
                                    @if ($item->media_type === 'photo')
                                        <img src="{{ asset('storage/' . $item->url_media) }}" alt="Koi Photo"
                                            class="w-full h-48 object-cover rounded-md">
                                    @else
                                        <video controls class="w-full h-48 rounded-md">
                                            <source src="{{ asset('storage/' . $item->url_media) }}" type="video/mp4">
                                        </video>
                                    @endif

                                    <button type="button" onclick="deleteMedia('{{ $item->id }}')"
                                        class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-md text-xs hover:bg-red-600">
                                        Hapus
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <!-- Upload Baru -->
                        <div class="mt-4">
                            <x-input-label for="media" :value="__('Upload Foto atau Video Baru')" />
                            <input type="file" name="media[]" id="media" class="block w-full border rounded-md"
                                multiple accept="image/*,video/*" onchange="previewMedia(this)">
                            <p class="text-sm text-gray-500 mt-1">Format yang didukung: JPG, PNG, MP4. Maks: 10MB.</p>
                            <div id="previewMedia" class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                        </div>


                    </div>

                    <!-- Sertifikat -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Sertifikat</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($certificates as $certificate)
                                <div class="relative" id="certificate-{{ $certificate->id }}">
                                    <img src="{{ asset('storage/' . $certificate->url_gambar) }}" alt="Certificate"
                                        class="w-full h-48 object-cover rounded-md">
                                    <button type="button" onclick="deleteCertificate('{{ $certificate->id }}')"
                                        class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-md text-xs hover:bg-red-600">
                                        Hapus
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <!-- Upload Baru -->
                        <div class="mt-4">
                            <x-input-label for="certificates" :value="__('Upload Sertifikat Baru')" />
                            <input type="file" name="certificates[]" id="certificates"
                                class="block w-full border rounded-md" multiple accept="image/*"
                                onchange="previewCertificates(this)">
                            <p class="text-sm text-gray-500 mt-1">Format yang didukung: JPG, PNG. Maks: 1MB.</p>
                            <div id="previewCertificates" class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end">
                        <x-primary-button class="ml-4">
                            {{ __('Update Koi') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Preview Media
        function previewMedia(input) {
            const previewContainer = document.getElementById('previewMedia');
            previewContainer.innerHTML = '';
            const files = input.files;
            Array.from(files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    if (file.type.startsWith('video')) {
                        const video = document.createElement('video');
                        video.src = e.target.result;
                        video.controls = true;
                        video.className = 'w-64 h-64 rounded-md';
                        previewContainer.appendChild(video);
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-32 h-32 rounded-md';
                        previewContainer.appendChild(img);
                    }
                };
                reader.readAsDataURL(file);
            });
        }

        // Preview Certificates
        function previewCertificates(input) {
            const previewContainer = document.getElementById('previewCertificates');
            previewContainer.innerHTML = '';
            const files = input.files;
            Array.from(files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-32 h-32 rounded-md';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }

        // Hapus Media dengan SweetAlert
        function deleteMedia(mediaId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Media ini akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/media/${mediaId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                Swal.fire(
                                    'Dihapus!',
                                    'Media berhasil dihapus.',
                                    'success'
                                );
                                document.getElementById(`media-${mediaId}`).remove();
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    'Media tidak dapat dihapus.',
                                    'error'
                                );
                            }
                        })
                        .catch(() => {
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat menghapus media.',
                                'error'
                            );
                        });
                }
            });
        }

        // Hapus Sertifikat dengan SweetAlert
        function deleteCertificate(certificateId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Sertifikat ini akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/certificates/${certificateId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                Swal.fire(
                                    'Dihapus!',
                                    'Sertifikat berhasil dihapus.',
                                    'success'
                                );
                                document.getElementById(`certificate-${certificateId}`).remove();
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    'Sertifikat tidak dapat dihapus.',
                                    'error'
                                );
                            }
                        })
                        .catch(() => {
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat menghapus sertifikat.',
                                'error'
                            );
                        });
                }
            });
        }


        // Preview Media dengan tombol batal
        function previewMedia(input) {
            const previewContainer = document.getElementById('previewMedia');
            previewContainer.innerHTML = '';
            const files = Array.from(input.files);
            const updatedFiles = new DataTransfer();

            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const container = document.createElement('div');
                    container.classList.add('relative', 'inline-block', 'w-32', 'h-32', 'rounded-md',
                        'overflow-hidden', 'bg-gray-100', 'dark:bg-gray-700');

                    if (file.type.startsWith('video')) {
                        const video = document.createElement('video');
                        video.src = e.target.result;
                        video.controls = true;
                        video.className = 'w-full h-full object-cover';
                        container.appendChild(video);
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-full h-full object-cover';
                        container.appendChild(img);
                    }

                    // Tombol silang
                    const removeButton = document.createElement('button');
                    removeButton.classList.add(
                        'absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white',
                        'text-xs', 'rounded-full', 'w-5', 'h-5', 'flex', 'items-center',
                        'justify-center', 'hover:bg-red-600', 'm-1', 'shadow-md'
                    );
                    removeButton.innerHTML = '&times;';
                    removeButton.onclick = () => {
                        container.remove();
                        files.splice(index, 1); // Hapus file dari array
                        updatedFiles.items.clear();
                        files.forEach((f) => updatedFiles.items.add(f));
                        input.files = updatedFiles.files; // Update file input
                    };
                    container.appendChild(removeButton);

                    previewContainer.appendChild(container);
                };
                reader.readAsDataURL(file);
            });
        }

        function previewCertificates(input) {
            const previewContainer = document.getElementById('previewCertificates');
            previewContainer.innerHTML = '';
            const files = Array.from(input.files);
            const updatedFiles = new DataTransfer();

            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const container = document.createElement('div');
                    container.classList.add('relative', 'inline-block', 'w-32', 'h-32', 'rounded-md',
                        'overflow-hidden', 'bg-gray-100', 'dark:bg-gray-700');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover';
                    container.appendChild(img);

                    // Tombol silang
                    const removeButton = document.createElement('button');
                    removeButton.classList.add(
                        'absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white',
                        'text-xs', 'rounded-full', 'w-5', 'h-5', 'flex', 'items-center',
                        'justify-center', 'hover:bg-red-600', 'm-1', 'shadow-md'
                    );
                    removeButton.innerHTML = '&times;';
                    removeButton.onclick = () => {
                        container.remove();
                        files.splice(index, 1); // Hapus file dari array
                        updatedFiles.items.clear();
                        files.forEach((f) => updatedFiles.items.add(f));
                        input.files = updatedFiles.files; // Update file input
                    };
                    container.appendChild(removeButton);

                    previewContainer.appendChild(container);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
</x-app-layout>
