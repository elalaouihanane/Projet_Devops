@extends('layouts.app')

@section('title', 'Éditer un article — Trendora')

@section('content')
    <div class="feed-head">
        <div>
            <p class="auth-eyebrow">Trendora</p>
            <h1 class="feed-title">Éditer un article</h1>
            <p class="feed-subtitle">Mettez à jour votre publication.</p>
        </div>
    </div>

    <div class="feed-card">
        <form method="POST" action="{{ url('/articles/' . $article->id) }}" enctype="multipart/form-data" class="auth-form" style="padding: 0;">
            @csrf
            @method('PUT')

            <div class="grid-2">
                <div class="field">
                    <label for="title">Titre</label>
                    <input id="title" type="text" name="title" value="{{ old('title', $article->title) }}" class="@error('title') is-invalid @enderror" required>
                    @error('title')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label for="type">Type</label>
                    <select id="type" name="type" class="@error('type') is-invalid @enderror" style="width:100%; padding:12px 12px; border-radius:14px; border:1px solid rgba(10,10,10,.14); background: rgba(245,240,232,.92);">
                        <option value="outfit" @selected(old('type', $article->type) === 'outfit')>Outfit</option>
                        <option value="clothing" @selected(old('type', $article->type) === 'clothing')>Clothing</option>
                    </select>
                    @error('type')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="field">
                <label for="category_id">Catégorie</label>
                <select id="category_id" name="category_id" class="@error('category_id') is-invalid @enderror" style="width:100%; padding:12px 12px; border-radius:14px; border:1px solid rgba(10,10,10,.14); background: rgba(245,240,232,.92);">
                    <option value="">— Aucune —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string)old('category_id', $article->category_id) === (string)$category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="@error('description') is-invalid @enderror" maxlength="2000">{{ old('description', $article->description) }}</textarea>
                @error('description')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid-2">
                <div class="field">
                    <label for="occasion">Occasion</label>
                    <input id="occasion" type="text" name="occasion" value="{{ old('occasion', $article->occasion) }}" class="@error('occasion') is-invalid @enderror" maxlength="100">
                    @error('occasion')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label for="color">Couleur</label>
                    <input id="color" type="text" name="color" value="{{ old('color', $article->color) }}" class="@error('color') is-invalid @enderror" maxlength="50">
                    @error('color')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="field">
                <label>Image actuelle</label>
                <div style="display:flex; gap: 12px; align-items:flex-start; flex-wrap: wrap;">
                    <img
                        src="{{ $article->publicImageUrl() }}"
                        alt="{{ $article->title }}"
                        style="width: 260px; max-width: 100%; height: 160px; object-fit: cover; border-radius: 14px; border:1px solid rgba(10,10,10,.10);"
                        onerror="this.onerror=null;this.src={{ \Illuminate\Support\Js::from(\App\Models\Article::placeholderImageUrl()) }}"
                    >
                    <div style="min-width: 220px;">
                        <p class="file__name" style="margin-top: 0;">Remplacer l’image</p>
                        <p class="file__hint">Laisser vide pour conserver l’image actuelle.</p>
                    </div>
                </div>
            </div>

            <div class="field">
                <label>Nouvelle image (optionnel)</label>
                <div class="file">
                    <div>
                        <input id="image" type="file" name="image" accept="image/*" class="@error('image') is-invalid @enderror">
                        @error('image')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="file__meta">
                        <p class="file__name" id="imageName">Aucun fichier sélectionné</p>
                        <p class="file__hint">Max 4 Mo. JPG/PNG/WebP.</p>
                    </div>

                    <div id="imagePreviewWrap" class="is-hidden" style="width: 220px;">
                        <img id="imagePreview" alt="Aperçu" style="width:100%; height: 140px; object-fit: cover; border-radius: 14px; border:1px solid rgba(10,10,10,.10);">
                    </div>
                </div>
            </div>

            <div class="field">
                <label for="tagInput">Tags</label>

                <div class="input-with-action">
                    <input id="tagInput" type="text" placeholder="Ex: streetwear, chic, vintage..." autocomplete="off">
                    <button class="input-action" type="button" id="addTagBtn">Ajouter</button>
                </div>

                @error('tags')
                    <p class="field-error">{{ $message }}</p>
                @enderror
                @error('tags.*')
                    <p class="field-error">{{ $message }}</p>
                @enderror

                <div id="tagsChips" class="chips" style="margin-top: 10px;"></div>
                <div id="tagsHidden"></div>
            </div>

            <div class="field field--check">
                <label class="check">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $article->is_published))>
                    <span>
                        <strong>Publié</strong><br>
                        <span style="color: rgba(10,10,10,.70);">Décochez pour passer en brouillon.</span>
                    </span>
                </label>
                @error('is_published')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="step-actions">
                <a class="btn btn--ghost" href="{{ url('/articles/' . $article->id) }}">Annuler</a>
                <button class="btn btn--primary" type="submit">Enregistrer</button>
            </div>
        </form>
    </div>

    <script>
        (function () {
            const imageInput = document.getElementById('image');
            const imageName = document.getElementById('imageName');
            const previewWrap = document.getElementById('imagePreviewWrap');
            const previewImg = document.getElementById('imagePreview');

            imageInput?.addEventListener('change', function () {
                const file = this.files && this.files[0];
                if (!file) {
                    imageName.textContent = 'Aucun fichier sélectionné';
                    previewWrap.classList.add('is-hidden');
                    previewImg.removeAttribute('src');
                    return;
                }
                imageName.textContent = file.name;
                previewWrap.classList.remove('is-hidden');
                previewImg.src = URL.createObjectURL(file);
            });

            const initialTags = @json(old('tags', $article->tags ?? []));
            const tags = new Set(Array.isArray(initialTags) ? initialTags : []);
            const tagInput = document.getElementById('tagInput');
            const addTagBtn = document.getElementById('addTagBtn');
            const chipsWrap = document.getElementById('tagsChips');
            const hiddenWrap = document.getElementById('tagsHidden');

            function normalizeTag(v) {
                return (v || '').trim().replace(/\s+/g, ' ');
            }

            function renderTags() {
                chipsWrap.innerHTML = '';
                hiddenWrap.innerHTML = '';

                Array.from(tags).forEach((t) => {
                    const chip = document.createElement('button');
                    chip.type = 'button';
                    chip.className = 'chip is-selected';
                    chip.textContent = t + ' ×';
                    chip.addEventListener('click', () => {
                        tags.delete(t);
                        renderTags();
                    });
                    chipsWrap.appendChild(chip);

                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'tags[]';
                    hidden.value = t;
                    hiddenWrap.appendChild(hidden);
                });
            }

            function addTag() {
                const t = normalizeTag(tagInput.value);
                if (!t) return;
                tags.add(t.slice(0, 50));
                tagInput.value = '';
                renderTags();
            }

            addTagBtn?.addEventListener('click', addTag);
            tagInput?.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addTag();
                }
            });

            renderTags();
        })();
    </script>
@endsection

