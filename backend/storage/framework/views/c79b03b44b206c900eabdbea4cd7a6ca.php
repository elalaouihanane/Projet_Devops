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
<body>
    <div class="app-shell">
        <header class="app-topbar">
            <a class="brand" href="<?php echo e(route('feed')); ?>" aria-label="Trendora - Feed">
                <span class="brand__mark" aria-hidden="true"></span>
                <span class="brand__name">Trendora</span>
            </a>

            <div class="app-topbar__right">
                <?php if(auth()->guard()->check()): ?>
                    <span class="app-user"><?php echo e(auth()->user()->name); ?></span>
                    <form method="POST" action="<?php echo e(url('/logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="btn btn--ghost" type="submit">Se déconnecter</button>
                    </form>
                <?php endif; ?>
            </div>
        </header>

        <main class="app-main">
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

<?php /**PATH /var/www/resources/views/layouts/app.blade.php ENDPATH**/ ?>