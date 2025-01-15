<div class="chat {{ $item->user->id === auth()->id() ? 'chat-end' : 'chat-start' }} ">
    <div class="chat-image avatar ">
        <div class="w-10 rounded-full">
            <img alt="{{ $item->user->name }}" src="{{ asset('storage/' . $item->user->profile_photo) }}" />
        </div>
    </div>
    <div class="chat-header">
        <span class="text-sm font-semibold">
            {{ $item->user->id === auth()->id() ? 'Kamu' : $item->user->name }}
            {{ $item->is_bin ? '🏆' : '' }}
        </span>
        <time class="text-xs opacity-50">
            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}
        </time>
    </div>
    <div class="chat-bubble {{ $item->is_bin ? 'chat-bubble-warning text-black' : ($item->is_sniping ? 'chat-bubble-error text-white' : 'chat-bubble-success text-white') }}">
        @if ($item->is_bin)
            Pemenang BIN: Rp {{ number_format($item->amount, 0, ',', '.') }} Rb
        @else
            Rp {{ number_format($item->amount, 0, ',', '.') }} Rb
        @endif
    </div>
</div>
