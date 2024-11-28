<div class="chat {{ $item->user->id === auth()->id() ? 'chat-end' : 'chat-start' }}">
    <div class="chat-image avatar">
        <div class="w-10 rounded-full">
            <img alt="{{ $item->user->name }}" src="{{ asset('storage/' . $item->user->profile_photo) }}" />
        </div>
    </div>
    <div class="chat-header">
        <span class="text-sm font-semibold">
            {{ $item->user->id === auth()->id() ? 'Kamu' : $item->user->name }}
        </span>
        <time class="text-xs opacity-50">
            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}
        </time>
    </div>
    <div class="chat-bubble {{ $item->user->id === auth()->id() ? 'chat-bubble-primary' : '' }} text-white">
        {{ $item->message }}
    </div>
</div>
