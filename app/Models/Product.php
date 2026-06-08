<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class Product extends Model
{
    protected static string $table = "products";

    public static function getPaginated(array $filters = [], int $page = 1, int $perPage = 12): array
    {
        $db = Database::getInstance()->getConnection();

        $where = ["p.is_active = 1"];
        $params = [];

        if (!empty($filters["search"])) {
            $search = trim($filters["search"]);

            if (mb_strlen($search) >= 3) {
                $where[] = "MATCH(p.name, p.description) AGAINST(? IN BOOLEAN MODE)";
                $params[] = $search . "*";
            } else {
                $where[] = "p.name LIKE ?";
                $params[] = "%" . $search . "%";
            }
        }

        if (!empty($filters["category"])) {
            $where[] = "c.slug = ?";
            $params[] = $filters["category"];
        }

        if (!empty($filters["min_price"]) && is_numeric($filters["min_price"])) {
            $where[] = "p.price >= ?";
            $params[] = (float) $filters["min_price"];
        }

        if (!empty($filters["max_price"]) && is_numeric($filters["max_price"])) {
            $where[] = "p.price <= ? ";
            $params[] = (float) $filters["max_price"];
        }

        $whereClause = "WHERE " . implode(" AND ", $where);

        $orderBy = match($filters["sort"] ?? "newest") {
            "price_asc" => "p.price ASC",
            "price_desc" => "p.price DESC",
            "name_asc" => "p.name ASC",
            default => "p.created_at DESC"
        };

        $countSql = "SELECT COUNT(*) AS total
            FROM products p
            JOIN categories c ON c.id = p.category_id
            JOIN users u ON u.id = p.seller_id
            {$whereClause}
        ";

        $countStmt = $db->prepare($countSql);
        $countStmt->execute($params);
        $total = (int) $countStmt->fetch()["total"];

        $offset = ($page - 1) * $perPage;

        $dataSql = "SELECT p.*,
                c.name AS category_name,
                c.slug AS category_slug,
                u.name AS seller_name
            FROM products p
            JOIN categories c ON c.id = p.category_id
            JOIN users u ON u.id = p.seller_id
            {$whereClause}
            ORDER BY {$orderBy}
            LIMIT {$perPage}
            OFFSET {$offset}
        ";

        $dataStmt = $db->prepare($dataSql);
        $dataStmt->execute($params);
        $products = $dataStmt->fetchAll();

        return [
            "products" => $products,
            "total" => $total
        ];
    }

    public static function findBySlug(string $slug): ?array
    {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT
                p.*,
                c.name AS category_name,
                c.slug AS category_slug,
                u.name AS seller_name,
                u.id AS seller_user_id
            FROM products p
            JOIN categories c ON c.id = p.category_id
            JOIN users u ON u.id = p.seller_id
            WHERE p.slug = ?
            AND p.is_active = 1
            LIMIT 1
        ");
        $stmt->execute([$slug]);
        $result = $stmt->fetch();

        return $result !== false ? $result : null;
    }

    public static function findBySeller(int $sellerId, int $page = 1, int $perPage = 20): array
    {
        $db = Database::getInstance()->getConnection();
        $offset = ($page - 1) * $perPage;

        $countStmt = $db->prepare("SELECT COUNT(*) AS total
            FROM products
            WHERE seller_id = ?
        ");
        $countStmt->execute([$sellerId]);
        $total = (int) $countStmt->fetch()["total"];

        $stmt = $db->prepare("SELECT p.*, c.name AS category_name
            FROM products p
            JOIN categories c ON c.id = p.category_id
            WHERE p.seller_id = ?
            ORDER BY p.created_at DESC
            LIMIT ?
            OFFSET ?
        ");
        $stmt->execute([$sellerId, $perPage, $offset]);

        return [
            "products" => $stmt->fetchAll(),
            "total" => $total
        ];
    }

    public static function getFeatured(int $limit = 8): array
    {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT
                p.*,
                c.name AS category_name,
                c.slug AS category_slug,
                u.name AS seller_name
            FROM products p
            JOIN categories c ON c.id = p.category_id
            JOIN users u ON u.id = p.seller_id
            WHERE p.is_active = 1
            AND p.stock > 0
            ORDER BY p.created_at DESC
            LIMIT ?
        ");

        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public static function getRelated(int $categoryId, int $excludeId, int $limit = 4): array
    {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT
                p.*,
                c.name AS category_name,
                u.name AS seller_name
            FROM products p
            JOIN categories c ON c.id = p.category_id
            JOIN users u ON u.id = p.seller_id
            WHERE p.category_id = ?
            AND p.id != ?
            AND p.is_active = 1
            AND p.stock > 0
            ORDER BY RAND()
            LIMIT ?
        ");
        $stmt->execute([$categoryId, $excludeId, $limit]);
        return $stmt->fetchAll();
    }

    public static function generateSlug(string $name): string
    {
        $baseSlug = slugify($name);
        $slug = $baseSlug;
        $counter = 2;

        while (static::exists("slug", $slug)) {
            $slug = $baseSlug . "-" . $counter;
            $counter++;
        }

        return $slug;
    }

    public static function formatPrice(float|string $price, string $currency = '₱'): string
    {
        return $currency . number_format((float) $price, 2);
    }
}