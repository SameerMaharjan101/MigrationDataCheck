<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
    @include('partials.navbar')
    <div class="flex items-center justify-center p-6 pt-20">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Migration Data Check</h1>
            <p class="text-gray-500 mb-8">Compare tables between prod_2 and vprod_2 databases</p>
            <a href="/compare-users" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Get Started — View Comparisons</a>
        </div>
    </div>
</body>
</html>
