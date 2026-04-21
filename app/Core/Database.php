<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct()
    {
        $config = require ROOT_PATH . "/config/database.php";

        $dsn = sprintf(
            "mysql:host=%s;port=%s;dbname=%s;charset=%s",
            $config["host"],
            $config["port"],
            $config["database"],
            $config["charset"]
        );

        try {
            $this->connection = new PDO(
                $dsn,
                $config["username"],
                $config["password"],
                $config["options"]
            );
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new \RuntimeException("Database connection failed. Check your configuration");
        }
    }

    public static function getInstance(): static
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }


    private function __clone()
    {
        //
    }
}