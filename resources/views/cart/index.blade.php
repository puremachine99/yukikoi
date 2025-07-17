<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cyan-800 dark:text-cyan-100 leading-tight">
            {{ __('Keranjang Belanja') }}
            <span class="ml-2 text-cyan-600">🐠</span>
        </h2>
        <style>
            :root {
                --aqua-primary: #06b6d4;
                --aqua-secondary: #22d3ee;
                --aqua-light: #e0f2fe;
                --aqua-dark: #083344;
            }

            .wave-bg {
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%2306b6d4' fill-opacity='0.1' d='M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E");
                background-repeat: repeat-x;
                background-position: bottom;
                background-size: contain;
            }

            .aqua-card {
                border-radius: 16px;
                border-top: 4px solid var(--aqua-primary);
                transition: all 0.3s ease;
                box-shadow: 0 4px 20px rgba(6, 182, 212, 0.1);
            }

            .aqua-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 24px rgba(6, 182, 212, 0.15);
            }

            .koi-selector {
                accent-color: var(--aqua-primary);
                width: 20px;
                height: 20px;
                cursor: pointer;
            }

            .koi-image {
                border-radius: 12px;
                object-fit: cover;
                transition: transform 0.3s ease;
                border: 2px solid rgba(6, 182, 212, 0.2);
            }

            .koi-image:hover {
                transform: scale(1.03);
                border-color: var(--aqua-primary);
            }

            .price-tag {
                background: linear-gradient(135deg, var(--aqua-primary), var(--aqua-secondary));
                color: white;
                padding: 4px 12px;
                border-radius: 20px;
                font-weight: 600;
                display: inline-block;
            }

            .fixed-bottom-bar {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                background: white;
                padding: 1rem 1.5rem;
                box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
                z-index: 50;
                border-top: 1px solid rgba(6, 182, 212, 0.2);
            }

            .dark .fixed-bottom-bar {
                background: var(--aqua-dark);
                border-top: 1px solid rgba(6, 182, 212, 0.3);
            }

            .checkout-btn {
                background: linear-gradient(135deg, var(--aqua-primary), var(--aqua-secondary));
                color: white;
                padding: 0.75rem 2rem;
                border-radius: 12px;
                font-weight: 600;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);
            }

            .checkout-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(6, 182, 212, 0.4);
            }

            .empty-cart-icon {
                font-size: 4rem;
                color: var(--aqua-primary);
                opacity: 0.5;
                margin-bottom: 1rem;
            }

            .seller-badge {
                background-color: var(--aqua-light);
                color: var(--aqua-dark);
                padding: 0.5rem 1rem;
                border-radius: 20px;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .dark .seller-badge {
                background-color: rgba(6, 182, 212, 0.2);
                color: var(--aqua-secondary);
            }
        </style>
    </x-slot>

    <div class="py-12 wave-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @forelse ($cartsBySeller as $farmName => $carts)
                <div class="aqua-card bg-white dark:bg-gray-800 p-6 overflow-hidden">
                    <div class="flex items-center mb-6">
                        <div class="seller-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $farmName ?? 'Toko Umum' }}
                        </div>
                    </div>

                    <div class="grid gap-6">
                        @foreach ($carts as $cart)
                            <div
                                class="flex items-start p-4 hover:bg-cyan-50/50 dark:hover:bg-gray-700/50 rounded-xl transition-colors duration-200 group border border-gray-200 dark:border-gray-700">
                                <input type="checkbox" class="koi-selector select-koi mr-4 mt-1"
                                    data-id="{{ $cart->id }}" data-price="{{ $cart->price }}">

                                <!-- Koi Image with Badges -->
                                <div class="flex-shrink-0 relative">
                                    <a href="{{ route('koi.show', ['id' => $cart->koi->id]) }}" class="block">
                                        <img src="{{ asset('storage/' . $cart->koi->media->first()->url_media ?? 'default.png') }}"
                                            alt="Koi Image" class="koi-image w-28 h-36">
                                    </a>
                                    <div class="absolute -top-2 -right-2 flex flex-col space-y-1">
                                        @if ($cart->koi->is_featured)
                                            <span
                                                class="bg-amber-500 text-white text-xs px-2 py-1 rounded-full flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                Featured
                                            </span>
                                        @endif
                                        @if ($cart->koi->is_sold)
                                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                                Sold
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Koi Details -->
                                <div class="ml-6 flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-lg font-bold text-cyan-800 dark:text-cyan-100">
                                                {{ $cart->koi->judul }}
                                            </h4>
                                            <div class="flex items-center mt-1 space-x-2">
                                                <span
                                                    class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-1 rounded">
                                                    {{ $cart->koi->category->name ?? 'General' }}
                                                </span>
                                                <span
                                                    class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-1 rounded flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $cart->koi->location ?? 'Unknown' }}
                                                </span>
                                            </div>
                                        </div>
                                        <span class="price-tag">
                                            Rp {{ number_format($cart->price, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <!-- Detailed Specifications -->
                                    <div class="mt-3 grid grid-cols-2 gap-3 text-sm">
                                        <div class="space-y-1">
                                            <div class="text-gray-600 dark:text-gray-300 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 mr-2 text-cyan-600" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span><span class="font-medium">Auction:</span>
                                                    {{ $cart->koi->auction_code }}</span>
                                            </div>
                                            <div class="text-gray-600 dark:text-gray-300 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 mr-2 text-cyan-600" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span><span class="font-medium">ID:</span>
                                                    {{ $cart->koi->kode_koi }}</span>
                                            </div>
                                            <div class="text-gray-600 dark:text-gray-300 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 mr-2 text-cyan-600" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span><span class="font-medium">Bid:</span>
                                                    {{ $cart->koi->bids->count() }}x</span>
                                            </div>
                                        </div>

                                        <div class="space-y-1">
                                            <div class="text-gray-600 dark:text-gray-300 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 mr-2 text-cyan-600" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span><span class="font-medium">Win Time:</span>
                                                    {{ optional($cart->koi->win_time)->format('d M Y, H:i') ?? '-' }}</span>
                                            </div>
                                            <div class="text-gray-600 dark:text-gray-300 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 mr-2 text-cyan-600" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span><span class="font-medium">Age:</span>
                                                    {{ $cart->koi->age ?? 'Unknown' }} years</span>
                                            </div>
                                            <div class="text-gray-600 dark:text-gray-300 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 mr-2 text-cyan-600" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span><span class="font-medium">Size:</span>
                                                    {{ $cart->koi->size ?? 'Unknown' }} cm</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-4 flex justify-between items-center">
                                        <div class="flex space-x-3">
                                            <button
                                                class="text-cyan-600 hover:text-cyan-800 dark:hover:text-cyan-400 transition-colors flex items-center text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Details
                                            </button>
                                            <button
                                                class="text-red-500 hover:text-red-700 dark:hover:text-red-400 transition-colors flex items-center text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Remove
                                            </button>
                                        </div>

                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Added {{ $cart->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="empty-cart-icon">🛒</div>
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300">Keranjang Kosong</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 max-w-md mx-auto">
                        Belum ada ikan koi di keranjang Anda. Yuk, ikuti lelang dan menangkan ikan impian Anda!
                    </p>
                    <a href="{{ route('auction.index') }}"
                        class="inline-block mt-6 px-6 py-2 bg-cyan-600 text-white rounded-full hover:bg-cyan-700 transition-colors">
                        Jelajahi Lelang
                    </a>
                </div>
            @endforelse

            @if ($cartsBySeller->isNotEmpty())
                <div class="fixed-bottom-bar">
                    <div class="max-w-7xl mx-auto flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                Total Terpilih: <span id="selected-count">0</span> item
                            </h3>
                            <h3 class="text-xl font-bold text-cyan-700 dark:text-cyan-400">
                                Rp <span id="total-price">0</span>
                            </h3>
                        </div>
                        <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form">
                            @csrf
                            <input type="hidden" name="cart_ids" id="selected-cart-ids" value="">
                            <button type="submit" class="checkout-btn flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                </svg>
                                Checkout
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Toggle checkbox when clicking item (except on buttons)
            $('.group').on('click', function(e) {
                if (!$(e.target).is('button, a, input')) {
                    const checkbox = $(this).find('.select-koi');
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    calculateTotal();
                }
            });

            // Calculate total price and selected count
            function calculateTotal() {
                let total = 0;
                let count = 0;

                $('.select-koi:checked').each(function() {
                    const price = parseFloat($(this).data('price')) || 0;
                    total += price;
                    count++;
                });

                $('#total-price').text(total.toLocaleString('id-ID'));
                $('#selected-count').text(count);
            }

            // Submit form with selected items
            $('#checkout-form').on('submit', function(event) {
                event.preventDefault();

                const selectedIds = $('.select-koi:checked').map(function() {
                    return $(this).data('id');
                }).get();

                if (selectedIds.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Pilih setidaknya satu ikan koi untuk checkout!',
                        confirmButtonColor: '#06b6d4'
                    });
                    return;
                }

                $('#selected-cart-ids').val(JSON.stringify(selectedIds));
                this.submit();
            });

            // Initialize calculation
            calculateTotal();
        });
    </script>
</x-app-layout>
