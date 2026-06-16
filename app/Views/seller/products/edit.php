<?php
    /** @var array $categories */
    /** @var array $product */
?>

<div class="flex flex-col gap-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-base-content">Edit Product</h1>
            <p class="text-base-content/50 text-sm mt-1">Update your product details</p>
        </div>

        <a href="<?= e($_ENV["APP_URL"]) ?>/seller/products"
            class="text-base-content/40 hover:text-primary transition-colors group flex-shrink-0">
            <span class="w-8 h-8 rounded-full border border-base-300 bg-base-100/70 flex items-center justify-center group-hover:bg-primary group-hover:border-primary group-hover:text-primary-content transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-x-icon lucide-x">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </span>
        </a>
    </div>

    <form
        action="<?= e($_ENV["APP_URL"] . "/seller/products/" . (int) $product["id"] ) ?>"
        method="POST"
        enctype="multipart/form-data"
        novalidate
    >

        <?= csrf_field() ?>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_340px] gap-6">
            <div class="flex flex-col gap-5">
                <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                    <div class="card-body p-6 md:p-8 gap-6">
                        <h2 class="font-black text-sm">Basic information</h2>

                        <div class="form-control">
                            <label class="label py-0 pb-1.5" for="name">
                                <span class="label-text text-sm font-semibold">
                                    Product name <span class="text-error">*</span>
                                </span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="<?= old("name", $product["name"]) ?>"
                                maxlength="255"
                                class="input input-bordered h-12 rounded-xl w-full text-sm
                                    <?= !empty($errors["name"]) 
                                        ? "input-error"
                                        : "focus:input-primary" ?>"
                            />
                            <?php if (!empty($errors["name"])): ?>
                                <label class="label pt-1.5">
                                    <span class="label-text-alt text-error text-xs">
                                        <?= e($errors["name"][0]) ?>
                                    </span>
                                </label>
                            <?php endif; ?>
                        </div>

                        <div class="form-control">
                            <label class="label py-0 pb-1.5" for="description">
                                <span class="label-text text-sm font-semibold">Description</span>
                                <span class="label-text-alt text-base-content/40 text-xs">Optional</span>
                            </label>
                            <textarea
                                id="description"
                                name="description"
                                rows="6"
                                placeholder="Describe your product — what it does, what's included, key specs..."
                                class="textarea rounded-xl w-full resize-none text-sm focus:textarea-primary leading-relaxed"
                            ><?= old('description', $product["description"] ?? "") ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                    <div class="card-body p-6 md:p-8 gap-6">
                        <h2 class="font-black text-sm">Pricing & Stock</h2>

                        <div class="grid grid-cols-2 gap-5">
                            <div class="form-control">
                                <label class="label py-0 pb-1.5" for="price">
                                    <span class="label-text text-sm font-semibold">
                                        Price <span class="text-error">*</span>
                                    </span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 z-10 font-black text-base-content/40 pointer-events-none">
                                        ₱
                                    </span>
                                    <input
                                        type="number"
                                        id="price"
                                        name="price"
                                        value="<?= old("price", $product["price"]) ?>"
                                        min="0.01"
                                        step="0.01"
                                        class="input input-bordered h-12 rounded-xl w-full text-sm pl-10
                                            <?= !empty($errors["price"]) 
                                                ? "input-error"
                                                : "focus:input-primary" ?>"
                                    />
                                    <?php if (!empty($errors["price"])): ?>
                                        <label class="label pt-1.5">
                                            <span class="label-text-alt text-error text-xs">
                                                <?= e($errors["price"][0]) ?>
                                            </span>
                                        </label>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-control">
                                <label class="label py-0 pb-1.5" for="stock">
                                    <span class="label-text text-sm font-semibold">
                                        Stock quantity <span class="text-error">*</span>
                                    </span>
                                </label>
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 z-10 w-4 h-4 text-base-content/30 pointer-events-none"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <input
                                        type="number"
                                        id="stock"
                                        name="stock"
                                        value="<?= old("stock", $product["stock"]) ?>"
                                        placeholder="0"
                                        min="0"
                                        step="1"
                                        class="input input-bordered h-12 rounded-xl w-full text-sm pl-10
                                            <?= !empty($errors["stock"]) 
                                                ? "input-error"
                                                : "focus:input-primary" ?>"
                                    />
                                </div>

                                <?php if (!empty($errors["stock"])): ?>
                                    <label class="label pt-1.5">
                                        <span class="label-text-alt text-error text-xs">
                                            <?= e($errors["stock"][0]) ?>
                                        </span>
                                    </label>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-5 lg:sticky lg:top-28 lg:self-start">
                <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                    <div class="card-body p-6 gap-4">
                        <h2 class="font-black text-sm">Product Image</h2>

                        <div
                            id="image-preview"
                            onclick="document.getElementById('image-input').click()"
                            class="relative aspect-square rounded-2xl bg-base-200 overflow-hidden cursor-pointer border-2 border-dashed border-base-300 hover:border-primary transition-colors group"
                        >
                            <div
                                id="preview-placeholder"
                                class="absolute inset-0 flex flex-col items-center justify-center gap-2
                                    <?= !empty($product["image"]) ? "hidden" : "" ?>"
                            >
                                <div class="w-12 h-12 rounded-2xl bg-base-300/60 group-hover:bg-primary/10 flex items-center justify-center transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-cloud-upload-icon lucide-cloud-upload">
                                        <path d="M12 13v8" />
                                        <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242" />
                                        <path d="m8 17 4-4 4 4" />
                                    </svg>
                                </div>

                                <div class="text-center">
                                    <p class="text-xs font-semibold text-base-content/50 group-hover:text-primary transition-colors">
                                        Click to upload
                                    </p>
                                    <p class="text-xs text-base-content/30 mt-1">JPG, PNG, WebP, GIF - Max 5MB</p>
                                </div>
                            </div>

                            <img
                                id="preview-img"
                                class="w-full h-full object-cover <?= empty($product["image"]) ? "hidden" : "" ?>"
                                alt="Product preview"
                                src="<?= !empty($product["image"]) ? e($_ENV["APP_URL"] . "/assets/images/products/" . $product["image"]) : "" ?>"
                            />

                            <div
                                id="preview-overlay"
                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center
                                    <?= empty($product["image"]) ? "hidden" : "" ?>"
                            >
                                <span class="text-white text-xs font-black uppercase tracking-widest">
                                    Change photo
                                </span>
                            </div>
                        </div>

                        <input
                            type="file"
                            id="image-input"
                            name="image"
                            accept="image/jpeg,image/png,image/webp,image/gif"
                            class="hidden"
                            onchange="previewImage(this)"
                        />

                        <p id="file-name" class="text-xs text-center text-base-content/40">No file chosen</p>
                    </div>
                </div>

                <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                    <div class="card-body p-6 gap-4">
                        <h2 class="font-black text-sm">Category</h2>

                        <div class="form-control">
                            <select
                                class="select h-12 rounded-xl w-full text-sm
                                    <?= !empty($errors["category_id"]) ? "select-error" : "focus:select-primary" ?>"
                                name="category_id"
                            >
                                <option disabled selected>Select a category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option
                                        value="<?= (int) $category["id"] ?>"
                                        <?= (old("category_id") ?: $product["category_id"]) == $category["id"] ? "selected" : "" ?>
                                    >
                                        <?= e($category["name"]) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <?php if (!empty($errors["category_id"])): ?>
                                <label class="label pt-1.5">
                                    <span class="label-text-alt text-error text-xs">
                                        <?= e($errors["category_id"][0]) ?>
                                    </span>
                                </label>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
                    <div class="card-body p-6 gap-4">
                        <h2 class="font-black text-sm">Visibility</h2>

                        <label class="flex items-center justify-between gap-4 px-4 py-3.5 rounded-2xl bg-base-200/60 border border-base-300/60 cursor-pointer hover:bg-primary/5 hover:border-primary/20 transition-colors">
                            <div>
                                <p class="text-sm font-semibold">Active Listing</p>
                                <p class="text-xs text-base-content/50 mt-1">Visible to buyers on the storefront</p>
                            </div>

                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                class="toggle toggle-primary"
                                <?= (int) (old("is_active") !== null ? old("is_active") : $product["is_active"]) ? "checked" : "" ?>
                            />
                        </label>

                        <button
                            type="submit"
                            class="btn btn-primary h-12 min-h-12 w-full rounded-2xl font-black text-sm shadow-lg shadow-primary/25 hover:scale-[1.02] transition-transform"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-check-icon lucide-check">
                                <path d="M20 6 9 17l-5-5" />
                            </svg>
                            Save changes
                        </button>

                        <p class="text-xs text-center text-base-content/30">
                            Changes will be reflected immediately on your listing
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const file = input.files[0];
    if (!file) return;

    document.getElementById("file-name").textContent = file.name;

    if (file.size > 5 * 1024 * 1024) {
        alert("File is too large. Maximum size is 5MB.");
        input.value = "";
        document.getElementById("file-name").textContent = "No file chosen";
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById("preview-img");
        const placeholder = document.getElementById("preview-placeholder");
        const overlay = document.getElementById("preview-overlay");

        img.src = e.target.result;
        img.classList.remove("hidden");
        placeholder.classList.add("hidden");
        overlay.classList.remove("hidden");
    }
    reader.readAsDataURL(file);
}

document.getElementById("price").addEventListener("input", function () {
    const val = parseFloat(this.value);
    const preview = document.getElementById("price-preview");
    const display = document.getElementById("price-preview-value");

    if (!isNaN(val) && val > 0) {
        display.textContent = "₱ " + val.toLocaleString("en-PH", {
            minimumFractionDigits: 2, maximumFractionDigits: 2
        });
        preview.classList.remove("hidden");
    } else {
        preview.classList.add("hidden");
    }
});
</script>