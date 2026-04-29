@extends('layouts.app')

@section('title', $user->name . ' - Profil - Trendora')

@section('content')
    <section class="profile-page">
        <header class="profile-header">
            <div class="profile-banner"></div>
            <div class="profile-avatar-wrapper">
                <img class="profile-avatar" src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=f5f0e8&color=1a1a1a&size=240' }}" alt="{{ $user->name }}" loading="lazy">
            </div>
            <div class="profile-info">
                <h1 class="profile-name">{{ $user->name }}</h1>
                <p class="profile-bio">{{ $user->bio ?: 'Passionne(e) de mode sur Trendora.' }}</p>
                @if ($user->style_prefere)
                    <div class="profile-style-badge">★ {{ $user->style_prefere }}</div>
                @endif

                <div class="profile-stats">
                    <div class="profile-stat">
                        <div class="profile-stat-value">{{ $stats['publications'] }}</div>
                        <div class="profile-stat-label">Publications</div>
                    </div>
                    <div class="profile-stat">
                        <div class="profile-stat-value">{{ $stats['likes_received'] }}</div>
                        <div class="profile-stat-label">J'aime recus</div>
                    </div>
                    <div class="profile-stat">
                        <div class="profile-stat-value">{{ $stats['member_since'] }}</div>
                        <div class="profile-stat-label">Membre depuis</div>
                    </div>
                </div>

                <div class="profile-actions">
                    @if (auth()->check() && auth()->id() === $user->id)
                        <a class="btn-outline" href="{{ route('profile.edit', $user) }}">Modifier mon profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-text">Deconnexion</button>
                        </form>
                    @else
                        <button type="button" class="btn-outline" disabled>Suivre</button>
                        <button type="button" class="btn-filled" disabled>Message</button>
                    @endif
                </div>
            </div>
        </header>

        <div class="profile-tabs" role="tablist" aria-label="Filtrer les publications">
            <button type="button" class="profile-tab active" data-filter="all">Publications</button>
            <button type="button" class="profile-tab" data-filter="outfit">Looks</button>
            <button type="button" class="profile-tab" data-filter="clothing">Vetements</button>
        </div>

        @if ($articles->count())
            <div class="articles-grid" data-articles-grid>
                @foreach ($articles as $article)
                    <article class="article-card" data-type="{{ $article->type }}">
                        <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" loading="lazy">
                        <div class="article-overlay">
                            <span class="article-type-badge">{{ $article->type === 'outfit' ? 'Look' : 'Vetement' }}</span>
                            <h3 class="article-title-overlay">{{ $article->title }}</h3>
                            <p class="article-likes">❤ {{ $article->likes_count }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg viewBox="0 0 64 80" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M32 4L44 18H20L32 4Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                    <path d="M16 22h32v38c0 4-4 8-8 8H24c-4 0-8-4-8-8V22z" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M24 34c0 8 4 14 8 14s8-6 8-14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <p>Aucune publication pour le moment</p>
            </div>
        @endif

        <div class="profile-pagination">
            {{ $articles->links() }}
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.profile-tab');
            const cards = document.querySelectorAll('.article-card');
            tabs.forEach((tab) => {
                tab.addEventListener('click', () => {
                    tabs.forEach((t) => t.classList.remove('active'));
                    tab.classList.add('active');
                    const filter = tab.dataset.filter;
                    cards.forEach((card) => {
                        const show = filter === 'all' || card.dataset.type === filter;
                        card.style.display = show ? '' : 'none';
                    });
                });
            });
        });
    </script>
@endsection
