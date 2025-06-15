<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
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

</head>


<body class="bg-gray-100">
    <x-admin.nav />
    <div class="flex pt-28">
        <x-admin.sidebar />
        <main class="flex-1 ml-64 min-h-screen p-8">
            {{ $slot }}
        </main>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const breadcrumbsContainer = document.getElementById('breadcrumbs');
        const pathArray = window.location.pathname.split('/').filter(segment => segment);

        let breadcrumbsHTML = '';
        pathArray.forEach((segment, index) => {
            const url = '/' + pathArray.slice(0, index + 1).join('/');
            const label = segment.charAt(0).toUpperCase() + segment.slice(1);
            breadcrumbsHTML += `<a href="${url}" class="hover:underline">${label}</a>`;
            if (index < pathArray.length - 1) {
                breadcrumbsHTML += ' / ';
            }
        });

        breadcrumbsContainer.innerHTML = breadcrumbsHTML;
    });
</script>

</html>
