<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, string $controller, string $method): void
    {
        $this->routes["GET"][$path] = [
            "controller" => $controller,
            "method" => $method
        ];
    }

    public function post(string $path, string $controller, string $method): void
    {
        $this->routes["POST"][$path] = [
            "controller" => $controller,
            "method" => $method
        ];
    }

    public function dispatch(string $url, string $httpMethod): void
    {
        $httpMethod = strtoupper($httpMethod);

        if (isset($this->routes[$httpMethod][$url])) {
            // continue tomorrow
        }
    }
}