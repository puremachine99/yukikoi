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
                        <select id="winFilter"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                            onchange="filterKoi()">
                            <option value="all">Semua</option>
                            <option value="win">Menang</option>
                            <option value="lose">Kalah</option>
                            <option value="ongoing">On Going</option>
                        </select>
                    </div>

                    <!-- Filter by Auction Status -->
                    <div>
                        <label for="statusFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">By
                            Status Lelang:</label>
                        <select id="statusFilter"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                            onchange="filterKoi()">
                            <option value="ongoing">Berlangsung</option>
                            <option value="finished">Selesai</option>
                        </select>
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
                                    alt="Koi Image" class="w-24 h-24 rounded-lg object-cover">

                                <!-- Right side: Koi and auction information -->
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $bid->koi->kode_ikan . '. ' . $bid->koi->judul . ' ' . $bid->koi->ukuran }}
                                        cm<br>
                                        <span class="uppercase">({{ $bid->koi->gender }})</span>
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
</x-app-layout>

<script>
    function filterKoi() {
        // Get selected filter values
        const winFilter = document.getElementById('winFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;

        // Loop through each koi item and toggle visibility based on filter
        document.querySelectorAll('[data-koi-row]').forEach(koiRow => {
            const winStatus = koiRow.getAttribute('data-win-status'); // Menang/Kalah/On Going
            const auctionStatus = koiRow.getAttribute('data-auction-status'); // Berlangsung/Selesai

            // Filter by Win Status
            const winMatch = (winFilter === 'all') || (winFilter === winStatus);

            // Filter by Auction Status
            const statusMatch = (statusFilter === auctionStatus);

            // Toggle visibility based on filters
            koiRow.style.display = (winMatch && statusMatch) ? 'block' : 'none';
        });
    }
    // Fungsi utama untuk validasi PIN sebelum melakukan aksi
    function handlePinValidation(koiId, actionType, amount = null) {
        Swal.fire({
            title: 'Konfirmasi PIN Anda',
            input: 'text', // Menggunakan input type password untuk PIN
            inputAttributes: {
                maxlength: 4,
                autocapitalize: 'off',
                autocorrect: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Konfirmasi',
            showLoaderOnConfirm: true,
            preConfirm: (pin) => {
                // Kirim PIN ke backend untuk verifikasi
                return fetch('{{ route('pin.confirm') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            koi_id: koiId,
                            pin: pin
                        })
                    }).then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            Swal.showValidationMessage(`PIN salah: ${data.message}`);
                        }
                        return data;
                    }).catch(error => {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed && result.value.success) {
                if (actionType === 'BIN') {
                    processBIN(koiId); // Panggil fungsi proses BIN setelah validasi PIN berhasil
                } else if (actionType === 'BID' && amount !== null) {
                    processBid(koiId, amount); // Panggil fungsi proses BID setelah validasi PIN berhasil
                }
            }
        });
    }

    // Fungsi untuk proses BIN setelah PIN valid
    function processBIN(koiId) {
        fetch('{{ route('bids.bin') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    koi_id: koiId
                })
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Pembelian berhasil!',
                        text: `Koi berhasil dibeli dengan harga Rp ${new Intl.NumberFormat('id-ID').format(data.winner.amount)}`,
                        icon: 'success'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'BIN Gagal',
                        text: data.message,
                        icon: 'error'
                    });
                }
            });
    }

    // Fungsi untuk proses BID setelah PIN valid
    function processBid(koiId, amount) {
        fetch('{{ route('bids.check') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    koi_id: koiId,
                    bid_amount: amount
                })
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Jika bid valid, simpan bid
                    fetch('{{ route('bids.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                koi_id: koiId,
                                bid_amount: amount
                            })
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Bid Berhasil!',
                                    text: `Berhasil pasang bid senilai Rp ${new Intl.NumberFormat('id-ID').format(amount)}`,
                                    icon: 'success',
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Ada masalah saat memasang bid.',
                                    icon: 'error',
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            }
                        });
                } else {
                    Swal.fire({
                        title: 'Bid Tidak Valid',
                        text: data.message,
                        icon: 'error',
                        timer: 2000,
                        timerProgressBar: true
                    });
                }
            }).catch(error => console.error('Error:', error));
    }

    // Fungsi untuk handle tombol BIN
    function handleBINClick(koiId) {
        handlePinValidation(koiId, 'BIN'); // Panggil validasi PIN untuk BIN
    }

    // Fungsi untuk handle tombol BID
    function handlePlaceBid(koiId) {
        const amountInput = document.getElementById(`bid-amount-${koiId}`);
        const amount = parseInt(amountInput.value);
        const increment = parseInt(amountInput.dataset.increment);
        const lastBid = parseInt(amountInput.dataset.lastBid);

        if (amount < lastBid + increment) {
            Swal.fire({
                title: 'Error',
                text: 'Bid amount kurang dari minimum bid.',
                icon: 'error',
                timer: 2000,
                timerProgressBar: true
            });
            return;
        }

        handlePinValidation(koiId, 'BID', amount); // Panggil validasi PIN sebelum melakukan BID
    }

    // Fungsi untuk handle Plus button
    function handlePlus(koiId) {
        const input = document.getElementById(`bid-amount-${koiId}`);
        let currentBid = parseInt(input.value);
        const increment = parseInt(input.dataset.increment);

        input.value = currentBid + increment;
    }

    // Fungsi untuk handle Minus button
    function handleMinus(koiId) {
        const input = document.getElementById(`bid-amount-${koiId}`);
        let currentBid = parseInt(input.value);
        const lastBid = parseInt(input.dataset.lastBid);
        const increment = parseInt(input.dataset.increment);

        // Tidak bisa kurang dari bid minimum
        const minimumBid = lastBid + increment;
        input.value = Math.max(currentBid - increment, minimumBid);
    }

    function updateBidAmount(koiId, newAmount, userId) {
        const priceCell = document.getElementById(`price-cell-${koiId}`);
        const koiRow = document.getElementById(`koi-row-${koiId}`);
        const myBidCell = document.getElementById(`my-bid-cell-${koiId}`);

        if (!priceCell || !koiRow) {
            console.error(`Element with ID price-cell-${koiId} or koi-row-${koiId} not found!`);
            return;
        }

        // Update Last Bid column
        priceCell.innerText = newAmount;

        // Highlight perubahan sementara untuk Last Bid
        priceCell.classList.add('highlight');
        setTimeout(() => {
            priceCell.classList.remove('highlight');
        }, 2000);

        // Update juga input bid-amount dengan nilai terbaru dan atur minimum
        const input = document.getElementById(`bid-amount-${koiId}`);
        if (input) {
            const increment = parseInt(input.dataset.increment);
            const minimumBid = newAmount + increment;
            input.value = minimumBid;
            input.min = minimumBid;
        }

        // Cek apakah bid dilakukan oleh user yang sedang login dan sesuaikan warna baris
        const loggedInUserId = {{ auth()->id() }}; // Pastikan id user dari blade
        if (userId == loggedInUserId) {
            koiRow.classList.add('bg-green-100'); // Hijau jika user login yang melakukan bid
            koiRow.classList.remove('bg-red-100');

            // Update "My Bid" jika user yang login melakukan bid terbaru
            if (myBidCell) {
                myBidCell.innerText = newAmount;
                myBidCell.classList.add('highlight');
                setTimeout(() => {
                    myBidCell.classList.remove('highlight');
                }, 2000);
            }
        } else {
            koiRow.classList.add('bg-red-100'); // Merah jika bid dilakukan oleh user lain
            koiRow.classList.remove('bg-green-100');
        }
    }

    function handleAuctionWinner(koiId, winnerName, winnerAmount) {
        const koiRow = document.getElementById(`koi-row-${koiId}`);
        if (koiRow) {
            const actionsCell = koiRow.querySelector('.flex.items-center.space-x-2');

            if (actionsCell) {
                // Ganti tombol-tombol dengan informasi pemenang
                actionsCell.innerHTML = `<span class="text-green-500 font-bold">
        Winner: ${winnerName} - Rp ${new Intl.NumberFormat('id-ID').format(winnerAmount)}
    </span>`;

                // Optional: Tambahkan efek highlight pada baris pemenang
                koiRow.classList.add('bg-yellow-100');
                setTimeout(() => {
                    koiRow.classList.remove('bg-yellow-100');
                }, 3000);
            }
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Event listener untuk tombol bid, plus, minus, dan BIN
        document.addEventListener('click', function(event) {
            const target = event.target;

            // Handle BIN button
            if (target.matches('.bin-btn')) {
                const koiId = target.dataset.koiId;
                handleBINClick(koiId);
            }

            // Handle Place Bid button
            if (target.matches('.place-bid-btn')) {
                const koiId = target.dataset.koiId;
                handlePlaceBid(koiId);
            }
        });
    });
</script>
