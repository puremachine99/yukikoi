<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
        height: 100%;
    }

    .dark body {
        background-color: #0f172a;
    }

    /* Glassmorphism effect */
    .glass-nav {
        backdrop-filter: blur(14px);
        background-color: rgba(186, 230, 253, 0.6);
        /* pastel-blue */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .dark .glass-nav {
        background-color: rgba(30, 41, 59, 0.6);
        /* slate-800 semitransparan */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
    }


    /* Animated nav links */
    .nav-link-hover {
        position: relative;
        transition: all 0.3s ease;
    }

    .nav-link-hover::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background-color: #0ea5e9;
        transition: width 0.3s ease;
    }

    .nav-link-hover:hover::after {
        width: 100%;
    }

    .active-nav-link::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #0ea5e9;
    }

    /* Hamburger animation */
    .hamburger-line {
        @apply block w-6 h-0.5 bg-gray-600 dark:bg-gray-300 rounded-full transition-all duration-300;
    }

    .open .hamburger-top {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .open .hamburger-middle {
        opacity: 0;
    }

    .open .hamburger-bottom {
        transform: rotate(-45deg) translate(5px, -5px);
    }

    /* Smooth transitions */
    .smooth-transition {
        transition: all 0.3s ease-in-out;
    }

    /* Card shadow */
    .card-shadow {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .dark .card-shadow {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.25), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
    }
</style>


<!-- Modern Navbar -->
<nav x-data="{ open: false, profileOpen: false, notificationsOpen: false }" class="glass-nav border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}"
                        class="flex items-center space-x-2 transition-transform duration-200 transform hover:scale-105">
                        <div
                            class="w-10 h-10 rounded-lg flex items-center justify-center bg-gradient-to-br from-blue-500 via-cyan-500 to-magenta-500 shadow-md">
                            <x-application-logo class="block h-6 w-6 text-white" />
                        </div>

                        <span class="text-xl font-bold text-gray-800 dark:text-white hidden md:block">
                            Yuki<span class="text-primary-500">Koi</span>
                        </span>
                    </a>
                </div>


                <!-- Navigation Links -->
                <div class="hidden md:flex space-x-1 ml-10">
                    <a href="{{ route('home') }}" @class([
                        'nav-link-hover relative px-4 py-2 text-sm font-medium',
                        'text-primary-600 dark:text-primary-400 active-nav-link' => request()->routeIs(
                            'home'),
                        'text-gray-700 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-300' => !request()->routeIs(
                            'home'),
                    ])>
                        <i class="fa-solid fa-house mr-2"></i>Home
                    </a>

                    <a href="{{ route('live.index') }}" @class([
                        'nav-link-hover relative px-4 py-2 text-sm font-medium',
                        'text-primary-600 dark:text-primary-400 active-nav-link' => request()->routeIs(
                            'live.index'),
                        'text-gray-700 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-300' => !request()->routeIs(
                            'live.index'),
                    ])>
                        <i class="fa-solid fa-bolt mr-2"></i>Live Lelang
                    </a>

                    <a href="{{ route('events.index') }}" @class([
                        'nav-link-hover relative px-4 py-2 text-sm font-medium',
                        'text-primary-600 dark:text-primary-400 active-nav-link' => request()->routeIs(
                            'events.index'),
                        'text-gray-700 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-300' => !request()->routeIs(
                            'events.index'),
                    ])>
                        <i class="fa-solid fa-calendar-days mr-2"></i>Live Event
                    </a>

                    <a href="#" @class([
                        'nav-link-hover relative px-4 py-2 text-sm font-medium',
                        'text-primary-600 dark:text-primary-400 active-nav-link' => request()->is(
                            'market'),
                        'text-gray-700 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-300' => !request()->is(
                            'market'),
                    ])>
                        <i class="fa-solid fa-store mr-2"></i>Market
                    </a>
                </div>

            </div>

            <!-- Right Section (Authenticated) -->
            <div class="flex items-center space-x-3">
                <!-- Switcher -->
                <button
                    class="theme-toggle relative inline-flex items-center h-8 w-16 rounded-full bg-gray-200 dark:bg-gray-600 transition-colors focus:outline-none">
                    <!-- Bulatan -->
                    <span
                        class="theme-toggle-circle absolute left-1 top-1 h-6 w-6 rounded-full bg-white dark:bg-gray-300 transition-all duration-300 transform"></span>

                    <!-- Ikon Matahari -->
                    <i
                        class="theme-toggle-light-icon fa-solid fa-sun text-yellow-400 absolute left-2 top-2 h-4 w-4 transition-opacity duration-300"></i>

                    <!-- Ikon Bulan -->
                    <i
                        class="theme-toggle-dark-icon fa-solid fa-moon text-indigo-400 absolute right-2 top-2 h-4 w-4 transition-opacity duration-300"></i>
                </button>





                <!-- Notifications -->
                <div class="relative">
                    <button @click="notificationsOpen = !notificationsOpen"
                        class="relative flex items-center justify-center w-10 h-10 aspect-square rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-transform duration-200 transform group-hover:scale-110 shadow-sm">
                        <i class="fa-solid fa-bell text-base"></i>

                        <!-- Badge -->
                        <span
                            class="absolute -top-0.5 -right-0.5 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full ring-2 ring-white dark:ring-gray-800 animate-pulse">
                            4
                        </span>
                    </button>

                    <!-- Notifications Dropdown -->
                    <div x-cloak x-show="notificationsOpen" @click.away="notificationsOpen = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg card-shadow z-50 border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-800 dark:text-white">Notifikasi (4)</h3>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700 max-h-80 overflow-y-auto">
                            <!-- Notification Items -->
                            <a href="#"
                                class="flex p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                                        <i class="fa-solid fa-gavel"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Bid Anda telah
                                        dikalahkan</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Produk Jam Tissot</p>
                                    <p class="text-xs text-gray-400 mt-1">2 menit yang lalu</p>
                                </div>
                            </a>
                            <a href="#"
                                class="flex p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-500">
                                        <i class="fa-solid fa-truck"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Pesanan telah dikirim
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">No. Pesanan #ORD-12345</p>
                                    <p class="text-xs text-gray-400 mt-1">1 jam yang lalu</p>
                                </div>
                            </a>
                            <a href="#"
                                class="flex p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500">
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Promo Spesial Akhir
                                        Bulan</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Diskon hingga 30%</p>
                                    <p class="text-xs text-gray-400 mt-1">3 jam yang lalu</p>
                                </div>
                            </a>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 text-center">
                            <a href="#"
                                class="text-sm font-medium text-primary-600 dark:text-primary-400 hover:underline">Lihat
                                Semua Notifikasi</a>
                        </div>
                    </div>
                </div>

                <!-- Cart -->
                <a href="{{ route('cart.index') }}"
                    class="relative flex items-center justify-center w-10 h-10 aspect-square rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-transform duration-200 transform hover:scale-110 shadow-sm">
                    <i class="fa-solid fa-shopping-cart text-base"></i>
                    <span
                        class="absolute -top-0.5 -right-0.5 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full ring-2 ring-white dark:ring-gray-800">
                        3
                    </span>
                </a>

                <!-- User Profile -->
                <div class="relative ml-2">
                    <button @click="profileOpen = !profileOpen" class="flex items-center space-x-2 focus:outline-none">
                        @if (Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo"
                                class="h-9 w-9 rounded-full object-cover smooth-transition transform hover:scale-105">
                        @else
                            <div
                                class="h-9 w-9 rounded-full bg-gradient-to-br from-primary-500 to-blue-600 flex items-center justify-center text-white font-semibold smooth-transition transform hover:scale-105">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        @endif

                    </button>

                    <!-- Profile Dropdown -->
                    <div x-cloak x-show="profileOpen" @click.away="profileOpen = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg card-shadow z-50 border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center">
                                @if (Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo"
                                        class="h-9 w-9 rounded-full object-cover smooth-transition transform hover:scale-105">
                                @else
                                    <div
                                        class="h-9 w-9 rounded-full bg-gradient-to-br from-primary-500 to-blue-600 flex items-center justify-center text-white font-semibold smooth-transition transform hover:scale-105">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                    </div>
                                @endif

                                <div class="ml-3">
                                    <h4 class="font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('profile.index') }}"
                                class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fa-solid fa-user mr-3 w-5 text-gray-400"></i> Profil Saya
                            </a>
                            @if (Auth::check() && Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fa-solid fa-user-secret mr-3 w-5 text-gray-400"></i> Admin Dashboard

                                </a>
                            @endif


                            <div class="px-4 py-2.5 text-xs uppercase text-gray-500 dark:text-gray-400 mt-1">Pembeli
                            </div>
                            <a href="{{ route('transactions.index') }}"
                                class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fa-solid fa-box mr-3 w-5 text-gray-400"></i> Pesanan Saya
                            </a>
                            <a href="{{ route('bids.user') }}"
                                class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fa-solid fa-chart-line mr-3 w-5 text-gray-400"></i> Monitoring Bid
                            </a>

                            <div class="px-4 py-2.5 text-xs uppercase text-gray-500 dark:text-gray-400 mt-1">Penjual
                            </div>
                            <a href="{{ route('orders.index') }}"
                                class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fa-solid fa-inbox mr-3 w-5 text-gray-400"></i> Pesanan Masuk <span
                                    class="ml-2 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">12</span>
                            </a>
                            <a href="{{ route('auctions.index') }}"
                                class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fa-solid fa-gavel mr-3 w-5 text-gray-400"></i> Lelang Saya
                            </a>
                            <a href="{{ route('events.list') }}"
                                class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fa-solid fa-calendar mr-3 w-5 text-gray-400"></i> Event Saya
                            </a>

                            <div class="border-t border-gray-200 dark:border-gray-700 mt-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                    <i class="fa-solid fa-arrow-right-from-bracket mr-3 w-5"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button @click="open = !open"
                    class="flex flex-col justify-center items-center w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 focus:outline-none transition-colors">
                    <span class="hamburger-line hamburger-top"></span>
                    <span class="hamburger-line hamburger-middle my-1"></span>
                    <span class="hamburger-line hamburger-bottom"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-cloak x-show="open" class="md:hidden">
        <div class="pt-2 pb-3 px-4 space-y-1 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('home') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-800 dark:text-white bg-gray-100 dark:bg-gray-700">
                <i class="fa-solid fa-house mr-2"></i>Home
            </a>
            <a href="{{ route('live.index') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                <i class="fa-solid fa-bolt mr-2"></i>Live Lelang
            </a>
            <a href="{{ route('events.index') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                <i class="fa-solid fa-calendar-days mr-2"></i>Live Event
            </a>
            <a href="#"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                <i class="fa-solid fa-store mr-2"></i>Market
            </a>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            @auth
                <div class="flex items-center px-5">
                    <div
                        class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-500 to-blue-600 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(Str::substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800 dark:text-white">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 px-2 space-y-1">
                    <a href="{{ route('profile.index') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-user mr-2"></i>Profil Saya
                    </a>

                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-purple-600 dark:text-purple-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-toolbox mr-2"></i>Admin Panel
                        </a>
                    @endif

                    <div class="px-3 pt-2 text-xs uppercase text-gray-500 dark:text-gray-400">Pembeli</div>
                    <a href="{{ route('transactions.index') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-box mr-2"></i>Pesanan Saya
                    </a>
                    <a href="{{ route('bids.user') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-chart-line mr-2"></i>Monitoring Bid
                    </a>

                    <div class="px-3 pt-2 text-xs uppercase text-gray-500 dark:text-gray-400">Penjual</div>
                    <a href="{{ route('orders.index') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-inbox mr-2"></i>Pesanan Masuk <span
                            class="ml-2 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">12</span>
                    </a>
                    <a href="{{ route('auctions.index') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-gavel mr-2"></i>Lelang Saya
                    </a>
                    <a href="{{ route('events.list') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-calendar mr-2"></i>Event Saya
                    </a>
                    <a href="{{ route('cart.index') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-shopping-cart mr-2"></i>Keranjang <span
                            class="ml-2 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">3</span>
                    </a>





                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                            <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i>Keluar
                        </button>
                    </form>
                </div>
            @else
                <div class="px-3 py-4 space-y-2">
                    <a href="{{ route('login') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 dark:text-blue-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-sign-in mr-2"></i>Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-green-600 dark:text-green-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-user-plus mr-2"></i>Register
                    </a>
                </div>
            @endauth
        </div>

    </div>
</nav>
<script>
    const updateAllThemeToggles = () => {
        const isDark = document.documentElement.classList.contains('dark');

        document.querySelectorAll('.theme-toggle').forEach(toggle => {
            const sun = toggle.querySelector('.theme-toggle-light-icon');
            const moon = toggle.querySelector('.theme-toggle-dark-icon');
            const circle = toggle.querySelector('.theme-toggle-circle');

            if (sun) sun.style.opacity = isDark ? '1' : '0';
            if (moon) moon.style.opacity = isDark ? '0' : '1';
            if (circle) circle.style.transform = isDark ? 'translateX(2rem)' : 'translateX(0.25rem)';
        });
    };

    document.querySelectorAll('.theme-toggle').forEach(toggle => {
        toggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            updateAllThemeToggles();

            // Optional: Simpan ke localStorage
            const isDark = document.documentElement.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        // Restore dari localStorage
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        updateAllThemeToggles();
    });
</script>
