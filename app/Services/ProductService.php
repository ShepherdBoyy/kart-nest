<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Validator;
use App\Models\Product;
use FileUploader;

class ProductService
{
    private const IMAGE_DIR = "public/assets/images/products";
    private FileUploader $uploader;

    public function __construct()
    {
        $this->uploader = new FileUploader(self::IMAGE_DIR);
    }

    public function validateProduct(array $data): Validator
    {
        $validator = new Validator($data);
        $validator->validate([
            "name" => ["required", "min:3", "max:255"],
            "category_id" => ["required", "numeric"],
            "price" => ["required", "positive"],
            "stock" => ["required", "numeric"],
        ]);

        return $validator;
    }

    public function createProduct(array $data, int $sellerId): int
    {
        $image = null;
        if ($this->uploader->hasFile("image")) {
            $image = $this->uploader->upload("image");
        }

        $slug = Product::generateSlug($data["name"]);

        return Product::create([
            "seller_id" => $sellerId,
            "category_id" => (int) $data["category_id"],
            "name" => trim($data["name"]),
            "slug" => $slug,
            "description" => trim($data["description"] ?? ""),
            "price" => (float) $data["price"],
            "stock" => (int) $data["stock"],
            "image" => $image,
            "is_active" => isset($data["is_active"]) ? 1 : 0
        ]);
    }

    public function updateProduct(int $productId, array $data, int $sellerId): bool
    {
        $product = Product::find($productId);
        if ($product === null) {
            return false;
        }

        if ((int) $product["seller_id"] !== $sellerId) {
            return false;
        }

        $image = $product["image"];
        if ($this->uploader->hasFile("image")) {
            $newImage = $this->uploader->upload("image");

            if (!empty($product["image"])) {
                $this->uploader->delete($product["image"]);
            }

            $image = $newImage;
        }

        Product::update($productId, [
            "category_id" => (int) $data["category_id"],
            "name" => trim($data["name"]),
            "description" => trim($data["description"] ?? ""),
            "price" => (float) $data["price"],
            "stock" => (int) $data["stock"],
            "image" => $image,
            "is_active" => isset($data["is_active"]) ? 1 : 0
        ]); 

        return true;
    }

    public function deleteProductd(int $productId, int $sellerId): bool
    {
        $product = Product::find($productId);
        if ($product === null) {
            return false;
        }

        if ((int) $product["seller_id"] !== $sellerId) {
            return false;
        }

        if (!empty($product["image"])) {
            $this->uploader->delete($product["image"]);
        }

        Product::delete($productId);

        return true;
    }

    public function getSellerProduct(int $productId, int $sellerId): ?array
    {
        $product = Product::find($productId);
        if ($product === null) {
            return null;
        }

        if ((int) $product['seller_id'] !== $sellerId) {
            return null;
        }

        return $product;
    }
}