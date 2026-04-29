@extends('layouts.auth')

@section('title', 'Inscription - Trendora')
@section('brand_title', 'Bienvenue sur Trendora.')
@section('brand_subtitle', 'Creez votre compte et partagez vos looks.')

@section('content')
    <div class="auth-card">
        <h2 class="auth-title">Creer votre compte</h2>
        <form class="auth-form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid-2">
                <div class="field">
                    <label for="first_name">Prenom</label>
                    <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required>
                </div>
                <div class="field">
                    <label for="last_name">Nom</label>
                    <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" required>
                </div>
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                @error('email') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid-2">
                <div class="field">
                    <label for="password">Mot de passe</label>
                    <input id="password" name="password" type="password" required minlength="8">
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div class="field">
                    <label for="password_confirmation">Confirmation</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8">
                </div>
            </div>

            <div class="field">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" rows="3">{{ old('bio') }}</textarea>
            </div>

            <div class="field">
                <label for="style_prefere">Style prefere</label>
                <input id="style_prefere" name="style_prefere" type="text" value="{{ old('style_prefere') }}">
            </div>

            <div class="field">
                <label for="photo">Photo de profil</label>
                <input id="photo" name="photo" type="file" accept="image/*">
            </div>

            <button type="submit" class="btn-filled">Creer mon compte</button>
            <p class="auth-footnote">Deja un compte ? <a href="{{ route('login') }}">Se connecter</a></p>
        </form>
    </div>
@endsection
