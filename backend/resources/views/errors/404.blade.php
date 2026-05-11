<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Trendora</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
    <style>
        .err-page{ min-height:100vh; display:grid; place-items:center; padding: 24px; background: var(--cream); }
        .err-card{ text-align:center; max-width: 420px; border: 1px solid rgba(10,10,10,.10); border-radius: var(--radius); padding: 32px 24px; background: rgba(245,240,232,.78); box-shadow: var(--shadow-soft); }
        .err-card h1{ margin:0; font-family: "Cormorant Garamond", Georgia, serif; font-size: 36px; color: var(--text); }
        .err-card p{ margin: 14px 0 0; color: rgba(10,10,10,.68); font-size: 15px; }
        .err-card a{ margin-top: 20px; display:inline-block; }
    </style>
</head>
<body>
    <div class="err-page">
        <div class="err-card">
            <h1>404 — Page introuvable</h1>
            <p>La page demandée n’existe pas ou a été déplacée.</p>
            <a class="btn btn--primary" href="{{ Route::has('feed') ? route('feed') : url('/') }}">Retour au feed</a>
        </div>
    </div>
</body>
</html>
