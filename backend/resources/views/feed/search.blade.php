@extends('layouts.app')

@section('title', 'Recherche — Trendora')

@section('content')
    <style>
        .feed-toolbar{ display:flex; flex-direction:column; gap:14px; margin: 18px 0 20px; }
        .feed-search{ display:flex; gap:10px; flex-wrap:wrap; align-items:center; }
        .feed-search input[type="search"]{ flex:1; min-width: 200px; }
        .feed-filters{ display:flex; flex-wrap:wrap; gap:10px; align-items:flex-end; }
        .feed-filters label{ display:flex; flex-direction:column; gap:6px; font-size: 12px; font-weight: 600; color: rgba(10,10,10,.75); }
        .feed-filters select{ min-width: 140px; padding: 10px 12px; border-radius: 14px; border: 1px solid rgba(10,10,10,.14); background: rgba(245,240,232,.92); }
        .feed-card--article{ padding: 0; overflow: hidden; display:flex; flex-direction:column; height:100%; }
        .feed-card__media{ display:block; line-height:0; }
        .feed-card__img{ width:100%; height: 220px; object-fit: cover; }
        .feed-card__body{ padding: 14px 16px 16px; display:flex; flex-direction:column; gap: 8px; flex:1; }
        .feed-card__row{ display:flex; justify-content: space-between; align-items:center; gap: 10px; }
        .feed-badge{ font-size: 11px; letter-spacing: .08em; text-transform: uppercase; padding: 6px 10px; border-radius: 999px; border: 1px solid rgba(201,169,110,.45); color: var(--accent2); background: rgba(201,169,110,.12); }
        .feed-card__likes{ font-size: 13px; color: rgba(10,10,10,.65); }
        .feed-card__title{ margin: 0; font-family: "Cormorant Garamond", Georgia, serif; font-size: 22px; line-height: 1.15; }
        .feed-card__title-link{ text-decoration: none; color: inherit; border-bottom: 1px solid transparent; transition: border-color .15s; }
        .feed-card__title-link:hover{ border-bottom-color: rgba(201,169,110,.55); }
        .feed-card__author{ display:flex; align-items:center; gap: 10px; margin-top: auto; padding-top: 4px; }
        .feed-card__avatar{ width: 32px; height: 32px; border-radius: 999px; object-fit: cover; border: 1px solid rgba(10,10,10,.10); }
        .feed-card__avatar--placeholder{ background: linear-gradient(135deg, var(--accent), rgba(201,169,110,.25)); }
        .feed-card__author-name{ font-size: 14px; color: rgba(10,10,10,.78); }
        .feed-empty{ text-align:center; padding: 28px 16px; color: rgba(10,10,10,.65); border: 1px dashed rgba(10,10,10,.16); border-radius: var(--radius); background: rgba(245,240,232,.5); }
        .feed-pagination{ margin-top: 22px; display:flex; justify-content: center; flex-wrap: wrap; gap: 8px; }
        .feed-back{ margin-bottom: 12px; }
    </style>

    <p class="feed-back"><a class="link" href="{{ route('feed') }}">← Retour au feed</a></p>

    <div class="feed-head">
        <div>
            <p class="auth-eyebrow">Trendora</p>
            <h1 class="feed-title">Résultats pour : {{ request('search') }}</h1>
            <p class="feed-subtitle">Affinez votre recherche ci-dessous.</p>
        </div>
    </div>

    <div class="feed-toolbar">
        <form class="feed-search" method="get" action="{{ route('search') }}" role="search">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Rechercher un article…" aria-label="Recherche">
            <button class="btn btn--primary" type="submit">Rechercher</button>
        </form>

        <form class="feed-filters" method="get" action="{{ route('search') }}">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <label>
                Catégorie
                <select name="category" onchange="this.form.submit()">
                    <option value="">Toutes</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected((string) request('category') === (string) $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </label>
            <label>
                Type
                <select name="type" onchange="this.form.submit()">
                    <option value="">Tous</option>
                    <option value="outfit" @selected(request('type') === 'outfit')>Outfit</option>
                    <option value="clothing" @selected(request('type') === 'clothing')>Vêtement</option>
                </select>
            </label>
            <label>
                Tri
                <select name="sort" onchange="this.form.submit()">
                    <option value="" @selected(request('sort') !== 'popular')>Récent</option>
                    <option value="popular" @selected(request('sort') === 'popular')>Populaire</option>
                </select>
            </label>
            <noscript><button class="btn btn--ghost" type="submit">Appliquer</button></noscript>
        </form>
    </div>

    @if ($articles->isEmpty())
        <p class="feed-empty">Aucun article trouvé</p>
    @else
        <div class="feed-grid">
            @foreach ($articles as $article)
                <x-article-card :article="$article" />
            @endforeach
        </div>
        <div class="feed-pagination">
            {{ $articles->withQueryString()->links() }}
        </div>
    @endif
@endsection
