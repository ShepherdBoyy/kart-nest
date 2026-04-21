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
                $this->abort(500, "Controller {$controllerClass} not found.");
                return;
            }

            $controller = new $controllerClass();

            if (!method_exists($controller, $controllerMethod)) {
                $this->abort(500, "Method {$controllerMethod} not found in {$controllerClass}.");
                return;
            }

            $controller->$controllerMethod();
            return;
        }

        $this->abort(404, "Page not found.");
    }

    private function abort(int $statusCode, string $message): void
    {
        http_response_code($statusCode);
        echo $message;
        exit;
    }
}