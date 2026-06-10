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

                    <div class="dropdown dropdown-end">
                        <div
                            tabindex="0"
                            role="button"
                            class="btn btn-ghost btn-circle hover:bg-base-200 transition"
                        >
                            <div class="avatar avatar-placeholder">
                                <div class="bg-primary text-primary-content rounded-full w-10 shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-user-round-icon lucide-user-round">
                                        <circle cx="12" cy="8" r="5" />
                                        <path d="M20 21a8 8 0 0 0-16 0" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div
                            tabindex="0"
                            class="dropdown-content mt-3 w-64 bg-base-100 border border-base-300/60 shadow-xl rounded-3xl overflow-hidden"
                        >
                            <div class="flex items-center gap-3 px-4 py-4 border-b border-base-200">
                                <div class="avatar avatar-placeholder flex-shrink-0">
                                    <div class="bg-primary text-primary-content rounded-2xl w-11 h-11 shadow-md">
                                        <span class="text-sm font-black">
                                            <?= strtoupper(substr(App\Core\Session::get("user_name", "U"), 0, 1)) ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="min-w-0">
                                    <p class="font-black text-sm text-base-content leading-tight truncate">
                                        <?= e(App\Core\Session::get("user_name")) ?>
                                    </p>
                                    <p class="text-xs text-base-content/40 truncate mt-0.5">
                                        <?= e(App\Core\Session::get("user_email")) ?>
                                    </p>
                                </div>
                            </div>

                            <?php if (App\Core\Session::get("user_role") === "seller" || App\Core\Session::get("user_role") === "admin"): ?>

                                <div class="p-2">
                                    <p class="px-2 pt-1 pb-1.5 text-xs font-black uppercase tracking-widest text-base-content/30">
                                        <?= ucfirst(App\Core\Session::get("user_role")) ?>
                                    </p>

                                    <a href="<?= e($_ENV["APP_URL"]) ?>/seller/products"
                                        class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm font-semibold text-base-content hover:bg-primary/10 hover:text-primary transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                                            <rect width="7" height="9" x="3" y="3" rx="1" />
                                            <rect width="7" height="5" x="14" y="3" rx="1" />
                                            <rect width="7" height="9" x="14" y="12" rx="1" />
                                            <rect width="7" height="5" x="3" y="16" rx="1" />
                                        </svg>
                                        Dashboard
                                    </a>
                                </div>
                                <div class="divider my-0 mx-3 h-px"></div>

                            <?php endif; ?>

                            <div class="p-2">
                                <a href="<?= e($_ENV["APP_URL"]) ?>/profile"
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm font-semibold text-base-content hover:bg-gray-200 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-user-round-icon lucide-circle-user-round">
                                        <path d="M17.925 20.056a6 6 0 0 0-11.851.001" />
                                        <circle cx="12" cy="11" r="4" />
                                        <circle cx="12" cy="12" r="10" />
                                    </svg>
                                    Profile
                                </a>

                                <a href="<?= e($_ENV["APP_URL"]) ?>/orders"
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm font-semibold text-base-content hover:bg-gray-200 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-shopping-basket-icon lucide-shopping-basket">
                                        <path d="m15 11-1 9" />
                                        <path d="m19 11-4-7" />
                                        <path d="M2 11h20" />
                                        <path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8a2 2 0 0 0 2-1.6l1.7-7.4" />
                                        <path d="M4.5 15.5h15" />
                                        <path d="m5 11 4-7" />
                                        <path d="m9 11 1 9" />
                                    </svg>
                                    My Orders
                                </a>
                            </div>

                            <div class="divider my-0 mx-3 h-px"></div>

                            <div class="p-2">
                                <a href="<?= e($_ENV["APP_URL"]) ?>/logout"
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm font-semibold text-error hover:bg-error/10 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-log-out-icon lucide-log-out">
                                        <path d="m16 17 5-5-5-5" />
                                        <path d="M21 12H9" />
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    </svg>
                                    Logout
                                </a>
                            </div>
                        </div>
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