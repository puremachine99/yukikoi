<nav class="fixed top-0 left-0 right-0 h-16 bg-blue-950 border-b border-zinc-200 shadow-sm z-30 flex items-center px-6">
    <div class="fixed top-16 left-0 right-0 h-14 bg-white border-b border-zinc-200 shadow-sm z-30 flex items-center px-6">
        <div id="breadcrumbs" class="flex items-center text-black text-sm space-x-2">
            <!-- Breadcrumbs akan diisi oleh JavaScript -->
        </div>
    </div>
    <div class="flex items-center gap-3">
        <x-application-logo class="h-8 w-auto fill-current text-white" />
        <span class="text-lg font-bold tracking-wide text-white">Yuki Admin</span>
    </div>
    <div class="flex-1"></div>
    <div class="flex items-center gap-4">
        <!-- Contoh: Notifikasi -->
        <x-dropdown align="right" width="64">
            <x-slot name="trigger">
                
                <button class="relative text-white hover:text-indigo-200 focus:outline-none">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">3</span>
                </button>
            </x-slot>
            <x-slot name="content" style="width: 320px;">
                <div class="px-4 py-2 text-sm text-zinc-700">Notifikasi terbaru admin di sini</div>
            </x-slot>
        </x-dropdown>
        <!-- Profil Admin -->
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <div class="flex items-center gap-2 cursor-pointer">
                    @if (Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo"
                            class="w-8 h-8 rounded-full border border-zinc-200 object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}" alt="Avatar" class="w-8 h-8 rounded-full border border-zinc-200">
                    @endif
                    <span class="text-sm text-white">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <i class="fa-solid fa-chevron-down text-xs ml-1 text-white"></i>
                </div>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link :href="route('profile.index')">
                    {{ __('Profile') }}
                </x-dropdown-link>
                <hr class="border-zinc-300">

                <!-- Buyer Section -->
                <div class="px-4 py-2 text-xs text-zinc-500">Buyer</div>
                <x-dropdown-link :href="route('transactions.index')">
                    {{ __('Pesanan Saya') }}
                </x-dropdown-link>
                <x-dropdown-link :href="route('bids.user')">
                    {{ __('Monitoring Bid') }}
                </x-dropdown-link>

                <hr class="border-zinc-300">

                <!-- Seller Section -->
                <div class="px-4 py-2 text-xs text-zinc-500">Seller</div>
                <x-dropdown-link :href="route('auctions.index')">
                    {{ __('Lelang Saya') }}
                </x-dropdown-link>
                <x-dropdown-link :href="route('events.list')">
                    {{ __('Event Saya') }}
                </x-dropdown-link>

                <hr class="border-zinc-300">

                <!-- Theme Toggle -->
                <x-dropdown-link id="theme-toggle">
                    <i id="theme-toggle-dark-icon" class="fa-solid fa-circle hidden w-5 h-5 text-yellow-300"></i>
                    <i id="theme-toggle-light-icon" class="fa-solid fa-moon hidden w-5 h-5 text-indigo-600"></i>
                </x-dropdown-link>

                <hr class="border-zinc-300">

                <!-- Exit Admin Mode -->
                <x-dropdown-link :href="route('live.index')">
                    Keluar Admin Mode
                </x-dropdown-link>

                <hr class="border-zinc-300">

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>
