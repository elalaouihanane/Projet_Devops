@extends('layouts.app')

@section('title', 'Profil - ' . $user->name)

@section('content')
    <section class="profile-page">
        <header class="profile-header">
            <div class="profile-banner"></div>
            <div class="profile-header-content">
                <img
                    src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=f5f0e8&color=1a1a1a&size=240' }}"
                    alt="Avatar de {{ $user->name }}"
                    class="profile-avatar"
                    loading="lazy"
                >

                <div class="profile-meta">
                    <h1>{{ $user->name }}</h1>
                    <p class="profile-bio">{{ $user->bio ?: 'Passionne(e) de mode sur Trendora.' }}</p>
                    @if ($user->style_prefere)
                        <span class="profile-style-badge">★ {{ $user->style_prefere }}</span>
                    @endif
                </div>

                <div class="profile-actions">
                    @if (auth()->check() && auth()->id() === $user->id)
                        <a href="{{ route('profile.edit', $user) }}" class="btn btn-accent">Modifier mon profil</a>
                        <form method="POST" action="{{ url('/logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline">Déconnexion</button>
                        </form>
                    @else
                        <button type="button" class="btn btn-accent">Suivre</button>
                        <button type="button" class="btn btn-outline">Message</button>
                    @endif
                </div>
            </div>

            <div class="profile-stats">
                <article>
                    <h2>{{ $stats['publications'] }}</h2>
                    <p>Publications</p>
                </article>
                <article>
                    <h2>{{ $stats['likes_received'] }}</h2>
                    <p>J'aime recus</p>
                </article>
                <article>
                    <h2>{{ ucfirst($stats['member_since'] ?? '-') }}</h2>
                    <p>Membre depuis</p>
                </article>
            </div>
        </header>

        <section class="profile-tabs-section">
            <div class="profile-tabs" role="tablist" aria-label="Filtres des articles">
                <button class="tab-btn is-active" type="button" data-filter="all">Publications</button>
                <button class="tab-btn" type="button" data-filter="outfit">Looks</button>
                <button class="tab-btn" type="button" data-filter="clothing">Vetements</button>
            </div>

            @if ($articles->count())
                <div class="articles-grid" data-articles-grid>
                    @foreach ($articles as $article)
                        <article class="article-card" data-type="{{ $article->type }}">
                            <img
                                src="{{ asset('storage/' . $article->image) }}"
                                alt="{{ $article->title }}"
                                loading="lazy"
                            >
                            <div class="article-overlay">
                                <span class="article-type">{{ $article->type === 'outfit' ? 'Look' : 'Vetement' }}</span>
                                <h3>{{ $article->title }}</h3>
                                <p>❤ {{ $article->likes_count }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <svg width="68" height="68" viewBox="0 0 68 68" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M20 14H48L44 30L52 54H16L24 30L20 14Z" stroke="#c9a96e" stroke-width="2"/>
                        <path d="M26 14C26 10.6863 29.134 8 33 8H35C38.866 8 42 10.6863 42 14" stroke="#0a0a0a" stroke-width="2"/>
                    </svg>
                    <p>Aucune publication pour le moment</p>
                </div>
            @endif
        </section>

        <div class="profile-pagination">
            {{ $articles->links() }}
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.tab-btn');
            const cards = document.querySelectorAll('.article-card');

            buttons.forEach((button) => {
                button.addEventListener('click', function () {
                    buttons.forEach((btn) => btn.classList.remove('is-active'));
                    button.classList.add('is-active');

                    const filter = button.dataset.filter;

                    cards.forEach((card) => {
                        const type = card.dataset.type;
                        const shouldShow = filter === 'all' || filter === type;
                        card.style.display = shouldShow ? 'block' : 'none';
                    });
                });
            });
        });
    </script>
@endsection
