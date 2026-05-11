<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Trendora - Connexion</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

    <h1 class="title">Trendora</h1>

    <div class="form-box">

        <h2>Connexion</h2>

        <form>
            <label>Email</label>
            <input type="email" placeholder="Entrer votre email">

            <label>Mot de passe</label>
            <input type="password" placeholder="Entrer votre mot de passe">

            <button type="submit">Se connecter</button>
        </form>

        <p class="link">
            Vous n’avez pas de compte ?
            <a href="/register">S’inscrire</a>
        </p>

    </div>

</div>

</body>
</html>