<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Server Error | KartNest</title>
    <link rel="stylesheet" href="/kart-nest/public/assets/css/app.css">
</head>
<body class="bg-base-200 min-h-screen flex items-center justify-center">

    <div class="card bg-base-100 shadow-md w-full max-w-md">
        <div class="card-body items-center text-center gap-4">

            <div class="text-8xl font-bold text-error opacity-20">
                500
            </div>

            <h1 class="card-title text-2xl">Something Went Wrong</h1>

            <p class="text-base-content/70">
                We are experiencing a technical issue.
                Please try again in a moment.
            </p>

            <?php if (!empty($debugMessage)): ?>
                <div class="alert alert-error text-left w-full">
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