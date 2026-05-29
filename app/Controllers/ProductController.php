<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\NotFoundException;
use App\Core\Paginator;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(): void
    {
        $search = trim($_GET["search"] ?? "");
        $category = preg_replace(
            "/[^a-zA-Z0-9_-]/",
            "",
            $_GET["category"] ?? ""
        );

        $allowedSorts = [
            "newest",
            "price_asc",
            "price_desc",
            "name_asc"
        ];
        $sort = in_array(
            $_GET["sort"] ?? "",
            $allowedSorts,
            true
        ) ? $_GET["sort"] : "newest";

        $minPrice = !empty($_GET["min_price"]) && is_numeric($_GET["min_price"])
            ? (float) $_GET["min_price"]
            : "";
        $maxPrice = !empty($_GET["max_price"]) && is_numeric($_GET["max_price"])
            ? (float) $_GET["max_price"]
            : "";
        
        $page = max(1, (int) ($_GET["page"] ?? 1));
        $perPage = 12;

        $filters = [
            "search" => $search,
            "category" => $category,
            "sort" => $sort,
            "min_price" => $minPrice,
            "max_price" => $maxPrice
        ];

        $result = Product::getPaginated($filters, $page, $perPage);
        $paginator = new Paginator(
            total: $result["total"],
            perPage: $perPage,
            currentPage: $page
        );

        $categories = Category::withProductCounts();

        $this->view("products.index", [
            "title" => "Products - KartNest",
            "products" => $result["products"],
            "paginator" => $paginator,
            "categories" => $categories,
            "filters" => $filters,
            "search" => $search,
            "sort" => $sort
        ]);
    }

    public function show(string $slug): void
    {
        $product = Product::findBySlug($slug);

        if ($product === null) {
            throw new NotFoundException("Product not found: {$slug}");
        }

        $related = Product::getRelated(
            categoryId: $product["category_id"],
            excludeId: $product["id"],
            limit: 4
        );

        $this->view("products.show", [
            "title" => e($product["name"] . " - KartNest"),
            "product" => $product,
            "related" => $related
        ]);
    }
}