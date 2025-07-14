<x-app-layout>
    <x-slot name="header">
        <style>
            @font-face {
                font-family: 'OnsenJapanDemoRegular';
                src: url('/fonts/OnsenJapanDemoRegular.ttf') format('truetype');
            }

            .vertical-text {
                writing-mode: vertical-rl;
                text-orientation: upright;
                letter-spacing: -0.2rem;
                z-index: 99;
                /* Adjust spacing between letters if needed */
            }

            .vertical-text-jp {
                font-family: 'OnsenJapanDemoRegular', sans-serif;
                writing-mode: vertical-rl;
                text-orientation: upright;
                letter-spacing: -0.2rem;
                z-index: 99;
            }

            .watermarked-image {
                position: relative;
                display: inline-block;
                overflow: hidden;
            }

            .koi-image {
                width: 100%;
                height: auto;
            }

            .watermark-overlay {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                opacity: 0.1;
                /* Adjust opacity to make it look like a watermark */
                pointer-events: none;
                /* Make watermark unclickable */
            }

            .watermark-logo {
                width: 80%;
                /* Adjust size as needed */
                max-width: 500px;
                height: auto;
                filter: grayscale(100%);
                /* Optional: make the watermark grayscale */
            }


            .text-outline {
                text-shadow:
                    -1px -1px 0 #000,
                    1px -1px 0 #000,
                    -1px 1px 0 #000,
                    1px 1px 0 #000;
            }
        </style>
    </x-slot>

    <div class="p-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Misalnya ini kontennya --}}
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Daftar Auction</h2>

            <div class="grid grid-cols-1 xs:grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($auctions as $auction)
                    <x-auction-card :auction="$auction" />
                @endforeach
            </div>
        </div>
    </div>
    @vite(['resources/js/app.js', 'resources/js/koi-card.js'])
</x-app-layout>
