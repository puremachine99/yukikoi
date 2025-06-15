<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <form action="{{ route('cart.confirmCheckout') }}" method="POST">
                    @csrf
                    <!-- Hidden Input for Cart IDs -->
                    @foreach ($cartsBySeller->flatten() as $cart)
                        <input type="hidden" name="cart_ids[]" value="{{ $cart->id }}">
                    @endforeach

                    <!-- Hidden Input untuk Cart IDs -->

                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Checkout</h3>

                    <!-- Loop Penjual -->
                    @foreach ($cartsBySeller as $sellerName => $carts)
                        <div class="mb-8 border-b pb-6">
                            <h4 class="text-lg font-semibold text-blue-600">Penjual: {{ $sellerName ?? 'Tanpa Nama' }}
                            </h4>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 mt-4">
                                @foreach ($carts as $cart)
                                    <div
                                        class="flex items-start bg-white hover:bg-blue-50 dark:bg-gray-800 p-4 rounded-lg shadow-md">
                                        <!-- Foto Koi -->
                                        <div class="w-1/3 mr-4">
                                            @if ($cart->koi->media->isNotEmpty())
                                                <div class="bg-blue-100 p-2 rounded-lg shadow-md">
                                                    <img src="{{ asset('storage/' . $cart->koi->media->first()->url_media) }}"
                                                        alt="Koi Image"
                                                        class="rounded-lg border w-full h-full object-contain"
                                                        style="max-height: 150px;">
                                                </div>
                                            @else
                                                <p class="text-gray-600">Tidak ada foto tersedia.</p>
                                            @endif
                                        </div>

                                        <!-- Rincian Koi -->
                                        <div class="w-2/3">
                                            <h4 class="text-lg font-semibold text-blue-600 mb-2">
                                                {{ $cart->koi->judul ?? 'Tidak tersedia' }}
                                            </h4>
                                            <table class="w-full text-sm text-gray-800">
                                                <tr>
                                                    <td class="py-1 font-semibold text-gray-600">Jenis Koi</td>
                                                    <td class="py-1 text-right">
                                                        {{ $cart->koi->jenis_koi ?? 'Tidak tersedia' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-1 font-semibold text-gray-600">Gender</td>
                                                    <td class="py-1 text-right">
                                                        {{ ucfirst($cart->koi->gender ?? 'Tidak tersedia') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-1 font-semibold text-gray-600">Ukuran</td>
                                                    <td class="py-1 text-right">
                                                        {{ $cart->koi->ukuran ?? 'Tidak tersedia' }} cm</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-1 font-semibold text-gray-600">Harga</td>
                                                    <td class="py-1 text-right">Rp
                                                        {{ number_format($cart->price, 0, ',', '.') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Subtotal Penjual -->
                            <div class="mt-4 text-right">
                                <p class="text-sm font-semibold text-gray-600">
                                    Subtotal Penjual: Rp {{ number_format($carts->sum('price'), 0, ',', '.') }}
                                </p>
                            </div>

                            <!-- Alamat Pengiriman -->
                            <div class="mt-4">
                                <label for="address-{{ $loop->index }}"
                                    class="block text-sm font-medium text-gray-600 dark:text-gray-400">
                                    Alamat Pengiriman:
                                </label>

                                {{-- Dropdown daftar alamat --}}
                                <x-select id="address-select-{{ $loop->index }}"
                                    name="addresses[{{ $sellerName }}][address_id]"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:border-gray-700"
                                    onchange="toggleCustomAddress(this, 'custom-address-{{ $loop->index }}')">

                                    {{-- Add Buyer Addresses --}}
                                    @foreach ($userAddresses as $userAddress)
                                        <option
                                            value="{{ json_encode([
                                                'type' => 'buyer',
                                                'id' => $userAddress->id,
                                                'nama' => $userAddress->recipient_name ?? $user->name,
                                                'full_address' => $userAddress->full_address,
                                                'phone' => $userAddress->phone_number ?? $user->phone_number,
                                            ]) }}"
                                            {{ $userAddress->is_default ? 'selected' : '' }}>
                                            Pembeli - {{ $userAddress->full_address }}
                                        </option>
                                    @endforeach

                                    {{-- Add Seller Addresses --}}
                                    @foreach ($sellerAddresses as $sellerAddress)
                                        {{-- Filter untuk tidak menampilkan alamat seller itu sendiri --}}
                                        @if ($sellerAddress['farm_name'] !== $sellerName)
                                            <option
                                                value="{{ json_encode([
                                                    'type' => 'seller',
                                                    'id' => $sellerAddress['id'],
                                                    'nama' => $sellerAddress['nama'],
                                                    'full_address' => $sellerAddress['full_address'],
                                                    'phone' => $sellerAddress['phone'],
                                                    'farm_name' => $sellerAddress['farm_name'],
                                                ]) }}">
                                                Seller - {{ $sellerAddress['farm_name'] }} -
                                                {{ $sellerAddress['full_address'] }} ({{ $sellerAddress['nama'] }} -
                                                {{ $sellerAddress['phone'] }})
                                            </option>
                                        @endif
                                    @endforeach

                                    {{-- Custom Address Option --}}
                                    <option value="other">Alamat Lain</option>
                                </x-select>

                                {{-- Custom Address Input --}}
                                <div id="custom-address-{{ $loop->index }}" class="mt-2 hidden">
                                    <x-textarea id="address-{{ $loop->index }}"
                                        name="addresses[{{ $sellerName }}][custom_address]" rows="3"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:border-gray-700"></x-textarea>
                                    <x-text-input id="phone-{{ $loop->index }}"`
                                        name="addresses[{{ $sellerName }}][custom_phone]" placeholder="Nomor Telepon"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:border-gray-700" />
                                    <x-text-input id="recipient-{{ $loop->index }}"
                                        name="addresses[{{ $sellerName }}][custom_recipient]"
                                        placeholder="Nama Penerima"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:border-gray-700" />
                                </div>


                                {{-- Custom Address Fields --}}
                                <div id="custom-address-{{ $loop->index }}" class="mt-2 hidden">
                                    <input type="hidden" name="addresses[{{ $sellerName }}][type]" value="custom">

                                    <div class="mb-2">
                                        <label for="custom-recipient-{{ $loop->index }}"
                                            class="block text-sm font-medium text-gray-600 dark:text-gray-400">
                                            Nama Penerima
                                        </label>
                                        <x-text-input id="custom-recipient-{{ $loop->index }}"
                                            name="addresses[{{ $sellerName }}][custom_name]" type="text"
                                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:border-gray-700" />
                                    </div>

                                    <div class="mb-2">
                                        <label for="custom-phone-{{ $loop->index }}"
                                            class="block text-sm font-medium text-gray-600 dark:text-gray-400">
                                            Nomor Telepon Penerima
                                        </label>
                                        <x-text-input id="custom-phone-{{ $loop->index }}"
                                            name="addresses[{{ $sellerName }}][custom_phone]" type="text"
                                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:border-gray-700" />
                                    </div>

                                    <div class="mb-2">
                                        <label for="custom-address-{{ $loop->index }}"
                                            class="block text-sm font-medium text-gray-600 dark:text-gray-400">
                                            Alamat Penerima
                                        </label>
                                        <x-textarea id="custom-address-{{ $loop->index }}"
                                            name="addresses[{{ $sellerName }}][custom_address]" rows="3"
                                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:border-gray-700"></x-textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- fee ongkir --}}
                            <div class="mt-4">
                                <label for="shipping_fee-{{ $loop->index }}"
                                    class="block text-sm font-medium text-gray-600 dark:text-gray-400">
                                    Biaya Ongkir
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-600 dark:text-gray-400">Rp</span>
                                    <x-number-input id="shipping_fee-{{ $loop->index }}"
                                        name="shipping_fees[{{ $sellerName }}]" min="0" step="500"
                                        value="0"
                                        class="block w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                        onchange="validateShippingFee(this)"></x-number-input>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- Biaya dan Total -->
                    <div class="mb-4 p-4 rounded-lg shadow-inner bg-blue-50 dark:bg-gray-800 dark:text-gray-300">

                        <h4 class="text-lg font-semibold text-blue-600 dark:text-blue-400 mb-4">Rincian Pembayaran</h4>

                        <table class="w-full text-sm text-gray-800 dark:text-gray-300">
                            <tr>
                                <td class="py-2 font-semibold text-gray-600 dark:text-gray-400">Subtotal Semua Penjual
                                </td>
                                <td class="py-2 text-right text-gray-800 dark:text-gray-200">
                                    Rp {{ number_format($cartsBySeller->flatten()->sum('price'), 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 font-semibold text-gray-600 dark:text-gray-400">Biaya Aplikasi</td>
                                <td class="py-2 text-right text-gray-800 dark:text-gray-200">
                                    Rp {{ number_format($applicationFee, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 font-semibold text-gray-600 dark:text-gray-400">Biaya Payment Gateway
                                </td>
                                <td class="py-2 text-right text-gray-800 dark:text-gray-200">
                                    Rp {{ number_format($paymentGatewayFee, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 font-semibold text-gray-600 dark:text-gray-400">
                                    Biaya Rekber <small class="text-red-500">*</small> <span
                                        class="text-sm">(Opsional)</span>
                                </td>
                                <td class="py-2 text-right">
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-600 dark:text-gray-400">Rp</span>
                                        <x-number-input id="rekber_fee" name="rekber_fee" min="0"
                                            step="500" value="0"
                                            class="block w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg 
                                            bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                            onchange="validateRekberFee(this)">
                                        </x-number-input>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 font-semibold text-gray-600 dark:text-gray-400">Total </td>
                                <td class="py-2 text-right">
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-gray-200">Rp
                                        <span id="total_price_display">
                                            {{ number_format($cartsBySeller->flatten()->sum('price') + $applicationFee + $paymentGatewayFee, 0, ',', '.') }}
                                        </span>
                                    </h4>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="py-2 px-6 bg-green-500 text-white rounded-lg shadow hover:bg-green-600">
                            Lanjutkan ke Pembayaran
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function toggleCustomAddress(selectElement, customAddressId) {
            const customAddressDiv = document.getElementById(customAddressId);
            if (selectElement.value === 'other') {
                customAddressDiv.classList.remove('hidden');
            } else {
                customAddressDiv.classList.add('hidden');
            }
        }
        document.addEventListener('DOMContentLoaded', () => {
            const applicationFee = {{ $applicationFee }};
            const paymentGatewayFee = {{ $paymentGatewayFee }};
            const basePrice = {{ $cartsBySeller->flatten()->sum('price') }};

            function calculateTotal() {
                let rekberFee = parseFloat(document.getElementById('rekber_fee').value) || 0;
                let shippingFees = 0;

                // Calculate total shipping fees
                document.querySelectorAll('[id^="shipping_fee-"]').forEach(input => {
                    shippingFees += parseFloat(input.value) || 0;
                });

                // Calculate total
                const totalPrice = basePrice + applicationFee + paymentGatewayFee + rekberFee + shippingFees;

                // Update the total price in the DOM
                const totalPriceElement = document.getElementById('total_price_display');
                totalPriceElement.textContent = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(totalPrice);
            }

            // Attach event listeners to the rekber and shipping fee inputs
            document.getElementById('rekber_fee').addEventListener('input', calculateTotal);

            document.querySelectorAll('[id^="shipping_fee-"]').forEach(input => {
                input.addEventListener('input', calculateTotal);
            });

            // Initial calculation to display correct total on load
            calculateTotal();
        });

        function validateRekberFee(input) {
            if (input.value < 0) input.value = 0; // Prevent negative values
            if (input.value % 500 !== 0) input.value = Math.floor(input.value / 1000) * 1000; // Round to nearest 1000
        }

        function validateShippingFee(input) {
            if (input.value < 0) input.value = 0; // Prevent negative values
            if (input.value % 500 !== 0) input.value = Math.floor(input.value / 1000) * 1000; // Round to nearest 1000
        }
    </script>
</x-app-layout>
