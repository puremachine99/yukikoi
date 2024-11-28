<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Test Checkout Request Data') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-7xl">
                    <!-- Menampilkan Request Data -->
                    <h3 class="text-lg font-bold">Request Data:</h3>
                    <pre class="bg-gray-100 p-4 rounded-lg overflow-x-auto text-sm text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                        {{ json_encode($requestData, JSON_PRETTY_PRINT) }}
                    </pre>
                </div>

                <div class="max-w-7xl mt-6">
                    <!-- Menampilkan Cart Items -->
                    <h3 class="text-lg font-bold">Cart Items:</h3>
                    <pre class="bg-gray-100 p-4 rounded-lg overflow-x-auto text-sm text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                        {{ json_encode($cartItems->toArray(), JSON_PRETTY_PRINT) }}
                    </pre>
                </div>
                <div class="max-w-7xl mt-6">
                    <!-- Menampilkan Transaction Items -->
                    <h3 class="text-lg font-bold">Transaction Items:</h3>
                    <pre class="bg-gray-100 p-4 rounded-lg overflow-x-auto text-sm text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                        {{ json_encode($transactionItems, JSON_PRETTY_PRINT) }}
                    </pre>
                </div>
                <div class="max-w-7xl mt-6">
                    <!-- Menampilkan Total Amount -->
                    <h3 class="text-lg font-bold">Total Amount:</h3>
                    <pre class="bg-gray-100 p-4 rounded-lg overflow-x-auto text-sm text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                        {{ $totalAmount }}
                    </pre>
                </div>

                <div class="max-w-7xl mt-6">
                    <!-- Menampilkan Grouped Carts -->
                    <h3 class="text-lg font-bold">Grouped Carts:</h3>
                    <pre class="bg-gray-100 p-4 rounded-lg overflow-x-auto text-sm text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                        {{ json_encode($groupedCarts->toArray(), JSON_PRETTY_PRINT) }}
                    </pre>
                </div>

                <div class="max-w-7xl mt-6">
                    <!-- Menampilkan URL -->
                    <h3 class="text-lg font-bold">Xendit Invoice URL:</h3>
                    <pre class="bg-gray-100 p-4 rounded-lg overflow-x-auto text-sm text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                        {{ json_encode($transaction ?? [], JSON_PRETTY_PRINT) }}
                    </pre>
                </div>
                <div class="max-w-7xl mt-6">
                    <!-- Menampilkan URL -->
                    <h3 class="text-lg font-bold">Xendit Invoice URL:</h3>
                    <pre class="bg-gray-100 p-4 rounded-lg overflow-x-auto text-sm text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                        {{ json_encode($invoice ?? [], JSON_PRETTY_PRINT) }}
                    </pre>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
