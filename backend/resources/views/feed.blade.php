@extends('layouts.app')

@section('title', 'Feed — Trendora')

@section('content')
    <div class="feed-head">
        <div>
            <p class="auth-eyebrow">Trendora</p>
            <h1 class="feed-title">Votre feed</h1>
            <p class="feed-subtitle">Espace en cours de construction. L’inscription redirige bien ici.</p>
        </div>
        <div class="feed-actions">
            <a class="btn btn--primary" href="#" onclick="return false;">Publier un article</a>
        </div>
    </div>

    <div class="feed-grid">
        <div class="feed-card">
            <h2 class="feed-card__title">Prochaine étape</h2>
            <p class="feed-card__text">
                On pourra maintenant implémenter la liste des articles (outfits/vêtements), les likes, commentaires et favoris.
            </p>
        </div>
        <div class="feed-card">
            <h2 class="feed-card__title">Astuce dev</h2>
            <p class="feed-card__text">
                Pour l’upload photo, pense à exécuter <code>php artisan storage:link</code> dans le conteneur.
            </p>
        </div>
    </div>
@endsection

