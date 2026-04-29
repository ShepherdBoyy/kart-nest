<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Services\UserService;

class RegisterController extends Controller
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function showForm(): void
    {
        if (Session::has("user_id")) {
            $this->redirect("/");
            return;
        }

        $this->view("auth.register", [
            "title" => "Create Account - KartNest",
            "errors" => $this->getErrors()
        ]);
    }

    public function register(): void
    {
        $this->verifyCsrf();

        $validator = $this->userService->validateRegistration($_POST);

        if ($validator->fails()) {
            Session::set("errors", $validator->errors());

            Session::set("_old_input", [
                "name" => $this->input("name"),
                "email" => $this->input("email")
            ]);

            $this->redirect("/register");
            return;
        }

        try {
            $userId = $this->userService->register($_POST);
        } catch (\Throwable $e) {
            error_log("Registration failed: " . $e->getMessage());

            Session::flash("error", "Something went wrong. Please try again.");
            Session::set("_old_input", [
                "name" => $this->input("name"),
                "email" => $this->input("email"),
            ]);

            $this->redirect("/register");
            return;
        }

        Session::remove("errors");
        Session::remove("_old_input");

        Session::flash("success", "Acccount created successfully! Please log in.");

        $this->redirect("/login");
    }
}