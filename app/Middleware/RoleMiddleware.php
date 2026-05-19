<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\MiddlewareInterface;
use App\Core\Session;

class RoleMiddleware implements MiddlewareInterface
{
    private string $requiredRole;

    public function __construct(string $requiredRole)
    {
        $this->requiredRole = $requiredRole;
    }

    public function handle(): bool
    {
        if (!Session::has("user_id")) {
            Session::set("intended_url", $_SERVER["REQUEST_URI"] ?? "/");
            Session::flash("info", "Please sign in to access that page");

            $base = rtrim($_ENV["APP_URL"] ?? "", "/");
            header("Location: " . $base . "/login");
            exit;
        }

        $userRole = Session::get("user_role", "buyer");
        if ($this->hasRequiredRole($userRole)) {
            return true;
        }

        Session::flash("error", "You do not have permission to access that page");

        $base = rtrim($_ENV["APP_URL"] ?? "", "/");
        header("Location: " . $base . "/");
        exit;
    }

    private function hasRequiredRole(string $userRole): bool
    {
        $hierarchy = [
            "buyer" => 1,
            "seller" => 2,
            "admin" => 3
        ];

        $userLevel = $hierarchy[$userRole] ?? 0;
        $requiredLevel = $hierarchy[$this->requiredRole] ?? 0;

        return $userLevel >= $requiredLevel;
    }
}