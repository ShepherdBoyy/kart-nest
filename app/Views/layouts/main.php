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
            <a href="<?= e($_ENV["APP_URL"]) ?>/" class="btn btn-ghost text-xl font-bold text-primary">
                KartNest
            </a>
        </div>

        <div class="flex items-center gap-2">
            <?php if (App\Core\Session::has("user_id")): ?>
                <span class="text-sm text-base-content/60 hidden sm:block">
                    Hello, <?= e(App\Core\Session::get("user_name")) ?>
                </span>

                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar avatar-placeholder">
                        <div class="bg-primary text-primary-content w-8 rounded-full">
                            <span class="text-sm">
                                <?= strtoupper(substr(App\Core\Session::get("user_name", "U"), 0, 1)) ?>
                            </span>
                        </div>
                    </div>
                    <ul
                        tabindex="0"
                        class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm"
                    >
                        <li class="menu-title">
                            <span><?= e(App\Core\Session::get("user_email")) ?></span>
                        </li>
                        <li>
                            <a href="<?= e($_ENV["APP_URL"]) ?>/profile">Profile</a>
                        </li>
                        <li>
                            <a href="<?= e($_ENV["APP_URL"]) ?>/orders">My Orders</a>
                        </li>
                        <li><hr class="my-1"></li>
                        <li>
                            <a
                                href="<?= e($_ENV["APP_URL"]) ?>/logout"
                                class="text-error"
                            >
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
                
            <?php else: ?>
                <a href="<?= e($_ENV["APP_URL"]) ?>/login" class="btn btn-ghost btn-md">
                    Sign in
                </a>
                <a href="<?= e($_ENV["APP_URL"]) ?>/register" class="btn btn-primary btn-md">
                    Get started
                </a>
            <?php endif; ?>
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