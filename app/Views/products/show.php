<?php

/** @var array $product */
/** @var array $related */
/** @var string $title */

?>

<div class="flex flex-col gap-10">
    <div>
        <a href="<?= e($_ENV["APP_URL"]) ?>/products"
            class="inline-flex items-center  gap-2 text-sm font-semibold text-base-content/60 hover:text-primary group">
            <span
                class="w-7 h-7 rounded-xl border border-base-300 bg-base-100/80 flex items-center justify-center group-hover:bg-primary group-hover:border-primary group-hover:text-primary-content transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-chevron-left-icon lucide-chevron-left">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </span>
            Back to products
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_420px] gap-6 xl:gap-10 items-start">
        <div class="flex flex-col gap-6">
            <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                <div class="relative aspect-[4/3] bg-base-200">
                    <?php if (!empty($product["image"])): ?>
                        <img src="<?= e($_ENV["APP_URL"] . "/assets/images/products/" . $product["image"]) ?>"
                            alt="<?= e($product["name"]) ?>" class="w-full h-full object-cover" />
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-8xl opacity-20">📦</div>
                    <?php endif; ?>

                    <div class="absolute top-4 left-4">
                        <a href="<?= e($_ENV["APP_URL"]) ?>/products?category=<?= e($product["category_slug"]) ?>"
                            class="badge badge-sm font-bold tracking-wide rounded-xl bg-base-100/90 backdrop-blur-sm border border-base-300/60 text-base-content hover:bg-primary hover:text-primary-content hover:border-primary transition px-3 py-3">
                            <?= e($product["category_name"]) ?>
                        </a>
                    </div>

                    <?php $stock = (int) $product["stock"] ?>
                    <?php if ($stock === 0): ?>
                        <div class="absolute top-4 right-4">
                            <span class="badge badge-error font-semibold shadow px-3 py-3">
                                Sold out
                            </span>
                        </div>
                    <?php else: ?>
                        <div class="absolute top-4 right-4">
                            <span class="badge badge-warning font-semibold shadow px-3 py-3">
                                Only <?= $stock ?> left
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($product["description"])): ?>
                <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                    <div class="card-body p-6 md:p-8 gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-6 bg-primary rounded-full"></div>
                            <h2 class="text-base font-black tracking-tight uppercase text-base-content/60 text-xs">
                                About this product
                            </h2>
                        </div>

                        <div class="text-base-content/70 leading-relaxed">
                            <?= nl2br(e($product["description"])) ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="lg:sticky lg:top-28 flex flex-col gap-4">
            <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                <div class="card-body p-6 gap-5">
                    <h1 class="text-2xl font-black tracking-tight text-base-content leading-snug">
                        <?= e($product["name"]) ?>
                    </h1>

                    <div class="bg-primary/5 border border-primary/15 rounded-2xl px-5 py-4">
                        <p class="text-xs font-black uppercase tracking-widest text-primary/60 mb-1">Price</p>
                        <span class="text-4xl font-black text-primary tracking-tight">
                            <?= App\Models\Product::formatPrice($product["price"]) ?>
                        </span>
                    </div>

                    <div>
                        <?php if ($stock === 0): ?>
                            <div class="flex items-center gap-2 text-error text-sm font-semibold">
                                <span class="w-3 h-3 rounded-full bg-error shadow-sm shadow-error/50"></span>
                                Out of stock
                            </div>
                        <?php elseif ($stock <= 5): ?>
                            <div class="flex items-center gap-2 text-warning text-sm font-semibold">
                                <span class="w-3 h-3 rounded-full bg-warning shadow-sm shadow-warning/50"></span>
                                Only <?= $stock ?> left - order soon
                            </div>
                        <?php else: ?>
                            <div class="flex items-center gap-2 text-success text-sm font-semibold">
                                <span class="w-3 h-3 rounded-full bg-success shadow-sm shadow-success/50"></span>
                                In stock - <?= $stock ?> available
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="divider my-0"></div>

                    <div class="flex flex-col gap-3">
                        <label class="text-xs font-black uppercase tracking-widest text-base-content/40">
                            Quantity
                        </label>

                        <div class="flex gap-3 items-center">
                            <div class="flex items-center border border-base-300 rounded-2xl overflow-hidden bg-base-200 shadow-inner">
                                <button class="btn btn-ghost btn-sm rounded-none w-11 h-12 min-h-12 text-lg font-black"
                                    type="button" onclick="changeQuantity(-1)">
                                    -
                                </button>
                                <input type="number" id="quantity" value="1" min="1" max="<?= $stock ?>"
                                    class="text-center bg-transparent border-0 text-sm font-black focus:outline-none"
                                    readonly />
                                <button class="btn btn-ghost btn-sm rounded-none w-11 h-12 min-h-12 text-lg font-black"
                                    type="button" onclick="changeQuantity(1)">
                                    +
                                </button>
                            </div>

                            <?php if ($stock > 0): ?>
                                <button type="button" onclick="addToCart(<?= (int) $product['id'] ?>)"
                                    class="btn btn-primary flex-1 h-12 min-h-12 rounded-2xl font-black shadow-lg shadow-primary/25 hover:scale-[1.02] transition-transform text-sm">
                                    Add to cart
                                </button>
                            <?php else: ?>
                                <button disabled
                                    class="btn btn-disabled flex-1 h-12 min-h-12 rounded-2xl font-black text-sm">
                                    Unavailable
                                </button>
                            <?php endif; ?>
                        </div>

                        <button type="button"
                            class="btn btn-outline h-11 min-h-11 rounded-2xl font-semibold text-sm gap-2 hover:btn-primary transition w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-heart-icon lucide-heart">
                                <path
                                    d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                            </svg>
                            Save to wishlist
                        </button>
                    </div>

                    <div class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-base-200/80 border border-base-300/60">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="flex-shrink-0 text-base-content/40">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 16v-4" />
                            <path d="M12 8h.01" />
                        </svg>

                        <p class="text-xs text-base-content/50 leading-relaxed">
                            Full cart functionality is coming soon in the next feature update
                        </p>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                <div class="card-body p-5 flex-row items-center gap-4">
                    <div class="avatar avatar-placeholder flex-shrink-0">
                        <div class="bg-primary/10 text-primary w-12 rounded-full shadow-sm">
                            <span class="text-base font-black">
                                <?= strtoupper(substr($product["seller_name"], 0, 1)) ?>
                            </span>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-base-content/40 mb-1">Sold by</p>
                        <p class="text-sm font-black text-base-content truncate"><?= e($product["seller_name"]) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($related)): ?>
        <div class="flex flex-col gap-5">
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-base-content/40 mb-1">Explore more</p>
                    <h class="text-xl font-black tracking-tight">You might also like</h>
                </div>
                <a href="<?= e($_ENV["APP_URL"]) ?>/products?category=<?= e($product["category_slug"]) ?>"
                    class="text-sm font-semibold text-primary hover:underline hidden sm:block">
                    View all in <?= e($product["category_name"]) ?> →
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php foreach($related as $item): ?>
                    <a href="<?= e($_ENV["APP_URL"] . "/products/" . $item["slug"]) ?>"
                        class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-200 group">
                        <figure class="aspect-square overflow-hidden bg-base-200">
                            <?php if (!empty($item["image"])): ?>
                                <img
                                    src="<?= e($_ENV["APP_URL"] . "/assets/images/products/" . $item["image"]) ?>"
                                    alt="<?= e($item["name"]) ?>"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy"
                                />
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-3xl opacity-20">
                                    📦
                                </div>
                            <?php endif; ?>
                        </figure>

                        <div class="card-body p-4 gap-2">
                            <h3 class="font-black text-xs leading-snug tracking-tight">
                                <?= e($item["name"]) ?>
                            </h3>
                            <p class="text-primary font-black text-sm">
                                <?= App\Models\Product::formatPrice($item["price"]) ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function changeQuantity(delta) {
        const input = document.getElementById("quantity");
        const max = parseInt(input.getAttribute("max")) || 99;
        input.value = Math.max(1, Math.min(max, (parseInt(input.value) || 1) + delta))
    }

    function addToCart(productId) {
        const qty = document.getElementById("quantity").value;
        alert("Cart feature coming soon!\n\nProduct ID: " + productId + "\nQuantity: " + qty);
    }
</script>