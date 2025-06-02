<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Kode verifikasi telah dikirim ke WhatsApp Anda.
    </div>

    <form method="POST" action="{{ route('verify.otp') }}">
        @csrf
        <input type="hidden" name="phone_number" value="{{ $phone_number }}">
        <input type="hidden" name="purpose" value="{{ $purpose }}">

        <div class="mb-4">
            <x-input-label for="otp" value="Masukkan 6 digit kode OTP" />
            <x-text-input id="otp" 
                class="block mt-1 w-full text-center font-mono text-xl tracking-[1rem]" 
                type="text" 
                name="otp" 
                inputmode="numeric"
                maxlength="6"
                required 
                autofocus />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center">
            Verifikasi
        </x-primary-button>
    </form>
</x-guest-layout>