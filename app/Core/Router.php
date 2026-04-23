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
            $route = $this->routes[$httpMethod][$url];
            
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
}