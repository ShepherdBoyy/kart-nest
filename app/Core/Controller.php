<?php

declare(strict_types=1);

namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    protected function redirect(string $url): void
    {
        $base = rtrim($_ENV["APP_URL"] ?? "", "/");

        if (str_starts_with($url, "http")) {
            $location = $url;
        } else {
            $location = $base . "/" . ltrim($url, "/");
        }

        header("Location: " . $location);
        exit();
    }

    protected function isPost(): bool
    {
        return $_SERVER["REQUEST_METHOD"] === "POST";
    }

    protected function input(string $key, string $default = ""): string
    {
        return trim($_POST[$key] ?? $default);
    }

    protected function verifyCsrf(): void
    {
        $token = $_POST["_csrf_token"] ?? "";

        if (!Session::verifyCsrfToken($token)) {
            throw new \RuntimeException(
                "Invalid CSRF Token. Form submission rejected."
            );
        }
    }
}