<x-app-layout>
    <x-slot name="header">
        <style>
            /* Gaya tambahan untuk kartu */
            .vertical-text {
                writing-mode: vertical-rl;
                text-orientation: upright;
                letter-spacing: -0.2rem;
                z-index: 99;
            }

            .event-card {
                position: relative;
                overflow: hidden;
                border-radius: 0.5rem;
                background: #fff;
                transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            }

            .event-card:hover {
                transform: translateY(-5px);
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            }

            .watermarked-image {
                position: relative;
                display: inline-block;
                overflow: hidden;
            }

            .watermark-overlay {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                opacity: 0.1;
                pointer-events: none;
            }

            .watermark-logo {
                width: 80%;
                max-width: 500px;
                height: auto;
                filter: grayscale(100%);
            }

            .text-outline {
                text-shadow:
                    -1px -1px 0 #000,
                    1px -1px 0 #000,
                    -1px 1px 0 #000,
                    1px 1px 0 #000;
            }
        </style>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('List Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($events as $event)
                    <div class="event-card shadow-lg p-4 bg-white dark:bg-zinc-800 rounded-lg">
                        <!-- Gambar Event -->
                        <div class="relative mb-4">
                            <div class="watermarked-image">
                                <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->event_name }}"
                                    class="w-full h-48 object-cover rounded-t-md" alt="Event Banner" />

                                <div class="watermark-overlay">
                                    <img src="{{ asset('images/watermark-logo.png') }}" class="watermark-logo"
                                        alt="Watermark">
                                </div>
                            </div>
                        </div>

                        <!-- Detail Event -->
                        <div class="flex flex-col space-y-2">
                            <h3 class="font-bold text-lg text-gray-800 dark:text-gray-200">
                                {{ $event->event_name }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ Str::limit($event->description, 100) }}
                            </p>
                            <div class="text-sm flex items-center justify-between mt-2">
                                <span class="text-gray-700 dark:text-gray-300">Mulai: {{ $event->start_time }}</span>
                                <span class="text-gray-700 dark:text-gray-300">Berakhir: {{ $event->end_time }}</span>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-4 flex justify-between items-center">
                            <x-secondary-button onclick="window.location='{{ route('events.show', $event->id) }}'">
                                Detail
                            </x-secondary-button>
                            <div>
                                <span
                                    class="px-2 py-1 text-xs font-semibold text-white {{ $event->status == 'approved' ? 'bg-green-500' : 'bg-yellow-500' }} rounded-md">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
