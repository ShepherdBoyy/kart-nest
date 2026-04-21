<div class="card bg-base-100 shadow-md max-w-md mx-auto">
    <div class="card-body items-center text-center">
        <h1 class="card-title text-3xl text-primary">
            <?= htmlspecialchars($message) ?>
        </h1>
        
        <p class="text-base-content/70">
            Your KartNest MVC framework is working correctly.
        </p>

        <div class="badge badge-success gap-2 mt-2">
            <?= htmlspecialchars($dbTest) ?>
        </div>

        <div class="card-actions mt-4">
            <button class="btn btn-primary">Get Started</button>
        </div>
    </div>
</div>