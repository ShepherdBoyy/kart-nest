<?php

declare(strict_types=1);

use App\Core\Migration;

class CreateRememberTokensTable extends Migration
{
    public function up(): void
    {
        $this->execute("CREATE TABLE IF NOT EXISTS remember_tokens (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            token_hash VARCHAR(255) NOT NULL,
            expires_at TIMESTAMP NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_user_id (user_id),
            INDEX idx_token_hash (token_hash),
            CONSTRAINT fk_remember_tokens_user
                FOREIGN KEY (user_id)
                REFERENCES users (id)
                ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    public function down(): void
    {
        $this->execute("DROP TABLE IF EXISTS remember_tokens");
    }
}