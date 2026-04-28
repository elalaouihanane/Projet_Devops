<nav class="navbar">
    <div class="nav-container">
        <a href="/" class="logo">Trendora</a>

        <button class="nav-toggle" type="button" aria-label="Ouvrir le menu" data-nav-toggle>
            <span></span><span></span><span></span>
        </button>

        <div class="nav-links" data-nav-menu>
            <a href="/">Accueil</a>
            <a href="/">Feed</a>
            @auth
                <a href="{{ route('profile.show', auth()->user()) }}">Mon Profil</a>
                <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Déconnexion</button>
                </form>
            @else
                <a href="{{ url('/login') }}">Connexion</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.querySelector('[data-nav-toggle]');
        const menu = document.querySelector('[data-nav-menu]');

        if (!toggle || !menu) {
            return;
        }

        toggle.addEventListener('click', function () {
            menu.classList.toggle('is-open');
        });
    });
</script>