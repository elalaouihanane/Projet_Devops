@extends('layouts.app')

<<<<<<< HEAD
<<<<<<< Updated upstream
@section('title', 'Profil - ' . $user->name)
=======
@section('title', $user->name . ' - Profil - Trendora')
>>>>>>> d2a23ba

@section('content')
    <section class="profile-page">
        <header class="profile-header">
            <div class="profile-banner"></div>
<<<<<<< HEAD
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
=======
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
>>>>>>> d2a23ba
                </div>

                <div class="profile-actions">
                    @if (auth()->check() && auth()->id() === $user->id)
<<<<<<< HEAD
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
=======
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
>>>>>>> d2a23ba

        <div class="profile-pagination">
            {{ $articles->links() }}
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
<<<<<<< HEAD
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
=======
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
>>>>>>> d2a23ba
                    });
                });
            });
        });
    </script>
@endsection
<<<<<<< HEAD
=======
@section('title', $user->name . ' — Profil — Trendora')

@section('content')
    <div class="profile-page">
        <header class="profile-header">
            <div class="profile-banner" aria-hidden="true"></div>
            <div class="profile-avatar-wrapper">
                @if ($user->photo)
                    <img
                        class="profile-avatar"
                        src="{{ Storage::disk('public')->url($user->photo) }}"
                        alt=""
                        width="120"
                        height="120"
                        loading="lazy"
                    >
                @else
                    <div class="profile-avatar profile-avatar--placeholder" role="img" aria-label="Pas de photo de profil"></div>
                @endif
            </div>
        </header>

        <div class="profile-info">
            <h1 class="profile-name">{{ $user->name }}</h1>
            @if ($user->bio)
                <p class="profile-bio">{{ $user->bio }}</p>
            @endif
            @if ($user->style_prefere)
                <div class="profile-style-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2l2.4 7.4h7.6l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/>
                    </svg>
                    {{ $user->style_prefere }}
                </div>
            @endif

            <div class="profile-stats">
                <div class="profile-stat">
                    <div class="profile-stat-value">{{ $articles->count() }}</div>
                    <div class="profile-stat-label">Publications</div>
                </div>
                <div class="profile-stat">
                    <div class="profile-stat-value">{{ $articles->sum('likes_count') }}</div>
                    <div class="profile-stat-label">J'aime reçus</div>
                </div>
                <div class="profile-stat">
                    <div class="profile-stat-value">{{ $user->created_at->format('F Y') }}</div>
                    <div class="profile-stat-label">Membre depuis</div>
                </div>
            </div>

            <div class="profile-actions">
                @auth
                    @if (Auth::id() === $user->id)
                        <a class="btn-outline" href="{{ route('profile.edit', $user) }}">Modifier mon profil</a>
                        <form method="POST" action="{{ route('logout') }}" class="profile-inline-form">
                            @csrf
                            <button type="submit" class="navbar-logout">Déconnexion</button>
                        </form>
                    @else
                        <button type="button" class="btn-outline" disabled>Suivre</button>
                        <button type="button" class="btn-filled" disabled>Message</button>
                    @endif
                @else
                    <button type="button" class="btn-outline" disabled>Suivre</button>
                    <button type="button" class="btn-filled" disabled>Message</button>
                @endauth
            </div>
        </div>

        <div class="profile-tabs" role="tablist" aria-label="Filtrer les publications">
            <button type="button" class="profile-tab active" data-profile-tab="all" role="tab" aria-selected="true">Publications</button>
            <button type="button" class="profile-tab" data-profile-tab="outfit" role="tab" aria-selected="false">Looks</button>
            <button type="button" class="profile-tab" data-profile-tab="clothing" role="tab" aria-selected="false">Vêtements</button>
        </div>

        @if ($articles->isEmpty())
            <div class="empty-state" data-empty-total>
                <svg viewBox="0 0 64 80" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M32 4L44 18H20L32 4Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                    <path d="M16 22h32v38c0 4-4 8-8 8H24c-4 0-8-4-8-8V22z" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M24 34c0 8 4 14 8 14s8-6 8-14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <p>Aucune publication pour le moment</p>
            </div>
        @else
            <div class="articles-grid" data-articles-grid>
                @foreach ($articles as $article)
                    <article class="article-card" data-article-type="{{ $article->type }}">
                        <img
                            src="{{ asset('storage/' . $article->image) }}"
                            alt=""
                            width="400"
                            height="400"
                            loading="lazy"
                        >
                        <div class="article-overlay">
                            <span class="article-type-badge">{{ $article->type === 'outfit' ? 'Look' : 'Vêtement' }}</span>
                            <h2 class="article-title-overlay">{{ $article->title }}</h2>
                            <p class="article-likes">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                {{ $article->likes_count }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="empty-state empty-state--filtered is-hidden" data-empty-filtered>
                <p>Aucun contenu dans cet onglet</p>
            </div>
        @endif
    </div>

    <script>
        (function () {
            var tabs = document.querySelectorAll('[data-profile-tab]');
            var grid = document.querySelector('[data-articles-grid]');
            if (!tabs.length || !grid) return;

            var cards = grid.querySelectorAll('[data-article-type]');
            var emptyFiltered = document.querySelector('[data-empty-filtered]');

            function setActiveTab(tab) {
                tabs.forEach(function (btn) {
                    var on = btn.getAttribute('data-profile-tab') === tab;
                    btn.classList.toggle('active', on);
                    btn.setAttribute('aria-selected', on ? 'true' : 'false');
                });
            }

            function applyFilter(type) {
                var visible = 0;
                cards.forEach(function (card) {
                    var t = card.getAttribute('data-article-type');
                    var show = type === 'all' || t === type;
                    card.style.display = show ? '' : 'none';
                    if (show) visible++;
                });
                if (emptyFiltered) {
                    emptyFiltered.classList.toggle('is-hidden', visible > 0);
                }
            }

            tabs.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var type = btn.getAttribute('data-profile-tab');
                    setActiveTab(type);
                    applyFilter(type);
                });
            });
        })();
    </script>
@endsection
>>>>>>> Stashed changes
=======
>>>>>>> d2a23ba
