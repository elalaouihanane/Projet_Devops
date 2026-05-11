<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trendora — Mode &amp; partage</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
    <style>
        .wl-body{ margin:0; min-height:100vh; display:flex; flex-direction:column; background: var(--cream); color: var(--text); font-family: 'DM Sans', sans-serif; }
        .wl-header{ display:flex; align-items:center; justify-content: space-between; gap: 16px; padding: 18px 20px; border-bottom: 1px solid rgba(10,10,10,.10); background: rgba(245,240,232,.85); backdrop-filter: blur(10px); }
        .wl-brand{ display:inline-flex; align-items:center; gap:10px; text-decoration:none; color: inherit; }
        .wl-brand__mark{ width: 14px; height: 14px; border-radius: 999px; background: linear-gradient(135deg, var(--accent), rgba(201,169,110,.35)); box-shadow: 0 0 0 3px rgba(201,169,110,.14); }
        .wl-brand__name{ font-family: "Cormorant Garamond", Georgia, serif; font-size: 24px; letter-spacing: .08em; text-transform: uppercase; }
        .wl-header__actions{ display:flex; align-items:center; gap: 10px; flex-wrap: wrap; }
        .wl-main{ flex:1; }
        .wl-hero{ padding: 48px 20px 40px; text-align: center; max-width: 720px; margin: 0 auto; }
        .wl-hero h1{ margin: 0; font-family: "Cormorant Garamond", Georgia, serif; font-size: clamp(40px, 7vw, 58px); line-height: 1.05; font-weight: 600; }
        .wl-hero p{ margin: 16px auto 0; max-width: 42ch; color: rgba(10,10,10,.72); font-size: 17px; line-height: 1.55; }
        .wl-hero__cta{ margin-top: 26px; }
        .wl-preview{ padding: 12px 20px 48px; max-width: 980px; margin: 0 auto; width: 100%; }
        .wl-preview h2{ font-family: "Cormorant Garamond", Georgia, serif; font-size: 28px; margin: 0 0 18px; text-align: center; }
        .wl-grid{ display:grid; grid-template-columns: 1fr; gap: 14px; }
        @media (min-width: 860px){ .wl-grid{ grid-template-columns: 1fr 1fr 1fr; } }
        .wl-card{ border: 1px solid rgba(10,10,10,.10); border-radius: var(--radius); overflow: hidden; background: rgba(245,240,232,.78); box-shadow: var(--shadow-soft); }
        .wl-card img{ width:100%; height: 200px; object-fit: cover; display:block; }
        .wl-card__body{ padding: 14px 16px 16px; }
        .wl-card__title{ margin:0; font-family: "Cormorant Garamond", Georgia, serif; font-size: 20px; }
        .wl-card__meta{ margin: 8px 0 0; font-size: 13px; color: rgba(10,10,10,.65); }
        .wl-footer{ padding: 22px 20px; text-align: center; font-size: 13px; color: rgba(10,10,10,.55); border-top: 1px solid rgba(10,10,10,.08); }
    </style>
</head>
<body class="wl-body">
    <header class="wl-header">
        <a class="wl-brand" href="{{ route('home') }}" aria-label="Trendora">
            <span class="wl-brand__mark" aria-hidden="true"></span>
            <span class="wl-brand__name">Trendora</span>
        </a>
        <div class="wl-header__actions">
            <a class="btn btn--ghost" href="{{ route('login') }}">Se connecter</a>
            <a class="btn btn--primary" href="{{ route('register') }}">S'inscrire</a>
        </div>
    </header>

    <main class="wl-main">
        <section class="wl-hero" aria-labelledby="wl-hero-title">
            <h1 id="wl-hero-title">La mode se vit ensemble</h1>
            <p>Partagez vos tenues, explorez les inspirations de la communauté et trouvez votre style sur Trendora.</p>
            <div class="wl-hero__cta">
                <a class="btn btn--primary" href="{{ route('register') }}">Rejoindre Trendora</a>
            </div>
        </section>

        <section class="wl-preview" aria-labelledby="wl-preview-title">
            <h2 id="wl-preview-title">Aperçu</h2>
            <div class="wl-grid">
                @forelse ($articles as $article)
                    <article class="wl-card">
                        <img
                            src="{{ $article->publicImageUrl() }}"
                            alt=""
                            onerror="this.onerror=null;this.src={{ \Illuminate\Support\Js::from(\App\Models\Article::placeholderImageUrl()) }}"
                        >
                        <div class="wl-card__body">
                            <h3 class="wl-card__title">{{ $article->title }}</h3>
                            <p class="wl-card__meta">{{ $article->user?->name ?? '—' }}</p>
                        </div>
                    </article>
                @empty
                    <p style="grid-column: 1 / -1; text-align:center; color: rgba(10,10,10,.6);">Les premiers articles arrivent bientôt.</p>
                @endforelse
            </div>
        </section>
    </main>

    <footer class="wl-footer">© 2025 Trendora</footer>
</body>
</html>
