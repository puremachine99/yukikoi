<nav x-data="{ open: false }" class="bg-white dark:bg-zinc-800 border-b border-zinc-100 dark:border-zinc-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-zinc-800 dark:text-zinc-200" />
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
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <!-- Notification Dropdown -->
                    <x-dropdown align="right" width="96">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-end px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-zinc-500 dark:text-zinc-400 bg-white dark:bg-zinc-800 hover:text-zinc-700 dark:hover:text-zinc-300 focus:outline-none transition ease-in-out duration-150 relative"
                                style="margin-right: 20px;">
                                <div class="relative flex items-center justify-end w-96">
                                    <i class="fa-solid fa-bell text-lg"></i>
                                    <span
                                        class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full"
                                        style="transform: translate(50%, -50%);">
                                        4
                                    </span>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content" style="width: 320px;">
                            <!-- Notification items here -->
                        </x-slot>
                    </x-dropdown>

                    <!-- User Profile Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-zinc-500 dark:text-zinc-400 bg-white dark:bg-zinc-800 hover:text-zinc-700 dark:hover:text-zinc-300 focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center">
                                    @if (Auth::user()->profile_photo)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo"
                                            class="h-12 w-12 rounded-full object-cover mr-8"
                                            style="width: 25px; height: 25px;">
                                    @else
                                        <img src="{{ asset('storage/avatar/user-default.png') }}" alt="Default Profile Photo"
                                            class="h-12 w-12 rounded-full object-cover mr-8"
                                            style="width: 25px; height: 25px;">
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
                            <x-dropdown-link :href="route('cart.index')">
                                {{ __('Keranjang') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('transactions.index')">
                                {{ __('Pesanan') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('auctions.index')">
                                {{ __('Lelang') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('events.list')">
                                {{ __('Event') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('bids.user')">
                                {{ __('Bid') }}
                            </x-dropdown-link>
                            <hr class="border-zinc-300">
                            <x-dropdown-link id="theme-toggle"
                                class="text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-zinc-200 dark:focus:ring-zinc-700 text-sm p-2.5">
                                <i id="theme-toggle-dark-icon"
                                    class="fa-solid fa-circle hidden w-5 h-5 text-yellow-300"></i>
                                <i id="theme-toggle-light-icon" class="fa-solid fa-moon hidden w-5 h-5 text-indigo-600"></i>
                            </x-dropdown-link>
                            <hr class="border-zinc-300">
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
                    class="inline-flex items-center justify-center p-2 rounded-md text-zinc-400 dark:text-zinc-500 hover:text-zinc-500 dark:hover:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-900 focus:outline-none transition duration-150 ease-in-out">
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

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-zinc-200 dark:border-zinc-600">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-zinc-800 dark:text-zinc-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-zinc-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.index')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('cart.index')">
                        {{ __('Keranjang') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('transactions.index')">
                        {{ __('Pesanan') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('auctions.index')">
                        {{ __('Lelang') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('events.list')">
                        {{ __('Event') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('bids.user')">
                        {{ __('Bid') }}
                    </x-responsive-nav-link>
                    <hr class="border-zinc-300">
                    <x-responsive-nav-link id="theme-toggle"
                        class="text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-zinc-200 dark:focus:ring-zinc-700 text-sm p-2.5">
                        <i id="theme-toggle-dark-icon" class="fa-solid fa-circle hidden w-5 h-5 text-yellow-300"></i>
                        <i id="theme-toggle-light-icon" class="fa-solid fa-moon hidden w-5 h-5 text-indigo-600"></i>
                    </x-responsive-nav-link>
                    <hr class="border-zinc-300">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
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
    </div>
</nav>
