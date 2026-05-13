<div class="card bg-base-100 shadow-md max-w-md mx-auto">
    <div class="card-body items-center text-center gap-4">

        <h1 class="card-title text-3xl text-primary">
            <?= e($message ?? '') ?>
        </h1>
        <p class="text-base-content/70">
            KartNest MVC is fully operational.
        </p>

        <div class="text-left w-full">
            <p class="text-sm text-base-content/50 mb-2">
                CSRF token for this session:
            </p>
            <code class="text-xs bg-base-200 p-2 rounded block break-all">
                <?= e(App\Core\Session::generateCsrfToken()) ?>
            </code>
        </div>

        <div class="card-actions mt-2">
            <a href="/kart-nest/public/" class="btn btn-primary">
                Refresh page
            </a>
        </div>

    </div>
</div>