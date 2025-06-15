<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengajuan Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <button id="help-button"
                        class="float-right text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200">
                        <i class="fa fa-question-circle text-lg" aria-hidden="true"
                            data-tooltip-target="tooltip-help"></i>
                    </button>
                    <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data"
                        id="event-form">
                        @csrf
                        <!-- Stepper Navigation -->
                        <div class="mb-6 flex justify-between items-center">
                            <div class="flex w-full overflow-x-auto space-x-6">
                                <!-- Step 1 -->
                                <div class="step-container flex-1 flex items-center relative">
                                    <div class="step flex items-center justify-center w-10 h-10 rounded-full border-2 text-sm font-bold transition-all duration-300"
                                        id="step-1">
                                        01
                                    </div>
                                    <div class="step-info ml-4">
                                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Informasi
                                            Umum</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Masukkan detail event Anda.
                                        </p>
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="step-container flex-1 flex items-center relative">
                                    <div class="step flex items-center justify-center w-10 h-10 rounded-full border-2 text-sm font-bold transition-all duration-300"
                                        id="step-2">
                                        02
                                    </div>
                                    <div class="step-info ml-4">
                                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Jadwal</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Atur jadwal event Anda.</p>
                                    </div>
                                </div>

                                <!-- Step 3 -->
                                <div class="step-container flex-1 flex items-center relative">
                                    <div class="step flex items-center justify-center w-10 h-10 rounded-full border-2 text-sm font-bold transition-all duration-300"
                                        id="step-3">
                                        03
                                    </div>
                                    <div class="step-info ml-4">
                                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Omset Lelang
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Estimasi pendapatan lelang.
                                        </p>
                                    </div>
                                </div>

                                <!-- Step 4 -->
                                <div class="step-container flex-1 flex items-center relative">
                                    <div class="step flex items-center justify-center w-10 h-10 rounded-full border-2 text-sm font-bold transition-all duration-300"
                                        id="step-4">
                                        04
                                    </div>
                                    <div class="step-info ml-4">
                                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Hadiah</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Atur hadiah untuk pemenang.
                                        </p>
                                    </div>
                                </div>

                                <!-- Step 5 -->
                                <div class="step-container flex-1 flex items-center relative">
                                    <div class="step flex items-center justify-center w-10 h-10 rounded-full border-2 text-sm font-bold transition-all duration-300"
                                        id="step-5">
                                        05
                                    </div>
                                    <div class="step-info ml-4">
                                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Doorprize
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Tambahkan doorprize.</p>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Step 1: Informasi Umum -->
                        <div class="step-content" id="step-1">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">
                                Informasi Umum
                            </h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <div class="mb-4">
                                        <x-input-label for="event_name" :value="__('Nama Event')" />
                                        <x-text-input id="event_name" class="block mt-1 w-full" type="text"
                                            name="event_name" required />
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="description" :value="__('Deskripsi')" />
                                        <textarea id="description" name="description" rows="5"
                                            class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 rounded-md"></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <x-select-option :options="[
                                            'kc' => 'Keeping Contest',
                                            'go' => 'Grow Out',
                                            'azukari' => 'Azukari',
                                        ]" id="event_type" name="event_type">
                                            {{ __('Jenis Event') }}
                                        </x-select-option>
                                    </div>
                                </div>
                                <div>
                                    <x-input-label for="banner" :value="__('Upload Banner Event')" />
                                    <input id="banner" name="banner" type="file" accept="image/png, image/jpeg"
                                        required
                                        class="block mt-1 w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 rounded-md"
                                        onchange="previewImage(event)" />
                                    <p class="text-sm text-gray-500 mt-1">
                                        Format yang diizinkan: JPG, PNG. Maks: 2MB.
                                    </p>
                                    <div
                                        class="mt-4 flex items-center justify-center border border-dashed border-gray-400 rounded-md bg-gray-100 dark:bg-gray-700">
                                        <img id="bannerPreview" class="object-contain h-full max-h-[300px] p-2"
                                            style="display: none" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Jadwal -->
                        <div class="step-content hidden" id="step-2">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">
                                Jadwal
                            </h3>

                            <!-- Waktu Pengumpulan dan Penjurian -->
                            <div class="mb-6">
                                <div class="mb-4">
                                    <x-input-label for="submission_time" :value="__('Waktu Pengumpulan Hasil (Submission Time)')" />
                                    <x-text-input id="submission_time" class="block mt-1 w-full" type="datetime-local"
                                        name="submission_time" onchange="validateSubmissionAndJudgingTime()" required />
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                        Minimal waktu pengumpulan hasil adalah <strong>3 hari</strong> sebelum akhir
                                        submisi.
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="judging_time" :value="__('Waktu Penjurian')" />
                                    <x-text-input id="judging_time" class="block mt-1 w-full" type="datetime-local"
                                        name="judging_time" onchange="validateSubmissionAndJudgingTime()" required />
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                        Penjurian akan dilaksanakan setelah akhir submisi. Hasil pengumuman minimal
                                        <strong>3 hari</strong> setelah penjurian.
                                    </p>
                                </div>
                            </div>

                            <!-- Jadwal Lelang -->
                            <div id="schedule-wrapper">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="flex-1">
                                        <x-input-label for="start_time[]" :value="__('Tanggal Mulai Lelang')" />
                                        <x-text-input id="start_time[]" class="block mt-1 w-full"
                                            type="datetime-local" name="start_time[]" required />
                                    </div>
                                    <div class="flex-1">
                                        <x-input-label for="end_time[]" :value="__('Tanggal Berakhir Lelang')" />
                                        <x-text-input id="end_time[]" class="block mt-1 w-full" type="datetime-local"
                                            name="end_time[]" required />
                                    </div>
                                    <x-secondary-button type="button" class="btn-primary"
                                        onclick="addScheduleRow()">+
                                        Tambah</x-secondary-button>
                                </div>
                            </div>
                        </div>


                        <!-- Step 3: Omset Lelang -->
                        <div class="step-content hidden" id="step-3">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Pengaturan Jumlah Koi
                                dan Bid</h3>

                            <!-- Penjelasan -->
                            <p class="mb-4 text-sm text-gray-700 dark:text-gray-300">
                                Tentukan jumlah koi, harga Open Bid, kelipatan bid, dan harga BIN. Sistem akan otomatis
                                menghitung estimasi omset
                                terkecil dan terbesar berdasarkan data yang Anda masukkan.
                            </p>

                            <!-- Estimasi Omset -->
                            <div class="mb-6 p-4 border border-gray-300 dark:border-gray-600 rounded-md">
                                <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-2">Estimasi Omset
                                </h4>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    Omset Terkecil: <span id="min_revenue" class="font-semibold">Rp0</span><br />
                                    Omset Terbesar: <span id="max_revenue" class="font-semibold">Rp0</span>
                                </p>
                            </div>

                            <!-- Jumlah Koi (Full Column) -->
                            <div class="mb-4">
                                <x-input-label for="koi_count" :value="__('Jumlah Koi')" />
                                <x-text-input id="koi_count" class="block mt-1 w-full" type="number"
                                    name="koi_count" placeholder="Contoh: 100" oninput="calculateRevenue()" />
                            </div>

                            <!-- Input Data (3 Kolom) -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Harga Open Bid -->
                                <div>
                                    <x-input-label for="open_bid" :value="__('Harga Open Bid (Rp)')" />
                                    <x-text-input id="open_bid" class="block mt-1 w-full" type="number"
                                        name="open_bid" placeholder="Contoh: 500000" oninput="calculateRevenue()" />
                                </div>

                                <!-- Kelipatan Bid -->
                                <div>
                                    <x-input-label for="bid_increment" :value="__('Kelipatan Bid (Rp)')" />
                                    <x-text-input id="bid_increment" class="block mt-1 w-full" type="number"
                                        name="bid_increment" placeholder="Contoh: 50000" />
                                </div>

                                <!-- Harga BIN -->
                                <div>
                                    <x-input-label for="bin_price" :value="__('Harga BIN (Buy It Now) (Rp)')" />
                                    <x-text-input id="bin_price" class="block mt-1 w-full" type="number"
                                        name="bin_price" placeholder="Contoh: 1000000"
                                        oninput="calculateRevenue()" />
                                </div>
                            </div>
                        </div>



                        <!-- Step 4: Hadiah -->
                        <div class="step-content hidden" id="step-4">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Hadiah</h3>

                            <!-- Mode Hadiah -->
                            <div class="mb-4">
                                <x-input-label for="reward_mode" :value="__('Mode Hadiah')" />
                                <x-select id="reward_mode" name="reward_mode"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-600 rounded-md"
                                    onchange="toggleRewardMode()">
                                    <option value="percent" selected>Persentase dari Omset</option>
                                    <option value="fixed">Jumlah Tetap</option>
                                </x-select>
                            </div>

                            <!-- Mode Basic vs Advanced -->
                            <div class="mb-4">
                                <x-input-label for="reward_type" :value="__('Jenis Setting')" />
                                <x-select id="reward_type" name="reward_type"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-600 rounded-md"
                                    onchange="toggleRewardType()">
                                    <option value="basic" selected>Basic</option>
                                    <option value="advanced">Advanced</option>
                                </x-select>
                            </div>

                            <!-- Threshold (Only for Advanced Mode) -->
                            <div id="threshold-wrapper" class="mb-4 hidden">
                                <x-input-label for="threshold_amount" :value="__('Ambang Batas (Threshold)')" />
                                <x-text-input id="threshold_amount" class="block mt-1 w-full" type="number"
                                    name="threshold_amount" placeholder="Contoh: 50000000" />
                                <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                    Masukkan ambang batas (threshold) omset untuk menentukan hadiah kedua.
                                </p>
                            </div>

                            <!-- Reward List -->
                            <div id="reward-wrapper">
                                <!-- Flexible Reward Section -->
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Flexible Reward
                                </h3>
                                <p class="mb-4 text-sm text-gray-700 dark:text-gray-300">
                                    Anda dapat menambahkan hadiah berupa uang, barang, atau kombinasi keduanya untuk
                                    setiap kategori juara. Sesuaikan dengan mode hadiah yang dipilih.
                                </p>

                                <!-- Reward Container -->
                                <div id="reward-list"></div>

                                <!-- Tombol Tambah Reward -->
                                <x-secondary-button class="bg-blue-500 text-white hover:bg-blue-600 mt-4"
                                    onclick="addRewardRow()">
                                    + Tambah Nominasi
                                </x-secondary-button>
                            </div>
                        </div>




                        <div class="step-content hidden" id="step-5">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">
                                Hadiah
                            </h3>
                            <div id="doorprize-wrapper">
                                <!-- Judul -->
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Doorprize</h3>
                                <p class="mb-4 text-sm text-gray-700 dark:text-gray-300">
                                    Doorprize adalah hadiah yang diberikan berdasarkan kategori tertentu. Anda dapat
                                    memilih untuk memberikan hadiah berupa uang atau barang.
                                </p>

                                <!-- Daftar Doorprize -->
                                <div id="doorprize-list">
                                    <!-- Template untuk tiap kategori -->
                                    @php
                                        $doorprizeCategories = [
                                            'Buyer dengan Bid terbanyak',
                                            'Buyer dengan Bid menang terbanyak',
                                            'Buyer dengan pembelian termahal per ekor',
                                            'Buyer dengan total pembelian termahal',
                                            'Partisipan Bid',
                                        ];
                                    @endphp
                                    @foreach ($doorprizeCategories as $index => $category)
                                        <div
                                            class="doorprize-item mb-6 p-4 border border-gray-300 dark:border-gray-600 rounded-md">
                                            <!-- Kategori -->
                                            <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200">
                                                {{ $index + 1 }}. {{ $category }}
                                            </h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Tambahkan hadiah untuk kategori ini (uang atau barang).
                                            </p>

                                            <!-- Input Nominal -->
                                            <div class="mb-4 mt-2">
                                                <x-input-label for="doorprize_nominal_{{ $index }}"
                                                    :value="__('Nominal Uang (opsional)')" />
                                                <x-text-input id="doorprize_nominal_{{ $index }}"
                                                    class="block mt-1 w-full" type="number"
                                                    name="doorprize_nominal[]" placeholder="Contoh: 1000000" />
                                            </div>

                                            <!-- Input Barang -->
                                            <div class="grid grid-cols-2 gap-4">
                                                <!-- Nama Barang -->
                                                <div>
                                                    <x-input-label for="doorprize_item_{{ $index }}"
                                                        :value="__('Nama Barang (opsional)')" />
                                                    <x-text-input id="doorprize_item_{{ $index }}"
                                                        class="block mt-1 w-full" type="text"
                                                        name="doorprize_item[]" placeholder="Contoh: Smartphone" />
                                                </div>
                                                <!-- Qty Barang -->
                                                <div>
                                                    <x-input-label for="doorprize_qty_{{ $index }}"
                                                        :value="__('Jumlah Pemenang')" />
                                                    <x-text-input id="doorprize_qty_{{ $index }}"
                                                        class="block mt-1 w-full" type="number"
                                                        name="doorprize_qty[]" placeholder="Contoh: 3" />
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <!-- Navigation Buttons -->
                        <div class="flex justify-between mt-6">
                            <x-secondary-button type="button" id="prev-step" onclick="prevStep()" disabled>←
                                Sebelumnya</x-secondary-button>
                            <x-primary-button type="button" id="next-step" onclick="nextStep()">Selanjutnya
                                →</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Bantuan -->
    <div id="help-modal" class="hidden fixed z-50 inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-11/12 lg:w-2/3 max-h-[90%] overflow-y-auto">
            <!-- Header Modal -->
            <div class="flex justify-between items-center border-b p-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                    Tata Cara Pembuatan Event
                </h3>
                <button class="text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
                    onclick="closeModal()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>

            <!-- Konten Modal -->
            <div class="p-4 text-gray-900 dark:text-gray-100">
                <h4 class="text-lg font-bold">Alur Pembuatan Event</h4>
                <ol class="list-decimal pl-6 mt-2">
                    <li>
                        <strong>Membuat Event</strong>
                        <p class="mt-2">Langkah User:</p>
                        <ol class="list-disc pl-6">
                            <li>Masuk ke halaman <strong>Buat Event</strong>.</li>
                            <li>
                                Isi form dengan data yang diperlukan:
                                <ul class="list-disc pl-6">
                                    <li>
                                        <strong>Nama Event:</strong> Masukkan nama unik untuk event
                                        Anda.
                                    </li>
                                    <li>
                                        <strong>Deskripsi:</strong> Tambahkan deskripsi singkat
                                        tentang event.
                                    </li>
                                    <li>
                                        <strong>Jenis Event:</strong> Pilih jenis event, misalnya
                                        Keeping Contest, Grow Out, atau Azukari.
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <strong>Mode Hadiah:</strong>
                                <ul class="list-disc pl-6">
                                    <li>
                                        <strong>Persentase dari Omset:</strong> Tentukan total
                                        hadiah dalam persen dan rinci nominasi beserta pembagian
                                        persentase.
                                    </li>
                                    <li>
                                        <strong>Jumlah Tetap:</strong> Masukkan total hadiah dalam
                                        angka dan rinci nominasi beserta nominal hadiah.
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <strong>Jadwal Event:</strong>
                                <ul class="list-disc pl-6">
                                    <li>
                                        Tambahkan satu atau lebih tanggal mulai
                                        (<code>start_time</code>) dan tanggal selesai
                                        (<code>end_time</code>).
                                    </li>
                                    <li>
                                        Isi waktu untuk <strong>Submisi Hasil</strong> (misalnya, 3
                                        hari sebelum penjurian).
                                    </li>
                                    <li>Isi waktu untuk <strong>Penjurian</strong>.</li>
                                </ul>
                            </li>
                            <li>
                                <strong>Doorprize (Opsional):</strong> Tambahkan informasi
                                hadiah doorprize jika ada.
                            </li>
                            <li>Tekan tombol <strong>Submit Event</strong>.</li>
                        </ol>
                        <p class="mt-2">
                            <strong>Hasil:</strong> Data event akan disimpan ke sistem dengan
                            status <code>pending</code>.
                        </p>

                        <!-- Contoh -->
                        <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-md">
                            <h5 class="font-semibold">Contoh:</h5>
                            <p class="mt-2">
                                <strong>Nama Event:</strong> "Grow Out Summer Championship"
                            </p>
                            <p>
                                <strong>Deskripsi:</strong> Kompetisi Grow Out untuk melihat
                                pertumbuhan terbaik selama musim panas.
                            </p>
                            <p><strong>Jenis Event:</strong> Grow Out</p>
                            <p><strong>Mode Hadiah:</strong> Persentase dari Omset</p>
                            <ul class="list-disc pl-6">
                                <li>Total Hadiah: 15%</li>
                                <li>
                                    Nominasi:
                                    <ul class="list-disc pl-6">
                                        <li>Grand Champion: 7%</li>
                                        <li>Runner-Up: 5%</li>
                                        <li>Best Growth: 3%</li>
                                    </ul>
                                </li>
                            </ul>
                            <p><strong>Jadwal:</strong></p>
                            <ul class="list-disc pl-6">
                                <li>Tanggal Mulai: 2024-08-01</li>
                                <li>Tanggal Selesai: 2024-08-10</li>
                                <li>Submisi Hasil: 2024-08-12</li>
                                <li>Penjurian: 2024-08-15</li>
                            </ul>
                            <p>
                                <strong>Doorprize:</strong> "Hadiah kejutan untuk peserta
                                terbaik."
                            </p>
                        </div>
                    </li>

                    <li class="mt-4">
                        <strong>Proses Verifikasi</strong>
                        <p class="mt-2">
                            Setelah Anda menekan tombol <strong>Submit Event</strong>, proses
                            verifikasi oleh admin akan dimulai. Biasanya, verifikasi
                            memerlukan waktu 2-3 hari kerja.
                        </p>
                        <p class="mt-2">
                            Admin akan menghubungi Anda melalui informasi kontak yang telah
                            Anda sediakan untuk:
                        </p>
                        <ul class="list-disc pl-6">
                            <li>Konfirmasi bahwa event Anda akan dijalankan.</li>
                            <li>
                                Memberikan detail pembayaran awal (DP) sebagai tanda keseriusan
                                event.
                            </li>
                        </ul>
                        <p class="mt-2">
                            Setelah verifikasi selesai, event Anda akan disetujui dan
                            statusnya berubah menjadi <code>ready</code>.
                        </p>

                        <!-- Contoh -->
                        <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-md">
                            <h5 class="font-semibold">Contoh:</h5>
                            <p class="mt-2">
                                <strong>Nama Event:</strong> "Grow Out Summer Championship"
                            </p>
                            <p>
                                <strong>Status:</strong> Pending → Ready (Setelah verifikasi
                                selesai dan pembayaran DP diterima).
                            </p>
                        </div>
                    </li>

                    <li class="mt-4">
                        <strong>Event Siap Berjalan</strong>
                        <p class="mt-2">
                            Setelah disetujui, event akan berjalan sesuai jadwal yang telah
                            Anda tentukan.
                        </p>
                        <ul class="list-disc pl-6">
                            <li>
                                <strong>Status Ready:</strong> Event menunggu waktu mulai
                                (<code>start_time</code>).
                            </li>
                            <li>
                                <strong>Status On Going:</strong> Event sedang berlangsung
                                setelah mencapai waktu mulai.
                            </li>
                            <li>
                                <strong>Status Completed:</strong> Event telah selesai
                                dijalankan setelah mencapai waktu selesai
                                (<code>end_time</code>).
                            </li>
                        </ul>

                        <!-- Contoh -->
                        <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-md">
                            <h5 class="font-semibold">Contoh:</h5>
                            <p class="mt-2"><strong>Status:</strong> On Going</p>
                            <p>
                                Event "Grow Out Summer Championship" sedang berlangsung dan akan
                                selesai pada tanggal 2024-08-10.
                            </p>
                        </div>
                    </li>
                </ol>

                <h4 class="text-lg font-bold mt-4">Catatan</h4>
                <ul class="list-disc pl-6 mt-2">
                    <li>
                        <strong>Waktu Minimum:</strong> Event harus dibuat setidaknya 1
                        bulan sebelum jadwal mulai untuk memberikan waktu verifikasi kepada
                        admin.
                    </li>
                    <li>
                        <strong>Perubahan Setelah Approval:</strong> Setelah event
                        disetujui, pembuat event tidak dapat lagi mengedit data event.
                        Perubahan hanya bisa dilakukan melalui admin.
                    </li>
                </ul>
            </div>

            <!-- Footer Modal -->
            <div class="border-t p-4 flex justify-end">
                <button class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600"
                    onclick="closeModal()">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    <script>
        // Stepper Navigation : Start
        let currentStep = 1;

        function showStep(step) {
            currentStep = step;
            document.querySelectorAll(".step-content").forEach((content, index) => {
                content.classList.toggle("hidden", index + 1 !== step); // Hide/Show steps
            });

            // Update the UI for stepper (active state)
            const steps = document.querySelectorAll(".step");
            steps.forEach((stepElement, index) => {
                if (index + 1 === step) {
                    stepElement.classList.add("text-blue-500", "border-blue-500");
                    stepElement.classList.remove("text-gray-500", "border-gray-300");
                } else {
                    stepElement.classList.remove("text-blue-500", "border-blue-500");
                    stepElement.classList.add("text-gray-500", "border-gray-300");
                }
            });

            // Update the button state and text
            document.getElementById("prev-step").disabled = step === 1;
            document.getElementById("next-step").textContent = step === 5 ? "Submit" : "Selanjutnya →";
        }

        function nextStep() {
            if (currentStep < 5) {
                showStep(currentStep + 1);
            } else {
                document.getElementById("event-form").submit(); // Submit form
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                showStep(currentStep - 1);
            }
        }
        // Stepper Navigation : END

        // Modal Help : Start
        const helpButton = document.getElementById("help-button");
        const helpModal = document.getElementById("help-modal");

        helpButton.addEventListener("click", () => {
            helpModal.classList.remove("hidden");
        });

        function closeModal() {
            helpModal.classList.add("hidden");
        }
        const tooltip = document.createElement("div");
        tooltip.className =
            "absolute text-sm bg-black text-white px-2 py-1 rounded-md shadow opacity-0 transition-opacity duration-200";
        tooltip.textContent = "Bantuan";

        document.body.appendChild(tooltip);

        const questionIcon = document.querySelector(
            '[data-tooltip-target="tooltip-help"]'
        );
        questionIcon.addEventListener("mouseenter", e => {
            const rect = e.target.getBoundingClientRect();
            tooltip.style.top = `${rect.top - 10}px`;
            tooltip.style.left = `${rect.left + rect.width / 2}px`;
            tooltip.style.opacity = "1";
        });
        questionIcon.addEventListener("mouseleave", () => {
            tooltip.style.opacity = "0";
        });
        // Help Modal : END


        // Stepper 1 : Informasi Umum @ upload image preview 
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById("bannerPreview");
            const reader = new FileReader();

            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = "block";
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
        // Stepper 1 : END

        //Stepper 2 : Jadwal 
        function addScheduleRow() {
            const wrapper = document.getElementById("schedule-wrapper");
            const row = document.createElement("div");
            row.className = "flex items-center gap-4 mb-4";
            row.innerHTML = `
                  <div class="flex-1">
                      <x-input-label for="start_time[]" :value="'Tanggal Mulai Lelang'" />
                      <x-text-input class="block mt-1 w-full" type="datetime-local" name="start_time[]" required />
                  </div>
                  <div class="flex-1">
                      <x-input-label for="end_time[]" :value="'Tanggal Berakhir Lelang'" />
                      <x-text-input class="block mt-1 w-full" type="datetime-local" name="end_time[]" required />
                  </div>
                  <x-secondary-button type="button" class="bg-red-500 text-white hover:bg-red-600" onclick="this.parentElement.remove()">
                  - Hapus
              </x-secondary-button>
  
              `;
            wrapper.appendChild(row);
        }

        function validateSubmissionAndJudgingTime() {
            const submissionTimeInput = document.getElementById("submission_time");
            const judgingTimeInput = document.getElementById("judging_time");

            const submissionTime = new Date(submissionTimeInput.value);
            const judgingTime = new Date(judgingTimeInput.value);

            if (submissionTimeInput.value && judgingTimeInput.value) {
                const minimumJudgingTime = new Date(submissionTime);
                minimumJudgingTime.setDate(minimumJudgingTime.getDate() + 3);

                if (judgingTime < minimumJudgingTime) {
                    alert("Waktu penjurian harus minimal 3 hari setelah akhir waktu submisi.");
                    judgingTimeInput.value = ""; // Reset nilai jika tidak valid
                }
            }
        }
        // Stepper 2 : END

        // Stepper 3 : Omset Lelang 
        function calculateRevenue() {
            const koiCount = parseInt(document.getElementById("koi_count").value) || 0;
            const openBid = parseInt(document.getElementById("open_bid").value) || 0;
            const binPrice = parseInt(document.getElementById("bin_price").value) || 0;

            // Hitung omset terkecil dan terbesar
            const minRevenue = koiCount * openBid;
            const maxRevenue = koiCount * binPrice;

            // Tampilkan hasil
            document.getElementById("min_revenue").textContent = formatCurrency(minRevenue);
            document.getElementById("max_revenue").textContent = formatCurrency(maxRevenue);
        }

        function formatCurrency(value) {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
            }).format(value);
        }
        // Stepper 3 : END

        // Stepper 4 : Hadiah
        function toggleRewardMode() {
            const mode = document.getElementById("reward_mode").value;
            const rewardTotalText = document.getElementById("reward-total-text");

            rewardTotalText.textContent = `Total Hadiah: ${mode === "percent" ? "0%" : "Rp 0"}`;
        }

        function toggleRewardType() {
            const type = document.getElementById("reward_type").value;
            const thresholdWrapper = document.getElementById("threshold-wrapper");
            const rewardItems = document.querySelectorAll(".reward-item");

            if (type === "advanced") {
                thresholdWrapper.classList.remove("hidden");
                rewardItems.forEach((item) => {
                    item.querySelector(".advanced-fields").classList.remove("hidden");
                });
            } else {
                thresholdWrapper.classList.add("hidden");
                rewardItems.forEach((item) => {
                    item.querySelector(".advanced-fields").classList.add("hidden");
                });
            }
        }

        function addRewardRow() {
            const rewardList = document.getElementById("reward-list");
            const mode = document.getElementById("reward_mode").value;
            const isAdvanced = document.getElementById("reward_type").value === "advanced";

            const newRewardItem = document.createElement("div");
            newRewardItem.className = "reward-item mb-6 p-4 border border-gray-300 dark:border-gray-600 rounded-md";

            newRewardItem.innerHTML = `
                <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-2">Nominasi Juara</h4>

                <!-- Basic Fields -->
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="nomination[]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nominasi</label>
                        <input id="nomination[]" class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md"
                            type="text" name="nomination[]" placeholder="Contoh: Juara Pertama" />
                    </div>
                    <div>
                        <label for="reward_nominal[]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            ${mode === "percent" ? "Persentase (%)" : "Nominal Uang"}
                        </label>
                        <input id="reward_nominal[]" class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md"
                            type="number" name="reward_nominal[]" placeholder="Contoh: ${mode === "percent" ? "5 (Persen)" : "1000000"}" />
                    </div>
                    <div>
                        <label for="reward_item[]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Barang</label>
                        <input id="reward_item[]" class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md"
                            type="text" name="reward_item[]" placeholder="Contoh: 1 Ekor Ikan Koi" />
                    </div>

                </div>

                <!-- Advanced Fields -->
                <div class="advanced-fields ${isAdvanced ? "" : "hidden"}">
                    <h5 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-2">Hadiah Kedua (Jika Threshold Tercapai)</h5>
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div></div>
                        <div>
                            <label for="advanced_reward_nominal[]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                ${mode === "percent" ? "Persentase (%)" : "Nominal Uang"}
                            </label>
                            <input id="advanced_reward_nominal[]" class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md"
                                type="number" name="advanced_reward_nominal[]" placeholder="Contoh: ${mode === "percent" ? "10 (Persen)" : "2000000"}" />
                        </div>
                        <div>
                            <label for="advanced_reward_item[]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Barang</label>
                            <input id="advanced_reward_item[]" class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md"
                                type="text" name="advanced_reward_item[]" placeholder="Contoh: 2 Ekor Ikan Koi" />
                        </div>

                    </div>
                </div>

                <!-- Tombol Hapus -->
                <button type="button" class="bg-red-500 text-white hover:bg-red-600 py-1 px-4 rounded-md"
                    onclick="removeRewardRow(this)">
                    - Hapus Nominasi
                </button>
            `;

            rewardList.appendChild(newRewardItem);
        }

        function removeRewardRow(button) {
            const rewardItem = button.closest(".reward-item");
            rewardItem.remove();
        }

        function updateTotalReward() {
            const mode = document.getElementById("reward_mode").value;
            const rewardItems = document.querySelectorAll("#reward-list .reward-item");
            let total = 0;

            rewardItems.forEach((item) => {
                const nominalInput = item.querySelector("[id^='reward_nominal']");
                const value = parseFloat(nominalInput.value) || 0;
                total += value;
            });

            const rewardTotalValue = document.getElementById("reward-total-value");
            rewardTotalValue.textContent = mode === "percent" ? `${total}%` : `Rp ${total.toLocaleString()}`;
        }
        // Stepper 4 : END
    </script>
</x-app-layout>
