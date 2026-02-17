<x-app.layout title="Live Lelang">
    @php
        $hotAuctions = [
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

        $upcomingAuctions = [
            [
                'time' => '19:30 WIB',
                'title' => 'Shiro Utsuri Grand Line',
                'size' => '45 cm',
                'breeder' => 'Sakura Nishikigoi Farm',
            ],
            [
                'time' => '20:00 WIB',
                'title' => 'Kohaku Jumbo Tosai',
                'size' => '52 cm',
                'breeder' => 'Miyabi Koi Center',
            ],
            [
                'time' => '20:30 WIB',
                'title' => 'Doitsu Kujaku Metallic',
                'size' => '40 cm',
                'breeder' => 'Shinju Breeding House',
            ],
        ];
    @endphp

    <section class="bg-gradient-to-b from-brand-white via-brand-light to-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-brand-teal">Live Auction</p>
                    <h1 class="mt-3 font-display text-4xl font-bold text-slate-900 sm:text-5xl">Arena Lelang Sedang
                        Berlangsung</h1>
                    <p class="mt-4 text-base text-slate-600">Monitor update bid terkini, dukung penjual favorit, dan bid
                        koi impian Anda langsung dari perangkat apa saja.</p>
                </div>
                <div class="flex flex-col gap-3 text-sm text-slate-600">
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-white/80 px-4 py-2 font-semibold text-brand-teal shadow-glow">
                        <span class="h-2 w-2 rounded-full bg-brand-rose animate-pulse"></span>
                        Live sekarang: 3 lelang
                    </div>
                    <p class="text-xs text-slate-500">Semua jadwal mengacu pada waktu Indonesia Barat (WIB)</p>
                </div>
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-[2fr_1fr]">
                <div class="grid gap-6 md:grid-cols-2">
                    @foreach ($hotAuctions as $auction)
                        <x-live.auction-card :title="$auction['title']" :image="$auction['image']" :timer="$auction['timer']" :sold="$auction['sold']"
                            :current-bid="$auction['currentBid']" :bid-count="$auction['bidCount']" :like-count="$auction['likeCount']" :watch-count="$auction['watchCount']" :open-bid="$auction['openBid']"
                            :bid-increment="$auction['bidIncrement']" :buy-now="$auction['buyNow']" :winner="$auction['winner']" />
                    @endforeach
                </div>
                <aside
                    class="flex flex-col gap-6 rounded-3xl border border-brand-light bg-white p-6 shadow-brand-teal/5">
                    <div>
                        <h2 class="font-display text-xl font-semibold text-slate-900">Live Chat Komunitas</h2>
                        <p class="mt-2 text-sm text-slate-600">Diskusikan kualitas koi, strategi bid, dan insight dengan
                            kolektor lainnya.</p>
                        <div class="mt-4 rounded-2xl bg-brand-light/80 p-4 text-xs text-slate-500">
                            <p><span class="font-semibold text-brand-teal">@KoiLover</span> lagi rebid Showa Supreme
                                nih, siap-siap ya!</p>
                            <p class="mt-2"><span class="font-semibold text-brand-rose">@MitaCollective</span> baru
                                join watchlist Tancho Kohaku.</p>
                            <p class="mt-2"><span class="font-semibold text-brand-teal">@NishikigoiID</span> share
                                tips perawatan warna merah.</p>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-display text-sm font-semibold uppercase tracking-wide text-brand-teal">Jadwal
                            Berikutnya</h3>
                        <ul class="mt-4 space-y-3 text-sm">
                            @foreach ($upcomingAuctions as $item)
                                <li class="flex items-start gap-3 rounded-2xl bg-brand-light/60 p-4">
                                    <span
                                        class="mt-1 inline-flex h-9 w-9 items-center justify-center rounded-full bg-white text-xs font-semibold text-brand-rose shadow-sm">{{ $item['time'] }}</span>
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $item['title'] }}</p>
                                        <p class="text-xs text-slate-500">{{ $item['size'] }} • {{ $item['breeder'] }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="rounded-3xl bg-brand-teal/10 p-6 text-sm text-slate-600">
                        <p class="font-display text-base font-semibold text-brand-teal">Tips Menang Lelang</p>
                        <ul class="mt-4 space-y-2">
                            <li>• Set reminder di dashboard agar tidak ketinggalan closing time.</li>
                            <li>• Pantau riwayat bid untuk mempelajari pola kompetitor.</li>
                            <li>• Siapkan saldo deposit agar transaksi bisa langsung diproses.</li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-brand-light/60 p-6 sm:p-10">
                <div class="grid gap-8 lg:grid-cols-[1.8fr_1fr]">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-brand-teal">Panduan Singkat</p>
                        <h2 class="mt-3 font-display text-3xl font-bold text-slate-900">Optimalkan Pengalaman Live
                            Bidding Anda</h2>
                        <p class="mt-4 text-sm text-slate-600">
                            Gunakan tombol watchlist untuk menyimpan koi favorit, aktifkan notifikasi, dan manfaatkan
                            fitur buy it now bila tidak ingin mengambil risiko kehilangan koi idaman.
                        </p>
                        <div class="mt-6 flex flex-col gap-3 text-sm text-slate-600 sm:flex-row">
                            <div class="rounded-2xl bg-white p-4 shadow-sm shadow-brand-teal/10">
                                <p class="font-semibold text-brand-rose">Watchlist</p>
                                <p class="mt-1 text-xs">Simpan koi favorit Anda dan dapatkan update real-time saat
                                    terjadi bid baru.</p>
                            </div>
                            <div class="rounded-2xl bg-white p-4 shadow-sm shadow-brand-teal/10">
                                <p class="font-semibold text-brand-teal">Auto Bid</p>
                                <p class="mt-1 text-xs">Atur batas maksimal penawaran Anda dan sistem akan melakukan bid
                                    otomatis.</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4 rounded-3xl bg-white p-6 shadow-lg shadow-brand-teal/10">
                        <h3 class="font-display text-base font-semibold text-slate-900">Masih baru di YukiAuction?</h3>
                        <p class="text-sm text-slate-600">Ikuti tur singkat untuk mengenal fitur live bidding dan cara
                            memastikan koi yang Anda menangkan sampai dengan selamat.</p>
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center rounded-full bg-brand-rose px-6 py-2 text-xs font-semibold uppercase tracking-wide text-white transition hover:bg-brand-rose/90">Mulai
                            Tur</a>
                        <a href="https://wa.me/6282257111683" target="_blank" rel="noopener"
                            class="inline-flex items-center justify-center rounded-full border border-brand-teal px-6 py-2 text-xs font-semibold uppercase tracking-wide text-brand-teal transition hover:bg-brand-teal hover:text-white">Tanya
                            Tim Support</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app.layout>
