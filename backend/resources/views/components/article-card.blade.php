@props(['article'])

@php
    $avatarSrc = \App\Models\Article::resolvedPublicMedia($article->user?->photo ?? null);
    $typeLabel = $article->type === 'clothing' ? 'Vêtement' : 'Outfit';
@endphp

<article class="feed-card feed-card--article">
    <a class="feed-card__media" href="{{ route('articles.show', $article) }}">
        <img
            src="{{ $article->publicImageUrl() }}"
            alt=""
            class="feed-card__img"
            loading="lazy"
            onerror="this.onerror=null;this.src={{ \Illuminate\Support\Js::from(\App\Models\Article::placeholderImageUrl()) }}"
        >
    </a>
    <div class="feed-card__body">
        <div class="feed-card__row">
            <span class="feed-badge">{{ $typeLabel }}</span>
            <span class="feed-card__likes" aria-label="J'aime">{{ (int) $article->likes_count }} ♥</span>
        </div>
        <h2 class="feed-card__title">
            <a class="feed-card__title-link" href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
        </h2>
        <div class="feed-card__author">
            @if ($avatarSrc)
                <img class="feed-card__avatar" src="{{ $avatarSrc }}" alt="">
            @else
                <span class="feed-card__avatar feed-card__avatar--placeholder" aria-hidden="true"></span>
            @endif
            <span class="feed-card__author-name">{{ $article->user?->name ?? '—' }}</span>
        </div>
    </div>
</article>
