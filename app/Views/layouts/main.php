<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'KartNest') ?></title>
    <link rel="stylesheet" href="/kart-nest/public/assets/css/app.css">
</head>
<body class="bg-base-200 min-h-screen">

    <div class="navbar bg-base-100 shadow-sm px-4">
        <div class="flex-1">
            <a href="/kart-nest/public/" class="btn btn-ghost text-xl font-bold text-primary">
                KartNest
            </a>
        </div>
        <div class="flex-none">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                    <div class="indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="badge badge-sm indicator-item">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="min-h-[calc(100vh-4rem)] flex flex-col">

        <?php
            $flashMessages = App\Core\Session::getFlash();
        ?>

        <?php foreach ($flashMessages as $type => $messages): ?>
            <?php foreach ($messages as $message): ?>
                <?php
                $alertClass = match($type) {
                    'success' => 'alert-success',
                    'error'   => 'alert-error',
                    'warning' => 'alert-warning',
                    'info'    => 'alert-info',
                    default   => 'alert-info',
                };
                ?>
                <div class="alert <?= $alertClass ?> mb-4">
                    <span><?= htmlspecialchars($message) ?></span>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>

        <?= $content ?? '' ?>

    </main>

</body>
</html>