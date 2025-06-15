<x-admin-layout>
    <div>
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Dashboard Admin</h1>
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
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Aktivitas Terbaru</h3>
            <ul class="space-y-4">
                <li class="flex justify-between text-gray-600 dark:text-gray-300">
                    <span>User A melakukan bid pada Auction #123</span>
                    <span>5 menit lalu</span>
                </li>
                <li class="flex justify-between text-gray-600 dark:text-gray-300">
                    <span>Admin B menyetujui iklan baru</span>
                    <span>10 menit lalu</span>
                </li>
                <li class="flex justify-between text-gray-600 dark:text-gray-300">
                    <span>User C mendaftar sebagai seller baru</span>
                    <span>20 menit lalu</span>
                </li>
            </ul>
        </div>
    </div>
</x-admin-layout>
