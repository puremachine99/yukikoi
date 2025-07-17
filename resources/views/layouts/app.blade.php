<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Preload important resources -->
    <link rel="preload" href="https://code.jquery.com/jquery-3.7.1.js" as="script">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css" as="style">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" as="style">
    <link rel="preload" href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" as="style">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/sweetalert2@11" as="script">
    
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    {{-- daisy ui --}}
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    {{-- Swal 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Global Preloader Styles */
        #global-preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }
        
        #global-preloader.dark {
            background: #111827; /* dark:bg-gray-900 */
        }
        
        .preloader-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #6366f1;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Smooth transition for page content */
        .page-content {
            opacity: 0;
            animation: fadeIn 0.5s ease forwards;
        }
        
        @keyframes fadeIn {
            to { opacity: 1; }
        }
    </style>
</head>

<body class="font-sans antialiased bg-white dark:bg-gray-900 text-black dark:text-white">
    <!-- Global Preloader -->
    <div id="global-preloader" class="dark:hidden">
        <div class="preloader-spinner"></div>
    </div>
    
    <!-- Dark mode preloader (hidden by default) -->
    <div id="global-preloader-dark" class="hidden dark:flex">
        <div class="preloader-spinner" style="border-top-color: #818cf8;"></div>
    </div>

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 page-content">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
        <script>
            // Mendapatkan userId dari Blade ke dalam JavaScript
            const userId = @json(auth()->id());
            
            // Hide preloader when everything is loaded
            window.addEventListener('load', function() {
                setTimeout(function() {
                    const preloader = document.getElementById('global-preloader');
                    const darkPreloader = document.getElementById('global-preloader-dark');
                    
                    if (preloader) preloader.style.opacity = '0';
                    if (darkPreloader) darkPreloader.style.opacity = '0';
                    
                    // Remove preloader after fade out
                    setTimeout(function() {
                        if (preloader) preloader.style.display = 'none';
                        if (darkPreloader) darkPreloader.style.display = 'none';
                    }, 500);
                }, 300); // Minimum show time
            });
            
            // Fallback in case load event doesn't fire
            setTimeout(function() {
                const preloader = document.getElementById('global-preloader');
                const darkPreloader = document.getElementById('global-preloader-dark');
                
                if (preloader && preloader.style.display !== 'none') {
                    preloader.style.opacity = '0';
                    setTimeout(() => preloader.style.display = 'none', 500);
                }
                if (darkPreloader && darkPreloader.style.display !== 'none') {
                    darkPreloader.style.opacity = '0';
                    setTimeout(() => darkPreloader.style.display = 'none', 500);
                }
            }, 3000); // Maximum show time
        </script>

        <div x-data="{ transactionId: null, amount: null, message: '' }" x-init="Echo.private(`user.${userId}`)
            .listen('PaymentCompleted', (event) => {
                // Assign received event data to Alpine.js variables
                console.log(event);
            });">
        </div>
    </div>
</body>
</html>