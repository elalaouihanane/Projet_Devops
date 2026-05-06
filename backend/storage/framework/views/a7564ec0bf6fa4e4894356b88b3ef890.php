<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Trendora'); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <?php if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'))): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <?php endif; ?>
</head>
<body class="auth-page">
    <div class="auth-shell">
        <aside class="auth-brand">
            <div class="auth-brand__inner">
                <a class="brand" href="<?php echo e(url('/')); ?>" aria-label="Aller à l'accueil Trendora">
                    <span class="brand__mark" aria-hidden="true"></span>
                    <span class="brand__name">Trendora</span>
                </a>

                <h1 class="auth-brand__title"><?php echo $__env->yieldContent('brand_title', 'Partagez votre style. Inspirez les autres.'); ?></h1>
                <p class="auth-brand__subtitle"><?php echo $__env->yieldContent('brand_subtitle', 'Une plateforme mode élégante et minimaliste, pensée pour vos looks et vos pièces préférées.'); ?></p>

                <p class="auth-brand__foot">© <?php echo e(date('Y')); ?> Trendora</p>
            </div>
        </aside>

        <main class="auth-main">
            <?php if(session('success')): ?>
                <div class="flash flash--success" role="status"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="flash flash--error" role="alert"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</body>
</html>
<?php /**PATH /var/www/resources/views/layouts/auth.blade.php ENDPATH**/ ?>