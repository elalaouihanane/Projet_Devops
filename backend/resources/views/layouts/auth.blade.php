<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Trendora')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
</head>
<body class="auth-page">
    <div class="auth-shell">
        <aside class="auth-brand">
            <div class="auth-brand__inner">
                <a class="brand" href="{{ url('/') }}">Trendora</a>
                <h1 class="auth-brand__title">@yield('brand_title', 'Partagez votre style. Inspirez les autres.')</h1>
                <p class="auth-brand__subtitle">@yield('brand_subtitle', 'Une plateforme mode elegante et minimaliste.')</p>
            </div>
        </aside>
        <main class="auth-main">
            @if (session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="flash-error">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
