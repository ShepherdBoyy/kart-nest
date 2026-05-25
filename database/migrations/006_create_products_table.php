<?php

declare(strict_types=1);

use App\Core\Migration;

class CreateProductsTable extends Migration
{
    public function up(): void
    {
        $this->execute("CREATE TABLE IF NOT EXISTS products (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            seller_id INT UNSIGNED NOT NULL,
            category_id INT UNSIGNED NOT NULL,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            description TEXT NULL,
            price DECIMAL(10,2) NOT NULL,
            stock INT UNSIGNED NOT NULL DEFAULT 0,
            image VARCHAR(255) NULL,
            is_active TINYINT(1) NOT NULL DEFAULT 1,
            
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            
            INDEX idx_name (name),
            INDEX idx_category_id (category_id),
            INDEX idx_seller_id (seller_id),
            INDEX idx_is_active (is_active),
            INDEX idx_price (price), 
            FULLTEXT idx_search (name, description),
            
            CONSTRAINT fk_products_seller
                FOREIGN KEY (seller_id)
                REFERENCES users (id)
                ON DELETE CASCADE,
            CONSTRAINT fk_products_category
                FOREIGN KEY (category_id)
                REFERENCES categories (id)
                ON DELETE RESTRICT
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    public function down(): void
    {
        $this->execute("DROP TABLE IF EXISTS products");
    }
}