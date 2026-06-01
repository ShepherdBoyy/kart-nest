<?php
// Build a URL preserving current filters but changing one value
// Usage: filterUrl(['category' => 'electronics'])
function filterUrl(array $overrides = []): string
{
    $params = array_merge([
        'search' => $_GET['search'] ?? '',
        'category' => $_GET['category'] ?? '',
        'sort' => $_GET['sort'] ?? 'newest',
        'min_price' => $_GET['min_price'] ?? '',
        'max_price' => $_GET['max_price'] ?? '',
        'page' => 1,
    ], $overrides);

    // Remove empty values from the URL
    $params = array_filter(
        $params,
        fn($v) => $v !== '' && $v !== null
    );

    $base = rtrim($_ENV['APP_URL'], '/');
    return $base . '/products?' . http_build_query($params);
}
?>

<div class="flex flex-col gap-6">

    <div class="flex flex-col sm:flex-row
                sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-base-content">
                Products
            </h1>
            <?php if (!empty($filters['search'])): ?>
                <p class="text-base-content/60 text-sm mt-1">
                    Search results for
                    "<strong><?= e($filters['search']) ?></strong>"
                </p>
            <?php endif; ?>
        </div>

        <form action="<?= e($_ENV['APP_URL']) ?>/products" method="GET" class="flex gap-2">

            <?php if (!empty($filters['category'])): ?>
                <input type="hidden" name="category" value="<?= e($filters['category']) ?>">
            <?php endif; ?>
            <?php if (
                !empty($filters['sort'])
                && $filters['sort'] !== 'newest'
            ): ?>
                <input type="hidden" name="sort" value="<?= e($filters['sort']) ?>">
            <?php endif; ?>

            <input type="search" name="search" value="<?= e($filters['search']) ?>" placeholder="Search products..."
                class="input input-bordered input-sm w-full
                       max-w-xs">
            <button type="submit" class="btn btn-primary btn-sm">
                Search
            </button>
            <?php if (!empty($filters['search'])): ?>
                <a href="<?= filterUrl(['search' => '']) ?>" class="btn btn-ghost btn-sm">
                    Clear
                </a>
            <?php endif; ?>
        </form>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">

        <aside class="w-full lg:w-64 flex-shrink-0">

            <div class="card bg-base-100 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="font-semibold text-sm
                               text-base-content/70 uppercase
                               tracking-wider mb-3">
                        Categories
                    </h2>

                    <ul class="menu menu-sm p-0">
                        <li>
                            <a href="<?= filterUrl(['category' => '']) ?>" class="<?= empty($filters['category'])
                                    ? 'active'
                                    : '' ?>">
                                All Categories
                            </a>
                        </li>
                        <?php foreach ($categories as $cat): ?>
                            <li>
                                <a href="<?= filterUrl([
                                    'category' => $cat['slug']
                                ]) ?>" class="flex justify-between
                                          <?= $filters['category']
                                              === $cat['slug']
                                              ? 'active'
                                              : '' ?>">
                                    <span>
                                        <?= e($cat['name']) ?>
                                    </span>
                                    <span class="badge badge-sm">
                                        <?= (int) $cat['product_count'] ?>
                                    </span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="card bg-base-100 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="font-semibold text-sm
                               text-base-content/70 uppercase
                               tracking-wider mb-3">
                        Price Range
                    </h2>

                    <form action="<?= e($_ENV['APP_URL']) ?>/products" method="GET">

                        <?php if (!empty($filters['search'])): ?>
                            <input type="hidden" name="search" value="<?= e($filters['search']) ?>">
                        <?php endif; ?>
                        <?php if (!empty($filters['category'])): ?>
                            <input type="hidden" name="category" value="<?= e($filters['category']) ?>">
                        <?php endif; ?>
                        <?php if (!empty($filters['sort'])): ?>
                            <input type="hidden" name="sort" value="<?= e($filters['sort']) ?>">
                        <?php endif; ?>

                        <div class="flex gap-2 mb-3">
                            <div class="form-control flex-1">
                                <label class="label py-0">
                                    <span class="label-text text-xs">
                                        Min (₱)
                                    </span>
                                </label>
                                <input type="number" name="min_price"
                                    value="<?= e((string) ($filters['min_price'] ?? '')) ?>" placeholder="0" min="0"
                                    class="input input-bordered
                                           input-sm w-full">
                            </div>
                            <div class="form-control flex-1">
                                <label class="label py-0">
                                    <span class="label-text text-xs">
                                        Max (₱)
                                    </span>
                                </label>
                                <input type="number" name="max_price"
                                    value="<?= e((string) ($filters['max_price'] ?? '')) ?>" placeholder="Any" min="0"
                                    class="input input-bordered
                                           input-sm w-full">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-outline btn-sm w-full">
                            Apply
                        </button>

                        <?php if (
                            !empty($filters['min_price'])
                            || !empty($filters['max_price'])
                        ): ?>
                            <a href="<?= filterUrl([
                                'min_price' => '',
                                'max_price' => '',
                            ]) ?>" class="btn btn-ghost btn-sm w-full mt-1">
                                Clear price
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

        </aside>

        <div class="flex-1 min-w-0">

            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-base-content/60">
                    <?php if ($paginator->total() > 0): ?>
                        Showing
                        <strong><?= $paginator->from() ?></strong>–<strong><?= $paginator->to() ?></strong>
                        of
                        <strong><?= number_format($paginator->total()) ?></strong>
                        products
                    <?php else: ?>
                        No products found
                    <?php endif; ?>
                </p>

                <div class="flex items-center gap-2">
                    <span class="text-sm text-base-content/60
                                 hidden sm:block">
                        Sort:
                    </span>
                    <select class="select select-bordered select-sm" onchange="window.location.href=this.value">
                        <option value="<?= filterUrl(['sort' => 'newest']) ?>" <?= $sort === 'newest'
                                ? 'selected' : '' ?>>
                            Newest
                        </option>
                        <option value="<?= filterUrl(['sort' => 'price_asc']) ?>" <?= $sort === 'price_asc'
                                ? 'selected' : '' ?>>
                            Price: Low to High
                        </option>
                        <option value="<?= filterUrl(['sort' => 'price_desc']) ?>" <?= $sort === 'price_desc'
                                ? 'selected' : '' ?>>
                            Price: High to Low
                        </option>
                        <option value="<?= filterUrl(['sort' => 'name_asc']) ?>" <?= $sort === 'name_asc'
                                ? 'selected' : '' ?>>
                            Name: A to Z
                        </option>
                    </select>
                </div>
            </div>

            <?php if (empty($products)): ?>

                <div class="flex flex-col items-center
                            justify-center py-24 text-center">
                    <div class="text-6xl mb-4 opacity-20">
                        🛍️
                    </div>
                    <h3 class="text-lg font-semibold mb-2">
                        No products found
                    </h3>
                    <p class="text-base-content/60 text-sm mb-4">
                        Try adjusting your filters or search term
                    </p>
                    <a href="<?= e($_ENV['APP_URL']) ?>/products" class="btn btn-primary btn-sm">
                        Clear all filters
                    </a>
                </div>

            <?php else: ?>

                <div class="grid grid-cols-1 sm:grid-cols-2
                            xl:grid-cols-3 gap-4">
                    <?php foreach ($products as $product): ?>

                        <a href="<?= e($_ENV['APP_URL'])
                            . '/products/'
                            . $product['slug'] ?>" class="card bg-base-100 shadow-sm
                                  hover:shadow-md transition-shadow
                                  cursor-pointer group">

                            <figure class="aspect-square
                                          overflow-hidden bg-base-200">
                                <?php if (!empty($product['image'])): ?>
                                    <img src="<?= e($_ENV['APP_URL'])
                                        . '/assets/images/products/'
                                        . $product['image'] ?>" alt="<?= e($product['name']) ?>" class="w-full h-full
                                               object-cover
                                               group-hover:scale-105
                                               transition-transform
                                               duration-300" loading="lazy">
                                <?php else: ?>
                                    <div class="w-full h-full
                                                flex items-center
                                                justify-center
                                                text-4xl opacity-20">
                                        📦
                                    </div>
                                <?php endif; ?>
                            </figure>

                            <div class="card-body p-4">

                                <div class="badge badge-outline
                                            badge-sm">
                                    <?= e($product['category_name']) ?>
                                </div>

                                <h3 class="font-semibold text-sm
                                           line-clamp-2 mt-1">
                                    <?= e($product['name']) ?>
                                </h3>

                                <div class="flex items-center
                                            justify-between mt-auto
                                            pt-2">
                                    <span class="text-primary
                                                 font-bold text-lg">
                                        <?= App\Models\Product::formatPrice(
                                            $product['price']
                                        ) ?>
                                    </span>

                                    <?php if ((int) $product['stock'] === 0): ?>
                                        <span class="badge badge-error
                                                     badge-sm">
                                            Out of stock
                                        </span>
                                    <?php elseif ((int) $product['stock'] <= 5): ?>
                                        <span class="badge badge-warning
                                                     badge-sm">
                                            Only <?= $product['stock'] ?> left
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-success
                                                     badge-sm">
                                            In stock
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <p class="text-xs text-base-content/50
                                          mt-1">
                                    by <?= e($product['seller_name']) ?>
                                </p>

                            </div>
                        </a>

                    <?php endforeach; ?>
                </div>

                <?= $paginator->links() ?>

            <?php endif; ?>

        </div>
    </div>
</div>