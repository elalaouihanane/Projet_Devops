@extends('layouts.app')

<<<<<<< HEAD
@section('title', 'Modifier mon profil — Trendora')
=======
@section('title', 'Modifier mon profil')
>>>>>>> d2a23ba

@section('content')
    @php
        $styles = ['Streetwear', 'Chic', 'Casual', 'Vintage', 'Sportswear', 'Bohème'];
<<<<<<< HEAD
        $currentStyle = old('style_prefere', $user->style_prefere);
    @endphp

    <div class="edit-form">
        <h1 class="edit-form-title">Modifier mon profil</h1>

=======
        $selectedStyle = old('style_prefere', $user->style_prefere);
    @endphp

    <section class="edit-form">
        <h1 class="edit-form-title">Modifier mon profil</h1>
>>>>>>> d2a23ba
        <form method="POST" action="{{ route('profile.update', $user) }}" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')

            <div class="edit-form-group">
<<<<<<< HEAD
                <label>Photo de profil</label>
                @if ($user->photo)
                    <img
                        id="photo-preview"
                        class="photo-preview"
                        src="{{ Storage::disk('public')->url($user->photo) }}"
                        alt=""
                        width="120"
                        height="120"
                        data-photo-preview
                    >
                @else
                    <div id="photo-preview-fallback" class="photo-preview photo-preview--empty" data-photo-preview-fallback></div>
                    <img
                        id="photo-preview"
                        class="photo-preview is-hidden"
                        src=""
                        alt=""
                        width="120"
                        height="120"
                        data-photo-preview
                    >
                @endif
                <input type="file" name="photo" id="photo" accept="image/*" data-photo-input>
                @error('photo')
                    <p class="field-error" role="alert">{{ $message }}</p>
                @enderror
=======
                <label for="photo">Photo de profil</label>
                <img id="photo-preview" class="photo-preview" src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=f5f0e8&color=1a1a1a&size=240' }}" alt="Apercu photo">
                <input id="photo" name="photo" type="file" accept="image/*">
                @error('photo') <p class="field-error">{{ $message }}</p> @enderror
>>>>>>> d2a23ba
            </div>

            <div class="edit-form-group">
                <label for="name">Nom</label>
<<<<<<< HEAD
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required maxlength="255">
                @error('name')
                    <p class="field-error" role="alert">{{ $message }}</p>
                @enderror
=======
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required maxlength="255">
                @error('name') <p class="field-error">{{ $message }}</p> @enderror
>>>>>>> d2a23ba
            </div>

            <div class="edit-form-group">
                <label for="bio">Bio</label>
<<<<<<< HEAD
                <textarea name="bio" id="bio" rows="4" maxlength="500">{{ old('bio', $user->bio) }}</textarea>
                @error('bio')
                    <p class="field-error" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="edit-form-group">
                <label>Style préféré</label>
                <input type="hidden" name="style_prefere" id="style_prefere" value="{{ $currentStyle }}" data-style-hidden>
                <div class="style-chips" role="group" aria-label="Style préféré">
                    @foreach ($styles as $style)
                        <button
                            type="button"
                            class="style-chip {{ $currentStyle === $style ? 'active' : '' }}"
                            data-style-chip="{{ $style }}"
                        >{{ $style }}</button>
                    @endforeach
                </div>
                @error('style_prefere')
                    <p class="field-error" role="alert">{{ $message }}</p>
                @enderror
=======
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
>>>>>>> d2a23ba
            </div>

            <div class="edit-form-actions">
                <button type="submit" class="btn-filled">Enregistrer les modifications</button>
                <a class="btn-outline" href="{{ route('profile.show', $user) }}">Annuler</a>
            </div>
        </form>
<<<<<<< HEAD
    </div>

    <script>
        (function () {
            var input = document.querySelector('[data-photo-input]');
            var preview = document.querySelector('[data-photo-preview]');
            var fallback = document.querySelector('[data-photo-preview-fallback]');
            if (input && preview) {
                input.addEventListener('change', function () {
                    var file = input.files && input.files[0];
                    if (!file) return;
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.classList.remove('is-hidden');
                        if (fallback) fallback.classList.add('is-hidden');
                    };
                    reader.readAsDataURL(file);
                });
            }

            var hidden = document.querySelector('[data-style-hidden]');
            var chips = document.querySelectorAll('[data-style-chip]');
            chips.forEach(function (chip) {
                chip.addEventListener('click', function () {
                    var val = chip.getAttribute('data-style-chip');
                    chips.forEach(function (c) { c.classList.remove('active'); });
                    chip.classList.add('active');
                    if (hidden) hidden.value = val;
                });
            });
        })();
=======
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
>>>>>>> d2a23ba
    </script>
@endsection
