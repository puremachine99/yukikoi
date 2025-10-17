<x-app-layout>
    <style>
        .bg-green-100 { background-color: #d4f4dd; }
        .bg-red-100 { background-color: #f8d7da; }
        .highlight { background-color: lightblue; transition: background-color 1s ease; }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('List Bid Koi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex space-x-4 mb-4">
                    <div>
                        <label for="winFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">By Win:</label>
                        <x-select id="winFilter" class="mt-1 block w-full" onchange="filterKoi()">
                            <option value="all">Semua</option>
                            <option value="win">Menang</option>
                            <option value="lose">Kalah</option>
                            <option value="ongoing">On Going</option>
                        </x-select>
                    </div>
                    <div>
                        <label for="statusFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">By Status Lelang:</label>
                        <x-select id="statusFilter" class="mt-1 block w-full" onchange="filterKoi()">
                            <option value="ongoing">Berlangsung</option>
                            <option value="finished">Selesai</option>
                        </x-select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($kois as $index => $bid)
                        @php
                            $latestBid = $latestBids->get($bid->koi_id) ?? null;
                            $winner    = $winners->get($bid->koi_id) ?? null;
                        @endphp

                        <x-koi-card-monitor
                            :bid="$bid"
                            :latest-bid="$latestBid"
                            :winner="$winner"
                        />
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            window.BID_APP = {
                userId: {{ auth()->id() ?? 'null' }},
                routes: {
                    pinConfirm: "{{ route('pin.confirm') }}",
                    bidsStore: "{{ route('bids.store') }}",
                    bin: "{{ route('bids.bin') }}"
                }
            };
        </script>

        <script>
            (function () {
                const fmt = n => new Intl.NumberFormat('id-ID').format(parseInt(n || 0));
                const swal = (type, message) => {
                    Swal.fire({ icon: type, title: message, timer: 3000, showConfirmButton: false });
                };

                function initKoiRow(row) {
                    const koiId     = parseInt(row.dataset.koiId);
                    const increment = parseInt(row.dataset.increment);
                    const lastBid   = parseInt(row.dataset.lastBid) || 0;
                    const openBid   = parseInt(row.dataset.openBid) || 0;
                    const binPrice  = parseInt(row.dataset.binPrice) || 0;

                    const priceCell  = document.getElementById(`price-cell-${koiId}`);
                    const myBidCell  = document.getElementById(`my-bid-cell-${koiId}`);
                    const actionsCell= document.getElementById(`actions-cell-${koiId}`);

                    const input   = document.getElementById(`bid-amount-${koiId}`);
                    const plusBtn = document.getElementById(`plus-btn-${koiId}`);
                    const minusBtn= document.getElementById(`minus-btn-${koiId}`);
                    const bidBtn  = document.getElementById(`place-bid-${koiId}`);
                    const binBtn  = document.getElementById(`bin-btn-${koiId}`);

                    const minBid = (lastBid > 0 ? lastBid : openBid) + increment;
                    if (input) input.value = minBid;

                    if (plusBtn) plusBtn.addEventListener('click', () => {
                        input.value = parseInt(input.value || minBid) + increment;
                    });

                    if (minusBtn) minusBtn.addEventListener('click', () => {
                        const current = parseInt(input.value || minBid);
                        input.value = Math.max(openBid + increment, current - increment);
                    });

                    async function confirmPinAnd(actionType, amount) {
                        const { value: pin, isConfirmed } = await Swal.fire({
                            title: 'Verifikasi PIN',
                            input: 'text',
                            inputAttributes: { maxlength: 4, inputmode: 'numeric' },
                            showCancelButton: true,
                            confirmButtonText: 'Konfirmasi',
                            allowOutsideClick: () => !Swal.isLoading()
                        });
                        if (!isConfirmed) return;

                        try {
                            const res = await fetch(BID_APP.routes.pinConfirm, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({ koi_id: koiId, pin })
                            });
                            const data = await res.json();
                            if (!data.success) return swal('error', data.message || 'PIN tidak valid');
                        } catch {
                            return swal('error', 'Gagal verifikasi PIN');
                        }

                        const url = actionType === 'BIN' ? BID_APP.routes.bin : BID_APP.routes.bidsStore;
                        try {
                            const res = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({ koi_id: koiId, bid_amount: amount })
                            });
                            const data = await res.json();

                            if (!data.success) return swal('error', data.message || 'Gagal mengirim');

                            if (actionType === 'BIN') {
                                window.location.reload();
                                return;
                            }

                            priceCell.textContent = fmt(amount);
                            input.value = amount + increment;
                            myBidCell.textContent = fmt(amount);
                            swal('success', data.message || 'Bid berhasil');
                        } catch {
                            swal('error', 'Terjadi kesalahan jaringan');
                        }
                    }

                    function validateBidAmount(amount) {
                        const last = parseInt((priceCell.textContent || '0').replace(/\./g, '')) || 0;
                        const min  = (last > 0 ? last : openBid) + increment;

                        if (amount < min) {
                            swal('error', `Bid harus minimal Rp ${fmt(min)}`);
                            return false;
                        }
                        if ((amount - min) % increment !== 0) {
                            swal('error', `Bid harus kelipatan Rp ${fmt(increment)}`);
                            return false;
                        }
                        return true;
                    }

                    if (bidBtn) {
                        bidBtn.addEventListener('click', () => {
                            const amount = parseInt(input.value || 0);
                            if (validateBidAmount(amount)) confirmPinAnd('BID', amount);
                        });
                    }

                    if (binBtn) {
                        binBtn.addEventListener('click', () => {
                            if (!binPrice) return swal('error', 'Harga BIN tidak tersedia');
                            confirmPinAnd('BIN', binPrice);
                        });
                    }

                    if (typeof Echo !== 'undefined') {
                        Echo.channel(`koi.${koiId}`)
                            .listen('PlaceBid', (event) => {
                                const newAmount = event.bid.amount;
                                priceCell.textContent = fmt(newAmount);
                                input.value = newAmount + increment;
                                myBidCell.textContent = fmt(newAmount);

                                row.classList.add('highlight');
                                setTimeout(() => row.classList.remove('highlight'), 800);
                            })
                            .listen('AuctionWon', (event) => {
                                const w = event.winner;
                                if (!w || !w.koi_id || w.koi_id !== koiId) return;

                                const isMe = (w.user_id === BID_APP.userId);
                                row.classList.remove('bg-gray-100');
                                row.classList.add(isMe ? 'bg-green-100' : 'bg-red-100');

                                actionsCell.innerHTML = `
                                    <span class="${isMe ? 'text-green-500' : 'text-red-500'} font-bold">
                                        ${isMe ? 'Winner' : 'Defeated by'}: ${w.name} - Rp ${fmt(w.amount)}
                                    </span>
                                `;
                            });
                    }
                }

                document.querySelectorAll('[data-koi-row]').forEach(initKoiRow);

                window.filterKoi = function () {
                    const win = document.getElementById('winFilter').value;
                    const status = document.getElementById('statusFilter').value;

                    document.querySelectorAll('[data-koi-row]').forEach(row => {
                        const w = row.dataset.winStatus;      // win | lose | ongoing
                        const s = row.dataset.auctionStatus;  // ongoing | finished
                        const passWin = (win === 'all') || (w === win);
                        const passStatus = (s === status);
                        row.style.display = (passWin && passStatus) ? '' : 'none';
                    });
                };
            })();
        </script>
    @endpush
</x-app-layout>
