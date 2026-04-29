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
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav class="navbar">
        <a class="navbar-logo" href="{{ url('/') }}">Trendora</a>
        <button type="button" class="mobile-menu-btn" data-mobile-menu-toggle aria-expanded="false" aria-label="Ouvrir le menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 6h18M3 12h18M3 18h18"/>
            </svg>
        </button>
        <div class="navbar-links" data-navbar-links>
            <a href="{{ url('/') }}">Accueil</a>
            <a href="{{ url('/') }}">Feed</a>
            @auth
                <a href="{{ route('profile.show', auth()->user()) }}">Mon Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="navbar-logout">Déconnexion</button>
                </form>
            @endauth
            @guest
                <a href="{{ url('/login') }}">Connexion</a>
                <a href="{{ url('/register') }}">Inscription</a>
            @endguest
        </div>
    </nav>

    <main class="main-shell">
        @if (session('success'))
            <div class="flash-success" role="status">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="flash-error" role="alert">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>

    <script>
        (function () {
            var btn = document.querySelector('[data-mobile-menu-toggle]');
            var links = document.querySelector('[data-navbar-links]');
            if (!btn || !links) return;
            btn.addEventListener('click', function () {
                var open = links.classList.toggle('active');
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        })();
    </script>
</body>
</html>