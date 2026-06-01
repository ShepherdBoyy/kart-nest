<div class="flex flex-col gap-8">

    <div>
        <a href="<?= e($_ENV['APP_URL']) ?>/products"
           class="cursor-pointer">
            ← Back to products
        </a>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="aspect-square rounded-xl
                            overflow-hidden bg-base-200">
                    <?php if (!empty($product['image'])): ?>
                        <img
                            src="<?= e($_ENV['APP_URL'])
                                    . '/assets/images/products/'
                                    . $product['image'] ?>"
                            alt="<?= e($product['name']) ?>"
                            class="w-full h-full object-cover"
                        >
                    <?php else: ?>
                        <div class="w-full h-full flex items-center
                                    justify-center text-8xl opacity-20">
                            📦
                        </div>
                    <?php endif; ?>
                </div>

                <div class="flex flex-col gap-4">

                    <div>
                        <a href="<?= e($_ENV['APP_URL']) ?>/products?category=<?= e($product['category_slug']) ?>"
                           class="badge badge-outline badge-sm mb-2">
                            <?= e($product['category_name']) ?>
                        </a>
                        <h1 class="text-2xl font-bold
                                   text-base-content">
                            <?= e($product['name']) ?>
                        </h1>
                    </div>

                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-primary">
                            <?= App\Models\Product::formatPrice(
                                $product['price']
                            ) ?>
                        </span>
                    </div>

                    <div>
                        <?php $stock = (int) $product['stock']; ?>

                        <?php if ($stock === 0): ?>
                            <div class="badge badge-error gap-1">
                                Out of stock
                            </div>
                        <?php elseif ($stock <= 5): ?>
                            <div class="badge badge-warning gap-1">
                                Only <?= $stock ?> left in stock
                            </div>
                        <?php else: ?>
                            <div class="badge badge-success gap-1">
                                In stock (<?= $stock ?> available)
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="flex items-center gap-3 py-3
                                border-t border-base-200">
                        <div class="avatar avatar-placeholder">
                            <div class="bg-primary text-primary-content
                                        rounded-full w-10">
                                <span class="text-sm">
                                    <?= strtoupper(
                                        substr($product['seller_name'], 0, 1)
                                    ) ?>
                                </span>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-base-content/50">
                                Sold by
                            </p>
                            <p class="text-sm font-medium">
                                <?= e($product['seller_name']) ?>
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-3 items-center">

                        <div class="flex items-center border
                                    border-base-300 rounded-lg
                                    overflow-hidden">
                            <button
                                class="btn btn-ghost btn-sm
                                       rounded-none px-3"
                                onclick="changeQty(-1)"
                                type="button">
                                −
                            </button>
                            <input
                                type="number"
                                id="quantity"
                                value="1"
                                min="1"
                                max="<?= $stock ?>"
                                class="w-16 text-center bg-transparent
                                       border-0 text-sm font-medium
                                       focus:outline-none"
                                readonly
                            >
                            <button
                                class="btn btn-ghost btn-sm
                                       rounded-none px-3"
                                onclick="changeQty(1)"
                                type="button">
                                +
                            </button>
                        </div>

                        <?php if ($stock > 0): ?>
                            <button
                                class="btn btn-primary flex-1"
                                onclick="addToCart(<?= (int) $product['id'] ?>)"
                                type="button">
                                Add to cart
                            </button>
                        <?php else: ?>
                            <button class="btn btn-disabled flex-1"
                                    disabled>
                                Out of stock
                            </button>
                        <?php endif; ?>

                        <button class="btn btn-outline btn-square"
                                title="Save to wishlist"
                                type="button">
                            ♡
                        </button>

                    </div>

                    <div class="alert alert-info text-sm py-2">
                        <span>
                            Shopping cart coming soon in the next feature.
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($product['description'])): ?>
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-6">
                <h2 class="text-lg font-bold mb-4">
                    Product Description
                </h2>
                <div class="prose prose-sm max-w-none
                            text-base-content/80">
                    <?= nl2br(e($product['description'])) ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($related)): ?>
        <div>
            <h2 class="text-lg font-bold mb-4">
                Related Products
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php foreach ($related as $item): ?>
                    <a href="<?= e($_ENV['APP_URL'])
                                . '/products/'
                                . $item['slug'] ?>"
                       class="card bg-base-100 shadow-sm
                              hover:shadow-md transition-shadow
                              cursor-pointer group">

                        <figure class="aspect-square
                                      overflow-hidden bg-base-200">
                            <?php if (!empty($item['image'])): ?>
                                <img
                                    src="<?= e($_ENV['APP_URL'])
                                            . '/assets/images/products/'
                                            . $item['image'] ?>"
                                    alt="<?= e($item['name']) ?>"
                                    class="w-full h-full object-cover
                                           group-hover:scale-105
                                           transition-transform
                                           duration-300"
                                    loading="lazy"
                                >
                            <?php else: ?>
                                <div class="w-full h-full
                                            flex items-center
                                            justify-center
                                            text-3xl opacity-20">
                                    📦
                                </div>
                            <?php endif; ?>
                        </figure>

                        <div class="card-body p-3">
                            <h3 class="font-medium text-sm
                                       line-clamp-2">
                                <?= e($item['name']) ?>
                            </h3>
                            <p class="text-primary font-bold text-sm">
                                <?= App\Models\Product::formatPrice(
                                    $item['price']
                                ) ?>
                            </p>
                        </div>

                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
// Quantity selector
function changeQty(delta) {
    const input = document.getElementById('quantity');
    const max   = parseInt(input.getAttribute('max')) || 99;
    const current = parseInt(input.value) || 1;
    const newVal  = Math.max(1, Math.min(max, current + delta));
    input.value = newVal;
}

// Add to cart placeholder
// Will be replaced when we build Feature 13 — Shopping Cart
function addToCart(productId) {
    const qty = document.getElementById('quantity').value;
    alert(
        'Cart feature coming soon!\n\n'
        + 'Product ID: ' + productId + '\n'
        + 'Quantity: '   + qty
    );
}
</script>