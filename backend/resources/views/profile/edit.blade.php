@extends('layouts.app')

@section('title', 'Modifier mon profil — Trendora')

@section('content')
    @php
        $styles = ['Streetwear', 'Chic', 'Casual', 'Vintage', 'Sportswear', 'Bohème'];
        $currentStyle = old('style_prefere', $user->style_prefere);
    @endphp

    <div class="edit-form">
        <h1 class="edit-form-title">Modifier mon profil</h1>

        <form method="POST" action="{{ route('profile.update', $user) }}" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')

            <div class="edit-form-group">
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
            </div>

            <div class="edit-form-group">
                <label for="name">Nom</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required maxlength="255">
                @error('name')
                    <p class="field-error" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="edit-form-group">
                <label for="bio">Bio</label>
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
            </div>

            <div class="edit-form-actions">
                <button type="submit" class="btn-filled">Enregistrer les modifications</button>
                <a class="btn-outline" href="{{ route('profile.show', $user) }}">Annuler</a>
            </div>
        </form>
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
    </script>
@endsection
