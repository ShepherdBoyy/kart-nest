<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\MiddlewareInterface;
use App\Core\Session;

class GuestMiddleware implements MiddlewareInterface
{
    public function handle(): bool
    {
        if (!Session::has("user_id")) {
            return true;
        }

        $base = rtrim($_ENV["APP_URL"] ?? "", "/");
        header("Location: " . $base . "/");
        exit;
    }
}