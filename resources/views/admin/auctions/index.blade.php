<x-admin-layout>
    <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <h1 class="text-xl font-bold text-indigo-700">Daftar Lelang</h1>
    </div>
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Owner</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Waktu Mulai</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Waktu Selesai</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($auctions as $auction)
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ ($auctions->currentPage()-1)*$auctions->perPage() + $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $auction->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ ucfirst($auction->jenis) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ ucfirst($auction->status) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 relative">
                                @if($auction->user)
                                    <a href="{{ route('profile.show', $auction->user->id) }}" target="_blank" class="hover:underline cursor-pointer user-name" data-user="{{ $auction->user->id }}">
                                        {{ $auction->user->name }}
                                    </a>
                                    <div class="user-card absolute left-0 mt-2 w-72 bg-white border border-gray-200 rounded-lg shadow-lg p-4 z-50 hidden flex items-center gap-4">
                                        <img src="{{ asset('storage/'. $auction->user->profile_photo) ?? asset('images/default-avatar.png') }}" alt="User Photo" class="w-12 h-12 rounded-full object-cover border border-gray-300">
                                        <div>
                                            <div class="font-bold text-indigo-700 text-base">{{ $auction->user->name }}</div>
                                            <div class="text-xs text-gray-500 mb-1">Farm: {{ $auction->user->farm_name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500 mb-1">No. Telp: {{ $auction->user->phone_number ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">Kota/Alamat: {{ $auction->user->city ?? $auction->user->address ?? '-' }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $auction->start_time }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $auction->end_time }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-400">Tidak ada data lelang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-6">
                {{ $auctions->withQueryString()->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.user-name').hover(
                function() {
                    $(this).next('.user-card').removeClass('hidden');
                },
                function() {
                    $(this).next('.user-card').addClass('hidden');
                }
            );
            $('.user-card').hover(
                function() {
                    $(this).removeClass('hidden');
                },
                function() {
                    $(this).addClass('hidden');
                }
            );
        });
    </script>
</x-admin-layout>