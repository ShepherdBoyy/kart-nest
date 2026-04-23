<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Page Not Found | KartNest</title>
    <link rel="stylesheet" href="/kart-nest/public/assets/css/app.css">
</head>
<body class="bg-base-200 min-h-screen flex items-center justify-center">

    <div class="card bg-base-100 shadow-md w-full max-w-md">
        <div class="card-body items-center text-center gap-4">

            <div class="text-8xl font-bold text-primary opacity-20">
                404
            </div>

            <h1 class="card-title text-2xl">Page Not Found</h1>

            <p class="text-base-content/70">
                The page you are looking for does not exist
                or has been moved.
            </p>

            <?php if (!empty($debugMessage)): ?>
                <div class="alert alert-warning text-left w-full">
                    <span class="text-sm font-mono"><?= htmlspecialchars($debugMessage) ?></span>
                </div>
            <?php endif; ?>

            <div class="card-actions">
                <a href="/kart-nest/public/" class="btn btn-primary">
                    Go Home
                </a>
            </div>

        </div>
    </div>

</body>
</html>