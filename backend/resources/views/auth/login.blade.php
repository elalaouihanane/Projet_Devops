@extends('layouts.auth')

@section('title', 'Connexion — Trendora')
@section('brand_title', 'Ravie de vous revoir.')
@section('brand_subtitle', 'Connectez-vous pour retrouver votre feed et vos favoris.')

@section('content')
    <div class="auth-card" data-login>
        <header class="auth-card__head">
            <div>
                <p class="auth-eyebrow">Connexion</p>
                <h2 class="auth-title">Se connecter</h2>
            </div>
            <div class="auth-steps" aria-label="Accès rapide">
                <a class="step is-active" href="{{ url('/login') }}">
                    <span class="step__dot">↩</span><span class="step__label">Accès</span>
                </a>
            </div>
        </header>

        <form class="auth-form" method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            @if ($errors->any())
                <div class="alert alert--error" role="alert">
                    <strong>Oups.</strong> Vérifie tes identifiants.
                </div>
            @endif

            <div class="field">
                <label for="email">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <p class="field-error" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label for="password">Mot de passe</label>
                <div class="input-with-action">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        data-password
                    >
                    <button class="input-action" type="button" data-toggle-password aria-label="Afficher le mot de passe">
                        Afficher
                    </button>
                </div>
                @error('password')
                    <p class="field-error" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="field field--check">
                <label class="check">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                    <span>Rester connecté(e)</span>
                </label>
            </div>

            <div class="step-actions">
                <span class="step-hint">Pas encore de compte ? <a class="link" href="{{ url('/register') }}">Créer un compte</a></span>
                <button type="submit" class="btn btn--primary">Connexion</button>
            </div>
        </form>
    </div>

    <script>
        (function () {
            const root = document.querySelector('[data-login]');
            if (!root) return;
            const password = root.querySelector('[data-password]');
            root.querySelector('[data-toggle-password]')?.addEventListener('click', () => {
                const isPw = password.type === 'password';
                password.type = isPw ? 'text' : 'password';
            });
        })();
    </script>
@endsection

