<?php

declare(strict_types=1);

namespace App\Core;

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\RoleMiddleware;

class Router
{
    private array $routes = [];
    private int $lastRouteIndex = -1;

    public function get(string $path, string $controller, string $method): static
    {
        return $this->addRoute("GET", $path, $controller, $method);
    }

    public function post(string $path, string $controller, string $method): static
    {
        return $this->addRoute("POST", $path, $controller, $method);
    }

    private function addRoute(string $httpMethod, string $path, string $controller, string $action): static
    {
        preg_match_all("/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/", $path, $matches);
        $paramNames = $matches[1];
        $regex = $this->buildRegex($path);
        
        $this->routes[] = [
            "method" => $httpMethod,
            "pattern" => $path,
            "regex" => $regex,
            "params" => $paramNames,
            "controller" => $controller,
            "action" => $action,
            "middleware" => []
        ];

        $this->lastRouteIndex = count($this->routes) - 1;

        return $this;
    }

    private function buildRegex(string $path): string
    {
        $escaped = preg_quote($path, "/");
        $regex = preg_replace_callback(
            "/\\\{([a-zA-Z_][a-zA-Z0-9_]*)\\\}/",
            function (array $matches) {
                $paramName = $matches[1];
                if ($paramName === "id" || str_ends_with($paramName, "Id")) {
                    return "([0-9]+)";
                }

                return "([a-zA-Z0-9_-]+)";
            },
            $escaped
        );

        return "/^" . $regex . "$/";
    }

    public function middleware(string $middleware): static
    {
        if ($this->lastRouteIndex >= 0) {
            $this->routes[$this->lastRouteIndex]["middleware"][] = $middleware;
        }

        return $this;
    }

    public function dispatch(string $url, string $httpMethod): void
    {
        $httpMethod = strtoupper($httpMethod);

        foreach ($this->routes as $route) {
            if ($route["method"] !== $httpMethod) {
                continue;
            }

            if (!preg_match($route["regex"], $url, $matches)) {
                continue;
            }

            array_shift($matches);
            $params = array_combine(
                $route["params"],
                $matches
            ) ?: [];

            $this->runMiddleware($route["middleware"]);
            $this->callController(
                $route["controller"],
                $route["action"],
                $params
            );

            return;
        }

        throw new NotFoundException("No route found for: {$url}");
    }

    private function callController(string $controllerName, string $actionName, array $params): void
    {
        $controllerClass = "App\\Controllers\\" . $controllerName;

        if (!class_exists($controllerClass)) {
            throw new \RuntimeException("Controller {$controllerClass} not found");
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $actionName)) {
            throw new \RuntimeException("Method {$actionName} not found in {$controllerClass}");
        }

        $reflection = new \ReflectionMethod($controller, $actionName);
        $args = [];
        
        foreach ($reflection->getParameters() as $param) {
            $paramName = $param->getName();

            if (isset($params[$paramName])) {
                $value = $params[$paramName];
                $type = $param->getType();

                if ($type instanceof \ReflectionNamedType) {
                    $value = match($type->getName()) {
                        "int" => (int) $value,
                        "float" => (float) $value,
                        "bool" => (bool) $value,
                        default => $value
                    };
                }

                $args[] = $value;
            } elseif ($param->isOptional()) {
                $args[] = $param->getDefaultValue();
            }
        }

        $controller->$actionName(...$args);
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