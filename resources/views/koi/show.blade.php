<x-app-layout>
    <style>
        @font-face {
            font-family: 'OnsenJapanDemoRegular';
            src: url('/fonts/OnsenJapanDemoRegular.ttf') format('truetype');
        }

        .vertical-text {
            writing-mode: vertical-rl;
            text-orientation: upright;
            letter-spacing: -0.2rem;
            z-index: 99;
            /* Adjust spacing between letters if needed */
        }

        .vertical-text-jp {
            font-family: 'OnsenJapanDemoRegular', sans-serif;
            writing-mode: vertical-rl;
            text-orientation: upright;
            letter-spacing: -0.2rem;
            z-index: 99;
        }

        .watermarked-image {
            position: relative;
            display: inline-block;
            overflow: hidden;
        }

        .koi-image {
            width: 100%;
            height: auto;
        }

        .watermark-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            /* Adjust opacity to make it look like a watermark */
            pointer-events: none;
            /* Make watermark unclickable */
        }

        .watermark-logo {
            width: 80%;
            /* Adjust size as needed */
            max-width: 500px;
            height: auto;
            filter: grayscale(100%);
            /* Optional: make the watermark grayscale */
        }


        .text-outline {
            text-shadow:
                -1px -1px 0 #000,
                1px -1px 0 #000,
                -1px 1px 0 #000,
                1px 1px 0 #000;
        }
    </style>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <!-- Tombol Kembali ke Daftar Lelang -->
            <a href="{{ route('auctions.show', ['auction_code' => $koi->auction->auction_code]) }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-300 focus:bg-gray-700 dark:focus:bg-gray-300 active:bg-gray-800 dark:active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 transition ease-in-out duration-150">
                <i class="fa-solid fa-arrow-left"></i> &nbsp; Lelang {{ $koi->auction->auction_code }}
            </a>
            <h2 class="font-semibold text-xl text-center text-zinc-800 dark:text-zinc-200 leading-tight">
                {{ __('Detail Koi') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 ">
                <!-- Bagian Gambar dan Video Koi -->
                @include('koi.partials.carousel', ['koi' => $koi])

                <!-- Bagian Detail Koi -->
                <div
                    class="bg-white dark:bg-zinc-800 p-4 sm:rounded-lg w-full rounded-lg shadow-lg relative overflow-visible ">
                    {{-- Info Koi --}}
                    @include('koi.partials.koi-details', ['koi' => $koi])

                    <!-- Bid + chat History -->
                    @include('koi.partials.history', [
                        'history' => $history,
                        'isAuctionOngoing' => $isAuctionOngoing,
                        'isBIN' => $isBIN,
                        'isAuctionReady' => $isAuctionReady,
                    ])
                </div>
            </div>
            @include('koi.partials.rekomendasi')
        </div>

        <div x-data="{ showUserList: false, usersHere: [] }" x-init="Echo.join('koi.{{ $koi->id }}')
            .here((users) => {
                usersHere = users;
            })
            .joining((user) => {
                usersHere.push(user);
            })
            .leaving((user) => {
                usersHere = usersHere.filter(u => u.id !== user.id);
            })">
            <!-- Button to toggle user list -->
            <div class="fixed bottom-4 right-4">
                <button @click="showUserList = !showUserList"
                    class="btn btn-circle relative bg-blue-500 text-white hover:bg-blue-600">
                    <i class="fa-solid fa-users"></i>
                    <span class="badge badge-sm badge-accent absolute top-0 right-0" x-text="usersHere.length"></span>
                </button>
            </div>

            <!-- Drawer-like user list -->
            <div x-show="showUserList" x-transition
                class="fixed bottom-16 right-4 w-64 bg-white shadow-lg rounded-lg max-h-80 overflow-y-auto p-4 dark:bg-zinc-800 dark:text-white">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Users Online</h2>
                    <button @click="showUserList = false"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
                <ul role="list" class="divide-y divide-gray-100">
                    <template x-for="user in usersHere" :key="user.id">
                        <a :href="`/profile/${user.id}`"
                            class="flex min-w-0 gap-x-4 transition duration-200 ease-in-out hover:bg-indigo-100 hover:bg-opacity-50 dark:hover:bg-indigo-700 dark:hover:bg-opacity-30">
                            <li class="flex justify-between gap-x-6 py-5">
                                <!-- Dynamically set the profile URL using Alpine.js -->
                                <!-- Profile Picture -->
                                <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                    :src="user.dp ? '/storage/' + user.dp : 'https://via.placeholder.com/40x40'"
                                    alt="Avatar" />
                                <div class="min-w-0 flex-auto">
                                    <!-- User Name -->
                                    <p class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-200"
                                        x-text="user.name"></p>
                                    <!-- Phone Number -->
                                    <p class="mt-1 truncate text-xs leading-5 text-gray-500 dark:text-gray-400"
                                        x-text="user.farm"></p>
                                </div>
                                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                    <!-- Presence Status -->
                                    <div class="mt-1 flex items-center gap-x-1.5">
                                        <div class="flex-none rounded-full bg-emerald-500/20 p-1">
                                            <div class="h-1.5 w-1.5 rounded-full bg-emerald-500"></div>
                                        </div>
                                        <p class="text-xs leading-5 text-gray-500">Online</p>
                                    </div>
                                </div>
                            </li>
                        </a>
                    </template>
                </ul>

            </div>
        </div>
        {{-- History --}}
        <div x-init="Echo.channel('koi.{{ $koi->id }}')
            .listen('PlaceBid', (event) => appendBidToHistory(event))
            .listen('ChatMessage', (event) => appendChatToHistory(event))
            .listen('AuctionWon', (event) => {
                handleAuctionWinner(event.winner.name, event.winner.amount);
                appendBINToHistory(event);
            })"></div>
        {{-- extra time 10 menit --}}
        <div x-init="Echo.channel('koi.{{ $koi->auction->auction_code }}')
            .listen('ExtraTimeAdded', (event) => {
                extraTime = event.extra_time;
                endTime = new Date(event.new_end_time).getTime(); // Update the endTime with new time
            });">
        </div>
        {{-- Lelang Berakhir --}}
        <div x-init="Echo.channel('auctions')
            .listen('AuctionEnded', (event) => {
                handleAuctionEnd();
            });"></div>
        {{-- modal video koi --}}
        <div id="videoModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50"
            onclick="closeVideoModal()">
            <div class="bg-white dark:bg-zinc-800 p-0 rounded-lg max-w-7xl w-auto max-h-screen overflow-auto">
                <video id="modalVideo" class="w-full h-auto mt-0 rounded-lg" controls style="max-height: 90vh;">
                    <source id="videoSource" src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>

    </div>


    <script>
        // ================================ CONFIGURATIONS ================================
        const KOI_ID = "{{ $koi->id }}"; // ID Koi
        const LOGGED_IN_USER_ID = parseInt('{{ auth()->id() }}'); // ID User login
        const OPEN_BID = {{ $koi->open_bid }}; // Open bid dari backend
        const INCREMENT = {{ $koi->kelipatan_bid }}; // Kelipatan bid
        const LAST_BID = {{ $koi->bids->isNotEmpty() ? $koi->bids->last()->amount : 0 }}; // Last bid
        const BIN_PRICE = {{ $koi->buy_it_now }}; // Harga BIN
        const THRESHOLD = 0.8 * BIN_PRICE; // Threshold BIN (80% dari harga BIN)
        const IS_AUCTION_ONGOING = @json($isAuctionOngoing); // Status lelang dari backend
        const EXTRA_TIME_MINUTES = 10; // Tambahan waktu saat sniping (bisa diatur dari admin)
        const CHAT_ENDPOINT = "{{ route('chat.store') }}"; // Endpoint untuk chat
        const BID_CHECK_ENDPOINT = "{{ route('bids.check') }}"; // Endpoint untuk validasi bid
        const BID_STORE_ENDPOINT = "{{ route('bids.store') }}"; // Endpoint untuk menyimpan bid
        const BIN_ENDPOINT = "{{ route('bids.bin') }}"; // Endpoint untuk proses BIN
        const PIN_CONFIRM_ENDPOINT = "{{ route('pin.confirm') }}"; // Endpoint untuk validasi PIN

        // ================================ DOM REFERENCES ================================
        const bidAmountInput = document.getElementById('bid-amount');
        const placeBidButton = document.getElementById('place-bid');
        const binButton = document.getElementById('bin-btn');
        const chatInput = document.getElementById('chat-input');
        const auctionEndMessage = document.querySelector('.auction-end-message');
        const bidHistory = document.getElementById('history');
        const timerDisplay = document.getElementById("timer-display");
        const plusBtn = document.getElementById('plus-btn');
        const minusBtn = document.getElementById('minus-btn');

        let minimumBid = LAST_BID > 0 ? LAST_BID + INCREMENT : OPEN_BID; // Minimal bid awal
        let extraTime = 0; // Extra time saat sniping
        let scrollPosition = 0;

        // ================================ HELPER FUNCTIONS ================================
        function fetchRequest(url, method, body = null) {
            return fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: body ? JSON.stringify(body) : null
            }).then(response => response.json());
        }

        function scrollToBottom() {
            bidHistory.scrollTop = bidHistory.scrollHeight;
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID').format(amount);
        }

        function disableControls() {
            binButton.style.display = 'none';
            placeBidButton.style.display = 'none';
            bidAmountInput.disabled = true;
            bidAmountInput.style.display = 'none';
            minusBtn.style.display = 'none';
            plusBtn.style.display = 'none';
            if (auctionEndMessage) {
                auctionEndMessage.style.display = 'block';
            }
        }

        function enableControls() {
            binButton.style.display = 'inline-block';
            placeBidButton.style.display = 'inline-block';
            bidAmountInput.disabled = false;
            bidAmountInput.style.display = 'inline-block';
            minusBtn.style.display = 'inline-block';
            plusBtn.style.display = 'inline-block';
            if (auctionEndMessage) {
                auctionEndMessage.style.display = 'none';
            }
        }

        function handleAuctionEnd() {
            disableControls();
        }

        function handleAuctionOngoing() {
            enableControls();
        }

        function handleAuctionWinner(winnerName, winnerAmount) {
            disableControls();

            const winnerMessage = document.createElement('h2');
            winnerMessage.classList.add('text-lg', 'font-bold', 'text-green-600');
            winnerMessage.innerHTML = `Winner: ${winnerName} 👑 - Rp ${formatCurrency(winnerAmount)}`;

            const bidControlContainer = document.querySelector('.flex.items-center.space-x-2.mb-2');
            bidControlContainer.innerHTML = '';
            bidControlContainer.appendChild(winnerMessage);

            Swal.fire({
                title: 'Auction Winner!',
                text: `${winnerName} telah memenangkan lelang dengan BIN Rp ${formatCurrency(winnerAmount)}!`,
                icon: 'success',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            }).then(() => window.location.reload());
        }

        // ================================ CORE FUNCTIONS ================================
        function processBIN() {
            fetchRequest(BIN_ENDPOINT, 'POST', {
                    koi_id: KOI_ID
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Pembelian berhasil!',
                            text: `Koi berhasil dibeli dengan harga Rp ${formatCurrency(data.cart.price)}`,
                            icon: 'success'
                        }).then(() => window.location.reload());
                    } else {
                        Swal.fire({
                            title: 'BIN Gagal',
                            text: data.message,
                            icon: 'error'
                        });
                    }
                });
        }

        function processBid() {
            const bidAmount = parseInt(bidAmountInput.value);

            fetchRequest(BID_CHECK_ENDPOINT, 'POST', {
                    koi_id: KOI_ID,
                    bid_amount: bidAmount
                })
                .then(validation => {
                    if (validation.success) {
                        fetchRequest(BID_STORE_ENDPOINT, 'POST', {
                                koi_id: KOI_ID,
                                bid_amount: bidAmount
                            })
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Bid Berhasil!',
                                        text: `Berhasil pasang bid senilai Rp ${formatCurrency(bidAmount)}`,
                                        icon: 'success',
                                        timer: 1000,
                                        timerProgressBar: true
                                    });
                                    scrollToBottom();
                                }
                            });
                    } else {
                        Swal.fire({
                            title: 'Bid Tidak Valid',
                            text: validation.message,
                            icon: 'error'
                        });
                    }
                });
        }

        function handlePinValidation(actionType) {
            Swal.fire({
                title: 'Konfirmasi PIN Anda',
                input: 'text',
                inputAttributes: {
                    maxlength: 4,
                    autocapitalize: 'off',
                    autocorrect: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Konfirmasi',
                preConfirm: pin => fetchRequest(PIN_CONFIRM_ENDPOINT, 'POST', {
                        koi_id: KOI_ID,
                        pin
                    })
                    .then(data => {
                        if (!data.success) {
                            Swal.showValidationMessage(`PIN salah: ${data.message}`);
                        }
                        return data;
                    })
            }).then(result => {
                if (result.isConfirmed && result.value.success) {
                    if (actionType === 'BIN') {
                        processBIN();
                    } else if (actionType === 'BID') {
                        processBid();
                    }
                }
            });
        }

        // ================================ EVENT LISTENERS ================================
        document.addEventListener("DOMContentLoaded", function() {
            if (IS_AUCTION_ONGOING) {
                handleAuctionOngoing();
            } else {
                handleAuctionEnd();
            }

            plusBtn.addEventListener('click', () => {
                bidAmountInput.value = parseInt(bidAmountInput.value) + INCREMENT;
            });

            minusBtn.addEventListener('click', () => {
                const currentBid = parseInt(bidAmountInput.value);
                bidAmountInput.value = Math.max(currentBid - INCREMENT, minimumBid);
            });

            binButton.addEventListener('click', () => {
                if (LAST_BID >= THRESHOLD) {
                    Swal.fire({
                        title: "BIN Gagal",
                        text: "Harga Lelang sudah terlalu tinggi",
                        icon: "error"
                    });
                } else {
                    handlePinValidation('BIN');
                }
            });

            placeBidButton.addEventListener('click', () => handlePinValidation('BID'));
        });

        // ================================ TIMER HANDLING ================================
        function updateTimer() {
            const now = new Date().getTime();
            const distance = (new Date(
                "{{ \Carbon\Carbon::parse($koi->auction->end_time)->addMinutes($koi->auction->extra_time)->toDateTimeString() }}"
                ).getTime() + extraTime * 60000) - now;

            if (distance < 0) {
                timerDisplay.innerHTML = "Lelang Berakhir";
                clearInterval(timerInterval);
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            timerDisplay.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        }

        const timerInterval = setInterval(updateTimer, 1000);
    </script>


</x-app-layout>
