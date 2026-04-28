<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Trendora')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body>
    @include('components.navbar')

    <main class="main-shell">
        @if (session('success'))
            <div class="flash flash-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="flash flash-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
