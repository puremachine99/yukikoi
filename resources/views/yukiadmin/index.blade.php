<x-app-layout>
    <div class="flex max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-300 dark:bg-gray-900 h-screen flex-shrink-0 p-4 mt-6 rounded-lg mr-2">
            <div class="text-gray-700 dark:text-gray-200 font-bold mb-6">Admin Panel</div>
            <nav class="space-y-4">
                <!-- Dashboard (active state example) -->
                <a href="{{ route('admin.dashboard') }}"
                   class="block py-2 px-4 rounded 
                   {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-500 text-white dark:bg-indigo-700' : 'hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-700' }}">
                    Dashboard
                </a>

                <!-- User Management -->
                <div x-data="{ open: false }">
                    <a @click="open = !open" class="flex justify-between items-center py-2 px-4 rounded cursor-pointer hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-700">
                        <span>User Management</span>
                        <svg :class="open ? 'rotate-90' : ''" class="h-4 w-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <div x-show="open" class="space-y-2 ml-4 mt-2" x-cloak>
                        <a href="#" class="block py-1 px-4 rounded hover:bg-indigo-400 dark:hover:bg-indigo-600">View Users</a>
                        <a href="#" class="block py-1 px-4 rounded hover:bg-indigo-400 dark:hover:bg-indigo-600">Add User</a>
                        <a href="#" class="block py-1 px-4 rounded hover:bg-indigo-400 dark:hover:bg-indigo-600">Roles & Permissions</a>
                    </div>
                </div>

                <!-- Auctions Management -->
                <div x-data="{ open: false }">
                    <a @click="open = !open" class="flex justify-between items-center py-2 px-4 rounded cursor-pointer hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-700">
                        <span>Auctions Management</span>
                        <svg :class="open ? 'rotate-90' : ''" class="h-4 w-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <div x-show="open" class="space-y-2 ml-4 mt-2" x-cloak>
                        <a href="#" class="block py-1 px-4 rounded hover:bg-indigo-400 dark:hover:bg-indigo-600">Active Auctions</a>
                        <a href="#" class="block py-1 px-4 rounded hover:bg-indigo-400 dark:hover:bg-indigo-600">Closed Auctions</a>
                        <a href="#" class="block py-1 px-4 rounded hover:bg-indigo-400 dark:hover:bg-indigo-600">Create Auction</a>
                    </div>
                </div>

                <!-- Ads Management -->
                <div x-data="{ open: false }">
                    <a @click="open = !open" class="flex justify-between items-center py-2 px-4 rounded cursor-pointer hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-700">
                        <span>Ads Management</span>
                        <svg :class="open ? 'rotate-90' : ''" class="h-4 w-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <div x-show="open" class="space-y-2 ml-4 mt-2" x-cloak>
                        <a href="#" class="block py-1 px-4 rounded hover:bg-indigo-400 dark:hover:bg-indigo-600">View Ads</a>
                        <a href="#" class="block py-1 px-4 rounded hover:bg-indigo-400 dark:hover:bg-indigo-600">Create Ad</a>
                        <a href="#" class="block py-1 px-4 rounded hover:bg-indigo-400 dark:hover:bg-indigo-600">Manage Sponsorships</a>
                    </div>
                </div>

                <!-- Reports -->
                <div x-data="{ open: false }">
                    <a @click="open = !open" class="flex justify-between items-center py-2 px-4 rounded cursor-pointer hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-700">
                        <span>Reports</span>
                        <svg :class="open ? 'rotate-90' : ''" class="h-4 w-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <div x-show="open" class="space-y-2 ml-4 mt-2" x-cloak>
                        <a href="#" class="block py-1 px-4 rounded hover:bg-indigo-400 dark:hover:bg-indigo-600">User Reports</a>
                        <a href="#" class="block py-1 px-4 rounded hover:bg-indigo-400 dark:hover:bg-indigo-600">Auction Reports</a>
                        <a href="#" class="block py-1 px-4 rounded hover:bg-indigo-400 dark:hover:bg-indigo-600">Financial Reports</a>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow p-6 bg-white dark:bg-gray-800 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="p-4 bg-indigo-200 dark:bg-indigo-700 text-gray-700 dark:text-gray-200 rounded-lg shadow">
                    <h3 class="font-semibold">Total Users</h3>
                    <p class="text-3xl">1,234</p>
                </div>
                <div class="p-4 bg-green-200 dark:bg-green-700 text-gray-700 dark:text-gray-200 rounded-lg shadow">
                    <h3 class="font-semibold">Total Auctions</h3>
                    <p class="text-3xl">567</p>
                </div>
                <div class="p-4 bg-yellow-200 dark:bg-yellow-700 text-gray-700 dark:text-gray-200 rounded-lg shadow">
                    <h3 class="font-semibold">Active Ads</h3>
                    <p class="text-3xl">45</p>
                </div>
                <div class="p-4 bg-red-200 dark:bg-red-700 text-gray-700 dark:text-gray-200 rounded-lg shadow">
                    <h3 class="font-semibold">Reports</h3>
                    <p class="text-3xl">9</p>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Recent Activity</h3>
                <ul class="space-y-4">
                    <li class="flex justify-between text-gray-600 dark:text-gray-300">
                        <span>User A placed a bid on Auction #123</span>
                        <span>5 minutes ago</span>
                    </li>
                    <li class="flex justify-between text-gray-600 dark:text-gray-300">
                        <span>Admin B approved a new ad</span>
                        <span>10 minutes ago</span>
                    </li>
                    <li class="flex justify-between text-gray-600 dark:text-gray-300">
                        <span>User C registered as a new seller</span>
                        <span>20 minutes ago</span>
                    </li>
                </ul>
            </div>
        </main>
    </div>

</x-app-layout>
