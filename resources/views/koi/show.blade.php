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
                class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-300 focus:bg-gray-700 dark:focus:bg-gray-300 active:bg-gray-800 dark:active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <i class="fa-solid fa-arrow-left"></i> &nbsp; Lelang {{ $koi->auction->auction_code }}
            </a>
            <h2 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight">
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
                    class="bg-white dark:bg-gray-800 p-4 sm:rounded-lg w-full rounded-lg shadow-lg relative overflow-visible ">
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
                class="fixed bottom-16 right-4 w-64 bg-white shadow-lg rounded-lg max-h-80 overflow-y-auto p-4 dark:bg-gray-800 dark:text-white">
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
        {{-- History (deleted -> go to script hehe) --}}

        {{-- modal video koi --}}
        <div id="videoModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50"
            onclick="closeVideoModal()">
            <div class="bg-white dark:bg-gray-800 p-0 rounded-lg max-w-7xl w-auto max-h-screen overflow-auto">
                <video id="modalVideo" class="w-full h-auto mt-0 rounded-lg" controls style="max-height: 90vh;">
                    <source id="videoSource" src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>

    </div>
    <script>
        // ========================================== CHAT + BID SYSTEM ==========================================
        $(document).ready(function() {
            // ============================== CONFIGURATIONS ===============================
            const CONFIG = {
                koiId: "{{ $koi->id }}",
                userProfilePhoto: "{{ optional(auth()->user())->profile_photo ?: asset('storage/avatar/user-default.png') }}",
                userId: parseInt('{{ auth()->id() }}'),
                csrfToken: "{{ csrf_token() }}",
                openBid: {{ $koi->open_bid }},
                increment: {{ $koi->kelipatan_bid }},
                lastBid: {{ $koi->bids->isNotEmpty() ? $koi->bids->last()->amount : 0 }},
                binPrice: {{ $koi->buy_it_now }},
                threshold: 0.8 * {{ $koi->buy_it_now }},
                isAuctionOngoing: @json($isAuctionOngoing),
                penaltytime: 900,
                endTime: new Date(
                    "{{ \Carbon\Carbon::parse($koi->auction->end_time)->addMinutes($koi->auction->extra_time)->toDateTimeString() }}"
                ).getTime(),
                routes: {
                    chatStore: "{{ route('chat.store') }}",
                    bidsCheck: "{{ route('bids.check') }}",
                    bidsStore: "{{ route('bids.store') }}",
                    pinConfirm: "{{ route('pin.confirm') }}",
                    bin: "{{ route('bids.bin') }}"
                }
            };

            let minimumBid = CONFIG.lastBid > 0 ? CONFIG.lastBid + CONFIG.increment : CONFIG.openBid;
            let extraTime = 0;
            // ============================== REALTIME LISTENERS ==============================
            Echo.channel('auctions')
                .listen('ExtraTimeAdded', (event) => {
                    extraTime = event.extra_time;
                    CONFIG.endTime = new Date(event.new_end_time).getTime(); // Update waktu akhir
                    initializeTimer(); // Re-initialize timer
                });

            Echo.channel(`koi.${CONFIG.koiId}`)
                .listen('ChatMessage', (event) => appendToHistory('chat', event))
                .listen('PlaceBid', (event) => {
                    appendToHistory('bid', event);

                    if (event.isSniping) {
                        extraTime = event.extraTime;
                        CONFIG.endTime = new Date(event.end).getTime(); // Update waktu akhir
                        initializeTimer(); // Re-initialize timer
                    }
                })
                .listen('AuctionWon', (event) => {
                    handleAuctionWinner(event.winner.name, event.winner.amount);
                    appendToHistory('bid', {
                        bid: {
                            id: event.winner.id,
                            koi_id: CONFIG.koiId,
                            amount: event.winner.amount,
                            user: {
                                id: event.winner.user_id,
                                name: event.winner.name,
                                pp: event.winner.pp
                            },
                            created_at: new Date().toISOString()
                        },
                        isSniping: false
                    });
                })
                .listen('ExtraTimeAdded', (event) => {
                    extraTime = event.extra_time * CONFIG.penaltytime;
                    CONFIG.endTime = new Date(event.new_end_time).getTime();

                    // Update timer secara langsung
                    updateTimer();

                    Swal.fire({
                        title: 'Extra Time Ditambahkan',
                        text: `${event.extra_time} menit tambahan telah diberikan!`,
                        icon: 'info',
                        timer: 3000,
                        timerProgressBar: true
                    });
                });


            // ============================== HELPER FUNCTIONS ==============================
            function scrollToBottom() {
                const bidHistory = $('#history');
                bidHistory.scrollTop(bidHistory.prop('scrollHeight'));
            }

            function formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID').format(amount);
            }

            function toggleControls(enable) {
                const action = enable ? 'show' : 'hide';
                const disabled = !enable;
                $('#bin-btn, #place-bid, #plus-btn, #minus-btn')[action]();
                $('#bid-amount').prop('disabled', disabled)[action]();
            }

            function validateBidAmount(amount) {
                return (amount - CONFIG.openBid) % CONFIG.increment === 0;
            }

            function correctBidAmount(amount) {
                if (!validateBidAmount(amount)) {
                    return Math.round((amount - CONFIG.openBid) / CONFIG.increment) * CONFIG.increment + CONFIG
                        .openBid;
                }
                return amount;
            }

            function updateBidAmount(newAmount) { // untuk tombol plus dan minus
                newAmount = correctBidAmount(newAmount); // Auto-correct the bid amount
                if (newAmount >= minimumBid) {
                    $('#bid-amount').val(newAmount);
                } else {
                    Swal.fire({
                        title: 'Bid Tidak Valid',
                        text: `Nilai bid tidak boleh kurang dari Rp ${formatCurrency(minimumBid)}`,
                        icon: 'error',
                        timer: 2000,
                        timerProgressBar: true
                    });
                }
            }

            function sendMessage() {
                const message = $('#chat-input').val().trim();
                if (message) {
                    sendAjaxRequest(CONFIG.routes.chatStore, 'POST', {
                        koi_id: CONFIG.koiId,
                        message
                    }, (data) => {
                        if (data.success) {
                            appendToHistory('chat', {
                                chat: {
                                    user: {
                                        id: CONFIG.userId,
                                        name: 'Kamu',
                                        pp: CONFIG.userProfilePhoto
                                    },
                                    message,
                                    created_at: new Date()
                                }
                            });
                            $('#chat-input').val(''); // Kosongkan input setelah berhasil
                        }
                    }, (error) => {
                        if (error.status === 429) {
                            Swal.fire({
                                title: 'Terlalu Banyak Chat!',
                                text: 'Anda telah mencapai batas chat. Tunggu beberapa saat sebelum mengirim lagi.',
                                icon: 'warning',
                                timer: 2000,
                                timerProgressBar: true
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Terjadi kesalahan saat mengirim pesan.',
                                icon: 'error'
                            });
                        }
                    });
                }
            }

            function processBidOrBIN(actionType, amount) {
                const route = actionType === 'BID' ? CONFIG.routes.bidsStore : CONFIG.routes.bin;

                sendAjaxRequest(route, 'POST', {
                        koi_id: CONFIG.koiId,
                        bid_amount: amount
                    },
                    (data) => {
                        if (data.success) {
                            Swal.fire({
                                title: `${actionType === 'BID' ? 'Bid Berhasil!' : 'Pembelian berhasil!'}`,
                                text: actionType === 'BID' ?
                                    `Berhasil pasang lelang senilai Rp ${formatCurrency(amount)}` :
                                    `Koi berhasil dibeli dengan harga Rp ${formatCurrency(data.cart.price)}`,
                                icon: 'success',
                                timer: 1000,
                                timerProgressBar: true
                            }).then(() => {
                                if (actionType === 'BIN') {
                                    window.location.reload();
                                }
                            });

                            // Tambahkan bid ke history jika sukses
                            if (actionType === 'BID') {
                                appendToHistory('bid', {
                                    bid: {
                                        id: data.bid.id,
                                        koi_id: data.bid.koi_id,
                                        amount: data.bid.amount,
                                        user: {
                                            id: CONFIG.userId,
                                            name: 'Kamu',
                                            pp: CONFIG.userProfilePhoto
                                        },
                                        created_at: new Date().toISOString()
                                    },
                                    isSniping: data.isSniping
                                });
                            }
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: data.message || 'Terjadi kesalahan saat menyimpan bid.',
                                icon: 'error',
                                timer: 2000,
                                timerProgressBar: true
                            });
                        }
                    },
                    (error) => {
                        const message = error.responseJSON?.message || 'Gagal menghubungkan ke server.';
                        Swal.fire({
                            title: 'Error',
                            text: message,
                            icon: 'error',
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }
                );
            }

            function appendToHistory(type, event) {
                const history = $('#history');
                const data = type === 'chat' ? event.chat : event.bid;

                // Check if entry already exists to prevent duplication
                if ($(`#history .chat[data-id="${data.id}"]`).length > 0) return;

                const isOwn = data.user.id === CONFIG.userId;
                const avatarUrl = data.user.pp && data.user.pp !== 'null' ? `/storage/${data.user.pp}` :
                    'https://via.placeholder.com/40';

                const dateOptions = {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                };
                const formattedDate = new Date(data.created_at).toLocaleString('id-ID', dateOptions);

                const displayName = isOwn ? 'Kamu' : data.user.name;

                const bubbleClass = (() => {
                    if (type === 'chat') {
                        return isOwn ? 'chat-bubble-primary text-white' : 'chat-bubble-default';
                    }

                    if (type === 'bid') {
                        if (event.isSniping) {
                            return 'chat-bubble-error text-white'; // Sniping
                        } else if (event.isWinner) {
                            return 'chat-bubble-warning text-black'; // Winner
                        } else {
                            return 'chat-bubble-success text-white'; // Regular bid
                        }
                    }

                    return 'chat-bubble-default'; // Default fallback (in case of unexpected type)
                })();

                // Sanitize content to prevent XSS
                const sanitizedContent = type === 'chat' ?
                    $('<div>').text(data.message).html() :
                    $('<div>').text(`Rp ${formatCurrency(data.amount)} Rb`).html();

                const newEntry = $(`
                    <div class="chat ${isOwn ? 'chat-end' : 'chat-start'}" data-id="${data.id}">
                        <div class="chat-image avatar">
                            <div class="w-10 rounded-full">
                                <img src="${avatarUrl}" alt="User Avatar">
                            </div>
                        </div>
                        <div class="chat-header">
                            <span class="text-sm font-semibold">${$('<div>').text(displayName).html()}</span>
                            <time class="text-xs opacity-50">${formattedDate}</time>
                        </div>
                        <div class="chat-bubble ${bubbleClass}">
                            ${sanitizedContent}
                        </div>
                    </div>
                `);

                history.append(newEntry);
                scrollToBottom();

                // Update minimum bid if the type is bid
                if (type === 'bid') {
                    const bidAmount = parseInt(data.amount, 10) || 0;
                    const increment = parseInt(CONFIG.increment, 10) || 0;

                    minimumBid = bidAmount + increment;

                    $('#bid-amount').val(minimumBid);
                }
            }

            function handleAuctionWinner(winnerName, winnerAmount) {
                // Sembunyikan tombol BIN dan bid controls
                $('#bin-btn, #place-bid, #plus-btn, #minus-btn, #bid-amount').hide();

                // Tampilkan informasi pemenang
                const winnerMessageContainer = $(
                    `<div class="flex items-center space-x-2 mb-2">
                        <h2 class="text-lg font-bold text-green-600">
                            Winner: ${winnerName} 👑 - Rp ${formatCurrency(winnerAmount)}
                        </h2>
                    </div>`
                );

                // Ganti elemen kontrol bid dengan pesan pemenang
                const bidControlContainer = $('.flex.items-center.space-x-2.mb-2');
                bidControlContainer.html(''); // Kosongkan kontainer
                bidControlContainer.append(winnerMessageContainer);

                // Tampilkan notifikasi dengan Swal
                Swal.fire({
                    title: 'Auction Winner!',
                    text: `${winnerName} telah memenangkan lelang dengan BIN Rp ${formatCurrency(winnerAmount)}!`,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                }).then(() => {
                    // Refresh halaman setelah Swal selesai
                    window.location.reload();
                });
            }

            function sendAjaxRequest(url, method, data, successCallback, errorCallback) {
                $.ajax({
                    url,
                    method,
                    headers: {
                        'X-CSRF-TOKEN': CONFIG.csrfToken
                    },
                    data,
                    success: successCallback,
                    error: (error) => {
                        console.error('Error Response:', error);
                        if (errorCallback) {
                            errorCallback(error);
                        }
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
                    showLoaderOnConfirm: true,
                    preConfirm: (pin) => {
                        return new Promise((resolve) => {
                            sendAjaxRequest(CONFIG.routes.pinConfirm, 'POST', {
                                koi_id: CONFIG.koiId,
                                pin
                            }, resolve, (error) => {
                                Swal.showValidationMessage(
                                    `Request failed: ${error.responseText}`);
                            });
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed && result.value.success) {
                        const amount = parseInt($('#bid-amount').val().replace(/\D/g, ''));
                        processBidOrBIN(actionType, amount);
                    }
                });
            }

            function initializeTimer() {
                function updateTimer() {
                    const now = new Date().getTime();
                    const distance = (CONFIG.endTime + extraTime * 60000) -
                        now; // Include extraTime in milliseconds

                    if (distance < 0) {
                        $('#timer-display').text('Lelang Berakhir');
                        clearInterval(timerInterval);
                        toggleControls(false); // Disable controls after auction ends
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    $('#timer-display').text(`${days}d ${hours}h ${minutes}m ${seconds}s`);

                    // Disable BIN button if lastBid >= threshold
                    if (CONFIG.lastBid >= CONFIG.threshold) {
                        $('#bin-btn').prop('disabled', true).addClass('cursor-not-allowed opacity-50');
                    }
                }

                // Jalankan interval untuk memperbarui timer
                const timerInterval = setInterval(updateTimer, 1000);
                updateTimer(); // Jalankan sekali untuk memperbarui segera
            }

            // ============================== EVENT LISTENERS ==============================
            $('#chat-input').keypress(function(event) {
                if (event.key === 'Enter') {
                    sendMessage();
                }
            });

            $('#send-message-btn').on('click', function() {
                sendMessage();
            });

            $('#bin-btn').on('click', function() {
                handlePinValidation('BIN');
            });

            $('#place-bid').on('click', function() {
                const amount = parseInt($('#bid-amount').val().replace(/\D/g, ''));
                if (!amount || amount < minimumBid || !validateBidAmount(amount)) {
                    Swal.fire({
                        title: 'Bid Tidak Valid',
                        text: `Nilai bid harus sesuai kelipatan Rp ${formatCurrency(CONFIG.increment)} dan minimal Rp ${formatCurrency(minimumBid)}`,
                        icon: 'error',
                        timer: 2000,
                        timerProgressBar: true
                    });
                    return;
                }

                handlePinValidation('BID');
            });

            $('#chat-input').on('click', function(event) {
                if (event.key === 'Enter') {
                    const message = $('#chat-input').val().trim();
                    if (message) {
                        sendAjaxRequest(CONFIG.routes.chatStore, 'POST', {
                                koi_id: CONFIG.koiId,
                                message
                            },
                            (data) => {
                                if (data.success) {
                                    appendToHistory('chat', {
                                        chat: {
                                            user: {
                                                id: CONFIG.userId,
                                                name: 'Kamu',
                                                pp: CONFIG.userProfilePhoto
                                            },
                                            message,
                                            created_at: new Date()
                                        }
                                    });
                                }
                            });
                    }
                }
            });

            $('#plus-btn').on('click', function() {
                const currentAmount = parseInt($('#bid-amount').val().replace(/\D/g, ''));
                const newAmount = correctBidAmount(currentAmount + CONFIG.increment);
                updateBidAmount(newAmount);
            });

            $('#minus-btn').on('click', function() {
                const currentAmount = parseInt($('#bid-amount').val().replace(/\D/g, ''));
                const newAmount = correctBidAmount(currentAmount - CONFIG.increment);
                updateBidAmount(newAmount);
            });

            // ============================== INITIALIZATION ==============================
            toggleControls(CONFIG.isAuctionOngoing);
            scrollToBottom();
            initializeTimer();
        });
    </script>


</x-app-layout>
