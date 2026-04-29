@extends('layouts.auth')

@section('title', 'Connexion - Trendora')
@section('brand_title', 'Heureux de vous revoir.')
@section('brand_subtitle', 'Connectez-vous pour retrouver votre univers mode.')

@section('content')
    <div class="auth-card">
        <h2 class="auth-title">Se connecter</h2>
        <form class="auth-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                @error('email') <p class="field-error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="password">Mot de passe</label>
                <input id="password" name="password" type="password" required>
            </div>
            <button type="submit" class="btn-filled">Connexion</button>
            <p class="auth-footnote">Nouveau ? <a href="{{ route('register') }}">Creer un compte</a></p>
        </form>
    </div>
@endsection
