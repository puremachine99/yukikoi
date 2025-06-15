<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lelang yang Sedang Berlangsung') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($auctions->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">{{ __('Tidak ada lelang yang sedang berlangsung.') }}</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach ($auctions as $auction)
                                <div class="border rounded-lg p-4 dark:bg-gray-700">
                                    <!-- Gambar Banner atau Placeholder -->
                                    @if ($auction->banner)
                                        <img src="{{ asset('storage/' . $auction->banner) }}"
                                            alt="{{ $auction->title }}" class="w-full h-32 object-cover mb-4">
                                    @else
                                        <div class="bg-gray-300 h-32 flex items-center justify-center mb-4">
                                            {{ __('No Image') }}
                                        </div>
                                    @endif

                                    <!-- Kode Lelang, Judul, dan Status -->
                                    <h3 class="text-lg font-semibold">{{ $auction->auction_code }} - {{ $auction->title }}</h3>
                                    <p class="mt-2 text-sm">Waktu: {{ \Carbon\Carbon::parse($auction->start_time)->format('d M Y H:i') }} - {{ \Carbon\Carbon::parse($auction->end_time)->format('d M Y H:i') }}</p>
                                    <p class="mt-4">{{ Str::limit($auction->description, 100) }}</p>

                                    <!-- Tombol Aksi -->
                                    <div class="flex justify-between mt-6">
                                        <a href="{{ route('auctions.show', ['auction' => $auction->id]) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md">
                                            {{ __('Lihat Lelang') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
