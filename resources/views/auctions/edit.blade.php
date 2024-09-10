<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('Edit Auction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-zinc-900 dark:text-zinc-100">
                    <form method="POST" action="{{ route('auctions.update', $auction->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Judul Lelang (default dengan nama farm) -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" 
                                          :value="old('title', $auction->title)" required />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="5" 
                                      class="block mt-1 w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:border-indigo-300 focus:ring-indigo-200 dark:focus:ring-indigo-700"
                                      required>{{ old('description', $auction->description) }}</textarea>
                        </div>

                        <!-- Jenis Lelang -->
                        <div class="mb-4">
                            <x-select-option :options="['reguler' => 'Reguler', 'azukari' => 'Azukari', 'keeping_contest' => 'Keeping Contest', 'grow_out' => 'Grow Out']"
                                             id="jenis" name="jenis" onchange="toggleContestTime()" 
                                             :selected="old('jenis', $auction->jenis)">
                                {{ __('Jenis Lelang') }}
                            </x-select-option>
                        </div>

                        <!-- Tanggal Mulai Lelang -->
                        <div class="mb-4">
                            <x-input-label for="start_time" :value="__('Tanggal Mulai Lelang')" />
                            <x-text-input id="start_time" class="block mt-1 w-full" type="datetime-local" name="start_time" 
                                          :value="old('start_time', \Carbon\Carbon::parse($auction->start_time)->format('Y-m-d\TH:i'))" required />
                        </div>

                        <!-- Waktu Berakhir Lelang -->
                        <div class="mb-4">
                            <x-input-label for="end_time" :value="__('Waktu Berakhir Lelang')" />
                            <x-text-input id="end_time" class="block mt-1 w-full" type="datetime-local" name="end_time" 
                                          :value="old('end_time', \Carbon\Carbon::parse($auction->end_time)->format('Y-m-d\TH:i'))" />
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Kosongkan jika default (1x24 jam).') }}</p>
                        </div>

                        <!-- Contest Time (Jika Jenis Lelang Bukan Reguler) -->
                        <div id="contest_time_wrapper" class="mb-4 {{ $auction->jenis === 'reguler' ? 'hidden' : '' }}">
                            <x-input-label for="contest_time" :value="__('Contest Time')" />
                            <x-text-input id="contest_time" class="block mt-1 w-full" type="datetime-local" name="contest_time" 
                                          :value="old('contest_time', $auction->contest_time ? \Carbon\Carbon::parse($auction->contest_time)->format('Y-m-d\TH:i') : '')" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>{{ __('Update Auction') }}</x-primary-button>
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

        // Set initial state on page load
        document.addEventListener('DOMContentLoaded', function () {
            toggleContestTime();
        });
    </script>
</x-app-layout>
