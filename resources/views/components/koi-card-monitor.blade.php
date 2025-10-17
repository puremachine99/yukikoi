@props(['bid', 'latestBid' => null, 'winner' => null])

@php
    $koi = optional($bid)->koi;

    // Jika $koi null (data tidak lengkap), jangan render apa-apa
    if (blank($koi)) {
        // kamu bisa return kosong atau tampilkan placeholder ringan
        echo '';
        return;
    }

    $loggedInUserId = auth()->id();
    $latestBidAmount = (int) optional($latestBid)->amount ?? 0;

    $userBid = optional($koi->bids)->firstWhere('user_id', $loggedInUserId);
    $farmName = optional(optional($koi->auction)->user)->farm_name ?? 'Unknown Farm';

    $winStatus = $winner ? ($winner->user_id === $loggedInUserId ? 'win' : 'lose') : 'ongoing';

    $auctionStatus = optional($koi->auction)->status === 'on going' ? 'ongoing' : 'finished';

    $photoMedia = optional($koi->media)->where('media_type', 'photo')->first();
    $koiImage = $photoMedia ? asset('storage/' . $photoMedia->url_media) : asset('images/logo.png');

    $rowBg = $winner ? ($winner->user_id === $loggedInUserId ? 'bg-green-100' : 'bg-red-100') : '';

    $increment = (int) ($koi->kelipatan_bid ?? 0);
    $openBid = (int) ($koi->open_bid ?? 0);

    $minForInput = ($latestBidAmount > 0 ? $latestBidAmount : $openBid) + $increment;

    $binPrice = (int) ($koi->buy_it_now ?? 0);
@endphp


<div id="koi-row-{{ $koi->id }}" data-koi-row data-koi-id="{{ $koi->id }}" data-win-status="{{ $winStatus }}"
    data-auction-status="{{ $auctionStatus }}" data-increment="{{ (int) $koi->kelipatan_bid }}"
    data-last-bid="{{ (int) $latestBidAmount }}" data-open-bid="{{ (int) $koi->open_bid }}"
    data-bin-price="{{ $binPrice }}" class="bg-white dark:bg-gray-700 rounded-lg shadow border {{ $rowBg }}">
    <div class="flex items-center p-4 space-x-4">
        <img src="{{ $koiImage }}" alt="Koi Image" class="w-24 h-auto rounded-lg object-cover">

        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                {{ $koi->kode_ikan . '. ' . $koi->judul . ' ' . $koi->ukuran }} cm
                <span class="uppercase">
                    ({{ $koi->gender === 'male' ? 'M' : ($koi->gender === 'female' ? 'F' : '') }})
                </span>
            </h3>

            <p class="text-sm text-gray-500">{{ $farmName }}</p>

            <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                <p><strong>Lelang:</strong> {{ $koi->auction->auction_code }}</p>
                <div class="flex justify-between">
                    <p><strong>OB:</strong> {{ number_format($koi->open_bid, 0, ',', '.') }}</p>
                    <p><strong>KB:</strong> {{ number_format($koi->kelipatan_bid, 0, ',', '.') }}</p>
                </div>
                <div class="flex justify-between mt-1">
                    <p><strong>My Bid:</strong>
                        <span id="my-bid-cell-{{ $koi->id }}">
                            {{ $userBid ? number_format($userBid->amount, 0, ',', '.') : '-' }}
                        </span>
                    </p>
                    <p><strong>Last Bid:</strong>
                        <span id="price-cell-{{ $koi->id }}">
                            {{ number_format($latestBidAmount ?? 0, 0, ',', '.') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex space-x-2 px-4 py-2 border-t bg-gray-100 dark:bg-gray-800 rounded-b-lg"
        id="actions-cell-{{ $koi->id }}">
        @if ($winner && $winner->user_id === $loggedInUserId)
            <span class="text-green-500 font-bold">
                Winner: {{ $winner->user->name }} - Rp {{ number_format($winner->amount, 0, ',', '.') }}
            </span>
        @elseif ($winner && $winner->user_id !== $loggedInUserId)
            <span class="text-red-500 font-bold">
                Defeated by: {{ $winner->user->name }} - Rp {{ number_format($winner->amount, 0, ',', '.') }}
            </span>
        @else
            <button id="bin-btn-{{ $koi->id }}"
                class="bin-btn bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600 text-xs"
                data-koi-id="{{ $koi->id }}">
                BIN
            </button>

            <button id="minus-btn-{{ $koi->id }}"
                class="minus-btn bg-gray-300 w-10 text-gray-700 px-2 py-1 rounded-md hover:bg-gray-400 text-xs"
                data-koi-id="{{ $koi->id }}">-</button>

            <input id="bid-amount-{{ $koi->id }}" type="number" value="{{ $minForInput }}"
                class="bid-amount text-center w-60 bg-white border border-gray-300 rounded-md text-gray-700 mx-1 text-sm"
                data-koi-id="{{ $koi->id }}" />

            <button id="plus-btn-{{ $koi->id }}"
                class="plus-btn bg-sky-500 w-10 text-white px-2 py-1 rounded-md hover:bg-sky-600 text-xs"
                data-koi-id="{{ $koi->id }}">+</button>

            <button id="place-bid-{{ $koi->id }}"
                class="place-bid-btn bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-600 text-xs"
                data-koi-id="{{ $koi->id }}">
                {{ optional($koi->bids)->isEmpty() ?? true ? __('Open Bid') : __('BID') }}

            </button>
        @endif
    </div>
</div>
