<x-app.layout title="Beranda">
    @php
        $liveAuctions = [
            [
                'title' => 'Showa Sanshoku Supreme',
                'image' => asset('images/display.jpeg'),
                'timer' => '01h 12m 08s',
                'currentBid' => 'Rp42.750.000',
                'bidCount' => 38,
                'likeCount' => 128,
                'watchCount' => 96,
                'openBid' => 'Rp15.000.000',
                'bidIncrement' => 'Rp1.000.000',
                'buyNow' => 'Rp68.000.000',
                'winner' => 'Lukas Setiawan',
                'sold' => false,
            ],
            [
                'title' => 'Tancho Kohaku Signature',
                'image' => asset('images/display.jpeg'),
                'timer' => '00h 45m 22s',
                'currentBid' => 'Rp27.300.000',
                'bidCount' => 22,
                'likeCount' => 89,
                'watchCount' => 72,
                'openBid' => 'Rp10.000.000',
                'bidIncrement' => 'Rp750.000',
                'buyNow' => 'Rp40.000.000',
                'winner' => 'Mitra Koi Hub',
                'sold' => false,
            ],
            [
                'title' => 'Sanke Champion Bloodline',
                'image' => asset('images/display.jpeg'),
                'timer' => 'Sold',
                'currentBid' => 'Rp55.200.000',
                'bidCount' => 41,
                'likeCount' => 142,
                'watchCount' => 118,
                'openBid' => 'Rp20.000.000',
                'bidIncrement' => 'Rp1.500.000',
                'buyNow' => 'Rp74.000.000',
                'winner' => 'Nadia Kusuma',
                'sold' => true,
            ],
        ];
    @endphp

    <section class="relative overflow-hidden bg-gradient-to-b from-brand-white via-brand-light to-white">
        <div class="absolute inset-x-0 top-0 -z-10 h-64 bg-[radial-gradient(circle_at_top,#66BFBF33,transparent_60%)]">
        </div>
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div class="space-y-8">
                <span
                    class="inline-flex items-center gap-2 rounded-full bg-white/70 px-4 py-1 text-xs font-semibold uppercase tracking-wide text-brand-teal shadow-sm">
                    Lelang koi premium &amp; terpercaya
                </span>
                <h1 class="font-display text-4xl font-bold leading-tight text-slate-900 sm:text-5xl">
                    Temukan Koi Idaman, <span class="text-brand-rose">Raih Harga Terbaik</span> di YukiAuction
                </h1>
                <p class="max-w-xl text-base text-slate-600 sm:text-lg">
                    YukiAuction menghubungkan breeder dan kolektor koi terbaik di Indonesia. Pengalaman lelang real-time
                    yang transparan, aman, dan memikat—dalam satu platform.
                </p>
                <div class="flex flex-col gap-4 sm:flex-row">
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center justify-center rounded-full bg-brand-rose px-8 py-3 text-sm font-semibold text-white shadow-glow transition hover:bg-brand-rose/90">
                        Mulai Berburu Koi
                    </a>
                    <a href="#cara-kerja"
                        class="inline-flex items-center justify-center rounded-full border border-brand-teal/60 px-8 py-3 text-sm font-semibold text-brand-teal transition hover:border-brand-teal hover:bg-brand-teal hover:text-white">
                        Lihat Cara Kerja
                    </a>
                </div>
                <dl class="grid grid-cols-2 gap-6 text-sm text-slate-500 sm:grid-cols-4">
                    <div>
                        <dt class="font-semibold text-slate-900">Breeder Terverifikasi</dt>
                        <dd>+120 partner</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-900">Total Lelang</dt>
                        <dd>3.500+ koi</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-900">Penawaran Maks</dt>
                        <dd>Rp185 jt</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-900">Tingkat Kepuasan</dt>
                        <dd>4.9/5 rating</dd>
                    </div>
                </dl>
            </div>
            <div class="relative">
                <div
                    class="relative mx-auto w-full max-w-md overflow-hidden rounded-3xl bg-white shadow-xl shadow-brand-teal/20">
                    <img src="{{ asset('images/display.jpeg') }}" alt="Ilustrasi ikan koi"
                        class="h-72 w-full object-cover" loading="lazy" />
                    <div class="space-y-4 p-6">
                        <div class="flex items-center justify-between">
                            <p class="font-display text-xl font-semibold text-slate-900">Showa Sanshoku</p>
                            <span
                                class="rounded-full bg-brand-light px-3 py-1 text-xs font-semibold text-brand-teal">Berlangsung</span>
                        </div>
                        <p class="text-sm text-slate-500">
                            Koleksi langka dari breeder unggulan. Sertifikat lengkap, pertumbuhan stabil, cocok untuk
                            kompetisi.
                        </p>
                        <div class="grid grid-cols-2 gap-4 text-xs">
                            <div class="rounded-2xl bg-brand-light/80 p-4">
                                <p class="text-slate-500">Penawaran Saat Ini</p>
                                <p class="mt-1 text-lg font-semibold text-brand-rose">Rp36.500.000</p>
                            </div>
                            <div class="rounded-2xl bg-brand-light/80 p-4">
                                <p class="text-slate-500">Berakhir Dalam</p>
                                <p class="mt-1 text-lg font-semibold text-slate-900">02h 14m</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-slate-500">
                            <div class="flex -space-x-2">
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-brand-teal/20 text-xs font-semibold text-brand-teal">AK</span>
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-brand-rose/20 text-xs font-semibold text-brand-rose">LS</span>
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-brand-teal/20 text-xs font-semibold text-brand-teal">MR</span>
                            </div>
                            <p>23 kolektor sedang bersaing</p>
                        </div>
                    </div>
                </div>
                <div
                    class="absolute -bottom-6 -right-6 hidden w-36 rounded-3xl border border-brand-light bg-white p-4 text-xs text-slate-500 shadow-lg shadow-brand-teal/10 sm:block">
                    <p class="font-semibold text-brand-teal">Kepercayaan</p>
                    <p class="mt-2 leading-relaxed">Semua transaksi dimonitor dan terjamin aman oleh tim YukiAuction.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="live-now" class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-brand-teal">Live Lelang Saat Ini</p>
                <h2 class="mt-3 font-display text-3xl font-bold text-slate-900 sm:text-4xl">Koi yang Sedang Hot di Arena
                    Lelang</h2>
                <p class="mt-3 max-w-2xl text-sm text-slate-600">Ikuti lelang yang sedang ramai dan jangan lewatkan
                    kesempatan membawa pulang koi premium dengan harga terbaik.</p>
            </div>
            <a href="/live-lelang"
                class="inline-flex items-center gap-2 self-start rounded-full border border-brand-teal/60 px-5 py-2 text-xs font-semibold uppercase tracking-wide text-brand-teal transition hover:border-brand-teal hover:bg-brand-teal hover:text-white">Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        <div class="mt-10 grid gap-6 lg:grid-cols-3">
            @foreach ($liveAuctions as $auction)
                <x-live.auction-card :title="$auction['title']" :image="$auction['image']" :timer="$auction['timer']" :sold="$auction['sold']"
                    :current-bid="$auction['currentBid']" :bid-count="$auction['bidCount']" :like-count="$auction['likeCount']" :watch-count="$auction['watchCount']" :open-bid="$auction['openBid']"
                    :bid-increment="$auction['bidIncrement']" :buy-now="$auction['buyNow']" :winner="$auction['winner']" />
            @endforeach
        </div>
    </section>

    <section id="fitur" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="font-display text-3xl font-bold text-slate-900 sm:text-4xl">Fitur yang Membuat Lelang Semakin
                Mudah</h2>
            <p class="mt-4 text-base text-slate-600">
                Didesain khusus untuk kebutuhan komunitas koi—transparan, informatif, dan siap menunjang keputusan
                pembelian terbaik.
            </p>
        </div>
        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <div class="flex h-full flex-col gap-4 rounded-3xl bg-white p-8 shadow-lg shadow-brand-teal/5">
                <span
                    class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-brand-teal/15 text-brand-teal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h6l2 4 2-4h6l-2 9h-8l-2 9" />
                    </svg>
                </span>
                <h3 class="font-display text-lg font-semibold text-slate-900">Live Bidding Real-time</h3>
                <p class="text-sm leading-relaxed text-slate-600">
                    Pantau dan ikuti penawaran secara langsung. Sistem cepat dan stabil menjaga ritme lelang tetap seru.
                </p>
            </div>
            <div class="flex h-full flex-col gap-4 rounded-3xl bg-white p-8 shadow-lg shadow-brand-teal/5">
                <span
                    class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-brand-teal/15 text-brand-teal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <h3 class="font-display text-lg font-semibold text-slate-900">Jadwal Lelang Terkurasi</h3>
                <p class="text-sm leading-relaxed text-slate-600">
                    Tim kami mengkurasi koi terbaik dan menyusun jadwal lelang yang terstruktur untuk kenyamanan Anda.
                </p>
            </div>
            <div class="flex h-full flex-col gap-4 rounded-3xl bg-white p-8 shadow-lg shadow-brand-teal/5">
                <span
                    class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-brand-teal/15 text-brand-teal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L7.5 16.5M8.25 6.75h9v9" />
                    </svg>
                </span>
                <h3 class="font-display text-lg font-semibold text-slate-900">Transparansi Sertifikat</h3>
                <p class="text-sm leading-relaxed text-slate-600">
                    Setiap koi dilengkapi data lengkap seperti bloodline, ukuran, dan sertifikat sukses kompetisi.
                </p>
            </div>
            <div class="flex h-full flex-col gap-4 rounded-3xl bg-white p-8 shadow-lg shadow-brand-teal/5">
                <span
                    class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-brand-teal/15 text-brand-teal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75a3 3 0 106 0V9" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a3 3 0 116 0V9" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 15a3 3 0 11-6 0" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12v2.25a3 3 0 106 0V12" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 9a3 3 0 116 0" />
                    </svg>
                </span>
                <h3 class="font-display text-lg font-semibold text-slate-900">Komunitas Eksklusif</h3>
                <p class="text-sm leading-relaxed text-slate-600">
                    Bergabung dengan komunitas kolektor dan breeder untuk update, tips, dan peluang kolaborasi.
                </p>
            </div>
            <div class="flex h-full flex-col gap-4 rounded-3xl bg-white p-8 shadow-lg shadow-brand-teal/5">
                <span
                    class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-brand-teal/15 text-brand-teal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.5 9.75v10.5a1.5 1.5 0 001.5 1.5h4.125v-6h4.75v6H19.5a1.5 1.5 0 001.5-1.5V9.75" />
                    </svg>
                </span>
                <h3 class="font-display text-lg font-semibold text-slate-900">Pengiriman Aman</h3>
                <p class="text-sm leading-relaxed text-slate-600">
                    Partner logistik andal dengan packaging standar kompetisi. Koi tiba sehat dan siap tampil.
                </p>
            </div>
            <div class="flex h-full flex-col gap-4 rounded-3xl bg-white p-8 shadow-lg shadow-brand-teal/5">
                <span
                    class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-brand-teal/15 text-brand-teal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.7 17.7L6 12l5.7-5.7" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18V6" />
                    </svg>
                </span>
                <h3 class="font-display text-lg font-semibold text-slate-900">Notifikasi Cerdas</h3>
                <p class="text-sm leading-relaxed text-slate-600">
                    Terima update ketika koi favorit mulai dilelang atau saat penawaran Anda disalip.
                </p>
            </div>
        </div>
    </section>

    <section id="cara-kerja" class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="font-display text-3xl font-bold text-slate-900 sm:text-4xl">Cara Kerja YukiAuction</h2>
                <p class="mt-4 text-base text-slate-600">Dalam tiga langkah mudah, Anda bisa memenangkan koi impian.
                </p>
            </div>
            <div class="mt-12 grid gap-8 lg:grid-cols-3">
                <div class="rounded-3xl border border-brand-light bg-brand-light/50 p-8 shadow-brand-teal/5">
                    <span
                        class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-brand-rose text-lg font-bold text-white">1</span>
                    <h3 class="mt-6 font-display text-xl font-semibold text-slate-900">Registrasi &amp; Verifikasi</h3>
                    <p class="mt-3 text-sm text-slate-600">Daftar dan selesaikan verifikasi data agar bisa mengikuti
                        lelang eksklusif.</p>
                </div>
                <div class="rounded-3xl border border-brand-light bg-brand-light/50 p-8 shadow-brand-teal/5">
                    <span
                        class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-brand-rose text-lg font-bold text-white">2</span>
                    <h3 class="mt-6 font-display text-xl font-semibold text-slate-900">Katalog &amp; Observasi</h3>
                    <p class="mt-3 text-sm text-slate-600">Jelajahi katalog koi lengkap dengan video, ukuran, dan
                        catatan kondisi.</p>
                </div>
                <div class="rounded-3xl border border-brand-light bg-brand-light/50 p-8 shadow-brand-teal/5">
                    <span
                        class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-brand-rose text-lg font-bold text-white">3</span>
                    <h3 class="mt-6 font-display text-xl font-semibold text-slate-900">Ikuti Lelang &amp; Checkout</h3>
                    <p class="mt-3 text-sm text-slate-600">Masukkan penawaran terbaik, menangkan koi, dan pilih
                        pengiriman aman.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="testimoni" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-[1.2fr_1fr]">
            <div>
                <h2 class="font-display text-3xl font-bold text-slate-900 sm:text-4xl">Suara dari Kolektor &amp;
                    Breeder</h2>
                <p class="mt-4 text-base text-slate-600">Kami tumbuh bersama komunitas koi yang percaya pada
                    transparansi dan kualitas.</p>
                <div class="mt-10 space-y-8">
                    <article class="rounded-3xl bg-white p-8 shadow-lg shadow-brand-teal/10">
                        <p class="text-lg font-semibold text-brand-teal">“Platform paling profesional untuk lelang
                            koi.”</p>
                        <p class="mt-3 text-sm text-slate-600">
                            "Navigasi mudah, katalog detail, dan tim support responsif. Saya berhasil menjual tiga koi
                            juara dalam waktu satu minggu."
                        </p>
                        <p class="mt-4 text-sm font-semibold text-brand-rose">Hiro – Breeder, Blitar</p>
                    </article>
                    <article class="rounded-3xl bg-white p-8 shadow-lg shadow-brand-teal/10">
                        <p class="text-lg font-semibold text-brand-teal">“Live bidding-nya bikin nagih.”</p>
                        <p class="mt-3 text-sm text-slate-600">
                            "Rasanya seperti berada di venue lelang. Sistem notifikasi membantu saya menangani beberapa
                            penawaran sekaligus."
                        </p>
                        <p class="mt-4 text-sm font-semibold text-brand-rose">Mita – Kolektor, Jakarta</p>
                    </article>
                </div>
            </div>
            <div class="rounded-3xl bg-brand-light/70 p-8 shadow-inner shadow-brand-teal/10">
                <h3 class="font-display text-xl font-semibold text-slate-900">Sorotan Komunitas</h3>
                <ul class="mt-6 space-y-4 text-sm text-slate-600">
                    <li class="flex items-start gap-3">
                        <span
                            class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-brand-teal/20 text-xs font-semibold text-brand-teal">01</span>
                        <div>
                            <p class="font-semibold text-slate-900">Event offline</p>
                            <p>Gathering kolektor setiap kuartal dengan sesi edukasi bloodline &amp; grooming.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span
                            class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-brand-teal/20 text-xs font-semibold text-brand-teal">02</span>
                        <div>
                            <p class="font-semibold text-slate-900">Insight mingguan</p>
                            <p>Analisis tren harga koi populer dan tips mempersiapkan koi sebelum lelang.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span
                            class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-brand-teal/20 text-xs font-semibold text-brand-teal">03</span>
                        <div>
                            <p class="font-semibold text-slate-900">Kolaborasi antar breeder</p>
                            <p>Membuka peluang joint auction untuk memperluas pasar dan exposure.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section id="faq" class="bg-white py-16">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="font-display text-3xl font-bold text-slate-900 sm:text-4xl">Pertanyaan yang Sering Diajukan
                </h2>
                <p class="mt-4 text-base text-slate-600">Masih ragu? Temukan jawabannya di sini.</p>
            </div>
            <div class="mt-10 space-y-4">
                <details class="group rounded-2xl border border-brand-light bg-brand-light/50 p-5">
                    <summary
                        class="flex cursor-pointer items-center justify-between text-sm font-semibold text-slate-900">
                        Bagaimana proses verifikasi seller?
                        <span
                            class="ml-4 inline-flex h-6 w-6 items-center justify-center rounded-full bg-brand-teal/15 text-brand-teal transition group-open:rotate-45">+</span>
                    </summary>
                    <p class="mt-4 text-sm leading-relaxed text-slate-600">
                        Kami melakukan pengecekan KTP, riwayat penjualan, dan inspeksi langsung ke kolam bagi breeder
                        baru sebelum membuka lelang pertama.
                    </p>
                </details>
                <details class="group rounded-2xl border border-brand-light bg-brand-light/50 p-5">
                    <summary
                        class="flex cursor-pointer items-center justify-between text-sm font-semibold text-slate-900">
                        Apakah pembeli dikenakan biaya tambahan?
                        <span
                            class="ml-4 inline-flex h-6 w-6 items-center justify-center rounded-full bg-brand-teal/15 text-brand-teal transition group-open:rotate-45">+</span>
                    </summary>
                    <p class="mt-4 text-sm leading-relaxed text-slate-600">
                        Tidak ada biaya tersembunyi. Pembeli hanya membayar harga menang lelang dan biaya pengiriman
                        sesuai lokasi.
                    </p>
                </details>
                <details class="group rounded-2xl border border-brand-light bg-brand-light/50 p-5">
                    <summary
                        class="flex cursor-pointer items-center justify-between text-sm font-semibold text-slate-900">
                        Bisakah meninjau koi secara langsung?
                        <span
                            class="ml-4 inline-flex h-6 w-6 items-center justify-center rounded-full bg-brand-teal/15 text-brand-teal transition group-open:rotate-45">+</span>
                    </summary>
                    <p class="mt-4 text-sm leading-relaxed text-slate-600">
                        Tentu, Anda dapat mengatur jadwal viewing langsung dengan breeder melalui dashboard setelah
                        melakukan deposit.
                    </p>
                </details>
            </div>
        </div>
    </section>

    <section class="bg-gradient-to-r from-brand-teal via-brand-teal to-brand-rose/80 py-14 text-white">
        <div class="mx-auto flex max-w-5xl flex-col items-center gap-6 px-4 text-center sm:px-6 lg:px-8">
            <h2 class="font-display text-3xl font-bold">Siap ikutan lelang koi berikutnya?</h2>
            <p class="max-w-3xl text-sm text-white/80">
                Daftar sekarang dan dapatkan akses ke jadwal lelang terbaru, preview video koi unggulan, dan penawaran
                eksklusif dari breeder favorit.
            </p>
            <div class="flex flex-col gap-4 sm:flex-row">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center rounded-full bg-white px-8 py-3 text-sm font-semibold text-brand-rose shadow-lg shadow-brand-rose/30 transition hover:bg-brand-light">Masuk
                    / Daftar</a>
                <a href="https://wa.me/6282257111683" target="_blank" rel="noopener"
                    class="inline-flex items-center justify-center rounded-full border border-white/60 px-8 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                    Konsultasi dengan Tim
                </a>
            </div>
        </div>
    </section>
</x-app.layout>
