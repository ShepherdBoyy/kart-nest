<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class ApiController extends Controller
{
    public function search(): void
    {
        header("Content-Type: application/json; charset=utf-8");
        header("Cache-control: no-cache, no-store, must-revalidate");

        $query = trim($_GET["q"] ?? "");
        $limit = min(10, (int) ($_GET["limit"] ?? 5));

        if (mb_strlen($query) < 2) {
            echo json_encode([
                "success" => true,
                "data" => [],
                "total" => 0,
                "query" => $query
            ]);
            exit;
        }

        try {
            $result = Product::getPaginated(
                filters: ["search" => $query],
                page: 1,
                perPage: $limit
            );

            $products = array_map(
                fn($product) => [
                    "id" => (int) $product["id"],
                    "name" => $product["name"],
                    "slug" => $product["slug"],
                    "price" => Product::formatPrice($product["price"]),
                    "image" => $product['image'],
                    "category_name" => $product["category_name"]
                ],
                $result["products"]
            );

            echo json_encode([
                "success" => true,
                "data" => $products,
                "total" => $result["total"],
                "query" => $query
            ]);
        } catch (\Throwable $e) {
            error_log("API search error: " . $e->getMessage());

            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Search failed. Please try again",
                "data" => [],
                "total" => 0
            ]);
        }
        
        exit;
    }

    public function getProduct(string $slug): void
    {
        header("Content-Type: application/json; charset=utf-8");

        $product = Product::findBySlug($slug);

        if ($product === null) {
            http_response_code(404);
            echo json_encode([
                "success" => false,
                "message" => "Product not found"
            ]);
            exit;
        }

        echo json_encode([
            "success" => true,
            "data" => [
                "id" => (int) $product["id"],
                "name" => $product["name"],
                "slug" => $product["slug"],
                "price" => Product::formatPrice($product["price"]),
                "price_raw" => (float) $product["price"],
                "stock" => (int) $product["stock"],
                "image" => $product["image"],
                "category_name" => $product["category_name"],
                "category_slug" => $product["category_slug"],
                "seller_name" => $product["seller_name"],
                "description" => $product["description"]
            ]
        ]);

        exit;
    }
}