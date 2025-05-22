<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - {{ $title ?? '' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body class="bg-zinc-100">
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
