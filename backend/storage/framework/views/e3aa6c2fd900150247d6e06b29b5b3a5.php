<?php $__env->startSection('title', 'Connexion — Trendora'); ?>
<?php $__env->startSection('brand_title', 'Ravie de vous revoir.'); ?>
<?php $__env->startSection('brand_subtitle', 'Connectez-vous pour retrouver votre feed et vos favoris.'); ?>

<?php $__env->startSection('content'); ?>
    <div class="auth-card" data-login>
        <header class="auth-card__head">
            <div>
                <p class="auth-eyebrow">Connexion</p>
                <h2 class="auth-title">Se connecter</h2>
            </div>
            <div class="auth-steps" aria-label="Accès rapide">
                <a class="step is-active" href="<?php echo e(url('/login')); ?>">
                    <span class="step__dot">↩</span><span class="step__label">Accès</span>
                </a>
            </div>
        </header>

        <form class="auth-form" method="POST" action="<?php echo e(route('login')); ?>" novalidate>
            <?php echo csrf_field(); ?>

            <?php if($errors->any()): ?>
                <div class="alert alert--error" role="alert">
                    <strong>Oups.</strong> Vérifie tes identifiants.
                </div>
            <?php endif; ?>

            <div class="field">
                <label for="email">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    value="<?php echo e(old('email')); ?>"
                    required
                >
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="field-error" role="alert"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="field">
                <label for="password">Mot de passe</label>
                <div class="input-with-action">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        data-password
                    >
                    <button class="input-action" type="button" data-toggle-password aria-label="Afficher le mot de passe">
                        Afficher
                    </button>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="field-error" role="alert"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="field field--check">
                <label class="check">
                    <input type="checkbox" name="remember" value="1" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                    <span>Rester connecté(e)</span>
                </label>
            </div>

            <div class="step-actions">
                <span class="step-hint">Pas encore de compte ? <a class="link" href="<?php echo e(url('/register')); ?>">Créer un compte</a></span>
                <button type="submit" class="btn btn--primary">Connexion</button>
            </div>
        </form>
    </div>

    <script>
        (function () {
            const root = document.querySelector('[data-login]');
            if (!root) return;
            const password = root.querySelector('[data-password]');
            root.querySelector('[data-toggle-password]')?.addEventListener('click', () => {
                const isPw = password.type === 'password';
                password.type = isPw ? 'text' : 'password';
            });
        })();
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/auth/login.blade.php ENDPATH**/ ?>