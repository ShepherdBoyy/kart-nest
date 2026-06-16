<?php
function searchFilterUrl(array $overrides = []): string {
    $params = array_merge([
        "q" => $_GET["q"] ?? "",
        "category" => $_GET["category"] ?? "",
        "sort" => $_GET["sort"] ?? "",
        "page" => 1
    ], $overrides);

    $params = array_filter($params, fn($v) => $v !== "" && $v !== null);
    $base = rtrim($_ENV["APP_URL"], "/");
    return $base . "/search?" . http_build_query($params);
}
?>

<div>
    <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
        <div class="card-body p-5 md:p-7">
            <form action="<?= e($_ENV["APP_URL"]) ?>/search" method="GET" class="flex gap-3">
                <div class="relative flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400 z-10 pointer-events-none"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>

                    <input type="search" name="q" id="main-search" value="<?= e($query) ?>"
                        placeholder="Search for products, categories, brands..."
                        class="input input-bordered h-14 pl-12 rounded-2xl w-full text-sm focus:input-primary" />
                </div>

                <button type="submit"
                    class="btn btn-primary h-14 min-h-14 rounded-2xl px-8 font-black text-sm shadow-lg shadow-primary/25 hover:scale-[1.02] transition-transform">
                    Search
                </button>
            </form>

            <?php if (!empty($query)): ?>

                <div class="flex items-center gap-2">
                    <?php if ($total > 0): ?>
                        <span class="badge badge-primary badge-sm font-black">
                            <?= number_format($total) ?>
                        </span>

                        <p class="text-sm text-base-content/50">
                            result<?= $total !== 1 ? "s" : "" ?> for
                            <span class="font-semibold text-base-content">
                                "<?= e($query) ?>"
                            </span>
                        </p>

                        <?php if (!empty($category)): ?>
                            <span class="text-base-content/30">·</span>
                            <a href="<?= searchFilterUrl(["category" => ""]) ?>"
                                class="text-xs font-semibold text-primary hover:underline flex items-center gap-1">
                                <?= e($category) ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-x-icon lucide-x">
                                    <path d="M18 6 6 18" />
                                    <path d="m6 6 12 12" />
                                </svg>
                            </a>
                        <?php endif; ?>

                    <?php else: ?>
                        <p class="text-sm text-base-content/50">
                            No result for
                            <span class="font-semibold text-base-content">"<?= e($query) ?>"</span>
                        </p>
                    <?php endif; ?>
                </div>

            <?php endif; ?>
        </div>
    </div>

    <?php if (empty($query)): ?>

        <div>
            <div class="card-body items-center text-center py-20 gap-6">
                <div class="w-20 h-20 bg-primary/10 rounded-3xl flex items-center justify-center">
                    <span class="text-primary/60">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-search-icon lucide-search">
                            <path d="m21 21-4.34-4.34" />
                            <circle cx="11" cy="11" r="8" />
                        </svg>
                    </span>
                </div>

                <div>
                    <h2 class="text-2xl font-black tracking-tight">What are you looking for?</h2>
                    <p class="text-base-content/50 text-sm mt-1.5 max-w-sm mx-auto">
                        Search by product name, desription or browse by category below
                    </p>
                </div>

                <?php if (!empty($categories)): ?>

                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-base-content/30">
                            Browse categories
                        </p>

                        <div>
                            <?php foreach ($categories as $cat): ?>
                                <?php if ((int) $cat["product_count"] > 0): ?>
                                    
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                <?php endif; ?>
            </div>
        </div>

    <?php endif; ?>
</div>