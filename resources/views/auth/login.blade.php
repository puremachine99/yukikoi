<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Masuk - YukiAuction</title>
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-dvh bg-gray-50 text-gray-900">
    <div class="mx-auto max-w-md px-4 py-10">
        <div class="mb-8 text-center">
            <img src="/images/logo.svg" alt="YukiAuction" class="mx-auto h-10 w-auto">
            <h1 class="mt-4 text-2xl font-semibold">Masuk ke akun Anda</h1>
            <p class="mt-1 text-sm text-gray-600">Gunakan nomor HP dan kata sandi.</p>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-3 py-2 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5" x-data="{ show: false }" novalidate>
            @csrf

            <div>
                <label for="phone" class="mb-1 block text-sm font-medium">Nomor HP</label>
                <div class="relative">
                    <input id="phone" name="phone" type="tel" inputmode="numeric" autocomplete="tel"
                        placeholder="08xx / 8xx / +628xx" value="{{ old('phone') }}"
                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-base shadow-sm placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                        required pattern="^(?:\+?62|0|8)[0-9\s\-.]{6,}$" />
                </div>
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium">Kata Sandi</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" id="password" name="password"
                        autocomplete="current-password"
                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-base shadow-sm placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                        required minlength="6" maxlength="100" />
                    <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-0 mr-2 inline-flex items-center rounded px-2 text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        <span x-show="!show">👁️</span>
                        <span x-show="show">🙈</span>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="inline-flex w-full items-center justify-center gap-2 rounded-md bg-indigo-600 px-4 py-2.5 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 disabled:opacity-50">
                Masuk
            </button>

            <p class="text-center text-sm text-gray-600">
                Lupa sandi? <a href="#" class="font-medium text-indigo-600 hover:underline">Hubungi admin</a>
            </p>
        </form>

        <p class="mt-10 text-center text-xs text-gray-500">
            Dengan masuk Anda menyetujui Ketentuan & Kebijakan Privasi.
        </p>
    </div>
</body>

</html>
