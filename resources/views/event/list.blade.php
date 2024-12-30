<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
                {{ __('Event Saya') }}
            </h2>
            <a href="{{ route('events.create') }}"
                class="inline-flex items-center px-4 py-2 bg-zinc-800 dark:bg-zinc-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-zinc-800 uppercase tracking-widest hover:bg-zinc-700 dark:hover:bg-white focus:bg-zinc-700 dark:focus:bg-white active:bg-zinc-900 dark:active:bg-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 transition ease-in-out duration-150">
                {{ __('+ Buat Event') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6" x-data="{}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-zinc-800 shadow sm:rounded-lg">
                <div class="flex justify-between mb-6">
                    <form method="GET" action="{{ route('events.list') }}" id="event-filter-form"
                        class="flex space-x-4 w-full">
                        <input type="text" name="search" placeholder="Cari event..." value="{{ request('search') }}"
                            class="flex-grow px-4 py-2 border rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-gray-200 border-gray-300 dark:border-zinc-600 focus:ring-indigo-500 focus:border-indigo-500">

                        <select name="status"
                            class="w-1/5 px-2 py-2 border rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-gray-200 border-gray-300 dark:border-zinc-600 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="all">Semua Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready</option>
                            <option value="on going" {{ request('status') == 'on going' ? 'selected' : '' }}>On Going
                            </option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                        </select>

                        <select name="sort"
                            class="w-1/5 px-2 py-2 border rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-gray-200 border-gray-300 dark:border-zinc-600 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama</option>
                        </select>
                    </form>
                </div>

                <div id="event-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($events as $event)
                        <div class="event-item border rounded-lg p-4 dark:bg-zinc-700 dark:border-zinc-600 relative flex flex-col justify-between">
                            <button onclick="deleteEvent('{{ $event->id }}')"
                                class="absolute group top-2 right-2 py-2 px-3 bg-zinc-500 text-white rounded-full hover:bg-zinc-100 hover:text-zinc-950 dark:hover:bg-zinc-200 dark:hover:text-zinc-800 transition-transform transform hover:scale-110 focus:outline-none z-30">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <button onclick="window.location.href='{{ route('events.edit', $event->id) }}'"
                                class="absolute group top-14 right-2 py-2 px-3 bg-zinc-500 text-white rounded-full hover:bg-zinc-100 hover:text-zinc-950 dark:hover:bg-zinc-200 dark:hover:text-zinc-800 transition-transform transform hover:scale-110 focus:outline-none z-30">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button
                                class="absolute group right-0 w-16 h-16 z-10 bg-white dark:bg-zinc-800 text-sky-500 dark:text-sky-300 border-2 border-sky-500 dark:border-sky-300 rounded-full flex items-center justify-center transition-transform transform hover:scale-110 hover:bg-sky-500 hover:text-white hover:border-white"
                                style="top: 61%; z-index: 10;"
                                onclick="window.location.href='{{ route('events.addKoi', $event->id) }}'">
                                <i class="fa-solid fa-fish text-3xl"></i>
                            </button>

                            @if ($event->banner)
                                <div class="relative w-full overflow-hidden rounded-lg shadow-lg" style="height: 200px">
                                    <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->event_name }}"
                                        class="absolute top-0 left-0 w-full h-full object-cover">
                                </div>
                            @endif

                            <h3 class="text-base font-semibold mt-4 uppercase text-zinc-900 dark:text-zinc-200">
                                [{{ $event->event_code }}] {{ $event->event_name }}
                            </h3>
                            <p class="mt-2 text-sm text-zinc-800 dark:text-zinc-400">
                                <span class="font-bold">{{ __('Status') }}:</span>
                                <span class="text-yellow-500">{{ ucfirst($event->status) }}</span>
                            </p>
                            <p class="mt-2 text-sm text-zinc-800 dark:text-zinc-400">
                                <span class="font-bold">{{ __('Mulai') }}:</span>
                                {{ $event->start_time->format('d M Y, H:i') }}
                            </p>
                            <p class="mt-2 text-sm text-zinc-800 dark:text-zinc-400">
                                <span class="font-bold">{{ __('Selesai') }}:</span>
                                {{ $event->end_time->format('d M Y, H:i') }}
                            </p>
                        </div>
                    @empty
                        <p class="text-center col-span-3 text-zinc-600 dark:text-zinc-400">Tidak ada data event.</p>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $events->links() }}
                </div>

                <script>
                    function deleteEvent(eventId) {
                        if (confirm('Apakah Anda yakin ingin menghapus event ini?')) {
                            document.getElementById(`delete-event-form-${eventId}`).submit();
                        }
                    }
                </script>

            </div>
        </div>
    </div>
</x-app-layout>