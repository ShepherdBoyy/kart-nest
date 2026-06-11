<?php

/** @var string $title */
/** @var array $products */
/** @var App\Core\Paginator $paginator */
/** @var array $categories */
/** @var array $filters */
/** @var string $search */
/** @var string $sort */

?>

<div class="flex flex-col gap-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-base-content">
                <?php if (!empty($filters["category"])): ?>
                    <?= e(ucfirst($filters["category"])) ?>
                <?php else: ?>
                    All Products
                <?php endif; ?>
            </h1>

            <?php if (!empty($filters["search"])): ?>
                <p class="text-base-content/50 text-sm mt-1">
                    Results for <strong class="text-base-content"><?= e($filters["search"]) ?></strong>
                </p>
            <?php else: ?>
                <p class="text-base-content/50 text-sm mt-1">
                    <?= number_format($paginator->total()) ?> items available
                </p>
            <?php endif; ?>
        </div>

        <form action="<?= e($_ENV["APP_URL"]) ?>/products" method="GET" class="flex gap-2 w-full sm:w-auto">
            <?php if (!empty($filters["category"])): ?>
                <input type="hidden" name="category" value="<?= e($filters["category"]) ?>" />
            <?php endif; ?>

            <?php if (!empty($filters["sort"]) && $filters["sort"] !== "newest"): ?>
                <input type="hidden" name="sort" value="<?= e($filters["sort"]) ?>" />
            <?php endif; ?>

            <div class="relative flex-1 sm:w-72">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 z-10 pointer-events-none">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </svg>

                <input type="search" name="search" placeholder="Search products..."
                    class="input input-bordered h-11 pl-10 rounded-xl w-full text-sm" />
            </div>
        </form>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <aside class="w-full lg:w-64 flex-shrink-0 flex flex-col gap-4">
            <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                <div class="card-body p-5">
                    <h2 class="text-xs font-black uppercase tracking-widest text-base-content/40 mb-3">
                        Categories
                    </h2>

                    <ul class="flex flex-col gap-1">
                        <li>
                            <a href="<?= filterUrl(["category" => ""]) ?>" class="flex items-center px-3 py-2 rounded-xl text-sm font-medium transition
                                    <?= empty($filters["category"])
                                        ? "bg-primary text-primary-content shadow-sm"
                                        : "hover:bg-base-200 text-base-content/70 hover:text-base-content" ?>">
                                All Categories
                            </a>
                        </li>

                        <?php foreach ($categories as $cat): ?>
                            <li>
                                <a href="<?= filterUrl(["category" => $cat["slug"]]) ?>" class="flex items-center justify-between px-3 py-2 rounded-xl text-sm font-medium transition
                                        <?= $filters["category"] === $cat["slug"]
                                            ? "bg-primary text-primary-content shadow-sm"
                                            : "hover:bg-base-200 text-base-content/70 hover:text-base-content" ?>">
                                    <span><?= e($cat["name"]) ?></span>
                                    <span class="badge badge-sm <?= $filters["category"] === $cat["slug"]
                                        ? "bg-primary-content/20 text-primary-content border-0"
                                        : "badge-ghost" ?>">
                                        <?= (int) $cat["product_count"] ?>
                                    </span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                <div class="card-body p-5">
                    <h2 class="text-xs font-black uppercase tracking-widest text-base-content/40 mb-3">
                        Price Range
                    </h2>

                    <form action="<?= e($_ENV["APP_URL"]) ?>/products" method="GET" class="flex flex-col gap-3">
                        <?php if (!empty($filters["search"])): ?>
                            <input type="hidden" name="search" value="<?= e($filters["search"]) ?>" />
                        <?php endif; ?>

                        <?php if (!empty($filters["category"])): ?>
                            <input type="hidden" name="category" value="<?= e($filters["category"]) ?>" />
                        <?php endif; ?>

                        <?php if (!empty($filters["sort"])): ?>
                            <input type="hidden" name="sort" value="<?= e($filters["sort"]) ?>" />
                        <?php endif; ?>

                        <div class="flex gap-2">
                            <div class="form-control flex-1">
                                <label class="label py-0 pb-1">
                                    <span class="label-text text-xs font-semibold">Min (₱)</span>
                                </label>
                                <input
                                    type="number"
                                    name="min_price"
                                    class="input input-bordered input-sm h-10 rounded-xl w-full text-sm focus:input-primary"
                                    placeholder="Type here..."
                                />
                            </div>

                            <div class="form-control flex-1">
                                <label class="label py-0 pb-1">
                                    <span class="label-text text-xs font-semibold">Min (₱)</span>
                                </label>
                                <input
                                    type="number"
                                    name="max_price"
                                    class="input input-bordered input-sm h-10 rounded-xl w-full text-sm focus:input-primary"
                                    placeholder="Type here..."
                                />
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary h-10 min-h-10 w-full rounded-xl text-sm font-semibold shadow-md shadow-primary/20 hover:scale-[1.01] transition"
                        >
                            Apply Filter
                        </button>

                        <?php if (!empty($filters["min_price"]) || !empty($filters["max_price"])): ?>
                            <a
                                href="<?= filterUrl(["min_price" => "", "max_price" => ""]) ?>"
                                class="btn btn-ghost btn-sm w-full rounded-xl text-xs"
                            >
                                Clear price filter
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 min-w-0 flex flex-col gap-5">
            <div class="flex items-center justify-between">
                <p class="text-sm text-base-content/50">
                    <?php if ($paginator->total() > 0): ?>
                        Showing
                        <span class="font-semibold text-base-content">
                            <?= $paginator->from() ?>-<?= $paginator->to() ?>
                        </span>
                        of
                        <span class="font-semibold text-base-content">
                            <?= number_format($paginator->total()) ?>
                        </span>
                        products
                    <?php else: ?>
                        No products found
                    <?php endif; ?>
                </p>

                <div class="flex items-center gap-2">
                    <span class="text-sm text-base-content/40 hidden sm:block flex-shrink-0">Sort by</span>
                    <select
                        class="select select-bordered select-sm h-10 rounded-xl text-sm cursor-pointer"
                        onchange="window.location.href=this.value"
                    >
                        <option
                            value="<?= filterUrl(["sort" => "newest"]) ?>
                            <?= $sort === "newest" ? "selected" : "" ?>"
                        >
                            Newest
                        </option>
                        <option
                            value="<?= filterUrl(["sort" => "price_asc"]) ?>"
                            <?= $sort === "price_asc" ? "selected" : "" ?>
                        >
                            Price: Low → High
                        </option>
                        <option
                            value="<?= filterUrl(["sort" => "price_desc"]) ?>"
                            <?= $sort === "price_desc" ? "selected" : "" ?>
                        >
                            Price: High → Low
                        </option>
                        <option
                            value="<?= filterUrl(["sort" => "name_asc"]) ?>"
                            <?= $sort === "name_asc" ? "selected" : "" ?>
                        >
                            Name: A → Z
                        </option>
                    </select>
                </div>
            </div>

            <?php if (empty($products)): ?>
                <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                    <div class="card-body items-center text-center py-20 gap-4">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl">
                            🛍️
                        </div>

                        <div>
                            <h3 class="text-lg font-black tracking-tight">
                                No products found
                            </h3>
                            <p class="text-base-content/50 text-sm mt-1">
                                Try adjusting your filters or search term
                            </p>
                        </div>

                        <a href="<?= e($_ENV["APP_URL"]) ?>/products"
                            class="btn btn-primary rounded-xl px-6 shadow-md shadow-primary/20 hover:scale-[1.02] transition">
                            Clear all filters
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                    <?php foreach ($products as $product): ?>
                        <a href="<?= e($_ENV["APP_URL"] . "/products/" . $product["slug"]) ?>"
                            class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden hover:shadow-2xl hover:-translate-y-0.5 transition-all duration-200 group">
                            <figure class="relative aspect-square overflow-hidden bg-base-200">
                                <?php if (!empty($product["image"])): ?>
                                    <img
                                        src="<?= e($_ENV["APP_URL"] . "/assets/images/products/" . $product["image"]) ?>"
                                        alt="<?= e($product["name"]) ?>"
                                        loading="lazy"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    />
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-5xl opacity-20">
                                        📦
                                    </div>
                                <?php endif; ?>

                                <div class="absolute top-3 right-3">
                                    <?php if ((int) $product["stock"] === 0): ?>
                                        <span class="badge badge-error badge-sm font-semibold shadow-sm">
                                            Out of stock
                                        </span>
                                    <?php elseif ((int) $product["stock"] <= 5): ?>
                                        <span class="badge badge-warning badge-sm font-semibold shadow-sm">
                                            Only <?= $product["stock"] ?> left
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </figure>

                            <div class="card-body p-4 gap-2">
                                <span class="badge badge-outline badge-sm rounded-lg font-semibold tracking-wide text-xs">
                                    <?= e($product["category_name"]) ?>
                                </span>
                                <h3 class="font-black text-sm leading-snug line-clamp-2 tracking-tight">
                                    <?= e($product["name"]) ?>
                                </h3>
                                <h3 class="text-xs text-base-content/40 font-medium">
                                    by <?= e($product["seller_name"]) ?>
                                </h3>

                                <div class="divider my-0"></div>

                                <div class="flex items-center justify-between">
                                    <span class="text-primary font-black text-xl tracking-tight">
                                        <?= App\Models\Product::formatPrice($product["price"]) ?>
                                    </span>

                                    <?php if ((int) $product["stock"] > 5): ?>
                                        <span class="flex items-center gap-1 text-success text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-success inline-block"></span>
                                            In stock
                                        </span>
                                    <?php elseif ((int) $product["stock"] > 0): ?>
                                        <span class="flex items-center gap-1 text-warning text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-warning inline-block"></span>
                                            <?= $product["stock"] ?> left
                                        </span>
                                    <?php else: ?>
                                        <span class="flex items-center gap-1 text-error text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-error inline-block"></span>
                                            Sold out
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>

                <?= $paginator->links() ?>
            <?php endif; ?>
        </div>
    </div>
</div>