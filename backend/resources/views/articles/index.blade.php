@extends('layouts.app')

@section('title', 'Mes articles — Trendora')

@section('content')
    <div class="feed-head">
        <div>
            <p class="auth-eyebrow">Trendora</p>
            <h1 class="feed-title">Mes articles</h1>
            <p class="feed-subtitle">Gérez vos looks et vêtements publiés sur Trendora.</p>
        </div>

        <div>
            <a class="btn btn--primary" href="{{ url('/articles/create') }}">Publier un article</a>
        </div>
    </div>

    @if ($articles->isEmpty())
        <div class="feed-card">
            <h2 class="feed-card__title">Aucun article</h2>
            <p class="feed-card__text">Vous n’avez pas encore publié d’article. Commencez par en publier un.</p>
        </div>
    @else
        <div class="feed-grid">
            @foreach ($articles as $article)
                <div class="feed-card">
                    <a href="{{ url('/articles/' . $article->id) }}" style="text-decoration:none;">
                        <div style="display:flex; gap: 14px; align-items:flex-start; flex-wrap: wrap;">
                            <div style="width: 160px; max-width: 100%;">
                                @php
                                    $img = (string) ($article->image ?? '');
                                    $src = \Illuminate\Support\Str::startsWith($img, ['http://', 'https://'])
                                        ? $img
                                        : (\Illuminate\Support\Str::startsWith($img, 'uploads/')
                                            ? asset($img)
                                            : asset('storage/' . ltrim($img, '/')));
                                @endphp
                                <img
                                    src="{{ $src }}"
                                    alt="{{ $article->title }}"
                                    style="width:100%; height: 120px; object-fit: cover; border-radius: 14px; border:1px solid rgba(10,10,10,.10);"
                                >
                            </div>

                            <div style="flex:1; min-width: 220px;">
                                <h2 class="feed-card__title" style="margin-bottom: 6px;">{{ $article->title }}</h2>

                                <div style="display:flex; gap: 10px; align-items:center; flex-wrap: wrap; margin-bottom: 10px;">
                                    <span class="chip is-selected" style="cursor: default;">
                                        {{ $article->type === 'outfit' ? 'Outfit' : 'Clothing' }}
                                    </span>
                                    @if ($article->category)
                                        <span class="chip" style="cursor: default;">
                                            {{ $article->category->name }}
                                        </span>
                                    @endif
                                    @if (!$article->is_published)
                                        <span class="chip" style="cursor: default;">Brouillon</span>
                                    @endif
                                </div>

                                <p class="feed-card__text" style="margin-bottom: 0;">
                                    Publié le {{ $article->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </a>

                    <div class="step-actions" style="margin-top: 14px;">
                        <div class="step-hint">
                            <a class="link" href="{{ url('/articles/' . $article->id) }}">Voir</a>
                            <span aria-hidden="true"> · </span>
                            <a class="link" href="{{ url('/articles/' . $article->id . '/edit') }}">Éditer</a>
                        </div>

                        <form method="POST" action="{{ url('/articles/' . $article->id) }}" onsubmit="return confirm('Supprimer cet article ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn--ghost" type="submit">Supprimer</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection

