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

        $this->router->get("/register", "RegisterController", "showForm")
            ->middleware("guest");
        $this->router->post("/register", "RegisterController", "register")
            ->middleware("guest");

        $this->router->get("/login", "LoginController", "showForm")
            ->middleware("guest");
        $this->router->post("/login", "LoginController", "login")
            ->middleware("guest");
        $this->router->get("/logout", "LoginController", "logout")
            ->middleware("auth");
        
        $this->router->get("/forgot-password", "PasswordResetController", "showForgotForm")
            ->middleware("guest");
        $this->router->post("/forgot-password", "PasswordResetController", "sendResetLink")
            ->middleware("guest");
        
        $this->router->get("/reset-password", "PasswordResetController", "showResetForm")
            ->middleware("guest");
        $this->router->post("/reset-password", "PasswordResetController", "resetPassword")
            ->middleware("guest");
        
        $this->router->get("/products", "ProductController", "index");
        $this->router->get("/products/{slug}", "ProductController", "show");

        $this->router->get("/seller/products", "SellerProductController", "index")
            ->middleware("auth")->middleware("role:seller");
        $this->router->get("/seller/products/create", "SellerProductController", "create")
            ->middleware("auth")->middleware("role:seller");
        $this->router->post("/seller/products", "SellerProductController", "store")
            ->middleware("auth")->middleware("role:seller");
        $this->router->get("/seller/products/{id}/edit", "SellerProductController", "edit")
            ->middleware("auth")->middleware("role:seller");
        $this->router->post("/seller/products/{id}", "SellerProductController", "update")
            ->middleware("auth")->middleware("role:seller");
        $this->router->post("/seller/products/{id}/delete", "SellerProductController", "delete")
            ->middleware("auth")->middleware("role:seller");
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