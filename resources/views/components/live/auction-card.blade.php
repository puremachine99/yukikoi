@props([
    'title',
    'image',
    'status' => null,
    'timer' => null,
    'sold' => false,
    'currentBid',
    'bidCount',
    'likeCount',
    'watchCount',
    'openBid',
    'bidIncrement',
    'buyNow',
    'winner' => null,
])

<div class="group flex h-full flex-col overflow-hidden rounded-3xl border border-brand-light bg-white shadow-lg shadow-brand-teal/10 transition hover:-translate-y-1 hover:shadow-xl">
    <div class="relative">
        <img src="{{ $image }}" alt="Foto {{ $title }}" class="h-56 w-full object-cover transition duration-500 group-hover:scale-[1.02]" loading="lazy">
        <div class="absolute inset-x-0 top-0 flex items-center justify-between p-4 text-[10px]/[1.1] font-semibold uppercase tracking-[0.12em]">
            <span class="rounded-full bg-white/90 px-3 py-1 text-brand-teal shadow">
                {{ $status ?? ($sold ? 'Selesai' : 'Sedang Lelang') }}
            </span>
            <span class="rounded-full {{ $sold ? 'bg-brand-rose text-white' : 'bg-slate-900/90 text-white' }} px-3 py-1 shadow">
                {{ $sold ? 'Sold' : ($timer ?? '00h 00m 00s') }}
            </span>
        </div>
    </div>
    <div class="flex flex-1 flex-col gap-5 p-6">
        <div>
            <h3 class="font-display text-xl font-semibold text-slate-900">{{ $title }}</h3>
            <p class="mt-1 text-xs uppercase tracking-wider text-brand-teal/70">Koleksi unggulan pilihan</p>
        </div>
        <dl class="grid grid-cols-2 gap-4 text-xs text-slate-600">
            <div class="rounded-2xl bg-brand-light/70 p-4">
                <dt class="text-[11px] uppercase tracking-wide text-slate-500">Bid terakhir</dt>
                <dd class="mt-1 text-lg font-semibold text-brand-rose">{{ $currentBid }}</dd>
            </div>
            <div class="rounded-2xl bg-brand-light/70 p-4">
                <dt class="text-[11px] uppercase tracking-wide text-slate-500">Open bid</dt>
                <dd class="mt-1 text-base font-semibold text-slate-900">{{ $openBid }}</dd>
            </div>
            <div class="rounded-2xl bg-white p-4 shadow-sm shadow-brand-teal/10">
                <dt class="text-[11px] uppercase tracking-wide text-slate-500">Bid count</dt>
                <dd class="mt-1 text-base font-semibold text-slate-900">{{ $bidCount }}x</dd>
            </div>
            <div class="rounded-2xl bg-white p-4 shadow-sm shadow-brand-teal/10">
                <dt class="text-[11px] uppercase tracking-wide text-slate-500">Kelipatan bid</dt>
                <dd class="mt-1 text-base font-semibold text-slate-900">{{ $bidIncrement }}</dd>
            </div>
        </dl>
        <div class="flex items-center justify-between text-xs text-slate-500">
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-brand-rose" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21C12 21 5 13.692 5 8.75C5 6.12665 7.01472 4 9.5 4C11.1214 4 12.5 5.0054 12.5 5.0054C12.5 5.0054 13.8786 4 15.5 4C17.9853 4 20 6.12665 20 8.75C20 13.692 13 21 13 21H12Z" />
                    </svg>
                    <span>{{ $likeCount }}</span>
                </span>
                <span class="inline-flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5l9-4.5 9 4.5M4.5 10.5v5l7.5 3.75 7.5-3.75v-5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 12l9-4.5" />
                    </svg>
                    <span>{{ $watchCount }}</span>
                </span>
            </div>
            <div class="text-right">
                <p class="text-[11px] uppercase tracking-wide text-slate-500">Buy it now</p>
                <p class="mt-1 text-base font-semibold text-slate-900">{{ $buyNow }}</p>
            </div>
        </div>
        <div class="flex items-center justify-between rounded-2xl bg-brand-light/70 p-4 text-xs text-slate-600">
            <div>
                <p class="text-[11px] uppercase tracking-wide text-slate-500">Pemenang sementara</p>
                <p class="mt-1 text-sm font-semibold text-slate-900">{{ $winner ?? 'Belum ada pemenang' }}</p>
            </div>
            <a href="/live-lelang" class="inline-flex items-center gap-2 rounded-full bg-brand-rose px-4 py-2 text-xs font-semibold text-white transition hover:bg-brand-rose/90">
                Lihat Detail
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</div>
