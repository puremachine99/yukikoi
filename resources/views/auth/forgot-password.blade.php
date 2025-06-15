<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Lupa kata sandi? Gak masalah. Cukup kasih tahu kami nomor WhatsApp kamu, dan kami bakal kirim link untuk atur ulang kata sandi kamu') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.request') }}">
        @csrf

        <!-- Phone Number -->
        <div>
            <x-input-label for="phone_number" :value="__('Nomor WhatsApp Terdaftar')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" 
                type="text" 
                name="phone_number" 
                :value="old('phone_number')" 
                required autofocus />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                href="{{ route('login') }}">
                Kembali ke Login
            </a>
            
            <x-primary-button>
                {{ __('Kirim OTP') }}
            </x-primary-button>
        </div>
    </form>

    @if (Route::has('password.request'))
        <div class="mt-4 text-center">
            <span class="text-sm text-gray-600 dark:text-gray-400">
                Belum punya akun? 
                <a class="underline hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('register') }}">
                    Daftar disini
                </a>
            </span>
        </div>
    @endif
</x-guest-layout>

