<div class="bg-gray-100 dark:bg-gray-900 p-2 rounded-lg shadow-md w-full flex-shrink-0">
    <!-- Chat selalu ditampilkan -->
    <div class="flex items-center space-x-2 mb-2">
        <input type="text" id="chat-input" x-model="newMessage" placeholder="Ketik pesan..."
            class="flex-grow p-2 border border-gray-300 rounded-md bg-white text-black dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100">
            <button id="send-message-btn" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800">
                <i class="fa-solid fa-paper-plane text-white"></i>
            </button>
    </div>

    <!-- Bid Section -->
    @php
        $latestBid = $koi->bids->sortByDesc('created_at')->first();
        $nextBid = $latestBid ? $latestBid->amount + $koi->kelipatan_bid : $koi->open_bid;
    @endphp
    <div class="flex items-center space-x-2">
        @if (!$isSeller)
            <!-- BIN Button -->
            <button id="bin-btn"
                class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 h-full dark:bg-red-700 dark:hover:bg-red-800">
                BIN
            </button>
            <!-- Minus Button -->
            <button id="minus-btn"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 h-full dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                <i class="fa-solid fa-minus"></i>
            </button>
            <!-- Bid Amount (Input) -->
            <input id="bid-amount" type="number" step="{{ $koi->kelipatan_bid }}"
                value="{{ number_format($nextBid, 0, ',', '.') }}"
                min="{{ number_format($nextBid, 0, ',', '.') }}"
                class="text-center bg-white border border-gray-300 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-sky-500 flex-grow px-2 py-2 min-w-0 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600">


            <!-- Plus Button -->
            <button id="plus-btn"
                class="bg-sky-500 text-white px-4 py-2 rounded-md hover:bg-sky-600 h-full dark:bg-sky-700 dark:hover:bg-sky-800">
                <i class="fa-solid fa-plus"></i>
            </button>
            <!-- Bid Button -->
            <button id="place-bid"
                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 h-full dark:bg-green-700 dark:hover:bg-green-800">
                {{ $koi->bids->isEmpty() ? __('Open Bid') : __('BID') }}
            </button>
        @else
            <!-- Seller tidak dapat bid -->
            <p class="text-red-600 font-bold">Anda tidak dapat melakukan bid di lelang Anda sendiri.</p>
        @endif
    </div>
</div>
