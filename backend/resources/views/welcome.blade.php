
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trendora — Se connecter</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
 
    <!-- Panneau gauche : visuel mode -->
    <div class="panel-left">
        <div class="overlay"></div>
        <div class="brand-box">
            <span class="logo-icon">✦</span>
            <h1 class="logo">Trendora</h1>
            <p class="tagline">Partagez votre style.<br>Inspirez le monde.</p>
        </div>
        <div class="deco-circles">
            <div class="circle c1"></div>
            <div class="circle c2"></div>
            <div class="circle c3"></div>
        </div>
    </div>
 
    <!-- Panneau droit : formulaire -->
    <div class="panel-right">
        <div class="form-container">
 
            <!-- Logo mobile -->
            <div class="mobile-logo">
                <span class="logo-icon-sm">✦</span>
                <span class="logo-sm">Trendora</span>
            </div>
 
            <div class="form-header">
                <h2>Bon retour !</h2>
                <p>Connectez-vous pour retrouver votre communauté mode.</p>
            </div>
 
            <!-- Messages d'erreur Laravel -->
            @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
 
            @if (session('status'))
                <div class="alert-success">
                    {{ session('status') }}
                </div>
            @endif
 
            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf
 
                <!-- Email -->
                <div class="field-group">
                    <label for="email">Adresse e-mail</label>
                    <div class="input-wrap">
                        <svg class="field-icon" viewBox="0 0 20 20" fill="none">
                            <path d="M2.5 5.5A1.5 1.5 0 014 4h12a1.5 1.5 0 011.5 1.5v9A1.5 1.5 0 0116 16H4a1.5 1.5 0 01-1.5-1.5v-9z" stroke="currentColor" stroke-width="1.2"/>
                            <path d="M2.5 5.5l7.5 5 7.5-5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                        </svg>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="votre@email.com"
                            autocomplete="email"
                            required
                        >
                    </div>
                </div>
 
                <!-- Mot de passe -->
                <div class="field-group">
                    <div class="label-row">
                        <label for="password">Mot de passe</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Mot de passe oublié ?</a>
                        @endif
                    </div>
                    <div class="input-wrap">
                        <svg class="field-icon" viewBox="0 0 20 20" fill="none">
                            <rect x="4" y="9" width="12" height="8" rx="1.5" stroke="currentColor" stroke-width="1.2"/>
                            <path d="M7 9V6.5a3 3 0 016 0V9" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                            <circle cx="10" cy="13" r="1" fill="currentColor"/>
                        </svg>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="toggle-pw" onclick="togglePassword()" aria-label="Afficher le mot de passe">
                            <svg id="eye-icon" viewBox="0 0 20 20" fill="none">
                                <path d="M2 10s3-5.5 8-5.5S18 10 18 10s-3 5.5-8 5.5S2 10 2 10z" stroke="currentColor" stroke-width="1.2"/>
                                <circle cx="10" cy="10" r="2.5" stroke="currentColor" stroke-width="1.2"/>
                            </svg>
                        </button>
                    </div>
                </div>
 
                <!-- Remember me -->
                <div class="remember-row">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" id="remember">
                        <span class="checkbox-custom"></span>
                        <span>Se souvenir de moi</span>
                    </label>
                </div>
 
                <!-- Bouton connexion -->
                <button type="submit" class="btn-login">
                    Se connecter
                    <svg viewBox="0 0 20 20" fill="none">
                        <path d="M5 10h10M11 6l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
 
            </form>
 
            <!-- Séparateur -->
            <div class="separator">
                <span></span>
                <small>ou</small>
                <span></span>
            </div>
 
            <!-- Lien inscription -->
            <div class="register-cta">
                <p>Pas encore de compte ?</p>
                <a href="{{ route('register') }}" class="btn-register">
                    Créer un compte gratuitement
                </a>
            </div>
 
        </div>
    </div>
 
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path d="M3 3l14 14M8.46 8.46A3 3 0 0012.54 11.54M6.1 6.1C3.9 7.5 2 10 2 10s3 5.5 8 5.5c1.55 0 2.96-.42 4.16-1.1M10 4.5C13.5 4.5 16.9 7 18 10c-.37.93-.93 1.82-1.62 2.6" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path d="M2 10s3-5.5 8-5.5S18 10 18 10s-3 5.5-8 5.5S2 10 2 10z" stroke="currentColor" stroke-width="1.2"/>
                    <circle cx="10" cy="10" r="2.5" stroke="currentColor" stroke-width="1.2"/>
                `;
            }
        }
    </script>
 
</body>
</html>