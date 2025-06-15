<x-app-layout>
    <div class="p-8 text-center">
        <h2 class="text-xl font-semibold text-red-600 dark:text-red-400">Checkout Gagal</h2>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            {{ session('errorMessage') ?? 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.' }}
        </p>
        <a href="{{ route('cart.index') }}" class="mt-4 inline-block bg-gray-500 text-white px-6 py-2 rounded-lg shadow hover:bg-gray-600">
            Kembali ke Keranjang
        </a>
    </div>
</x-app-layout>
