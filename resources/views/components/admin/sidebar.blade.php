<aside class="w-64 h-screen bg-gray-100 text-gray-800 flex flex-col border-r border-gray-200 shadow-sm fixed">

    <nav class="flex-1 py-4">
        <ul class="space-y-2 p-5">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg transition duration-150
                   {{ request()->routeIs('admin.dashboard')
                       ? 'bg-white text-gray-700 font-semibold shadow-lg'
                       : 'hover:shadow-md hover:bg-gray-100' }}">
                    <i class="fa-solid fa-gauge w-5 h-5"></i> Dashboard
                </a>
            </li>
            <!-- Users Menu Tree -->
            <x-admin.sidebar-menu-tree
                icon="fa-solid fa-users"
                title="Users"
                :active="request()->routeIs('admin.users.*')"
                :routes="[
                    [
                        'href' => route('admin.users.index'),
                        'label' => 'List Users',
                        'active' => request()->routeIs('admin.users.index')
                    ],
                    [
                        'href' => route('admin.users.bnr'),
                        'label' => 'User Bnr',
                        'active' => request()->routeIs('admin.users.bnr')
                    ]
                ]"
            />
            <!-- Auctions Menu Tree -->
            <x-admin.sidebar-menu-tree
                icon="fa-solid fa-gavel"
                title="Auctions"
                :active="request()->routeIs('admin.auctions.*')"
                :routes="[
                    [
                        'href' => route('admin.auctions.index'),
                        'label' => 'List Auctions',
                        'active' => request()->routeIs('admin.auctions.index')
                    ],
                    [
                        'href' => '#',
                        'label' => 'Rekapitulasi',
                        'active' => false
                    ]
                ]"
            />
            <!-- Event Menu Tree -->
            <x-admin.sidebar-menu-tree
                icon="fa-solid fa-calendar-days"
                title="Event"
                :active="request()->routeIs('admin.events.*')"
                :routes="[
                    [
                        'href' => route('admin.events.index'),
                        'label' => 'List Event',
                        'active' => request()->routeIs('admin.events.index')
                    ],
                    [
                        'href' => '#',
                        'label' => 'Event Request',
                        'active' => false
                    ],
                    [
                        'href' => '#',
                        'label' => 'Rekapitulasi',
                        'active' => false
                    ]
                ]"
            />
            <!-- Ads Menu Tree -->
            <x-admin.sidebar-menu-tree
                icon="fa-solid fa-bullhorn"
                title="Ads"
                :active="request()->routeIs('admin.ads.*')"
                :routes="[
                    [
                        'href' => route('admin.ads.index'),
                        'label' => 'List Ads',
                        'active' => request()->routeIs('admin.ads.index')
                    ],
                    [
                        'href' => '#',
                        'label' => 'Ads Request',
                        'active' => false
                    ],
                    [
                        'href' => '#',
                        'label' => 'Kategori Ads',
                        'active' => false
                    ],
                    [
                        'href' => '#',
                        'label' => 'Rekapitulasi Ads',
                        'active' => false
                    ]
                ]"
            />
            <!-- Settings -->
            <li>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg transition duration-150
                    hover:shadow-md hover:bg-white hover:text-indigo-500">
                    <i class="fa-solid fa-gear w-5 h-5"></i> Settings
                </a>
            </li>
        </ul>
    </nav>
</aside>
