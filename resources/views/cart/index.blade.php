<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('Keranjang') }}
        </h2>
        <style>
            .fixed-bottom-bar {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                background-color: #fff;
                /* Untuk mode terang */
                padding: 1rem 1.5rem;
                box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.1);
                /* Shadow atas */
                z-index: 50;
                /* Agar selalu di atas */
            }

            .fixed-bottom-bar .container {
                max-width: 1024px;
                /* Lebar sama seperti container konten di atas */
                margin: 0 auto;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .fixed-bottom-bar h3 {
                font-size: 1.25rem;
                font-weight: bold;
                color: #2d3748;
                /* Teks untuk mode terang */
            }

            .fixed-bottom-bar.dark h3 {
                color: #e2e8f0;
                /* Teks untuk mode gelap */
            }

            .fixed-bottom-bar button {
                background-color: #38a169;
                /* Tombol hijau */
                color: #fff;
                padding: 0.5rem 1rem;
                border-radius: 0.375rem;
                font-size: 1rem;
                font-weight: 600;
                transition: background-color 0.2s ease;
            }

            .fixed-bottom-bar button:hover {
                background-color: #2f855a;
                /* Hover tombol */
            }
        </style>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @forelse ($cartsBySeller as $farmName => $carts)
                <div class="mb-8 bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-md">
                    <h3 class="font-semibold text-lg text-zinc-700 dark:text-zinc-200 mb-4">
                        Toko: {{ $farmName ?? 'Tanpa Nama' }}
                    </h3>

                    <div class="space-y-6">
                        @foreach ($carts as $cart)
                            <div class="itemcart flex items-start bg-white hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors duration-200 dark:bg-zinc-800 p-4 rounded-lg shadow-md cursor-pointer">
                                <div class="flex-shrink-0">
                                    <input type="checkbox" class="select-koi" data-id="{{ $cart->id }}"
                                        data-price="{{ $cart->price }}" style="transform: scale(1.2);">
                                </div>

                                <!-- Gambar Koi -->
                                <div class="flex-shrink-0 ml-4">
                                    <a href="{{ route('koi.show', ['id' => $cart->koi->id]) }}" class="block">
                                        <img src="{{ asset('storage/' . $cart->koi->media->first()->url_media ?? 'default.png') }}"
                                            alt="Koi Image" class="border object-cover rounded-lg w-24 h-36">
                                    </a>
                                </div>

                                <!-- Detail Koi -->
                                <div class="ml-6 flex-1">
                                    <h4 class="text-lg font-semibold text-zinc-800 dark:text-zinc-200">
                                        {{ $cart->koi->judul }}
                                    </h4>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                        Kode Lelang: {{ $cart->koi->auction_code }}
                                    </p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                        Kode Ikan: {{ $cart->koi->kode_koi }}
                                    </p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                        Jumlah Bid: {{ $cart->koi->bids->count() }}x
                                    </p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                        Waktu Menang: {{ optional($cart->koi->win_time)->format('d M Y, H:i') ?? '-' }}
                                    </p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 font-semibold mt-2">Harga Menang:
                                    </p>
                                    <p class="text-lg font-bold text-green-600 dark:text-green-400">
                                        Rp {{ number_format($cart->price, 0, ',', '.') }}
                                    </p>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-center text-zinc-600 dark:text-zinc-400">Keranjang kosong. Mulai tambahkan koi dari
                    lelang yang Anda menangkan.</p>
            @endforelse

            @if ($cartsBySeller->isNotEmpty())
                <div class="fixed bottom-0 left-0 w-full bg-white dark:bg-zinc-900 shadow-md px-6 py-4 z-50">
                    <div class="max-w-7xl mx-auto flex justify-between items-center">
                        <h3 class="text-xl font-bold text-zinc-800 dark:text-zinc-200">
                            Total Harga: Rp <span id="total-price">0</span>
                        </h3>
                        <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form">
                            @csrf
                            <input type="hidden" name="cart_ids" id="selected-cart-ids" value="">
                            <button type="submit"
                                class="py-2 px-6 bg-green-500 text-white rounded-lg shadow hover:bg-green-600">
                                Checkout
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <script>
        // Toggle checkbox when clicking the parent div

        $(document).ready(function() {
            function toggleCheckbox(container) {
                const checkbox = $(container).find('input[type="checkbox"]');
                if (checkbox.length) {
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    calculateTotal(); // Recalculate total after toggling
                    logSelectedItems(); // Log selected items
                }
            }

            // Calculate total price
            function calculateTotal() {
                let total = 0;

                $('.select-koi:checked').each(function() {
                    const price = parseFloat($(this).data('price')) ||
                        0; // Pastikan input harga berupa angka
                    total += price;
                });

                // Update total price display
                $('#total-price').text(new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(total));
            }

            // Log selected items to console
            function logSelectedItems() {
                const selectedItems = [];

                $('.select-koi:checked').each(function() {
                    selectedItems.push({
                        id: $(this).data('id'),
                        price: parseFloat($(this).data('price')) || 0
                    });
                });
            }

            // Attach event listeners to parent divs for toggling checkboxes
            $('.itemcart').on('click', function() {
                toggleCheckbox(this);
            });

            // Event listener untuk checkbox
            $('.select-koi').on('change', function() {
                calculateTotal();
                logSelectedItems();
            });

            // Submit form and log selected data before sending
            $('#checkout-form').on('submit', function(event) {
                event.preventDefault(); // Mencegah form terkirim langsung tanpa validasi

                const selectedIds = $('.select-koi:checked').map(function() {
                    return $(this).data('id');
                }).get(); // Mengambil ID dari checkbox yang dipilih

                if (selectedIds.length === 0) {
                    alert('Pilih setidaknya satu koi untuk checkout!');
                    return; // Jangan kirim form jika tidak ada yang dipilih
                }

                // Set data ke input hidden
                $('#selected-cart-ids').val(JSON.stringify(selectedIds));

                // Submit form secara manual
                this.submit();
            });
        });
    </script>


</x-app-layout>
