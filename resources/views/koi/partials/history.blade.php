<div class="bg-white dark:bg-gray-800 p-4 rounded-lg relative sm:h-[540px] flex flex-col justify-between">
    <div id="history"
        class="overflow-scroll overflow-x-hidden max-h-[450px] p-2 mb-4 flex-1 rounded-lg shadow bg-gray-100 dark:bg-gray-900">
        @foreach ($history as $item)
            @if ($item instanceof \App\Models\Bid)
                <!-- Bid Item -->
                @include('koi.partials.history-bid', ['item' => $item])
            @elseif ($item instanceof \App\Models\Chat)
                <!-- Chat Item -->
                @include('koi.partials.history-chat', ['item' => $item])
            @endif
        @endforeach
    </div>

    {{-- Cek apakah user sudah login --}}
    @auth
        {{-- Jika login, tampilkan tombol interaksi --}}
        @if ($isAuctionOngoing && !$isBIN)
            @include('koi.partials.on_going') {{-- Partial untuk lelang yang sedang berlangsung --}}
        @elseif ($isBIN)
            @include('koi.partials.bin') {{-- Partial untuk Buy It Now (BIN) --}}
        @elseif ($isAuctionReady)
            @include('koi.partials.ready') {{-- Partial untuk lelang yang siap tetapi belum dimulai --}}
        @else
            @include('koi.partials.completed') {{-- Partial untuk lelang yang sudah selesai --}}
        @endif
    @else
        {{-- Jika tidak login, tampilkan peringatan dan tombol login --}}
        <div class="text-center mt-4">
            <p class="text-red-500 font-semibold mb-4">Anda harus login untuk berpartisipasi dalam lelang atau chat.</p>
            <a href="{{ route('login') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Login
            </a>
        </div>
    @endauth
</div>
