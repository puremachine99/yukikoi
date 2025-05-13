<x-admin-layout>

    <div class="overflow-x-auto bg-white shadow rounded p-4">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-zinc-100 text-zinc-600">
                <tr>
                    <th class="p-2 text-left">Name</th>
                    <th class="p-2 text-left">Email</th>
                    <th class="p-2 text-left">Status</th>
                    <th class="p-2 text-left">Koi</th>
                    <th class="p-2 text-left">Earning</th>
                    <th class="p-2 text-left">Menang</th>
                    <th class="p-2 text-left">Joined Auction</th>
                    <th class="p-2 text-left">Actions</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b">
                        <td class="p-2">{{ $user->name }}</td>
                        <td class="p-2">{{ $user->email }}</td>
                        <td class="p-2">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="p-2">{{ $user->auctions_count ?? 0 }} koi</td>
                        <td class="p-2">Rp {{ number_format($user->total_earnings ?? 0, 0, ',', '.') }}</td>
                        <td class="p-2">{{ $user->won_auctions_count ?? 0 }} x</td>
                        <td class="p-2">{{ $user->participated_auctions_count ?? 0 }} lelang</td>
                        <td class="p-2 flex gap-2">
                            <form action="{{ route('admin.users.toggleActive', $user) }}" method="POST">@csrf
                                <button type="submit" class="text-blue-500">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-500">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500">Hapus</button>
                            </form>
                            <form action="{{ route('admin.users.resetPassword', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-500">Reset Password</button>
                            </form>
                            <form action="{{ route('admin.users.ban', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-purple-500">
                                    {{ $user->is_banned ? 'Unban' : 'Ban' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>
