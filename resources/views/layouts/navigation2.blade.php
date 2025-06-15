<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('live.index')" :active="request()->routeIs('live.index')">
                        {{ __('Live Lelang') }}
                    </x-nav-link>
                    <x-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')">
                        {{ __('Live Event') }}
                    </x-nav-link>
                    <x-nav-link>
                        {{ __('Market') }}
                    </x-nav-link>
                </div>
            </div>

            @auth

                <!-- Settings Dropdown for Desktop -->
                <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">

                    <!-- Notifikasi -->
                    <x-dropdown align="right" width="96">
                        <x-slot name="trigger">
                            <button
                                class="relative flex items-center justify-center w-10 h-10 text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 rounded-full hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Notifikasi">
                                <i class="fa-solid fa-bell text-lg"></i>
                                <span
                                    class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
                                    4
                                </span>
                            </button>
                        </x-slot>
                        <x-slot name="content" style="width: 320px;">
                            <!-- Notification items here -->
                        </x-slot>
                    </x-dropdown>

                    <!-- Pesanan Masuk -->
                    {{-- <a href="{{ route('orders.index') }}"
                        class="relative flex items-center justify-center w-10 h-10 text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 rounded-full hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Pesanan Masuk">
                        <i class="fa-solid fa-box text-lg"></i>
                        @if ($orderCount > 0)
                            <span
                                class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
                                {{ $orderCount }}
                            </span>
                        @endif
                    </a> --}}

                    <!-- Keranjang -->
                    <a href="{{ route('cart.index') }}"
                        class="relative flex items-center justify-center w-10 h-10 text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 rounded-full hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Keranjang">
                        <i class="fa-solid fa-shopping-cart text-lg"></i>
                        @if ($cartCount > 0)
                            <span
                                class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- User Profile Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center">
                                    @if (Auth::user()->profile_photo)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo"
                                            class="h-8 w-8 rounded-full object-cover mr-2">
                                    @else
                                        <img src="{{ asset('storage/avatar/user-default.png') }}"
                                            alt="Default Profile Photo" class="h-8 w-8 rounded-full object-cover mr-2">
                                    @endif
                                    <span>{{ Auth::user()->name }}</span>
                                </div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.index')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <hr class="border-gray-300">

                            @if (Auth::check() && Auth::user()->role === 'admin')
                                <x-dropdown-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                    {{ __('Admin Panel') }}
                                </x-dropdown-link>
                                <hr class="border-gray-300">
                            @endif

                            <!-- Buyer Section -->
                            <div class="px-4 py-2 text-xs text-gray-500 dark:text-gray-400">Buyer</div>
                            <x-dropdown-link :href="route('transactions.index')">
                                {{ __('Pesanan Saya') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('bids.user')">
                                {{ __('Monitoring Bid') }}
                            </x-dropdown-link>

                            <hr class="border-gray-300">

                            <!-- Seller Section -->
                            <div class="px-4 py-2 text-xs text-gray-500 dark:text-gray-400">Seller</div>
                            <x-dropdown-link :href="route('orders.index')">
                                <span class="relative flex items-center">
                                    Pesanan Masuk
                                    @if ($orderCount > 0)
                                        <span
                                            class="ml-2 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
                                            {{ $orderCount }}
                                        </span>
                                    @endif
                                </span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('auctions.index')">
                                {{ __('Lelang Saya') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('events.list')">
                                {{ __('Event Saya') }}
                            </x-dropdown-link>
                            <hr class="border-gray-300">

                            <!-- Theme Toggle -->
                            <x-dropdown-link id="theme-toggle">
                                <i id="theme-toggle-dark-icon"
                                    class="fa-solid fa-circle hidden w-5 h-5 text-yellow-300"></i>
                                <i id="theme-toggle-light-icon" class="fa-solid fa-moon hidden w-5 h-5 text-indigo-600"></i>
                            </x-dropdown-link>

                            <hr class="border-gray-300">

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>

                </div>
            @else
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('login')">
                        {{ __('Login') }}
                    </x-nav-link>
                    <x-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-nav-link>
                </div>
            @endauth

            <!-- Hamburger for Mobile -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('live.index')" :active="request()->routeIs('live.index')">
                {{ __('Live Lelang') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')">
                {{ __('Live Event') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link>
                {{ __('Market') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive User Menu -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.index')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    {{-- Add this section for Admin Link (Responsive) --}}
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Admin Panel') }}
                        </x-responsive-nav-link>
                    @endif
                    <x-responsive-nav-link :href="route('transactions.index')">
                        {{ __('Pesanan Saya') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('bids.user')">
                        {{ __('Monitoring Bid') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('auctions.index')">
                        {{ __('Lelang Saya') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('events.list')">
                        {{ __('Event Saya') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('cart.index')">
                        {{ __('Keranjang') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link id="theme-toggle">
                        <i id="theme-toggle-dark-icon" class="fa-solid fa-circle hidden w-5 h-5 text-yellow-300"></i>
                        <i id="theme-toggle-light-icon" class="fa-solid fa-moon hidden w-5 h-5 text-indigo-600"></i>
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    {{ __('Register') }}
                </x-responsive-nav-link>
            </div>
        @endauth
    </div>
</nav>
