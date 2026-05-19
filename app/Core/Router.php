<?php

declare(strict_types=1);

namespace App\Core;

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\RoleMiddleware;

class Router
{
    private array $routes = [];
    private string $lastRouteKey = "";

    public function get(string $path, string $controller, string $method): static
    {
        $this->routes["GET"][$path] = [
            "controller" => $controller,
            "method" => $method,
            "middleware" => []
        ];
        $this->lastRouteKey = "GET:" . $path;
        return $this;
    }

    public function post(string $path, string $controller, string $method): static
    {
        $this->routes["POST"][$path] = [
            "controller" => $controller,
            "method" => $method,
            "middleware" => []
        ];
        $this->lastRouteKey = "POST:" . $path;
        return $this;
    }

    public function middleware(string $middleware): static
    {
        if ($this->lastRouteKey === "") {
            return $this;
        }

        [$httpMethod, $path] = explode(":", $this->lastRouteKey, 2);
        $this->routes[$httpMethod][$path]["middleware"][] = $middleware;

        return $this;
    }

    public function dispatch(string $url, string $httpMethod): void
    {
        $httpMethod = strtoupper($httpMethod);

        if (isset($this->routes[$httpMethod][$url])) {
            $route = $this->routes[$httpMethod][$url];

            $this->runMiddleware($route["middleware"]);
            
            $controllerClass = "App\\Controllers\\" . $route["controller"];
            $controllerMethod = $route["method"];

            if (!class_exists($controllerClass)) {
                throw new \RuntimeException(
                    "Controller {$controllerClass} not found."
                );
            }

            $controller = new $controllerClass();

            if (!method_exists($controller, $controllerMethod)) {
                throw new \RuntimeException(
                    "Method {$controllerMethod} not found in {$controllerClass}."
                );
            }

            $controller->$controllerMethod();
            return;
        }

        throw new NotFoundException("No route found for: {$url}");
    }

    private function runMiddleware(array $middlewareList): void
    {
        foreach ($middlewareList as $middlewareName) {
            $middlewareInstance = $this->resolveMiddleware($middlewareName);
            if (!$middlewareInstance->handle()) {
                exit;
            }
        }
    }

    private function resolveMiddleware(string $name): MiddlewareInterface
    {
        $parts = explode(":", $name, 2);
        $middlewareName = $parts[0];
        $middlewareParam = $parts[1] ?? null;

        $map = [
            "auth" => AuthMiddleware::class,
            "guest" => GuestMiddleware::class,
            "role" => RoleMiddleware::class
        ];

        if (!isset($map[$middlewareName])) {
            throw new \RuntimeException(
                "Middleware [{$middlewareName}] not found"
            );
        }

        $class = $map[$middlewareName];
        if ($middlewareParam !== null) {
            return new $class($middlewareParam);
        }

        return new $class();
    }
}