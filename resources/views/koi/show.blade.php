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
        document.addEventListener('DOMContentLoaded', function() {
            fetch(`/koi/{{ $koi->id }}/view`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            });
        });
        scrollToBottom();
        // Variabel bid
        const loggedInUserId = parseInt('{{ auth()->id() }}');
        const bidAmountInput = document.getElementById('bid-amount');
        const openBid = {{ $koi->open_bid }};
        const increment = {{ $koi->kelipatan_bid }};
        const lastBid = {{ $koi->bids->isNotEmpty() ? $koi->bids->last()->amount : 0 }};
        const placeBidButton = document.getElementById('place-bid');
        let minimumBid = lastBid > 0 ? lastBid + increment : openBid;
        const auctionEndMessage = document.querySelector('.auction-end-message');
        const binButton = document.getElementById('bin-btn');
        const lastBidAmount = parseInt("{{ $koi->bids->isNotEmpty() ? $koi->bids->last()->amount : 0 }}");
        const binPrice = {{ $koi->buy_it_now }};
        const threshold = 0.8 * binPrice; // 80% dari harga BIN
        const sendMessageButton = document.getElementById('sendMessageButton');
        const chatInput = document.getElementById('chat-input');

        // Auction Status Handling
        const isAuctionOngoing = @json($isAuctionOngoing);
        // sembunyiin bid control e 
        function handleAuctionEnd() {
            binButton.style.display = 'none';
            placeBidButton.style.display = 'none';
            bidAmountInput.disabled = true;
            bidAmountInput.style.display = 'none';
            document.getElementById('minus-btn').style.display = 'none';
            document.getElementById('plus-btn').style.display = 'none';
            if (auctionEndMessage) {
                auctionEndMessage.style.display = 'block';
            }
        }
        // munculin bid control e pas ready nang on going
        function handleAuctionOngoing() {
            binButton.style.display = 'inline-block';
            placeBidButton.style.display = 'inline-block';
            bidAmountInput.disabled = false;
            document.getElementById('minus-btn').style.display = 'inline-block';
            document.getElementById('plus-btn').style.display = 'inline-block';
            if (auctionEndMessage) {
                auctionEndMessage.style.display = 'none';
            }
        }

        function handleAuctionWinner(winnerName, winnerAmount) {
            // Sembunyikan tombol BIN dan bid controls
            binButton.style.display = 'none';
            placeBidButton.style.display = 'none';
            bidAmountInput.disabled = 'none';
            bidAmountInput.style.display = 'none';
            document.getElementById('minus-btn').style.display = 'none';
            document.getElementById('plus-btn').style.display = 'none';

            // Tampilkan informasi pemenang
            const winnerMessageContainer = document.createElement('div');
            winnerMessageContainer.classList.add('flex', 'items-center', 'space-x-2', 'mb-2');

            const winnerMessage = document.createElement('h2');
            winnerMessage.classList.add('text-lg', 'font-bold', 'text-green-600');
            winnerMessage.innerHTML =
                `Winner: ${winnerName} 👑 - Rp ${new Intl.NumberFormat('id-ID').format(winnerAmount)}`;

            // Append winner message to the appropriate place in DOM
            const bidControlContainer = document.querySelector('.flex.items-center.space-x-2.mb-2');
            bidControlContainer.innerHTML = ''; // Clear the current bid input controls
            bidControlContainer.appendChild(winnerMessage);

            // Optional: Display a Swal notification if needed
            Swal.fire({
                title: 'Auction Winner!',
                text: `${winnerName} telah memenangkan lelang dengan BIN Rp ${new Intl.NumberFormat('id-ID').format(winnerAmount)}!`,
                icon: 'success',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            }).then(() => {
                // Refresh halaman setelah Swal selesai
                window.location.reload();
            });
        }

        // Fungsi utama untuk mengirim pesan
        function sendMessage(event) {
            let message = chatInput.value.trim();
            const koiId = "{{ $koi->id }}"; // ID Koi

            if (message === "") {
                return;
            }

            // Kirim request ke server untuk menyimpan chat
            fetch("{{ route('chat.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        koi_id: koiId,
                        message: message
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        chatInput.value = '';
                        appendChatToHistory(event);
                    } else {
                        console.error('Failed to send message:', data.message);
                    }
                })
                .catch(error => console.error('Error sending message:', error));
        }

        // chat bubble buat history
        function appendBidToHistory(event) {
            const bid = event.bid;
            const isSniping = event.isSniping;
            const bidHistory = document.getElementById('history');
            const isScrolledToBottom = bidHistory.scrollHeight - bidHistory.clientHeight <= bidHistory.scrollTop + 1;

            const newBid = document.createElement('div');
            const isOwnBid = bid.user.id === loggedInUserId;
            newBid.classList.add('chat', isOwnBid ? 'chat-end' : 'chat-start');

            // Avatar Section
            const avatarContainer = document.createElement('div');
            avatarContainer.classList.add('chat-image', 'avatar');
            const avatar = document.createElement('div');
            avatar.classList.add('w-10', 'rounded-full');
            const avatarImg = document.createElement('img');
            avatarImg.src = bid.user.pp ? `/storage/${bid.user.pp}` :
                'https://via.placeholder.com/40'; // Placeholder or actual profile pic
            avatarImg.alt = 'User Avatar';
            avatar.appendChild(avatarImg);
            avatarContainer.appendChild(avatar);

            // Header Section (Name + Timestamp)
            const bidHeader = document.createElement('div');
            bidHeader.classList.add('chat-header');

            const userName = document.createElement('span');
            userName.classList.add('text-sm', 'font-semibold');
            userName.textContent = bid.user.name;

            const timestamp = document.createElement('time');
            timestamp.classList.add('text-xs', 'opacity-50');
            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            };
            const formattedDate = new Date(bid.created_at).toLocaleDateString('id-ID', options);
            const formattedTime = new Date(bid.created_at).toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
            timestamp.textContent = ` ${formattedDate}, ${formattedTime}`;

            bidHeader.appendChild(userName);
            bidHeader.appendChild(timestamp);

            // Chat Bubble Section
            const bidBubble = document.createElement('div');
            bidBubble.classList.add('chat-bubble');

            if (isOwnBid) {
                if (isSniping) {
                    bidBubble.classList.add('chat-bubble-error', 'text-white');
                } else {
                    bidBubble.classList.add('chat-bubble-success', 'text-white');
                }
            } else {
                if (isSniping) {
                    bidBubble.classList.add('chat-bubble-error', 'text-white');
                } else {
                    bidBubble.classList.add('chat-bubble-success', 'text-white');
                }
            }
            bidBubble.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(bid.amount)} K`;

            // Append all elements to the main container
            newBid.appendChild(avatarContainer);
            newBid.appendChild(bidHeader);
            newBid.appendChild(bidBubble);
            bidHistory.appendChild(newBid);

            // Scroll to bottom if necessary
            if (isScrolledToBottom) {
                scrollToBottom();
            }

            // Update minimum bid and input
            minimumBid = bid.amount + increment;
            bidAmountInput.value = minimumBid;
        }

        function appendBINToHistory(event) {
            const winner = event.winner; // Mengambil data pemenang BIN
            const bidHistory = document.getElementById('history');
            const isScrolledToBottom = bidHistory.scrollHeight - bidHistory.clientHeight <= bidHistory.scrollTop + 1;

            const newBid = document.createElement('div');
            const isOwnBid = winner.id === loggedInUserId; // Cek apakah pemenangnya adalah user yang sedang login
            newBid.classList.add('chat', isOwnBid ? 'chat-end' : 'chat-start');

            // Avatar Section
            const avatarContainer = document.createElement('div');
            avatarContainer.classList.add('chat-image', 'avatar');
            const avatar = document.createElement('div');
            avatar.classList.add('w-10', 'rounded-full');
            const avatarImg = document.createElement('img');
            avatarImg.src = winner.pp ? `/storage/${winner.pp}` :
                'https://via.placeholder.com/40'; // Placeholder or actual profile pic
            avatarImg.alt = 'User Avatar';
            avatar.appendChild(avatarImg);
            avatarContainer.appendChild(avatar);

            // Header Section (Name + Timestamp)
            const bidHeader = document.createElement('div');
            bidHeader.classList.add('chat-header');

            const userName = document.createElement('span');
            userName.classList.add('text-sm', 'font-semibold');
            userName.textContent = `${winner.name} 🏆`; // Add crown icon to indicate BIN winner

            const timestamp = document.createElement('time');
            timestamp.classList.add('text-xs', 'opacity-50');
            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            };
            const formattedDate = new Date().toLocaleDateString('id-ID', options); // Menggunakan waktu sekarang
            const formattedTime = new Date().toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
            timestamp.textContent = ` ${formattedDate}, ${formattedTime}`;

            bidHeader.appendChild(userName);
            bidHeader.appendChild(timestamp);

            // Chat Bubble Section for BIN
            const bidBubble = document.createElement('div');
            bidBubble.classList.add('chat-bubble', 'chat-bubble-warning',
                'text-black'); // BIN-specific bubble with warning color

            bidBubble.textContent =
                `Pemenang BIN: Rp ${new Intl.NumberFormat('id-ID').format(winner.amount)} K`; // Display BIN amount

            // Append all elements to the main container
            newBid.appendChild(avatarContainer);
            newBid.appendChild(bidHeader);
            newBid.appendChild(bidBubble);
            bidHistory.appendChild(newBid);

            // Scroll to bottom if necessary
            if (isScrolledToBottom) {
                scrollToBottom();
            }

            // Disable bid controls (Optional if needed for BIN)
            binButton.style.display = 'none';
            placeBidButton.style.display = 'none';
            bidAmountInput.disabled = true;
            document.getElementById('minus-btn').style.display = 'none';
            document.getElementById('plus-btn').style.display = 'none';
        }

        function appendChatToHistory(event) {
            const chat = event.chat;
            const chatHistory = document.getElementById('history');
            const isScrolledToBottom = chatHistory.scrollHeight - chatHistory.clientHeight <= chatHistory.scrollTop + 1;

            const newChat = document.createElement('div');
            const isOwnChat = chat.user.id === loggedInUserId;

            newChat.classList.add('chat', isOwnChat ? 'chat-end' : 'chat-start');

            // Avatar Section
            const avatarContainer = document.createElement('div');
            avatarContainer.classList.add('chat-image', 'avatar');
            const avatar = document.createElement('div');
            avatar.classList.add('w-10', 'rounded-full');
            const avatarImg = document.createElement('img');
            avatarImg.src = chat.user.pp ? `/storage/${chat.user.pp}` : 'https://via.placeholder.com/40';
            avatarImg.alt = 'User Avatar';
            avatar.appendChild(avatarImg);
            avatarContainer.appendChild(avatar);

            // Header Section (Name + Timestamp)
            const chatHeader = document.createElement('div');
            chatHeader.classList.add('chat-header');

            const userName = document.createElement('span');
            userName.classList.add('text-sm', 'font-semibold');
            userName.textContent = chat.user.name;

            const timestamp = document.createElement('time');
            timestamp.classList.add('text-xs', 'opacity-50');
            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            };
            const formattedDate = new Date(chat.created_at).toLocaleDateString('id-ID', options);
            const formattedTime = new Date(chat.created_at).toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
            timestamp.textContent = ` ${formattedDate}, ${formattedTime}`;

            chatHeader.appendChild(userName);
            chatHeader.appendChild(timestamp);

            // Chat Bubble Section
            const chatBubble = document.createElement('div');
            chatBubble.classList.add('chat-bubble');

            if (isOwnChat) {
                chatBubble.classList.add('chat-bubble-primary', 'text-white');
            } else {
                chatBubble.classList.add('text-white');
            }

            chatBubble.textContent = chat.message;

            // Append all elements to the main container
            newChat.appendChild(avatarContainer);
            newChat.appendChild(chatHeader);
            newChat.appendChild(chatBubble);
            chatHistory.appendChild(newChat);

            // Scroll to bottom if necessary
            if (isScrolledToBottom) {
                scrollToBottom();
            }
        }

        function scrollToBottom() {
            const bidHistory = document.getElementById('history');
            bidHistory.scrollTop = bidHistory.scrollHeight;
        }

        function openVideoModal(videoUrl) {
            scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            const video = document.getElementById('modalVideo');
            const videoSource = document.getElementById('videoSource');
            const videoModal = document.getElementById('videoModal');
            if (video && videoSource && videoModal) {
                videoSource.src = videoUrl;
                video.load();
                video.play();
                videoModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeVideoModal() {
            const video = document.getElementById('modalVideo');
            const videoModal = document.getElementById('videoModal');
            if (video && videoModal) {
                video.pause();
                video.currentTime = 0;
                videoModal.classList.add('hidden');
                document.body.style.overflow = '';
                window.scrollTo(0, scrollPosition);
            }
        }

        // Fungsi untuk handle BIN setelah PIN valid
        function processBIN() {
            fetch('{{ route('bids.bin') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        koi_id: '{{ $koi->id }}'
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

        // Fungsi untuk handle Bid setelah PIN valid
        function processBid() {
            let bidAmount = parseInt(bidAmountInput.value.replace(/\D/g, ''));

            fetch('{{ route('bids.check') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        koi_id: '{{ $koi->id }}',
                        bid_amount: bidAmount
                    })
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Proses bid jika validasi berhasil
                        fetch('{{ route('bids.store') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    koi_id: '{{ $koi->id }}',
                                    bid_amount: bidAmount
                                })
                            }).then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Bid Berhasil!',
                                        text: `Berhasil pasang lelang senilai Rp ${new Intl.NumberFormat('id-ID').format(bidAmount)}`,
                                        icon: 'success',
                                        timer: 1000,
                                        timerProgressBar: true
                                    });
                                    scrollToBottom();
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

        // buat validasi pin
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
                    // Kirim PIN ke backend untuk verifikasi
                    return fetch('{{ route('pin.confirm') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                koi_id: '{{ $koi->id }}',
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
                        processBIN();
                    } else if (actionType === 'BID') {
                        processBid();
                    }
                }
            });
        }
        // ========================================== DOM ====================================================
        let endTime = new Date(
            "{{ \Carbon\Carbon::parse($koi->auction->end_time)->addMinutes($koi->auction->extra_time)->toDateTimeString() }}"
        ).getTime();
        extraTime = 0;
        document.addEventListener("DOMContentLoaded", function() {
            const placeBidButton = document.getElementById('place-bid');
            const bidsExist = {{ $koi->bids->isEmpty() ? 'false' : 'true' }};

            if (!bidsExist) {
                placeBidButton.textContent = 'Open';
            }
            if (isAuctionOngoing) {
                handleAuctionOngoing();
            } else {
                handleAuctionEnd();
            }
            scrollToBottom();
            // Timer
            function updateTimer() {
                const now = new Date().getTime();
                const distance = (endTime + extraTime) - now;

                if (distance < 0) {
                    document.getElementById("timer-display").innerHTML = "Lelang Berakhir";
                    clearInterval(timerInterval);
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("timer-display").innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                if (lastBidAmount >= threshold) {
                    binButton.disabled = true; // Matikan tombol BIN
                    binButton.classList.add('cursor-not-allowed', 'opacity-50'); // Tambahkan visual disabled
                }
            }

            const timerInterval = setInterval(updateTimer, 1000);
            // Kirim Pesan Enter
            chatInput.addEventListener('keypress', function() {
                if (event.key === 'Enter') {
                    sendMessage();
                }
            });

            // Increment 
            document.getElementById('plus-btn').addEventListener('click', function() {
                let currentBid = parseInt(bidAmountInput.value);
                bidAmountInput.value = currentBid + increment;
            });

            // Decrement Bid Amount
            document.getElementById('minus-btn').addEventListener('click', function() {
                let currentBid = parseInt(bidAmountInput.value);
                let minimumBid = parseInt(bidAmountInput.getAttribute(
                'min')); // Ambil nilai minimum dari attribute 'min'

                if (currentBid - increment >= minimumBid) {
                    bidAmountInput.value = currentBid - increment;
                } else {
                    bidAmountInput.value = minimumBid;
                }
            });

            // Event listener untuk tombol BIN
            document.getElementById('bin-btn').addEventListener('click', function() {
                if (lastBidAmount >= threshold) {
                    Swal.fire({
                        title: "BIN Gagal",
                        text: "Harga Lelang sudah terlalu tinggi",
                        icon: "error"
                    });
                } else {
                    handlePinValidation('BIN'); // Panggil validasi PIN khusus untuk BIN
                }
            });

            // Event listener untuk tombol Bid
            document.getElementById('place-bid').addEventListener('click', function() {
                handlePinValidation('BID'); // Panggil validasi PIN khusus untuk Bid
            });


        });
    </script>

</x-app-layout>
