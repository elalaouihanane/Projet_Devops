@extends('layouts.auth')

@section('title', 'Inscription — Trendora')
@section('brand_title', 'Bienvenue sur Trendora.')
@section('brand_subtitle', 'Créez votre compte et commencez à partager vos looks.')

@section('content')
    <div class="auth-card" data-register>
        <header class="auth-card__head">
            <div>
                <p class="auth-eyebrow">Inscription</p>
                <h2 class="auth-title">Créer votre compte</h2>
            </div>

            <div class="auth-steps" aria-label="Étapes d'inscription">
                <button type="button" class="step is-active" data-step-nav="1" aria-current="step">
                    <span class="step__dot">1</span><span class="step__label">Compte</span>
                </button>
                <span class="step__sep" aria-hidden="true"></span>
                <button type="button" class="step" data-step-nav="2">
                    <span class="step__dot">2</span><span class="step__label">Profil</span>
                </button>
                <span class="step__sep" aria-hidden="true"></span>
                <button type="button" class="step" data-step-nav="3">
                    <span class="step__dot">3</span><span class="step__label">Confirmation</span>
                </button>
            </div>
        </header>

        <form class="auth-form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data" novalidate>
            @csrf

            <input type="hidden" name="name" value="{{ old('name') }}" data-fullname>
            <input type="hidden" name="style_prefere" value="{{ old('style_prefere') }}" data-style-hidden>

            @if ($errors->any())
                <div class="alert alert--error" role="alert">
                    <strong>Oups.</strong> Merci de corriger les champs en erreur.
                </div>
            @endif

            {{-- STEP 1 --}}
            <section class="step-panel is-active" data-step="1" aria-label="Étape 1 : Compte">
                <div class="grid-2">
                    <div class="field">
                        <label for="first_name">Prénom</label>
                        <input
                            id="first_name"
                            name="first_name"
                            type="text"
                            autocomplete="given-name"
                            value="{{ old('first_name') }}"
                            required
                            data-firstname
                        >
                    </div>

                    <div class="field">
                        <label for="last_name">Nom</label>
                        <input
                            id="last_name"
                            name="last_name"
                            type="text"
                            autocomplete="family-name"
                            value="{{ old('last_name') }}"
                            required
                            data-lastname
                        >
                    </div>
                </div>

                @error('name')
                    <p class="field-error" role="alert">{{ $message }}</p>
                @enderror

                <div class="field">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <p class="field-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label for="password">Mot de passe</label>
                        <div class="input-with-action">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                required
                                minlength="8"
                                data-password
                            >
                            <button class="input-action" type="button" data-toggle-password aria-label="Afficher le mot de passe">
                                Afficher
                            </button>
                        </div>

                        <div class="pw-meter" aria-label="Force du mot de passe" aria-live="polite">
                            <div class="pw-meter__bar"><span class="pw-meter__fill" data-pw-fill></span></div>
                            <p class="pw-meter__text" data-pw-text>Force : —</p>
                        </div>

                        @error('password')
                            <p class="field-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Confirmation</label>
                        <div class="input-with-action">
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                required
                                minlength="8"
                                data-password-confirm
                            >
                            <button class="input-action" type="button" data-toggle-password-confirm aria-label="Afficher la confirmation">
                                Afficher
                            </button>
                        </div>
                    </div>
                </div>

                <div class="step-actions">
                    <span class="step-hint">Déjà un compte ? <a class="link" href="{{ url('/login') }}">Se connecter</a></span>
                    <button type="button" class="btn btn--primary" data-next>Continuer</button>
                </div>
            </section>

            {{-- STEP 2 --}}
            <section class="step-panel" data-step="2" aria-label="Étape 2 : Profil">
                <div class="field">
                    <label for="photo">Photo de profil (optionnel)</label>
                    <div class="file">
                        <input id="photo" name="photo" type="file" accept="image/*" data-photo>
                        <div class="file__meta">
                            <p class="file__name" data-photo-name>Aucun fichier sélectionné</p>
                            <p class="file__hint">Formats image, taille recommandée \( &lt; 2MB \).</p>
                        </div>
                    </div>
                    @error('photo')
                        <p class="field-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label for="bio">Bio courte (optionnel)</label>
                    <textarea id="bio" name="bio" rows="3" maxlength="280" placeholder="Quelques mots sur votre univers..." data-bio>{{ old('bio') }}</textarea>
                    @error('bio')
                        <p class="field-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label>Style préféré</label>
                    <div class="chips" role="listbox" aria-label="Choisir un style préféré">
                        @php
                            $styles = ['Streetwear', 'Chic', 'Casual', 'Vintage', 'Sportswear', 'Bohème'];
                            $oldStyle = old('style_prefere');
                        @endphp
                        @foreach ($styles as $style)
                            <button
                                type="button"
                                class="chip {{ $oldStyle === $style ? 'is-selected' : '' }}"
                                data-style="{{ $style }}"
                                aria-pressed="{{ $oldStyle === $style ? 'true' : 'false' }}"
                            >
                                {{ $style }}
                            </button>
                        @endforeach
                    </div>
                    @error('style_prefere')
                        <p class="field-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="step-actions">
                    <button type="button" class="btn btn--ghost" data-prev>Retour</button>
                    <button type="button" class="btn btn--primary" data-next>Continuer</button>
                </div>
            </section>

            {{-- STEP 3 --}}
            <section class="step-panel" data-step="3" aria-label="Étape 3 : Confirmation">
                <div class="recap">
                    <h3 class="recap__title">Récapitulatif</h3>
                    <div class="recap__grid">
                        <div class="recap__row">
                            <span class="recap__k">Nom</span>
                            <span class="recap__v" data-recap-name>—</span>
                        </div>
                        <div class="recap__row">
                            <span class="recap__k">Email</span>
                            <span class="recap__v" data-recap-email>—</span>
                        </div>
                        <div class="recap__row">
                            <span class="recap__k">Style</span>
                            <span class="recap__v" data-recap-style>—</span>
                        </div>
                        <div class="recap__row">
                            <span class="recap__k">Bio</span>
                            <span class="recap__v recap__v--muted" data-recap-bio>—</span>
                        </div>
                    </div>
                </div>

                <div class="field field--check">
                    <label class="check">
                        <input type="checkbox" name="cgu" value="1" required data-cgu>
                        <span>J’accepte les <a class="link" href="#" onclick="return false;">CGU</a>.</span>
                    </label>
                    <p class="field-error is-hidden" data-cgu-error role="alert">Merci d’accepter les CGU.</p>
                </div>

                <div class="step-actions">
                    <button type="button" class="btn btn--ghost" data-prev>Retour</button>
                    <button type="submit" class="btn btn--primary">Créer mon compte</button>
                </div>
            </section>
        </form>
    </div>

    <script>
        (function () {
            const root = document.querySelector('[data-register]');
            if (!root) return;

            const form = root.querySelector('form');
            const panels = Array.from(root.querySelectorAll('[data-step]'));
            const nav = Array.from(root.querySelectorAll('[data-step-nav]'));

            const firstName = root.querySelector('[data-firstname]');
            const lastName = root.querySelector('[data-lastname]');
            const fullNameHidden = root.querySelector('[data-fullname]');
            const email = root.querySelector('#email');

            const password = root.querySelector('[data-password]');
            const passwordConfirm = root.querySelector('[data-password-confirm]');
            const pwFill = root.querySelector('[data-pw-fill]');
            const pwText = root.querySelector('[data-pw-text]');

            const styleHidden = root.querySelector('[data-style-hidden]');
            const chips = Array.from(root.querySelectorAll('[data-style]'));

            const photo = root.querySelector('[data-photo]');
            const photoName = root.querySelector('[data-photo-name]');

            const bio = root.querySelector('[data-bio]');

            const recapName = root.querySelector('[data-recap-name]');
            const recapEmail = root.querySelector('[data-recap-email]');
            const recapStyle = root.querySelector('[data-recap-style]');
            const recapBio = root.querySelector('[data-recap-bio]');

            const cgu = root.querySelector('[data-cgu]');
            const cguError = root.querySelector('[data-cgu-error]');

            let currentStep = 1;

            function setStep(step) {
                currentStep = Math.max(1, Math.min(3, step));
                panels.forEach(p => p.classList.toggle('is-active', Number(p.dataset.step) === currentStep));
                nav.forEach(n => {
                    const s = Number(n.dataset.stepNav);
                    n.classList.toggle('is-active', s === currentStep);
                    if (s === currentStep) n.setAttribute('aria-current', 'step');
                    else n.removeAttribute('aria-current');
                });
                if (currentStep === 3) hydrateRecap();
                root.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            function hydrateFullName() {
                const fn = (firstName?.value || '').trim();
                const ln = (lastName?.value || '').trim();
                const v = [fn, ln].filter(Boolean).join(' ').trim();
                if (fullNameHidden) fullNameHidden.value = v;
                return v;
            }

            function scorePassword(v) {
                let s = 0;
                if (v.length >= 8) s += 1;
                if (v.length >= 12) s += 1;
                if (/[a-z]/.test(v) && /[A-Z]/.test(v)) s += 1;
                if (/\d/.test(v)) s += 1;
                if (/[^A-Za-z0-9]/.test(v)) s += 1;
                return Math.min(5, s);
            }

            function renderPasswordStrength() {
                const v = password?.value || '';
                const s = scorePassword(v);
                const pct = (s / 5) * 100;
                if (pwFill) pwFill.style.width = pct + '%';
                if (pwFill) pwFill.dataset.level = String(s);

                let label = '—';
                if (v.length === 0) label = '—';
                else if (s <= 1) label = 'Faible';
                else if (s === 2) label = 'Moyen';
                else if (s === 3) label = 'Bien';
                else label = 'Fort';

                if (pwText) pwText.textContent = 'Force : ' + label;
            }

            function selectStyle(style) {
                styleHidden.value = style || '';
                chips.forEach(c => {
                    const isSelected = c.dataset.style === style;
                    c.classList.toggle('is-selected', isSelected);
                    c.setAttribute('aria-pressed', isSelected ? 'true' : 'false');
                });
            }

            function hydrateRecap() {
                const name = hydrateFullName() || fullNameHidden.value || '—';
                recapName.textContent = name || '—';
                recapEmail.textContent = (email?.value || '').trim() || '—';
                recapStyle.textContent = (styleHidden?.value || '').trim() || '—';

                const b = (bio?.value || '').trim();
                recapBio.textContent = b ? (b.length > 120 ? (b.slice(0, 120) + '…') : b) : '—';
                recapBio.classList.toggle('recap__v--muted', !b);
            }

            function validateStep1() {
                const name = hydrateFullName();
                const mail = (email?.value || '').trim();
                const pw = password?.value || '';
                const pwc = passwordConfirm?.value || '';

                const okName = name.length > 1;
                const okMail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(mail);
                const okPw = pw.length >= 8;
                const okPwc = pwc.length >= 8 && pw === pwc;

                [firstName, lastName, email, password, passwordConfirm].forEach((el) => {
                    if (!el) return;
                    el.classList.remove('is-invalid');
                });

                if (!okName) { if (firstName) firstName.classList.add('is-invalid'); if (lastName) lastName.classList.add('is-invalid'); }
                if (!okMail) { if (email) email.classList.add('is-invalid'); }
                if (!okPw) { if (password) password.classList.add('is-invalid'); }
                if (!okPwc) { if (passwordConfirm) passwordConfirm.classList.add('is-invalid'); }

                return okName && okMail && okPw && okPwc;
            }

            function validateCgu() {
                if (!cgu) return true;
                const ok = !!cgu.checked;
                if (!ok) cguError?.classList.remove('is-hidden');
                else cguError?.classList.add('is-hidden');
                return ok;
            }

            // Step nav
            root.addEventListener('click', (e) => {
                const next = e.target.closest('[data-next]');
                const prev = e.target.closest('[data-prev]');
                const navBtn = e.target.closest('[data-step-nav]');
                if (next) {
                    if (currentStep === 1 && !validateStep1()) return;
                    setStep(currentStep + 1);
                } else if (prev) {
                    setStep(currentStep - 1);
                } else if (navBtn) {
                    const target = Number(navBtn.dataset.stepNav);
                    if (target > currentStep) {
                        if (currentStep === 1 && !validateStep1()) return;
                    }
                    setStep(target);
                }
            });

            // Password toggles + strength
            root.querySelector('[data-toggle-password]')?.addEventListener('click', () => {
                const isPw = password.type === 'password';
                password.type = isPw ? 'text' : 'password';
            });
            root.querySelector('[data-toggle-password-confirm]')?.addEventListener('click', () => {
                const isPw = passwordConfirm.type === 'password';
                passwordConfirm.type = isPw ? 'text' : 'password';
            });

            password?.addEventListener('input', renderPasswordStrength);
            renderPasswordStrength();

            // Full name hydration
            firstName?.addEventListener('input', hydrateFullName);
            lastName?.addEventListener('input', hydrateFullName);
            hydrateFullName();

            // Photo label
            photo?.addEventListener('change', () => {
                const f = photo.files && photo.files[0];
                if (photoName) photoName.textContent = f ? f.name : 'Aucun fichier sélectionné';
            });

            // Style chips
            chips.forEach((chip) => {
                chip.addEventListener('click', () => {
                    const style = chip.dataset.style || '';
                    selectStyle(styleHidden.value === style ? '' : style);
                });
            });
            if (styleHidden?.value) selectStyle(styleHidden.value);

            // Submit (CGU)
            form.addEventListener('submit', (e) => {
                hydrateFullName();
                if (!validateCgu()) {
                    e.preventDefault();
                    setStep(3);
                }
            });

            // If server-side validation errors exist, attempt to go to the most relevant step
            const hasErrors = root.querySelector('.alert--error');
            if (hasErrors) {
                const step2Keys = ['photo', 'bio', 'style_prefere'];
                const step2HasError = step2Keys.some((k) => root.querySelector(`[name="${k}"]`)?.classList.contains('is-invalid'));
                setStep(step2HasError ? 2 : 1);
            } else {
                setStep(1);
            }
        })();
    </script>
@endsection
