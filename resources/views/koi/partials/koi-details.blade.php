<div class="flex justify-between">
    <h3 class="text-xl font-semibold mt-4 uppercase">
        {{ $koi->kode_ikan }}. {{ $koi->judul }} {{ $koi->ukuran }} cm - [{{ $koi->gender }}]
    </h3>
    <h3 class="text-xl font-semibold mt-4 uppercase">
        {{ $koi->auction->auction_code ?: '-' }}<br>
    </h3>
</div>


<p class="text-sm">{{ __('Jenis: ') . $koi->jenis_koi }}</p>

<hr class="mb-2 mt-2">
<div class="flex justify-between items-center">
    <span class="text-md font-bold text-green-600">OB : {{ number_format($koi->open_bid, 0, ',', '.') }} ribu</span>
    <h2 id="timer" class="text-xl font-bold">
        <i class="fa-regular fa-clock text-sm"></i>
        <span id="timer-display">00:00:00:00</span>
    </h2>
    <span class="text-md font-bold">KB : {{ number_format($koi->kelipatan_bid, 0, ',', '.') }} ribu</span>
</div>
<hr class="mb-2 mt-2">

<p class="text-md flex justify-between">
    <span>
        <b>Farm : </b>{{ $koi->auction->user->farm_name ?: '-' }} <b>[{{ $koi->auction->user->city }}]</b><br>
        <b>Rating : </b> 4.5 / 5.0<br>
    </span>
    <span>
        <b>Jenis Lelang : </b>{{ Str::upper($koi->auction->jenis ?: '-') }}<br>
        @if ($koi->buy_it_now)
            <b>Buy it Now : </b>{{ number_format($koi->buy_it_now, 0, ',', '.') }}
        @endif
    </span>
</p>
