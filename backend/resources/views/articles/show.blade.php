@extends('layouts.app')

@section('title', ($article->title ?? 'Article') . ' — Trendora')

@section('content')
    <div class="feed-head">
        <div>
            <p class="auth-eyebrow">Trendora</p>
            <h1 class="feed-title">{{ $article->title }}</h1>
            <p class="feed-subtitle">
                <span style="color: rgba(10,10,10,.70);">Publié le {{ $article->created_at->format('d/m/Y') }}</span>
            </p>
        </div>

        <div style="display:flex; gap: 10px; flex-wrap: wrap; align-items:center;">
            <a class="btn btn--ghost" href="{{ url('/articles') }}">Retour</a>

            @if (auth()->id() === $article->user_id)
                <a class="btn btn--primary" href="{{ url('/articles/' . $article->id . '/edit') }}">Éditer</a>

                <form method="POST" action="{{ url('/articles/' . $article->id) }}" onsubmit="return confirm('Supprimer cet article ?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn--ghost" type="submit">Supprimer</button>
                </form>
            @endif
        </div>
    </div>

    <div class="feed-card">
        <img
            src="{{ asset('storage/' . $article->image) }}"
            alt="{{ $article->title }}"
            style="width:100%; height: min(520px, 60vh); object-fit: cover; border-radius: 16px; border:1px solid rgba(10,10,10,.10);"
        >

        <div style="margin-top: 14px; display:flex; gap: 10px; flex-wrap: wrap; align-items:center;">
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
            @if ($article->occasion)
                <span class="chip" style="cursor: default;">Occasion : {{ $article->occasion }}</span>
            @endif
            @if ($article->color)
                <span class="chip" style="cursor: default;">Couleur : {{ $article->color }}</span>
            @endif
        </div>

        @if ($article->description)
            <p class="feed-card__text" style="margin-top: 14px; white-space: pre-wrap;">{{ $article->description }}</p>
        @endif

        @if (!empty($article->tags) && is_array($article->tags))
            <div style="margin-top: 14px;">
                <p class="auth-eyebrow" style="margin-bottom: 10px;">Tags</p>
                <div class="chips">
                    @foreach ($article->tags as $tag)
                        <span class="chip" style="cursor: default;">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <div style="margin-top: 16px; padding-top: 14px; border-top: 1px solid rgba(10,10,10,.08); display:flex; align-items:center; justify-content: space-between; gap: 12px; flex-wrap: wrap;">
            <div>
                <p class="auth-eyebrow" style="margin-bottom: 6px;">Auteur</p>
                <a class="link" href="{{ url('/users/' . $article->user->id) }}">
                    {{ $article->user->name }}
                </a>
            </div>

            <div style="display:flex; align-items:center; gap: 10px;">
                @php
                    $photo = $article->user->photo ? asset('storage/' . $article->user->photo) : null;
                @endphp
                @if ($photo)
                    <img src="{{ $photo }}" alt="{{ $article->user->name }}" style="width: 44px; height: 44px; border-radius: 999px; object-fit: cover; border:1px solid rgba(10,10,10,.10);">
                @else
                    <div style="width:44px; height:44px; border-radius:999px; border:1px solid rgba(10,10,10,.12); background: rgba(201,169,110,.14); display:flex; align-items:center; justify-content:center; font-weight: 700;">
                        {{ mb_substr($article->user->name, 0, 1) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

