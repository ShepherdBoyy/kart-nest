<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Paginator;
use App\Models\Category;
use App\Models\Product;

class SearchController extends Controller
{
    public function index(): void
    {
        $query = trim($_GET["q"] ?? "");
        $page = max(1, (int) ($_GET["page"] ?? 1));
        $perPage = 12;
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

        $filters = [
            "search" => $query,
            "category" => $category,
            "sort" => $sort
        ];

        if (!empty($query)) {
            $result = Product::getPaginated(
                filters: $filters,
                page: $page,
                perPage: $perPage
            );
        } else {
            $result = ["products" => [], "total" => 0];
        }

        $paginator = new Paginator(
            total: $result["total"],
            perPage: $perPage,
            currentPage: $page
        );

        $categories = Category::withProductCounts();

        $this->view("search.index", [
            "title" => empty($query)
                ? "Search - KartNest"
                : "Search: " . htmlspecialchars($query) . " - KartNest",
            "query" => $query,
            "products" => $result["products"],
            "paginator" => $paginator,
            "categories" => $categories,
            "sort" => $sort,
            "category" => $category,
            "total" => $result["total"]
        ]);
    }
}