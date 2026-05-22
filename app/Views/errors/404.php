<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Page Not Found | KartNest</title>

    <link rel="stylesheet" href="/kart-nest/public/assets/css/app.css">
</head>

<body class="bg-base-200 min-h-screen overflow-hidden">
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute top-0 left-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl"></div>

        <div class="absolute bottom-0 right-0 w-96 h-96 bg-secondary/10 rounded-full blur-3xl"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-[460px]">
            <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                <div class="card-body items-center text-center p-8 sm:p-10">
                    <div class="text-8xl sm:text-9xl font-black tracking-tight text-primary/10 leading-none mb-2">
                        404
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight text-base-content">
                        Page Not Found
                    </h1>

                    <p class="text-sm leading-relaxed text-base-content/60 max-w-sm mt-2">
                        The page you are looking for may have been moved,
                        deleted, or never existed.
                    </p>

                    <?php if (!empty($debugMessage)): ?>

                        <div class="alert alert-warning text-left w-full mt-6 rounded-2xl shadow-sm">

                            <span class="text-xs font-mono break-all">
                                <?= htmlspecialchars($debugMessage) ?>
                            </span>

                        </div>

                    <?php endif; ?>

                    <!-- Actions -->
                    <div class="w-full mt-7">

                        <a
                            href="/kart-nest/public/"
                            class="btn btn-primary h-12 min-h-12 w-full rounded-xl text-sm font-semibold shadow-md hover:scale-[1.01] transition"
                        >
                            Back to Homepage
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>
</html>