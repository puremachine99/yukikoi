<div class="bg-gray-100 dark:bg-gray-900 p-2 rounded-lg shadow-md w-full flex-shrink-0">
    <div class="flex items-center space-x-2 mb-2">
        <input type="text" id="chat-input" x-model="newMessage"
            placeholder="Ketik pesan..."
            class="flex-grow p-2 border border-gray-300 rounded-md bg-white text-black dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100">
        <button onclick="sendMessage()"
            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800">
            <i class="fa-solid fa-paper-plane text-white"></i>
        </button>
    </div>

    <div class="flex items-center space-x-2">
        <h2 class="text-lg font-bold text-green-600">
            {{ __('Winner : ') }}
            {{ $winner->user->name }} 👑
            - Rp {{ number_format($winner->amount, 0, ',', '.') }}
        </h2>
    </div>
</div>
