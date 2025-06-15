<div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg shadow-md w-full flex-shrink-0 text-center">
    @if ($winner)
        <h2 class="text-lg font-bold text-green-600" x-init="scrollToBottom()">
            {{ __('Pemenang:') }}
            {{ $winner->user->name }}
            - Rp {{ number_format($winner->amount, 0, ',', '.') }}
        </h2>
    @else
        <h2 class="text-lg font-bold text-red-600">
            {{ __('Tidak ada pemenang lelang') }}
        </h2>
    @endif
</div>
