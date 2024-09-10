<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-center">
                    <!-- Foto Profil -->
                    <div class="mb-4">
                        <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('default-profile.png') }}"
                             alt="Profile Photo" class="rounded-full w-32 h-32 mx-auto object-cover">
                    </div>

                    <!-- Data Diri Singkat -->
                    <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $user->name }}</h1>
                    <p class="text-zinc-600 dark:text-zinc-400">{{ $user->email }}</p>

                    <!-- Badge Achievement (Hardcoded Example) -->
                    <div class="mt-4">
                        <img src="{{ asset('images/badge-achievement.png') }}" alt="Achievement Badge" class="w-16 h-16 mx-auto">
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2">Achievement Badge</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
