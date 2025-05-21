<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - {{ $title ?? '' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="bg-zinc-100">
    <div class="flex">
        <x-admin.sidebar />
        <main class="flex-1 ml-64 min-h-screen p-8">
            {{ $slot }}
        </main>
    </div>
</body>
</html>