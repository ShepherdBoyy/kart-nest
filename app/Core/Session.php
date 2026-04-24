<?php

declare(strict_types=1);

namespace App\Core;

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                "lifetime" => 0,
                "path" => "/",
                "secure" => ($_ENV["APP_ENV"] ?? "development") === "production",
                "httponly" => true,
                "samesite" => "Lax",
            ]);

            session_start();

            if (!self::has("_last_regenerated")) {
                session_regenerate_id(true);
                self::set("_last_regenerated", time());
            }
        }
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        return isset($_SERVER[$key]);
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function destroy(): void
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                "",
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }

    public static function flash(string $type, string $message): void
    {
        $_SESSION["_flash"][$type][] = $message;
    }

    public static function getFlash(): array
    {
        $messages = $_SESSION["_flash"] ?? [];

        unset($_SESSION["_flash"]);

        return $messages;
    }

    public static function hasFlash(): bool
    {
        return !empty($_SESSION["_flash"]);
    }

    public static function generateCsrfToken(): string
    {
        if(!self::has("_csrf_token")) {
            self::set("_csrf_token", bin2hex(random_bytes(32)));
        }

        return self::get("_csrf_token");
    }

    public static function getCsrfToken(): string
    {
        return self::get("_csrf_token", "");
    }

    public static function verifyCsrfToken(string $submittedToken): bool
    {
        $storedToken = self::getCsrfToken();

        if (empty($storedToken) || empty($submittedToken)) {
            return false;
        }

        return hash_equals($storedToken, $submittedToken);
    }

    public static function regenerateCsrfToken(): void
    {
        self::set("_csrf_token", bin2hex(random_bytes(32)));
    }
}