<?php

use App\Core\Session;
?>
<div class="card bg-base-100 shadow-md max-w-md mx-auto">
    <div class="card-body items-center text-center">
        <h1 class="card-title text-3xl text-primary">
            <?= e($message) ?>
        </h1>
        
        <p class="text-base-content/70">
            Your KartNest MVC framework is working correctly.
        </p>

        <div class="text-left w-full">
            <p class="text-sm text-base-content/50 mb-2">
                CSRF token generated for this session:
            </p>
            <code class="text-xs bg-base-200 p-2 rounded block break-all">
                <?= e(Session::generateCsrfToken()) ?>
            </code>
        </div>

        <div>
            <a href="/kart-nest/public/" class="btn btn-primary">Refresh page</a>
        </div>
    </div>
</div>