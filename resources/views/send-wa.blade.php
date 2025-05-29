<!DOCTYPE html>
<html>
<head>
    <title>Kirim Pesan WhatsApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-md">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-green-600">Test Whatsapp Message</h1>
            <p class="text-gray-600 mt-2">Coba kirim pesan ke nomor kamu sendiri</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/send-wa" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">
                    Nomor WhatsApp
                    <span class="text-xs text-gray-500">(contoh: 6282257111684)</span>
                </label>
                <input 
                    type="text" 
                    name="phone_number" 
                    required
                    placeholder="6281234567890" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                >
            </div>
            
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">
                    Isi Pesan
                </label>
                <textarea 
                    name="message" 
                    required
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                >Hello World!</textarea>
            </div>
            
            <button 
                type="submit" 
                class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                </svg>
                Kirim Sekarang
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-500">
            <p>Pastiin nomor udah bener ya, biar pesan nyampe!</p>
        </div>
    </div>
</body>
</html>