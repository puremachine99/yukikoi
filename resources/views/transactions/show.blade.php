<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoice Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-8">
            <!-- Header Invoice -->
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">INVOICE</h1>
                    <p class="text-sm text-gray-500">No. Invoice: #{{ $transaction->id }}</p>
                    <p class="text-sm text-gray-500">Tanggal: {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-semibold text-gray-800">Yuki Koi Auction</p>
                    <p class="text-sm text-gray-500">Jl. Koi Sejahtera No. 1, Tokyo</p>
                    <p class="text-sm text-gray-500">Email: support@yukikoi.com</p>
                    <p class="text-sm text-gray-500">Phone: +62 812 3456 7890</p>
                </div>
            </div>

            <!-- Informasi Pembeli dan Penjual -->
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <div class="w-1/2">
                    <h4 class="text-lg font-semibold text-blue-600">Pembeli</h4>
                    <p class="text-sm text-gray-700">Nama: {{ optional($buyer)->name ?? 'Tidak tersedia' }}</p>
                    <p class="text-sm text-gray-700">Email: {{ optional($buyer)->email ?? 'Tidak tersedia' }}</p>
                </div>
                <div class="w-1/2 text-right">
                    <h4 class="text-lg font-semibold text-blue-600">Penjual</h4>
                    <p class="text-sm text-gray-700">Nama: {{ optional($seller)->name ?? 'Tidak tersedia' }}</p>
                    <p class="text-sm text-gray-700">Email: {{ optional($seller)->email ?? 'Tidak tersedia' }}</p>
                </div>
            </div>

            <!-- Detail Koi dan Rincian Pembayaran -->
            <div class="flex items-start mb-6">
                <!-- Foto Koi -->
                <div class="w-1/3 mr-8">
                    @if ($transaction->koi->media->isNotEmpty())
                        <div class="bg-blue-100 p-2 rounded-lg shadow-md">
                            <img src="{{ asset('storage/' . $transaction->koi->media->first()->url_media) }}"
                                alt="Koi Image" class="rounded-lg border w-full h-full object-contain"
                                style="max-height: 250px;">
                        </div>
                    @else
                        <p class="text-gray-600">Tidak ada foto tersedia.</p>
                    @endif
                </div>

                <!-- Rincian Koi -->
                <div class="w-2/3">
                    <h4 class="text-lg font-semibold text-blue-600 mb-4">Detail Koi {{ $transaction->koi->id }}</h4>
                    <table class="w-full text-sm text-gray-800">
                        <tr>
                            <td class="py-2 font-semibold text-gray-600">Judul</td>
                            <td class="py-2">{{ $transaction->koi->judul ?? 'Tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold text-gray-600">Jenis Koi</td>
                            <td class="py-2">{{ $transaction->koi->jenis_koi ?? 'Tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold text-gray-600">Gender</td>
                            <td class="py-2">{{ ucfirst($transaction->koi->gender ?? 'Tidak tersedia') }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold text-gray-600">Ukuran</td>
                            <td class="py-2">{{ $transaction->koi->ukuran ?? 'Tidak tersedia' }} cm</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold text-gray-600">Keuntungan</td>
                            <td class="py-2">Rp
                                {{ number_format($transaction->koi->buy_it_now * 1000 - $transaction->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold text-gray-600">Cara Menang</td>
                            <td class="py-2">{{ $winningMethod }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Rincian Pembayaran -->
            <div class="bg-blue-50 p-4 rounded-lg shadow-inner mb-6">
                <h4 class="text-lg font-semibold text-blue-600 mb-4">Rincian Pembayaran</h4>
                <table class="w-full text-sm text-gray-800">
                    <tr>
                        <td class="py-2 font-semibold text-gray-600">Status</td>
                        <td class="py-2 text-right">{{ ucfirst($transaction->status) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold text-gray-600">Harga Dasar</td>
                        <td class="py-2 text-right">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold text-gray-600">Biaya Payment Gateway</td>
                        <td class="py-2 text-right">Rp
                            {{ number_format($transaction->payment_gateway_fee, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold text-gray-600">Biaya Penanganan</td>
                        <td class="py-2 text-right">Rp {{ number_format($transaction->handling_fee, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold text-gray-600">Biaya Rekber</td>
                        <td class="py-2 text-right">
                            Rp <input type="number" id="rekber_fee"
                                class="text-right border border-gray-300 rounded w-48"
                                value="{{ $transaction->rekber_fee }}" min="0" step="500"
                                onchange="validateRekberFee(); updateTotal();">
                        </td>

                    </tr>
                </table>
            </div>

            <!-- Total Keseluruhan dan Tombol -->
            <div class="flex justify-between items-center">
                <a href="{{ url()->previous() }}"
                    class="py-2 px-4 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600">
                    Kembali
                </a>
                <h3 class="text-xl font-bold text-gray-800">Total: Rp <span
                        id="total_display">{{ number_format($transaction->total_with_fees, 0, ',', '.') }}</span></h3>
                <form action="{{ route('transactions.pay', $transaction->id) }}" method="POST"
                    onsubmit="return setRekberFee()">
                    @csrf
                    <input type="hidden" name="rekber_fee" id="rekber_fee_input"
                        value="{{ $transaction->rekber_fee }}">
                    <button type="submit"
                        class="py-2 px-4 bg-green-500 text-white rounded-lg shadow hover:bg-green-600">
                        Bayar Sekarang
                    </button>
                </form>
            </div>

            <script>
                function validateRekberFee() {
                    const rekberFeeInput = document.getElementById('rekber_fee');
                    let value = parseInt(rekberFeeInput.value) || 0;

                    // Pastikan nilai tidak negatif dan kelipatan 500
                    if (value < 0) {
                        value = 0;
                    } else if (value % 500 !== 0) {
                        value = Math.round(value / 500) * 500; // Pembulatan ke kelipatan terdekat dari 500
                    }

                    rekberFeeInput.value = value;
                }

                function setRekberFee() {
                    const rekberFee = document.getElementById('rekber_fee').value || 0;
                    document.getElementById('rekber_fee_input').value = rekberFee;
                    return true;
                }

                function updateTotal() {
                    const totalAmount = {{ $transaction->total_amount }};
                    const paymentGatewayFee = {{ $transaction->payment_gateway_fee }};
                    const handlingFee = {{ $transaction->handling_fee }};
                    const rekberFee = parseFloat(document.getElementById('rekber_fee').value) || 0;
                    const totalWithFees = totalAmount + paymentGatewayFee + handlingFee + rekberFee;

                    document.getElementById('total_display').textContent = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(totalWithFees);
                }
            </script>
        </div>
    </div>
</x-app-layout>
