<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Buat Lelang Baru') }}
            </h2>
            <a href="{{ route('auctions.index') }}"
                class="inline-flex items-center px-3 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <i class="fas fa-arrow-left mr-2"></i> {{ __('Kembali ke Lelang Saya') }}
            </a>
        </div>
    </x-slot>

    @php
        $oldJudul = old('judul', []);
        $initialForms = max(count($oldJudul), 1);

        $codeForIndex = function ($index) {
            $code = '';
            $current = $index;
            while ($current >= 0) {
                $code = chr($current % 26 + 65) . $code;
                $current = intdiv($current, 26) - 1;
            }
            return $code;
        };
    @endphp

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('auctions.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-2xl overflow-hidden">
                    <div class="p-6 sm:p-10 space-y-8">
                        <section class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ __('Detail Lelang') }}
                                </h3>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Masukkan informasi dasar lelang, termasuk waktu mulai dan selesai.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <x-input-label for="title" :value="__('Judul Lelang')" />
                                    <x-text-input id="title" name="title" type="text"
                                        class="mt-1 block w-full" placeholder="Contoh: {{ Auth::user()->farm_name }} Auction"
                                        :value="old('title', Auth::user()->farm_name ? Auth::user()->farm_name . ' Auction' : '')" />
                                    @error('title')
                                        <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <x-input-label for="jenis" :value="__('Jenis Lelang')" />
                                    <x-select id="jenis" name="jenis"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="reguler" {{ old('jenis') === 'reguler' ? 'selected' : '' }}>
                                            Reguler (Fee +5%)
                                        </option>
                                        <option value="priority" {{ old('jenis') === 'priority' ? 'selected' : '' }}>
                                            Lelang Reguler Prioritas (Fee +7.5%)
                                        </option>
                                        <option value="azukari" {{ old('jenis') === 'azukari' ? 'selected' : '' }}>
                                            Azukari (Fee +7.5%)
                                        </option>
                                        <option value="keeping_contest" {{ old('jenis') === 'keeping_contest' ? 'selected' : '' }}>
                                            Keeping Contest (Fee +7.5%)
                                        </option>
                                        <option value="grow_out" {{ old('jenis') === 'grow_out' ? 'selected' : '' }}>
                                            Grow Out (Fee +7.5%)
                                        </option>
                                    </x-select>
                                    @error('jenis')
                                        <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <x-input-label for="start_time" :value="__('Tanggal & Waktu Mulai')" />
                                    <x-text-input id="start_time" name="start_time" type="datetime-local"
                                        class="mt-1 block w-full" :value="old('start_time')" required />
                                    @error('start_time')
                                        <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <x-input-label for="end_time" :value="__('Tanggal & Waktu Berakhir')" />
                                    <x-text-input id="end_time" name="end_time" type="datetime-local"
                                        class="mt-1 block w-full" :value="old('end_time')" required />
                                    @error('end_time')
                                        <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="banner" :value="__('Banner Lelang (Opsional)')" />
                                    <label for="banner"
                                        class="mt-1 flex flex-col items-center justify-center w-full h-36 border-2 border-dashed rounded-xl cursor-pointer border-gray-300 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-400 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                                            <i class="fas fa-cloud-upload-alt text-2xl text-gray-500 dark:text-gray-300 mb-2"></i>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                <span class="font-semibold">Klik untuk unggah</span> atau seret & letakkan
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                JPG, PNG (MAX. 2MB)
                                            </p>
                                        </div>
                                        <x-file-input id="banner" name="banner" class="hidden" accept="image/*" />
                                    </label>
                                    @error('banner')
                                        <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="description" :value="__('Deskripsi Lelang')" />
                                    <textarea id="description" name="description" rows="4"
                                        class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        <hr class="border-gray-200 dark:border-gray-700">

                        <section class="space-y-6">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ __('Daftar Koi untuk Lelang') }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Tambahkan informasi koi yang akan dilelang. Gunakan tombol tambah untuk membuat lebih dari satu koi.
                                    </p>
                                </div>
                                <x-secondary-button type="button" id="addKoiButton"
                                    class="inline-flex items-center gap-2 border-indigo-300 text-indigo-600 hover:bg-indigo-50 hover:text-indigo-700">
                                    <i class="fas fa-plus"></i>
                                    {{ __('Tambah Koi') }}
                                </x-secondary-button>
                            </div>

                            <div id="koiFormWrapper" class="grid grid-cols-1 gap-6">
                                @for ($i = 0; $i < $initialForms; $i++)
                                    @php
                                        $label = $codeForIndex($i);
                                    @endphp
                                    <div class="koi-form p-6 bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm transition">
                                        <div class="flex items-center justify-between mb-6">
                                            <h4 class="koi-form-heading text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                                {{ 'Koi ' . $label }}
                                            </h4>
                                            <span
                                                class="koi-badge px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 {{ $i === 0 ? '' : 'hidden' }}">
                                                New
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                            <div class="md:col-span-2">
                                                <x-input-label :value="__('Judul Koi')" />
                                                <x-text-input name="judul[]" class="mt-1 block w-full"
                                                    placeholder="Masukkan judul koi"
                                                    :value="old('judul.' . $i)" />
                                                @error('judul.' . $i)
                                                    <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <x-input-label :value="__('Jenis Koi')" />
                                                <x-dropdown-jenis-koi name="jenis_koi[{{ $i }}]"
                                                    :selected="old('jenis_koi.' . $i)"
                                                    class="mt-1 block w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition" />
                                                @error('jenis_koi.' . $i)
                                                    <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                        <div>
                                                <x-input-label :value="__('Ukuran (cm)')" />
                                                <x-number-input name="ukuran[{{ $i }}]" class="mt-1 block w-full"
                                                    :value="old('ukuran.' . $i)" min="0" step="0.1" />
                                                @error('ukuran.' . $i)
                                                    <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="md:col-span-2">
                                                <x-input-label :value="__('Gender')" />
                                                <div class="mt-2 flex flex-wrap gap-4">
                                                    @php
                                                        $genderOld = old('gender.' . $i, 'Unchecked');
                                                    @endphp
                                                    <label class="inline-flex items-center gap-2 text-gray-700 dark:text-gray-300 text-sm">
                                                        <input type="radio" class="gender-option h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                                                            name="gender[{{ $i }}]" value="Male"
                                                            {{ $genderOld === 'Male' ? 'checked' : '' }}>
                                                        Male
                                                    </label>
                                                    <label class="inline-flex items-center gap-2 text-gray-700 dark:text-gray-300 text-sm">
                                                        <input type="radio" class="gender-option h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                                                            name="gender[{{ $i }}]" value="Female"
                                                            {{ $genderOld === 'Female' ? 'checked' : '' }}>
                                                        Female
                                                    </label>
                                                    <label class="inline-flex items-center gap-2 text-gray-700 dark:text-gray-300 text-sm">
                                                        <input type="radio" class="gender-option h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                                                            name="gender[{{ $i }}]" value="Unchecked"
                                                            {{ $genderOld === 'Unchecked' ? 'checked' : '' }}>
                                                        Unchecked
                                                    </label>
                                                </div>
                                                @error('gender.' . $i)
                                                    <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <x-input-label :value="__('Open Bid (dalam ribuan)')" />
                                                <div class="mt-1 relative">
                                                    <span
                                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-sm">Rp</span>
                                                    <x-number-input name="open_bid[{{ $i }}]"
                                                        class="block w-full pl-9" min="0" step="1"
                                                        placeholder="500 untuk Rp500.000" :value="old('open_bid.' . $i)" />
                                                </div>
                                                @error('open_bid.' . $i)
                                                    <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <x-input-label :value="__('Kelipatan Bid (dalam ribuan)')" />
                                                <div class="mt-1 relative">
                                                    <span
                                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-sm">Rp</span>
                                                    <x-number-input name="kelipatan_bid[{{ $i }}]"
                                                        class="block w-full pl-9" min="0" step="1"
                                                        placeholder="50 untuk Rp50.000" :value="old('kelipatan_bid.' . $i)" />
                                                </div>
                                                @error('kelipatan_bid.' . $i)
                                                    <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <x-input-label :value="__('Buy It Now (dalam ribuan)')" />
                                                <div class="mt-1 relative">
                                                    <span
                                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-sm">Rp</span>
                                                    <x-number-input name="buy_it_now[{{ $i }}]"
                                                        class="block w-full pl-9" min="0" step="1"
                                                        placeholder="Opsional" :value="old('buy_it_now.' . $i)" />
                                                </div>
                                                @error('buy_it_now.' . $i)
                                                    <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="md:col-span-2">
                                                <x-input-label :value="__('Deskripsi tentang koi')" />
                                                <textarea name="keterangan[{{ $i }}]" rows="3"
                                                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition"
                                                    placeholder="Ceritakan detail koi">{{ old('keterangan.' . $i) }}</textarea>
                                                @error('keterangan.' . $i)
                                                    <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="md:col-span-2">
                                                <x-input-label :value="__('Nama Breeder Koi')" />
                                                <x-text-input name="breeder[{{ $i }}]" class="mt-1 block w-full"
                                                    placeholder="Contoh: Dainichi Koi Farm" :value="old('breeder.' . $i)" />
                                                @error('breeder.' . $i)
                                                    <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="md:col-span-2 space-y-4">
                                                <div>
                                                    <x-input-label :value="__('Video Koi (Max 1)')" />
                                                    <label data-input="video" for="video-koi-{{ $i }}"
                                                        class="mt-1 flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-xl cursor-pointer border-gray-300 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-400 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                                        <div class="flex flex-col items-center justify-center pt-4 pb-4 text-center">
                                                            <i class="fas fa-video text-xl text-gray-500 dark:text-gray-300 mb-2"></i>
                                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                                Klik untuk unggah atau seret & letakkan
                                                            </p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                MP4, MOV, AVI (MAX. 50MB)
                                                            </p>
                                                        </div>
                                                        <x-file-input id="video-koi-{{ $i }}" name="video_koi[{{ $i }}]"
                                                            class="hidden video-koi" accept="video/mp4,video/quicktime,video/x-msvideo" />
                                                    </label>
                                                    @error('video_koi.' . $i)
                                                        <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                                    @enderror
                                                    <div class="preview-video mt-3"></div>
                                                </div>

                                                <div>
                                                    <x-input-label :value="__('Gambar Koi')" />
                                                    <label data-input="gambar" for="gambar-koi-{{ $i }}"
                                                        class="mt-1 flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-xl cursor-pointer border-gray-300 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-400 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                                        <div class="flex flex-col items-center justify-center pt-4 pb-4 text-center">
                                                            <i class="fas fa-image text-xl text-gray-500 dark:text-gray-300 mb-2"></i>
                                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                                Klik untuk unggah atau seret & letakkan
                                                            </p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                JPG, PNG (MAX. 10MB each)
                                                            </p>
                                                        </div>
                                                        <x-file-input id="gambar-koi-{{ $i }}" name="gambar_koi[{{ $i }}][]"
                                                            class="hidden gambar-koi" accept="image/jpeg,image/png" multiple />
                                                    </label>
                                                    @error('gambar_koi.' . $i . '.*')
                                                        <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                                    @enderror
                                                    <div class="preview-gambar mt-3 grid grid-cols-2 sm:grid-cols-3 gap-3"></div>
                                                </div>

                                                <div>
                                                    <x-input-label :value="__('Sertifikat (Jika Ada)')" />
                                                    <label data-input="sertifikat" for="sertifikat-koi-{{ $i }}"
                                                        class="mt-1 flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-xl cursor-pointer border-gray-300 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-400 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                                        <div class="flex flex-col items-center justify-center pt-4 pb-4 text-center">
                                                            <i class="fas fa-file-alt text-xl text-gray-500 dark:text-gray-300 mb-2"></i>
                                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                                Klik untuk unggah atau seret & letakkan
                                                            </p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                JPG, PNG, PDF (MAX. 10MB each)
                                                            </p>
                                                        </div>
                                                        <x-file-input id="sertifikat-koi-{{ $i }}" name="sertifikat_koi[{{ $i }}][]"
                                                            class="hidden sertifikat-koi" accept="image/jpeg,image/png,application/pdf" multiple />
                                                    </label>
                                                    @error('sertifikat_koi.' . $i . '.*')
                                                        <p class="error-text text-sm text-red-600 mt-1">{{ $message }}</p>
                                                    @enderror
                                                    <div class="preview-sertifikat mt-3 grid grid-cols-2 sm:grid-cols-3 gap-3"></div>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($i > 0)
                                            <button type="button"
                                                class="remove-koi-btn mt-6 inline-flex items-center justify-center gap-2 w-full px-4 py-2 rounded-lg bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 hover:bg-red-200 dark:hover:bg-red-800 transition">
                                                <i class="fas fa-trash-alt"></i>
                                                {{ __('Hapus Koi') }}
                                            </button>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </section>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3">
                        <a href="{{ route('auctions.index') }}"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button class="inline-flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i>
                            {{ __('Simpan Lelang') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const getKoiCode = (index) => {
            let code = '';
            let current = index;
            while (current >= 0) {
                code = String.fromCharCode(current % 26 + 65) + code;
                current = Math.floor(current / 26) - 1;
            }
            return code;
        };

        const configureKoiForm = (form, index, { resetValues = false } = {}) => {
            form.dataset.index = index;

            const heading = form.querySelector('.koi-form-heading');
            if (heading) {
                heading.textContent = `Koi ${getKoiCode(index)}`;
            }

            const badge = form.querySelector('.koi-badge');
            if (badge) {
                if (index === 0) {
                    badge.classList.remove('hidden');
                } else {
                    badge.remove();
                }
            }

            form.querySelectorAll('.gender-option').forEach((input) => {
                input.name = `gender[${index}]`;
                if (resetValues && input.value === 'Unchecked') {
                    input.checked = true;
                }
            });

            const imageInput = form.querySelector('.gambar-koi');
            const imageLabel = form.querySelector('label[data-input="gambar"]');
            if (imageInput && imageLabel) {
                imageInput.id = `gambar-koi-${index}`;
                imageLabel.setAttribute('for', imageInput.id);
            }

            const certInput = form.querySelector('.sertifikat-koi');
            const certLabel = form.querySelector('label[data-input="sertifikat"]');
            if (certInput && certLabel) {
                certInput.id = `sertifikat-koi-${index}`;
                certLabel.setAttribute('for', certInput.id);
            }

            const videoInput = form.querySelector('.video-koi');
            const videoLabel = form.querySelector('label[data-input="video"]');
            if (videoInput && videoLabel) {
                videoInput.id = `video-koi-${index}`;
                videoLabel.setAttribute('for', videoInput.id);
            }

            if (resetValues) {
                form.querySelectorAll('input, textarea, select').forEach((input) => {
                    if (input.type === 'radio') {
                        input.checked = input.value === 'Unchecked';
                    } else if (input.type === 'file') {
                        input.value = '';
                    } else if (input.tagName.toLowerCase() === 'select') {
                        const options = Array.from(input.options);
                        const firstEnabledIndex = options.findIndex((option) => !option.disabled);
                        input.selectedIndex = firstEnabledIndex === -1 ? 0 : firstEnabledIndex;
                    } else if (input.tagName.toLowerCase() === 'textarea') {
                        input.value = '';
                    } else if (!input.name.startsWith('_token')) {
                        input.value = '';
                    }
                });

                form.querySelectorAll('.preview-gambar, .preview-sertifikat, .preview-video').forEach((preview) => {
                    preview.innerHTML = '';
                });

                form.querySelectorAll('.error-text').forEach((errorEl) => errorEl.remove());
            }

            let removeBtn = form.querySelector('.remove-koi-btn');
            if (index === 0) {
                if (removeBtn) {
                    removeBtn.remove();
                }
            } else {
                if (!removeBtn) {
                    removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className =
                        'remove-koi-btn mt-6 inline-flex items-center justify-center gap-2 w-full px-4 py-2 rounded-lg bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 hover:bg-red-200 dark:hover:bg-red-800 transition';
                    removeBtn.innerHTML = '<i class="fas fa-trash-alt"></i> Hapus Koi';
                    form.appendChild(removeBtn);
                }

                removeBtn.onclick = () => {
                    form.classList.add('opacity-0', 'translate-y-3');
                    setTimeout(() => {
                        form.remove();
                        reindexKoiForms();
                    }, 250);
                };
            }

            setupFilePreviewHandlers(form);
            setupDragAndDrop(form);
        };

        const reindexKoiForms = () => {
            document.querySelectorAll('#koiFormWrapper .koi-form').forEach((form, idx) => {
                configureKoiForm(form, idx, { resetValues: false });
            });
        };

        const previewFiles = (input, previewElement, isVideo = false) => {
            if (!previewElement) return;
            previewElement.innerHTML = '';

            if (isVideo) {
                const file = input.files?.[0];
                if (!file) {
                    return;
                }
                const info = document.createElement('div');
                info.className = 'text-sm text-gray-500 dark:text-gray-400 mb-2';
                info.textContent = `${file.name} (${(file.size / (1024 * 1024)).toFixed(2)}MB)`;
                previewElement.appendChild(info);

                const video = document.createElement('video');
                video.src = URL.createObjectURL(file);
                video.controls = true;
                video.className = 'w-full h-48 rounded-lg border border-gray-200 dark:border-gray-600';
                previewElement.appendChild(video);
                return;
            }

            const files = input.files ? Array.from(input.files) : [];
            if (!files.length) {
                return;
            }

            const maxPreviews = 6;
            const displayFiles = files.slice(0, maxPreviews);

            displayFiles.forEach((file) => {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative group';

                    const img = document.createElement('img');
                    img.src = event.target?.result;
                    img.alt = 'Preview';
                    img.className =
                        'w-full h-24 object-cover rounded-lg border border-gray-200 dark:border-gray-600 group-hover:opacity-80 transition';
                    wrapper.appendChild(img);

                    const caption = document.createElement('div');
                    caption.className =
                        'absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition rounded-lg';
                    caption.innerHTML =
                        `<span class="text-white text-xs px-2 text-center truncate w-full">${file.name}</span>`;
                    wrapper.appendChild(caption);

                    previewElement.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });

            if (files.length > maxPreviews) {
                const more = document.createElement('div');
                more.className = 'text-xs text-gray-500 dark:text-gray-400 mt-2';
                more.textContent = `+${files.length - maxPreviews} lagi`;
                previewElement.appendChild(more);
            }
        };

        const setupFilePreviewHandlers = (form) => {
            const imageInput = form.querySelector('.gambar-koi');
            const certInput = form.querySelector('.sertifikat-koi');
            const videoInput = form.querySelector('.video-koi');

            if (imageInput) {
                imageInput.onchange = () => previewFiles(imageInput, form.querySelector('.preview-gambar'));
            }
            if (certInput) {
                certInput.onchange = () => previewFiles(certInput, form.querySelector('.preview-sertifikat'));
            }
            if (videoInput) {
                videoInput.onchange = () => previewFiles(videoInput, form.querySelector('.preview-video'), true);
            }
        };

        const setupDragAndDrop = (form) => {
            const zones = form.querySelectorAll('label[data-input]');
            zones.forEach((zone) => {
                if (zone.dataset.ddBound === 'true') {
                    return;
                }

                zone.dataset.ddBound = 'true';
                const inputId = zone.getAttribute('for');
                const input = form.querySelector(`#${inputId}`);
                if (!input) return;

                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach((eventName) => {
                    zone.addEventListener(eventName, (event) => {
                        event.preventDefault();
                        event.stopPropagation();
                        if (eventName === 'dragenter' || eventName === 'dragover') {
                            zone.classList.add('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900');
                        } else {
                            zone.classList.remove('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900');
                        }
                    });
                });

                zone.addEventListener('drop', (event) => {
                    input.files = event.dataTransfer.files;
                    input.dispatchEvent(new Event('change'));
                });
            });
        };

        document.addEventListener('DOMContentLoaded', () => {
            const forms = document.querySelectorAll('#koiFormWrapper .koi-form');
            forms.forEach((form, index) => configureKoiForm(form, index, { resetValues: false }));
        });

        document.getElementById('addKoiButton')?.addEventListener('click', () => {
            const wrapper = document.getElementById('koiFormWrapper');
            if (!wrapper || !wrapper.children.length) {
                return;
            }

            const newForm = wrapper.children[0].cloneNode(true);
            configureKoiForm(newForm, wrapper.children.length, { resetValues: true });

            newForm.classList.add('opacity-0', 'translate-y-3');
            wrapper.appendChild(newForm);
            requestAnimationFrame(() => {
                newForm.classList.remove('opacity-0', 'translate-y-3');
                newForm.classList.add('transition', 'duration-300');
            });
        });
    </script>
</x-app-layout>
