<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Silakan lengkapi nomor ponsel Anda untuk menyelesaikan proses masuk dengan Google.') }}
    </div>

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        @if (! empty($name))
            <div><strong>{{ __('Nama') }}:</strong> {{ $name }}</div>
        @endif
        @if (! empty($email))
            <div><strong>{{ __('Email') }}:</strong> {{ $email }}</div>
        @endif
    </div>

    <form method="POST" action="{{ route('oauth.google.phone.store') }}">
        @csrf

        <div>
            <x-input-label for="phone_number" :value="__('Nomor Ponsel')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number"
                :value="old('phone_number')" required autofocus autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Simpan Nomor Ponsel') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
