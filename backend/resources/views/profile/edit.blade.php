@extends('layouts.app')

@section('title', 'Edition Profil - ' . $user->name)

@section('content')
    <section class="profile-edit-page">
        <h1>Modifier mon profil</h1>

        <form method="POST" action="{{ route('profile.update', $user) }}" enctype="multipart/form-data" class="profile-edit-form">
            @csrf
            @method('PUT')

            <label for="name">Nom</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>

            <label for="bio">Bio</label>
            <textarea id="bio" name="bio" rows="4">{{ old('bio', $user->bio) }}</textarea>

            <label for="style_prefere">Style prefere</label>
            <input id="style_prefere" name="style_prefere" type="text" value="{{ old('style_prefere', $user->style_prefere) }}">

            <label for="photo">Photo de profil</label>
            <input id="photo" name="photo" type="file" accept="image/*">

            <img
                id="photo-preview"
                class="profile-photo-preview"
                src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=f5f0e8&color=1a1a1a&size=240' }}"
                alt="Apercu photo de profil"
            >

            <button type="submit" class="btn btn-accent">Enregistrer</button>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('photo');
            const preview = document.getElementById('photo-preview');

            if (!input || !preview) {
                return;
            }

            input.addEventListener('change', function (event) {
                const file = event.target.files[0];

                if (!file) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
