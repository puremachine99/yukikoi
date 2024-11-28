<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('Create Auction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-zinc-900 dark:text-zinc-100">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('auctions.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Judul Lelang (default dengan nama farm) -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                :value="old('title', Auth::user()->farm_name . ' Auction')" required />
                        </div>

                        <!-- Upload Banner -->
                        <div class="mb-4">
                            <x-input-label for="banner" :value="__('Upload Banner Lelang')" />
                            <img id="bannerPreview" class="object-cover mb-4"
                                style="height: 100px; width: auto; display: none;">
                            <input type="file" id="banner" name="banner" accept="image/*"
                                onchange="previewImage(event)"
                                class="block mt-1 w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:border-indigo-300 focus:ring-indigo-200 dark:focus:ring-indigo-700">

                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="5"
                                class="block mt-1 w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:border-indigo-300 focus:ring-indigo-200 dark:focus:ring-indigo-700"
                                required>{{ old('description') }}</textarea>
                        </div>

                        <!-- Jenis Lelang -->
                        <div class="mb-4">
                            <x-select-option :options="[
                                'reguler' => 'Reguler (Fee +5%)',
                                'priority' => 'Lelang Reguler Prioritas (Fee +7.5%)',
                                'azukari' => 'Azukari (Fee +7.5%)',
                                'keeping_contest' => 'Keeping Contest (Fee +7.5%)',
                                'grow_out' => 'Grow Out (Fee +7.5%)',
                            ]" id="jenis" name="jenis"
                                onchange="toggleContestTime()">
                                {{ __('Jenis Lelang') }}
                            </x-select-option>
                        </div>

                        <!-- Tanggal Mulai Lelang -->
                        <div class="mb-4">
                            <x-input-label for="start_time" :value="__('Tanggal Mulai Lelang')" />
                            <x-text-input id="start_time" class="block mt-1 w-full" type="datetime-local"
                                name="start_time" required />
                        </div>

                        <!-- Waktu Berakhir Lelang -->
                        <div class="mb-4">
                            <x-input-label for="end_time" :value="__('Waktu Berakhir Lelang')" />
                            <x-text-input id="end_time" class="block mt-1 w-full" type="datetime-local"
                                name="end_time" />
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                {{ __('Kosongkan jika default (1x24 jam).') }}</p>
                        </div>

                        <!-- Contest Time (Jika Jenis Lelang Bukan Reguler) -->
                        <div id="contest_time_wrapper" class="mb-4 hidden">
                            <x-input-label for="contest_time" :value="__('Contest Time')" />
                            <x-text-input id="contest_time" class="block mt-1 w-full" type="datetime-local"
                                name="contest_time" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>{{ __('Submit Auction') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleContestTime() {
            const jenis = document.getElementById('jenis').value;
            const contestTimeWrapper = document.getElementById('contest_time_wrapper');

            if (jenis === 'reguler') {
                contestTimeWrapper.classList.add('hidden');
            } else {
                contestTimeWrapper.classList.remove('hidden');
            }
        }

        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('bannerPreview');
            const reader = new FileReader();

            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block'; // Tampilkan preview gambar setelah berhasil di-load
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]); // Mulai membaca file untuk menampilkan preview
            }
        }

        // Set initial state on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleContestTime();
        });
    </script>
</x-app-layout>
