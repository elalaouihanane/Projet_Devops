<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Trendora')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
</head>
<body>
    <div class="app-shell">
        <header class="app-topbar">
            <a class="brand" href="{{ route('feed') }}" aria-label="Trendora - Feed">
                <span class="brand__mark" aria-hidden="true"></span>
                <span class="brand__name">Trendora</span>
            </a>

            <div class="app-topbar__right">
                @auth
                    @if (Route::has('profile.show'))
                        <a class="btn btn--ghost" href="{{ route('profile.show', auth()->id()) }}">Mon profil</a>
                    @endif
                    <a class="btn btn--ghost" href="{{ route('articles.create') }}">Publier</a>
                    <a class="btn btn--ghost" href="{{ route('articles.index') }}">Mes articles</a>
                    <span class="app-user">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ url('/logout') }}">
                        @csrf
                        <button class="btn btn--ghost" type="submit">Se déconnecter</button>
                    </form>
                @endauth
            </div>
        </header>

        <main class="app-main">
            @if (session('success'))
                <div class="flash flash--success" role="status">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="flash flash--error" role="alert">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>

