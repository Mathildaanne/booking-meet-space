<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Meet Space')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-white text-gray-800">
<div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
    @include('partials.sidebar')

    <main class="flex-grow flex flex-col lg:ml-64">
        @include('partials.topbar')
        <section class="flex-grow px-6 py-6 max-w-7xl mx-auto">
            @yield('content')
        </section>
    </main>
</div>
</body>
</html>