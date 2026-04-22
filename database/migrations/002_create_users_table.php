<?php

declare(strict_types=1);

use App\Core\Migration;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        $this->execute("CREATE TABLE IF NOT EXISTS users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NUL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('buyer', 'seller', 'admin') NOT NULL DEFAULT 'buyer',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb_unicode_ci");
    }

    public function down(): void
    {
        $this->execute("DROP TABLE IF EXISTS users");
    }
}