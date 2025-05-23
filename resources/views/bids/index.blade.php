<x-app-layout>
    <style>
        .bg-green-100 {
            background-color: #d4f4dd;
            /* Warna hijau muda */
        }

        .bg-red-100 {
            background-color: #f8d7da;
            /* Warna merah muda */
        }

        .highlight {
            background-color: lightblue;
            transition: background-color 1s ease;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('List Bid Koi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex space-x-4 mb-4">
                    <!-- Filter by Win Status -->
                    <div>
                        <label for="winFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">By
                            Win:</label>
                        <x-select id="winFilter"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                            onchange="filterKoi()">
                            <option value="all">Semua</option>
                            <option value="win">Menang</option>
                            <option value="lose">Kalah</option>
                            <option value="ongoing">On Going</option>
                        </x-select>
                    </div>

                    <!-- Filter by Auction Status -->
                    <div>
                        <label for="statusFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">By
                            Status Lelang:</label>
                        <x-select id="statusFilter"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                            onchange="filterKoi()">
                            <option value="ongoing">Berlangsung</option>
                            <option value="finished">Selesai</option>
                        </x-select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($kois as $index => $bid)
                        @php
                            $latestBid = $bid->koi->bids->first();
                            $winner = $winners->get($bid->koi_id);
                            $userBid = $bid->koi->bids->firstWhere('user_id', Auth::id());
                            $farmName = $bid->koi->auction->user->farm_name ?? 'Unknown Farm';
                            $winStatus = $winner ? ($winner->user_id === Auth::id() ? 'win' : 'lose') : 'ongoing';
                            $auctionStatus = $bid->koi->auction->status === 'on going' ? 'ongoing' : 'finished';
                        @endphp

                        <div id="koi-row-{{ $bid->koi->id }}" data-koi-row data-win-status="{{ $winStatus }}"
                            data-auction-status="{{ $auctionStatus }}"
                            class="bg-white dark:bg-zinc-700 rounded-lg shadow border {{ $winner && $winner->user_id === Auth::id() ? 'bg-green-100' : ($winner && $winner->user_id !== Auth::id() ? 'bg-red-100' : '') }}"
                            data-koi-id="{{ $bid->koi->id }}" x-data="{ bidAmount: {{ $bid->amount + $bid->koi->kelipatan_bid }} }" x-init="Echo.channel('koi.{{ $bid->koi->id }}')
                                .listen('PlaceBid', (event) => {
                                    let koiId = event.bid.koi_id;
                                    let newAmount = event.bid.amount;
                                    let userId = event.bid.user.id;
                                    updateBidAmount(koiId, newAmount, userId);
                                })
                                .listen('AuctionWon', (event) => {
                                    if (!event.winner || !event.winner.koi_id) {
                                        return console.error('Invalid event data: koi_id is missing');
                                    }
                            
                                    const koiId = event.winner.koi_id;
                                    const koiRow = document.getElementById(`koi-row-${koiId}`);
                                    const actionsCell = document.getElementById(`actions-cell-${koiId}`);
                                    const loggedInUserId = {{ auth()->id() }};
                            
                                    if (koiRow && actionsCell) {
                                        if (event.winner.id === loggedInUserId) {
                                            koiRow.classList.add('bg-green-100');
                                            actionsCell.innerHTML = `
                                                                            <span class='text-green-500 font-bold'>
                                                                                Winner: ${event.winner.name} - Rp ${new Intl.NumberFormat('id-ID').format(event.winner.amount)}
                                                                            </span>`;
                                        } else {
                                            koiRow.classList.add('bg-red-100');
                                            actionsCell.innerHTML = `
                                                                            <span class='text-red-500 font-bold'>
                                                                                Defeated by: ${event.winner.name} - Rp ${new Intl.NumberFormat('id-ID').format(event.winner.amount)}
                                                                            </span>`;
                                        }
                                    }
                                });">
                            <div class="flex items-center p-4 space-x-4">
                                <!-- Left side: Koi image -->
                                <img src="{{ asset('storage/' . ($bid->koi->media->where('media_type', 'photo')->first()->url_media ?? 'default-koi.jpg')) }}"
                                    alt="Koi Image" class="w-24 h-auto rounded-lg object-cover">

                                <!-- Right side: Koi and auction information -->
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $bid->koi->kode_ikan . '. ' . $bid->koi->judul . ' ' . $bid->koi->ukuran }}
                                        cm <span class="uppercase">
                                            ({{ $bid->koi->gender === 'male' ? 'M' : ($bid->koi->gender === 'female' ? 'F' : '') }})
                                        </span>

                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        {{ $farmName }}
                                    </p>

                                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                        <p><strong>Lelang:</strong> {{ $bid->koi->auction->auction_code }}</p>
                                        <div class="flex justify-between">
                                            <p><strong>OB:</strong>
                                                {{ number_format($bid->koi->open_bid, 0, ',', '.') }}</p>
                                            <p><strong>KB:</strong>
                                                {{ number_format($bid->koi->kelipatan_bid, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="flex justify-between mt-1">
                                            <p><strong>My Bid:</strong>
                                                <span
                                                    id="my-bid-cell-{{ $bid->koi->id }}">{{ $userBid ? number_format($userBid->amount, 0, ',', '.') : '-' }}</span>
                                            </p>
                                            <p><strong>Last Bid:</strong>
                                                <span
                                                    id="price-cell-{{ $bid->koi->id }}">{{ number_format($latestBid->amount ?? 0, 0, ',', '.') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer: Bid controls -->
                            <div class="flex space-x-2 px-4 py-2 border-t bg-gray-100 dark:bg-gray-800 rounded-b-lg"
                                id="actions-cell-{{ $bid->koi->id }}">
                                @if ($winner && $winner->user_id === Auth::id())
                                    <span class="text-green-500 font-bold">
                                        Winner: {{ $winner->user->name }} - Rp
                                        {{ number_format($winner->amount, 0, ',', '.') }}
                                    </span>
                                @elseif ($winner && $winner->user_id !== Auth::id())
                                    <span class="text-red-500 font-bold">
                                        Defeated by: {{ $winner->user->name }} - Rp
                                        {{ number_format($winner->amount, 0, ',', '.') }}
                                    </span>
                                @else
                                    <button id="bin-btn-{{ $bid->koi->id }}"
                                        class="bin-btn bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600 text-xs"
                                        data-koi-id="{{ $bid->koi->id }}">
                                        BIN
                                    </button>
                                    <button id="minus-btn-{{ $bid->koi->id }}"
                                        onclick="handleMinus('{{ $bid->koi->id }}')"
                                        class="bg-gray-300 w-10 text-gray-700 px-2 py-1 rounded-md hover:bg-gray-400 text-xs">-</button>
                                    <input id="bid-amount-{{ $bid->koi->id }}" type="number"
                                        value="{{ $latestBid ? $latestBid->amount + $bid->koi->kelipatan_bid : $bid->koi->open_bid + $bid->koi->kelipatan_bid }}"
                                        data-increment="{{ $bid->koi->kelipatan_bid }}"
                                        data-last-bid="{{ $latestBid->amount ?? 0 }}"
                                        data-open-bid="{{ $bid->koi->open_bid }}"
                                        class="text-center w-60 bg-white border border-gray-300 rounded-md text-gray-700 mx-1 text-sm" />
                                    <button id="plus-btn-{{ $bid->koi->id }}"
                                        onclick="handlePlus('{{ $bid->koi->id }}')"
                                        class="bg-sky-500 w-10 text-white px-2 py-1 rounded-md hover:bg-sky-600 text-xs">+</button>
                                    <button id="place-bid-{{ $bid->koi->id }}"
                                        class="place-bid-btn bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-600 text-xs"
                                        data-koi-id="{{ $bid->koi->id }}">
                                        {{ $bid->koi->bids->isEmpty() ? __('Open Bid') : __('BID') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    <script>
        // ========================================== MULTI KOI BID SYSTEM ==========================================
        $(document).ready(function() {
            // Inisialisasi untuk semua koi
            $('[data-koi-row]').each(function() {
                const koiRow = $(this);
                const koiId = koiRow.data('koi-id');
                const auctionStatus = koiRow.data('auction-status');

                // Config untuk setiap koi
                const CONFIG = {
                    koiId: koiId,
                    userId: parseInt('{{ auth()->id() }}'),
                    csrfToken: "{{ csrf_token() }}",
                    openBid: parseInt(koiRow.find(`#bid-amount-${koiId}`).data('last-bid')) || parseInt(
                        koiRow.find(`#bid-amount-${koiId}`).data('open-bid')),
                    increment: parseInt(koiRow.find(`#bid-amount-${koiId}`).data('increment')),
                    lastBid: parseInt(koiRow.find(`#price-cell-${koiId}`).text().replace(/\./g, '')) ||
                        0,
                    binPrice: parseInt(koiRow.data('bin-price')) || 0,
                    routes: {
                        pinConfirm: "{{ route('pin.confirm') }}",
                        bidsStore: "{{ route('bids.store') }}",
                        bin: "{{ route('bids.bin') }}"
                    }
                };
                console.log(CONFIG);
                // Inisialisasi nilai awal
                let minimumBid = CONFIG.lastBid > 0 ?
                    CONFIG.lastBid + CONFIG.increment :
                    CONFIG.openBid + CONFIG.increment;

                $(`#bid-amount-${koiId}`).val(minimumBid);

                // ============================== EVENT HANDLERS ==============================
                // Plus Button
                $(`#plus-btn-${koiId}`).on('click', function() {
                    const current = parseInt($(`#bid-amount-${koiId}`).val());
                    const newAmount = current + CONFIG.increment;
                    $(`#bid-amount-${koiId}`).val(newAmount);
                });

                // Minus Button
                $(`#minus-btn-${koiId}`).on('click', function() {
                    const current = parseInt($(`#bid-amount-${koiId}`).val());
                    const newAmount = Math.max(
                        CONFIG.openBid + CONFIG.increment,
                        current - CONFIG.increment
                    );
                    $(`#bid-amount-${koiId}`).val(newAmount);
                });

                // Place Bid Button
                $(`#place-bid-${koiId}`).on('click', function() {
                    const amount = parseInt($(`#bid-amount-${koiId}`).val());
                    if (validateBid(koiId, amount)) {
                        handlePinValidation(koiId, 'BID', amount);
                    }
                });

                // BIN Button
                $(`#bin-btn-${koiId}`).on('click', function() {
                    handlePinValidation(koiId, 'BIN', CONFIG.binPrice);
                });

                // Real-time Bid Updates
                Echo.channel(`koi.${koiId}`)
                    .listen('PlaceBid', (event) => {
                        const newAmount = event.bid.amount;
                        updateBidDisplay(koiId, newAmount);
                    })
                    .listen('AuctionWon', (event) => {
                        handleAuctionResult(koiId, event.winner);
                    });
            });

            // ============================== SHARED FUNCTIONS ==============================
            function validateBid(koiId, amount) {
                const increment = $(`#bid-amount-${koiId}`).data('increment');
                const lastBid = parseInt($(`#price-cell-${koiId}`).text().replace(/\./g, ''));
                const minBid = lastBid > 0 ? lastBid + increment :
                    parseInt($(`#bid-amount-${koiId}`).data('open-bid')) + increment;

                if (amount < minBid) {
                    showAlert('error', `Bid harus minimal Rp ${formatCurrency(minBid)}`);
                    return false;
                }

                if ((amount - minBid) % increment !== 0) {
                    showAlert('error', `Bid harus kelipatan Rp ${formatCurrency(increment)}`);
                    return false;
                }

                return true;
            }

            function handlePinValidation(koiId, actionType, amount) {
                Swal.fire({
                    title: 'Verifikasi PIN',
                    input: 'text',
                    inputAttributes: {
                        maxlength: 4,
                        inputmode: 'numeric'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Konfirmasi',
                    preConfirm: (pin) => {
                        return $.ajax({
                            url: "{{ route('pin.confirm') }}",
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            data: {
                                koi_id: koiId,
                                pin: pin
                            }
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed && result.value.success) {
                        processBid(koiId, actionType, amount);
                    } else if (result.value && !result.value.success) {
                        showAlert('error', 'PIN tidak valid');
                    }
                });
            }

            function processBid(koiId, actionType, amount) {
                const route = actionType === 'BID' ? "{{ route('bids.store') }}" : "{{ route('bids.bin') }}";

                $.ajax({
                    url: route,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        koi_id: koiId,
                        bid_amount: amount
                    },
                    success: function(response) {
                        if (response.success) {
                            if (actionType === 'BIN') window.location.reload();
                            showAlert('success', response.message);
                            updateBidDisplay(koiId, amount);
                        } else {
                            showAlert('error', response.message);
                        }
                    }
                });
            }

            function updateBidDisplay(koiId, amount) {
                $(`#price-cell-${koiId}`).text(formatCurrency(amount));
                const newMinBid = amount + parseInt($(`#bid-amount-${koiId}`).data('increment'));
                $(`#bid-amount-${koiId}`).val(newMinBid);

                // Update user's last bid
                $(`#my-bid-cell-${koiId}`).text(formatCurrency(amount));
            }

            function handleAuctionResult(koiId, winner) {
                const actionsCell = $(`#actions-cell-${koiId}`);
                const isWinner = winner.user_id === {{ auth()->id() }};

                actionsCell.html(`
                    <span class="${isWinner ? 'text-green-500' : 'text-red-500'} font-bold">
                        ${isWinner ? 'Winner' : 'Defeated by'}: 
                        ${winner.name} - Rp ${formatCurrency(winner.amount)}
                    </span>
                `);

                $(`#koi-row-${koiId}`)
                    .removeClass('bg-gray-100')
                    .addClass(isWinner ? 'bg-green-100' : 'bg-red-100');
            }

            // ============================== UTILITIES ==============================
            function formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID').format(amount);
            }

            function showAlert(type, message) {
                Swal.fire({
                    icon: type,
                    title: message,
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    </script>
</x-app-layout>
