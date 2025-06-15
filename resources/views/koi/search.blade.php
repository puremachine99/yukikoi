<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Hasil Pencarian Koi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Form Pencarian -->
                <form method="GET" action="{{ route('koi.search') }}" class="mb-4 flex flex-wrap gap-2">
                    <input type="text" name="q" placeholder="Cari Koi..." value="{{ request('q') }}" 
                           class="border p-2 rounded flex-1">

                    <select name="gender" class="border p-2 rounded">
                        <option value="">Semua Gender</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Jantan</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Betina</option>
                    </select>

                    <input type="number" name="min_price" placeholder="Min Harga" class="border p-2 rounded w-24" value="{{ request('min_price') }}">
                    <input type="number" name="max_price" placeholder="Max Harga" class="border p-2 rounded w-24" value="{{ request('max_price') }}">

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Cari</button>
                </form>

                <!-- Daftar Hasil Pencarian -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @forelse($kois as $koi)
                        <div class="border p-4 rounded-lg shadow-md">
                            <img src="{{ asset('storage/' . ($koi->media->first()->url_media ?? 'default.png')) }}" 
                                 class="w-full h-40 object-cover rounded-lg">

                            <h3 class="text-lg font-semibold mt-2">{{ $koi->judul }}</h3>
                            <p class="text-gray-600 text-sm">Jenis: {{ $koi->jenis_koi }}</p>
                            <p class="text-gray-600 text-sm">Gender: {{ ucfirst($koi->gender) }}</p>
                            <p class="text-gray-600 text-sm">Harga Buka: Rp {{ number_format($koi->open_bid, 0, ',', '.') }}</p>

                            <a href="{{ route('koi.show', $koi->id) }}" class="mt-2 block bg-blue-500 text-white text-center p-2 rounded">
                                Lihat Detail
                            </a>
                        </div>
                    @empty
                        <p class="col-span-3 text-center text-gray-500">Tidak ada koi yang ditemukan.</p>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $kois->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
