<?php
    /** @var \App\Core\Paginator $paginator */
?>

<div class="flex flex-col gap-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-base-content">My Products</h1>
            <p class="text-base-content/50 text-sm mt-1">Manage and monitor your product listings</p>
        </div>

        <a href="<?= e($_ENV["APP_URL"]) ?>/seller/products/create" class="btn btn-primary h-11 min-h-11 rounded-2xl px-5 font-black text-sm shadow-lg shadow-primary/25 hover:scale-[1.02] transition-transform gap-2 self:start sm:self-auto flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-plus-icon lucide-plus">
                <path d="M5 12h14" />
                <path d="M12 5v14" />
            </svg>
            Add Product
        </a>
    </div>

    <?php if (empty($products)): ?>
    <?php else: ?>

        <?php
            $totalProducts = $paginator->total();
            $activeCount = count(array_filter($products, fn($p) => (int) $p["is_active"]));
            $lowStockCount = count(array_filter($products, fn($p) => (int) $p["stock"] > 0 && (int) $p["stock"] <= 5));
            $outOfStock = count(array_filter($products, fn($p) => (int) $p["stock"] === 0));
        ?>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                <div class="card-body p-5 gap-1">
                    <p class="text-xs font-black uppercase tracking-widest text-base-content/40">Total</p>
                    <p class="text-3xl font-black tracking-tight text-base-content"><?= number_format($totalProducts) ?></p>
                    <p class="text-xs text-base-content/40">products listed</p>
                </div>
            </div>
            
            <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                <div class="card-body p-5 gap-1">
                    <p class="text-xs font-black uppercase tracking-widest text-success/70">Active</p>
                    <p class="text-3xl font-black tracking-tight text-success"><?= $activeCount ?></p>
                    <p class="text-xs text-base-content/40">visible to buyers</p>
                </div>
            </div>

            <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                <div class="card-body p-5 gap-1">
                    <p class="text-xs font-black uppercase tracking-widest text-warning/70">Low stock</p>
                    <p class="text-3xl font-black tracking-tight text-warning"><?= $lowStockCount ?></p>
                    <p class="text-xs text-base-content/40">need restocking</p>
                </div>
            </div>

            <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                <div class="card-body p-5 gap-1">
                    <p class="text-xs font-black uppercase tracking-widest text-error/70">Sold out</p>
                    <p class="text-3xl font-black tracking-tight text-error"><?= $outOfStock ?></p>
                    <p class="text-xs text-base-content/40">out of stock</p>
                </div>
            </div>
        </div>

        <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th class="bg-transparent text-xs font-black uppercase tracking-widest text-base-content/40 py-4 px-6">Product</th>
                            <th class="bg-transparent text-xs font-black uppercase tracking-widest text-base-content/40 py-4 px-4">Category</th>
                            <th class="bg-transparent text-xs font-black uppercase tracking-widest text-base-content/40 py-4 px-4">Price</th>
                            <th class="bg-transparent text-xs font-black uppercase tracking-widest text-base-content/40 py-4 px-4">Stock</th>
                            <th class="bg-transparent text-xs font-black uppercase tracking-widest text-base-content/40 py-4 px-4">Status</th>
                            <th class="bg-transparent text-xs font-black uppercase tracking-widest text-base-content/40 py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            
                            <?php
                                $stock = (int) $product["stock"];
                                $stockColor = $stock === 0 ? "text-error" : ($stock <= 5 ? "text-warning" : "text-success");
                                $stockBg = $stock === 0 ? "bg-error/10" : ($stock <= 5 ? "bg-warning/10" : "bg-success/10");
                            ?>

                            <tr>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-base-200 rounded-2xl overflow-hidden flex-shrink-0 border border-base-300/60">
                                            <?php if (!empty($product["image"])): ?>
                                                <img
                                                    src="<?= e($_ENV["APP_URL"] . "/assets/images/products" . $product["image"]) ?>"
                                                    alt="<?= e($product["name"]) ?>"
                                                    class="w-full h-full object-cover"
                                                />
                                            <?php else: ?>
                                                <div class="w-full h-full flex items-center justify-center text-lg">📦</div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-black text-sm text-base-content tracking-tight">
                                                <?= e($product["name"]) ?>
                                            </p>

                                            <p class="text-xs text-base-content/30 mt-0.5 font-medium truncate">
                                                /<?= e($product["slug"]) ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-4">
                                    <span class="badge badge-outline badge-sm font-semibold tracking-wide px-2">
                                        <?= e($product["category_name"]) ?>
                                    </span>
                                </td>

                                <td class="py-4 px-4">
                                    <span class="text-primary font-black text-sm tracking-tight">
                                        <?= App\Models\Product::formatPrice($product["price"]) ?>
                                    </span>
                                </td>

                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-black <?= $stockColor ?> <?= $stockBg ?>">
                                        <?= $stock ?> left
                                    </span>
                                </td>

                                <td class="py-4 px-4">
                                    <?php if ((int) $product["is_active"]): ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-black text-success bg-success/10">
                                            Active
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-black text-base-content/40 bg-base-200">
                                            Hidden
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-end">
                                        <a href="<?= e($_ENV["APP_URL"] . "/seller/products/" . $product["id"]) . "/edit" ?>"
                                            class="btn btn-ghost btn-sm h-9 min-h-9 rounded-xl gap-1.5 font-semibold text-xs hover:bg-primary/10 hover:text-primary transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-pencil-icon lucide-pencil">
                                                <path
                                                    d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                                <path d="m15 5 4 4" />
                                            </svg>
                                            Edit
                                        </a>

                                        <form
                                            action="<?= e($_ENV["APP_URL"] . "/seller/products" . $product["id"] . "/delete") ?>"
                                            method="POST"
                                            onsubmit="return confirm('Delete <?= e(addslashes($product['name'])) ?>? This cannot be undone.')"
                                        >
                                            <?= csrf_field() ?>

                                            <button
                                                type="submit"
                                                class="btn btn-ghost btn-sm h-9 min-h-9 rounded-xl gap-1.5 font-semibold text-xs hover:bg-error/10 hover:text-error transition-colors"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-trash-icon lucide-trash">
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                    <path d="M3 6h18" />
                                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-b border-base-300">
                <p class="text-xs font-black uppercase tracking-widest text-base-content/40">
                    Showing
                    <span class="text-base-content"><?= $paginator->from() ?>-<?= $paginator->to() ?></span>
                    of
                    <span class="text-base-content"><?= number_format($paginator->total()) ?></span>
                    products
                </p>
            </div>
        </div>

        <?= $paginator->links() ?>

    <?php endif; ?>
</div>