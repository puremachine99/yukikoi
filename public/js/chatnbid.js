
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
