<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

abstract class Model
{
    protected static string $table = "";
    protected static string $primaryKey = "id";

    protected static function db(): PDO
    {
        return Database::getInstance()->getConnection();
    }

    protected static function getTable(): string
    {
        if (empty(static::$table)) {
            throw new \RuntimeException(
                'Model [' . static::class . '] must define a $table property.'
            );
        }

        return static::$table;
    }

    public static function find(int $id): ?array
    {
        $table = static::getTable();
        $pk = static::$primaryKey;

        $stmt = static::db()->prepare("SELECT * FROM `{$table}` WHERE `{$pk}` = ? LIMIT 1");
        $stmt->execute([$id]);

        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    public static function findAll(string $orderBy = "id", string $direction = "ASC"): array
    {
        $table = static::getTable();
        
        $direction = strtoupper($direction) === "DESC" ? "DESC" : "ASC";
        $orderBy = preg_replace("/[^a-zA-Z0-9_]/", "", $orderBy);

        $stmt = static::db()->query(
            "SELECT * FROM `{$table}` ORDER BY `{$orderBy}` {$direction}"
        );

        return $stmt->fetchAll();
    }

    public static function findBy(string $column, mixed $value): ?array
    {
        $table = static::getTable();
        $column = preg_replace("/[^a-zA-Z0-9_]/", "", $column);

        $stmt = static::db()->prepare(
            "SELECT * FROM `{$table}` WHERE `{$column}` = ? LIMIT 1"
        );
        $stmt->execute([$value]);

        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    public static function findAllBy(string $column, mixed $value, string $orderBy, string $direction): array
    {
        $table = static::getTable();
        $column = preg_replace("/[^a-zA-Z0-9_]/", "", $column);
        $orderBy = preg_replace("/[^a-zA-Z0-9_]/", "", $orderBy);
        $direction = strtoupper($direction) === "DESC" ? "DESC" : "ASC";

        $stmt = static::db()->prepare(
            "SELECT * FROM `{$table}`
            WHERE `{$column}` = ?
            ORDER BY `{$orderBy}` {$direction}"
        );
        $stmt->execute([$value]);

        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $table = static::getTable();

        $columns = array_keys($data);
        $placeholders = array_fill(0, count($columns), "?");

        $columns = array_map(
            fn($col) => "`" . preg_replace("/[^a-zA-Z0-9_]/", "", $col) . "`",
            $columns
        );

        $columnList = implode(", ", $columns);
        $placeholderList = implode(", ", $placeholders);

        $stmt = static::db()->prepare(
            "INSERT INTO `{$table}` ({$columnList}) VALUES ({$placeholderList})"
        );
        $stmt->execute(array_values($data));

        return (int) static::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $table = static::getTable();
        $pk = static::$primaryKey;

        $setParts = [];
        foreach (array_keys($data) as $column) {
            $column = preg_replace("/[^a-zA-Z0-9_]/", "", $column);
            $setParts[] = "`{$column}`";
        }

        $setClause = implode(", ", $setParts);
        $values = array_values($data);
        $values[] = $id;

        $stmt = static::db()->prepare(
            "UPDATE `{$table}` SET {$setClause} WHERE `{$pk}` = ?"
        );

        return $stmt->execute($values);
    }

    public static function delete(int $id): bool
    {
        $table = static::getTable();
        $pk = static::$primaryKey;

        $stmt = static::db()->prepare(
            "DELETE FROM `{$table}` WHERE `{$pk}` = ?"
        );

        return $stmt->execute([$id]);
    }

    public static function count(): int
    {
        $table = static::getTable();

        $stmt = static::db()->query(
            "SELECT COUNT(*) FROM `{$table}`"
        );

        return (int) $stmt->fetchColumn();
    }

    public static function exists(string $column, mixed $value): bool
    {
        $table = static::getTable();
        $column = preg_replace("/[^a-zA-Z0-9_]/", "", $column);

        $stmt = static::db()->prepare(
            "SELECT 1 FROM `{$table}` WHERE `{$column}` = ? LIMIT 1"
        );
        $stmt->execute([$value]);

        return $stmt->fetchColumn() !== false;
    }
}