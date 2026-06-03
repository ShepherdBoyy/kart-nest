<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'KartNest') ?></title>
    <link rel="stylesheet" href="/kart-nest/public/assets/css/app.css">
</head>

<body class="bg-base-200 text-base-content min-h-screen">
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl"></div>
    </div>

    <header class="sticky top-0 z-50 backdrop-blur border-b border-base-300/60 bg-base-100/80">
        <div class="navbar max-w-7xl mx-auto px-4 lg:px-8 min-h-20">
            <div class="flex-1">
                <a href="<?= e($_ENV["APP_URL"]) ?>/" class="flex items-center gap-3 group">
                    <div
                        class="w-10 h-10 bg-primary rounded-2xl text-primary-content flex items-center justify-center shadow-md group-hover:scale-105 transition">
                        <span class="font-black text-lg">K</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-black tracking-tight leading-none">KartNest</h1>
                        <p class="text-xs text-base-content/50 leading-none mt-1">Shop Smart, Shop Nest</p>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-3">

                <?php if (App\Core\Session::has("user_id")): ?>

                    <div class="hidden md:flex flex-col text-right mr-1">
                        <span class="text-sm font-medium">
                            <?= e(App\Core\Session::get("user_name")) ?>
                        </span>
                        <span class="text-xs text-base-content/50">
                            Welcome back
                        </span>
                    </div>

                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle hover:bg-base-200 transition">
                            <div class="avatar avatar-placeholder">
                                <div class="bg-primary text-primary-content rounded-full w-10 shadow">
                                    <span class="text-sm font-bold">
                                        <?= strtoupper(substr(App\Core\Session::get("user_name", "U"), 0, 1)) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <ul tabindex="0"
                            class="dropdown-content menu mt-3 p-2 shadow-xl bg-base-100 rounded-2xl border-base-300 w-64">
                            <li class="px-3 py-2 pointer-events-none">
                                <div class="flex flex-col gap-1">
                                    <span class="font-semibold text-sm">
                                        <?= e(App\Core\Session::get("user_name")) ?>
                                    </span>
                                    <span class="text-xs text-base-content/50 break-all">
                                        <?= e(App\Core\Session::get("user_email")) ?>
                                    </span>
                                </div>
                            </li>

                            <div class="divider my-1"></div>

                            <li>
                                <a href="<?= e($_ENV["APP_URL"]) ?>/profile" class="rounded-xl">
                                    Profile
                                </a>
                            </li>
                            <li>
                                <a href="<?= e($_ENV["APP_URL"]) ?>/orders" class="rounded-xl">My Orders</a>
                            </li>

                            <div class="divider my-1"></div>

                            <li>
                                <a
                                    href="<?= e($_ENV["APP_URL"]) ?>/logout"
                                    class="text-error rounded-xl hover:bg-error hover:text-error-content"
                                >
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>

                <?php else: ?>

                    <a
                        href="<?= e($_ENV["APP_URL"]) ?>/login"
                        class="btn btn-ghost rounded-xl px-5"
                    >
                        Sign in
                    </a>
                    <a
                        href="<?= e($_ENV["APP_URL"]) ?>/register"
                        class="btn btn-primary rounded-xl px-5 shadow-lg shadow-primary/20 hover:scale-[1.02] transition"
                    >
                        Get started
                    </a>
                <?php endif; ?>
            </div>
        </div>

    </header>

    <main class="">

        <?php $flashMessages = App\Core\Session::getFlash(); ?>

        <?php if (!empty($flashMessages)): ?>

            <div class="max-w-7xl mx-auto px-4 lg:px-8 pt-6 space-y-3">

                <?php foreach ($flashMessages as $type => $messages): ?>
                    <?php foreach ($messages as $message): ?>
                        <?php
                            $alertClass = match ($type) {
                                'success' => 'alert-success',
                                'error' => 'alert-error',
                                'warning' => 'alert-warning',
                                'info' => 'alert-info',
                                default => 'alert-info',
                            };
                        ?>

                        <div class="alert <?= $alertClass ?> shadow-lg rounded-2xl">
                            <span><?= htmlspecialchars($message) ?></span>
                        </div>

                    <?php endforeach; ?>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>

        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-8">
            <?= $content ?? '' ?>
        </div>

    </main>

</body>

</html>