<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ($title ?? 'YukiAuction') . ' | Lelang Koi Premium' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            teal: '#66BFBF',
                            light: '#EAF6F6',
                            white: '#FFFFFF',
                            rose: '#FF0063',
                        },
                    },
                    fontFamily: {
                        display: ['"Plus Jakarta Sans"', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        glow: '0 25px 50px -12px rgba(102, 191, 191, 0.35)',
                    },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-brand-light text-slate-800 antialiased">
    <div class="min-h-screen flex flex-col">
        <x-navigation />
        <main class="flex-1">
            {{ $slot }}
        </main>
        <x-footer />
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggles = document.querySelectorAll('[data-nav-toggle]');
            toggles.forEach((toggle) => {
                const targetId = toggle.getAttribute('data-nav-toggle');
                const target = document.getElementById(targetId);

                if (!target) {
                    return;
                }

                toggle.addEventListener('click', () => {
                    const isOpen = target.getAttribute('data-open') === 'true';
                    target.setAttribute('data-open', String(!isOpen));
                    target.classList.toggle('hidden');
                });
            });
        });
    </script>
</body>
</html>
