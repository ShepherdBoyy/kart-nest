<?php

namespace App\Core;

class App
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
        $this->registerRoutes();
    }

    private function registerRoutes(): void
    {
        $this->router->get("/", "HomeController", "index");
    }

    public function run(): void
    {
        $url = $this->getUrl();

        $method = strtolower($_SERVER["REQUEST_METHOD"]);

        $this->router->dispatch($url, $method);
    }

    private function getUrl(): string
    {
        $url = $_SERVER["REQUEST_URI"] ?? "/";
        $url = strtok($url, "?");

        $basePath = dirname($_SERVER["SCRIPT_NAME"]);
        if ($basePath !== "/" && str_starts_with($url, $basePath)) {
            $url = substr($url, strlen($basePath));
        }

        $url = "/" . ltrim($url, "/");

        return $url;
    }
}