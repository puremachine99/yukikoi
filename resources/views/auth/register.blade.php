<x-guest-layout>
    @if ($errors->has('oauth'))
        <div class="mb-4 text-sm text-red-600 dark:text-red-400">
            {{ $errors->first('oauth') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- No telpon -->
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')"
                required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>
        
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-8">
        <div class="flex items-center">
            <span class="flex-grow border-t border-gray-200 dark:border-gray-700"></span>
            <span class="mx-3 text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                {{ __('Atau daftar dengan') }}
            </span>
            <span class="flex-grow border-t border-gray-200 dark:border-gray-700"></span>
        </div>

        <a href="{{ route('oauth.google.redirect') }}"
            class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 533.5 544.3" aria-hidden="true">
                <path fill="#4285f4" d="M533.5 278.4c0-18.8-1.5-37-4.4-54.8H272.1v103.8h147.4c-6.3 34-25.2 62.8-53.6 82.1v68h86.7c50.7-46.7 80.9-115.5 80.9-199.1z" />
                <path fill="#34a853" d="M272.1 544.3c72.9 0 134.1-24.1 178.8-65.1l-86.7-68c-24.1 16.2-55 25.6-92.1 25.6-70.7 0-130.6-47.7-152-111.5h-89.4v69.9c44.4 88.1 135.6 148.9 241.4 148.9z" />
                <path fill="#fbbc04" d="M120.1 325.3c-10.7-31.9-10.7-66.7 0-98.6v-69.9h-89.4c-39.8 79.7-39.8 172.3 0 252l89.4-69.9z" />
                <path fill="#ea4335" d="M272.1 107.7c38.9-.6 75.8 13.7 104 40.1l77.6-77.6C403.7 24.7 344.8-.3 272.1 0 166.3 0 75.1 60.8 30.7 148.9l89.4 69.9c21.2-63.8 81.2-111.5 152-111.1z" />
            </svg>
            <span>{{ __('Google') }}</span>
        </a>
    </div>
</x-guest-layout>
