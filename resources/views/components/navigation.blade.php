<nav class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-brand-light/40 shadow-sm">
    <div class="mx-auto flex max-w-7xl flex-col px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between py-4">
            <a href="/" class="flex items-center gap-2 font-display text-lg font-semibold text-brand-rose">
                <span
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-brand-teal text-white shadow-glow">YA</span>
                <span>YukiAuction</span>
            </a>
            <div class="hidden items-center gap-8 text-sm font-medium md:flex">
                <a href="/live-lelang" class="transition hover:text-brand-rose">Live Lelang</a>
                <a href="#fitur" class="transition hover:text-brand-rose">Fitur</a>
                <a href="#cara-kerja" class="transition hover:text-brand-rose">Cara Kerja</a>
                <a href="#testimoni" class="transition hover:text-brand-rose">Testimoni</a>
                <a href="#faq" class="transition hover:text-brand-rose">FAQ</a>
            </div>
            <div class="hidden items-center gap-3 md:flex">
                <a href="{{ route('login') }}"
                    class="rounded-full border border-brand-teal px-5 py-2 text-sm font-semibold text-brand-teal transition hover:bg-brand-teal hover:text-white">Masuk</a>
                <a href="{{ route('login') }}"
                    class="rounded-full bg-brand-rose px-5 py-2 text-sm font-semibold text-white shadow-glow transition hover:bg-brand-rose/90">Mulai
                    Lelang</a>
            </div>
            <button type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-brand-teal/40 text-brand-teal md:hidden"
                data-nav-toggle="primary-nav" aria-label="Toggle navigation">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <div id="primary-nav" class="hidden flex-col gap-4 pb-6 text-sm font-medium md:hidden" data-open="false">\n <a
                href="/live-lelang"
                class="rounded-full bg-brand-rose/90 px-4 py-2 text-white transition hover:bg-brand-rose">Live
                Lelang</a>\n <a href="#fitur"
                class="rounded-full bg-brand-light px-4 py-2 text-brand-teal transition hover:bg-brand-teal hover:text-white">Fitur</a>
            <a href="#cara-kerja"
                class="rounded-full bg-brand-light px-4 py-2 text-brand-teal transition hover:bg-brand-teal hover:text-white">Cara
                Kerja</a>
            <a href="#testimoni"
                class="rounded-full bg-brand-light px-4 py-2 text-brand-teal transition hover:bg-brand-teal hover:text-white">Testimoni</a>
            <a href="#faq"
                class="rounded-full bg-brand-light px-4 py-2 text-brand-teal transition hover:bg-brand-teal hover:text-white">FAQ</a>
            <div class="flex flex-col gap-3 pt-2">
                <a href="{{ route('login') }}"
                    class="rounded-full border border-brand-teal px-4 py-2 text-center font-semibold text-brand-teal transition hover:bg-brand-teal hover:text-white">Masuk</a>
                <a href="{{ route('login') }}"
                    class="rounded-full bg-brand-rose px-4 py-2 text-center font-semibold text-white transition hover:bg-brand-rose/90">Mulai
                    Lelang</a>
            </div>
        </div>
    </div>
</nav>
