<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\MiddlewareInterface;
use App\Core\Session;
use Override;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle(): bool
    {
        if (Session::has("user_id")) {
            return true;
        }

        $currentUrl = $_SERVER["REQUEST_URI"] ?? "/";
        Session::set("intended_url", $currentUrl);
        Session::flash("info", "Please sign in to access that page");

        $base = rtrim($_ENV["APP_URL"] ?? "", "/");
        header("Location: " . $base . "/login");
        exit;
    }
}