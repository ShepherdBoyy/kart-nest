<?php

declare(strict_types=1);

if (PHP_SAPI !== "cli") {
    die("This script can only be run from the command line.");
}

define("ROOT_PATH", __DIR__);

require_once ROOT_PATH . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

$command = $argv[1] ?? null;

if (!in_array($command, ["migrate", "rollback"], true)) {
    echo "Usage:\n";
    echo "  php migrate.php migrate   - Run all pending migrations\n";
    echo "  php migrate.php rollback  - Rollback the last migration\n";
    exit(1);
}

$db = App\Core\Database::getInstance()->getConnection();

$db->exec("CREATE TABLE IF NOT EXISTS migrations (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    migration VARCHAR(255) NOT NULL,
    ran_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

$migrationsPath = ROOT_PATH . "/database/migrations";
$files = glob($migrationsPath . "/*.php");
sort($files);

if (empty($files)) {
    echo "No migration files found in database/migrations\n";
    exit(0);
}

function getRanMigrations(\PDO $db): array
{
    $stmt = $db->query("SELECT migration FROM migrations ORDER BY id ASC");
    return $stmt->fetchAll(\PDO::FETCH_COLUMN);
}

function output(string $message, string $type = "info"): void
{
    $colors = [
        "info" => "\033[36m",
        "success" => "\033[32m",
        "error" => "\033[31m",
        "warning" => "\033[33m",
    ];
    $reset = "\033[0m";
    $color = $colors[$type] ?? $colors["info"];
    echo $color . $message . $reset . "\n";
}

if ($command === "migrate") {
    $ranMigrations = getRanMigrations($db);
    $pending = [];

    foreach ($files as $file) {
        $filename = basename($file);

        if (in_array($filename, $ranMigrations, true)) {
            continue;
        }

        $pending[] = $file;
    }

    if (empty($pending)) {
        output("Nothing to migrate. All migrations are up to date.", "info");
        exit(0);
    }

    foreach ($pending as $file) {
        $filename = basename($file);

        try {
            require_once $file;

            $className = filenameToClassname($filename);
            $fullClass = $className;

            if (!class_exists($fullClass)) {
                throw new \RuntimeException(
                    "Class {$fullClass} not found in {$filename}"
                );
            }

            $migation = new $fullClass();
            $migation->up();

            $stmt = $db->prepare(
                "INSERT INTO migrations (migration) VALUES (?)"
            );
            $stmt->execute([$filename]);

            output("    Migrated: {$filename}", "success");
        } catch (\Throwable $e) {
            output("    Failed:     {$filename}", "error");
            output("    Error:      " . $e->getMessage(), "error");
            exit(1);
        }
    }

    output("\nAll migrations ran successfully.", "success");
}

if ($command === "rollback") {
    $ranMigrations = getRanMigrations($db);

    if (empty($ranMigrations)) {
        output("Nothing to rollback. No migrations have been run.", "warning");
        exit(0);
    }

    $lastMigration = end($ranMigrations);
    $file = $migrationsPath . "/" . $lastMigration;

    if (!file_exists($file)) {
        output("Migration file not found: {$lastMigration}", "error");
        exit(1);
    }

    try {
        require_once $file;

        $className = filenameToClassname($lastMigration);
        $fullClass = $className;

        if (!class_exists($fullClass)) {
            throw new \RuntimeException(
                "Class {$fullClass} not found in {$lastMigration}"
            );
        }

        $stmt = $db->prepare(
            "DELETE FROM migrations WHERE migration = ?"
        );
        $stmt->execute([$lastMigration]);

        $migration = new $fullClass();
        $migration->down();

        output("    Rolled back: {$lastMigration}", "success");
        output("\nRollback completed.", "success");
    } catch (\Throwable $e) {
        output("    Failed:     {$lastMigration}", "error");
        output("    Error:      " . $e->getMessage(), "error");
        exit(1);
    }
}

function filenameToClassname(string $filename): string
{
    $name = pathinfo($filename, PATHINFO_FILENAME);
    $name = preg_replace("/^\d+_/", "", $name);

    return str_replace("_", "", ucwords($name, "_"));
}