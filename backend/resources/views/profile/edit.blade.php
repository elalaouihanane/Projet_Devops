@extends('layouts.app')

@section('title', 'Modifier mon profil')

@section('content')
    @php
        $styles = ['Streetwear', 'Chic', 'Casual', 'Vintage', 'Sportswear', 'Bohème'];
        $selectedStyle = old('style_prefere', $user->style_prefere);
    @endphp

    <section class="edit-form">
        <h1 class="edit-form-title">Modifier mon profil</h1>
        <form method="POST" action="{{ route('profile.update', $user) }}" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')

            <div class="edit-form-group">
                <label for="photo">Photo de profil</label>
                <img id="photo-preview" class="photo-preview" src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=f5f0e8&color=1a1a1a&size=240' }}" alt="Apercu photo">
                <input id="photo" name="photo" type="file" accept="image/*">
                @error('photo') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="edit-form-group">
                <label for="name">Nom</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required maxlength="255">
                @error('name') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="edit-form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" rows="4" maxlength="500">{{ old('bio', $user->bio) }}</textarea>
                @error('bio') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="edit-form-group">
                <label>Style prefere</label>
                <input type="hidden" id="style_prefere" name="style_prefere" value="{{ $selectedStyle }}">
                <div class="style-chips">
                    @foreach ($styles as $style)
                        <button type="button" class="style-chip {{ $selectedStyle === $style ? 'active' : '' }}" data-style="{{ $style }}">{{ $style }}</button>
                    @endforeach
                </div>
                @error('style_prefere') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="edit-form-actions">
                <button type="submit" class="btn-filled">Enregistrer les modifications</button>
                <a class="btn-outline" href="{{ route('profile.show', $user) }}">Annuler</a>
            </div>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('photo');
            const preview = document.getElementById('photo-preview');
            const styleInput = document.getElementById('style_prefere');
            const chips = document.querySelectorAll('.style-chip');

            fileInput?.addEventListener('change', function (e) {
                const file = e.target.files && e.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = function (evt) {
                    preview.src = evt.target.result;
                };
                reader.readAsDataURL(file);
            });

            chips.forEach((chip) => {
                chip.addEventListener('click', function () {
                    chips.forEach((c) => c.classList.remove('active'));
                    chip.classList.add('active');
                    styleInput.value = chip.dataset.style;
                });
            });
        });
    </script>
@endsection
