<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class Category extends Model
{
    protected static string $table = "categories";

    public static function findBySlug(string $slug): ?array
    {
        return static::findBy("slug", $slug);
    }

    public static function withProductCounts(): array
    {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->query("SELECT c.*, COUNT(p.id) AS product_count
            FROM categories c
            LEFT JOIN products p
                ON p.category_id = c.id
                AND p.is_active = 1
            GROUP BY c.id
            ORDER BY c.name ASC
        ");

        return $stmt->fetchAll();
    }

    public static function generateSlug(string $name): string
    {
        $baseSlug = slugify($name);
        $slug = $baseSlug;
        $counter = 2;

        while(static::exists("slug", $slug)) {
            $slug = $baseSlug . "-" . $counter;
            $counter++;
        }

        return $slug;
    }
}