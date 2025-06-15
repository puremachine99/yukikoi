<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('List Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-4">
                @foreach ($groupedEvents as $eventName => $parts)
                    @php
                        // Ambil banner dari part pertama
                        $banner = $parts->first()->banner;
                    @endphp
                    <div class="event-card shadow-lg p-4 bg-white dark:bg-gray-800 rounded-lg">
                        <!-- Banner Event -->
                        <div class="relative mb-4">
                            <img src="{{ asset('storage/' . $banner) }}" alt="{{ $eventName }}"
                                class="w-full h-48 object-cover rounded-md" />
                        </div>

                        <!-- Nama Event Utama -->
                        <h3 class="font-bold text-md text-gray-800 dark:text-gray-200 mb-2">
                            {{ $eventName }}
                        </h3>

                        <!-- Tampilkan setiap part -->
                        <div class="mt-2">
                            <button type="button"
                                class="w-full text-left px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-md focus:outline-none"
                                onclick="toggleAccordion('accordion-{{ Str::slug($eventName) }}')">
                                Lihat Jadwal Part
                            </button>
                            <div id="accordion-{{ Str::slug($eventName) }}" class="accordion-content mt-2">
                                <ul class="list-disc pl-5">
                                    @foreach ($parts as $part)
                                        <li class="flex justify-between items-center mb-1">
                                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                                {{ $part->event_name }}
                                            </span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $part->start_time }} s/d {{ $part->end_time }}
                                            </span>
                                            <a href="{{ route('events.koi.list', ['event' => $part->id]) }}"
                                                class="text-sm text-blue-500 dark:text-blue-300 underline ml-2">
                                                Lihat Koi
                                            </a>
                                            
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function toggleAccordion(id) {
            const accordion = document.getElementById(id);
            accordion.classList.toggle('open');
        }
    </script>
</x-app-layout>
