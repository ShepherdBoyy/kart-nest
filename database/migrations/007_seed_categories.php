<?php

declare(strict_types=1);
use App\Core\Migration;

class SeedCategories extends Migration
{
    private array $categories = [
        [
            'name'        => 'Electronics',
            'description' => 'Phones, laptops, gadgets and accessories',
        ],
        [
            'name'        => 'Clothing',
            'description' => 'Fashion for men, women and children',
        ],
        [
            'name'        => 'Home & Garden',
            'description' => 'Furniture, decor and garden supplies',
        ],
        [
            'name'        => 'Sports & Outdoors',
            'description' => 'Equipment and gear for sports and outdoor activities',
        ],
        [
            'name'        => 'Books',
            'description' => 'Fiction, non-fiction, textbooks and more',
        ],
        [
            'name'        => 'Beauty & Health',
            'description' => 'Skincare, makeup and wellness products',
        ],
        [
            'name'        => 'Toys & Games',
            'description' => 'Toys, board games and video games',
        ],
        [
            'name'        => 'Food & Grocery',
            'description' => 'Fresh produce, pantry essentials and snacks',
        ],
    ];

    public function up(): void
    {
        $stmt = $this->db->prepare("INSERT IGNORE INTO categories
                (name, slug, description)
            VALUES
                (?, ?, ?)
        ");

        foreach ($this->categories as $category) {
            $slug = slugify($category["name"]);

            $stmt->execute([
                $category["name"],
                $slug,
                $category["description"]
            ]);

            echo " Seeded category: {$category["name"]}\n";
        }
    }

    public function down(): void
    {
        $slugs = array_map(
            fn($cat) => slugify($cat["name"]),
            $this->categories
        );

        $placeholders = implode(
            ",",
            array_fill(0, count($slugs), "?")
        );

        $stmt = $this->db->prepare(
            "DELETE FROM categories WHERE slug IN ({$placeholders})"
        );
        $stmt->execute($slugs);
    }
}