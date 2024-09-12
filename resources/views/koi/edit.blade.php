<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('Edit Koi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-zinc-800 shadow sm:rounded-lg">
                <form action="{{ route('koi.update', $koi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Judul -->
                    <div class="mb-4">
                        <x-input-label for="judul" :value="__('Judul')" />
                        <x-text-input name="judul" id="judul" value="{{ $koi->judul }}" class="block w-full" required />
                    </div>

                    <!-- Jenis Koi -->
                    <div class="mb-4">
                        <x-input-label for="jenis_koi" :value="__('Jenis Koi')" />
                        <x-text-input name="jenis_koi" id="jenis_koi" value="{{ $koi->jenis_koi }}" class="block w-full" required />
                    </div>

                    <!-- Ukuran -->
                    <div class="mb-4">
                        <x-input-label for="ukuran" :value="__('Ukuran (cm)')" />
                        <x-text-input name="ukuran" id="ukuran" value="{{ $koi->ukuran }}" class="block w-full" required />
                    </div>

                    <!-- Gender -->
                    <div class="mb-4">
                        <x-input-label for="gender" :value="__('Gender')" />
                        <select name="gender" id="gender" class="block w-full">
                            <option value="Male" {{ $koi->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $koi->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Unchecked" {{ $koi->gender == 'Unchecked' ? 'selected' : '' }}>Unchecked</option>
                        </select>
                    </div>

                    <!-- Open Bid -->
                    <div class="mb-4">
                        <x-input-label for="open_bid" :value="__('Open Bid (ribu)')" />
                        <x-text-input name="open_bid" id="open_bid" value="{{ $koi->open_bid }}" class="block w-full" required />
                    </div>

                    <!-- Kelipatan Bid -->
                    <div class="mb-4">
                        <x-input-label for="kelipatan_bid" :value="__('Kelipatan Bid (ribu)')" />
                        <x-text-input name="kelipatan_bid" id="kelipatan_bid" value="{{ $koi->kelipatan_bid }}" class="block w-full" required />
                    </div>

                    <!-- Buy It Now -->
                    <div class="mb-4">
                        <x-input-label for="buy_it_now" :value="__('Buy It Now (ribu)')" />
                        <x-text-input name="buy_it_now" id="buy_it_now" value="{{ $koi->buy_it_now }}" class="block w-full" />
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <x-input-label for="keterangan" :value="__('Keterangan')" />
                        <x-textarea name="keterangan" id="keterangan" class="block w-full">{{ $koi->keterangan }}</x-textarea>
                    </div>

                    <!-- Breeder -->
                    <div class="mb-4">
                        <x-input-label for="breeder" :value="__('Breeder')" />
                        <x-text-input name="breeder" id="breeder" value="{{ $koi->breeder }}" class="block w-full" />
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
</x-app-layout>
