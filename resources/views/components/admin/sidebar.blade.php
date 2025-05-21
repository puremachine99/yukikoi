<aside class="w-64 h-screen bg-zinc-900 text-white flex flex-col fixed">
    <div class="flex items-center justify-center h-16 border-b border-zinc-700">
        <span class="text-xl font-bold">Admin Panel</span>
    </div>
    <nav class="flex-1 py-4">
        <ul>
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-6 py-3 hover:bg-zinc-800 transition {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-800 font-semibold' : '' }}">
                    <i class="fa-solid fa-gauge mr-3"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('users.index') }}"
                   class="flex items-center px-6 py-3 hover:bg-zinc-800 transition {{ request()->routeIs('users.*') ? 'bg-zinc-800 font-semibold' : '' }}">
                    <i class="fa-solid fa-users mr-3"></i> Users
                </a>
            </li>
            <li>
                <a href="{{ route('ikan.index') }}"
                   class="flex items-center px-6 py-3 hover:bg-zinc-800 transition {{ request()->routeIs('ikan.*') ? 'bg-zinc-800 font-semibold' : '' }}">
                    <i class="fa-solid fa-fish mr-3"></i> Ikan
                </a>
            </li>
            <!-- Tambahkan menu lain sesuai kebutuhan -->
        </ul>
    </nav>
</aside>