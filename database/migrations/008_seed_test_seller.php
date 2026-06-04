<?php

declare(strict_types=1);

use App\Core\Migration;

class SeedTestSeller extends Migration
{
    public function up(): void
    {
        $stmt = $this->db->prepare("UPDATE users
            SET role = 'seller'
            WHERE id = 1
            LIMIT 1
        ");
        $stmt->execute();

        $affected = $stmt->rowCount();

        if ($affected === 0) {
            echo " Warning: No user with ID 1 found. "
                . "Register a user first.\n";
        } else {
            echo " Promoted user ID 1 to seller role.\n";
        }
    }

    public function down(): void
    {
        $stmt = $this->db->prepare("UPDATE users
            SET role = 'buyer'
            WHERE id = 1
            LIMIT 1
        ");
        $stmt->execute();
    }
}