<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Services\PasswordResetService;

class PasswordResetController extends Controller
{
    private PasswordResetService $resetService;

    public function __construct()
    {
        $this->resetService = new PasswordResetService();
    }

    public function showForgotForm(): void
    {
        if (Session::has("user_id")) {
            $this->redirect("/");
            return;
        }

        $this->view("auth.forgot-password", [
            "title" => "Forgot Password - KartNest",
            "errors" => $this->getErrors()
        ]);
    }

    public function sendResetLink(): void
    {
        $this->verifyCsrf();

        $email = $this->input("email");
        if (empty($email)) {
            Session::set("errors", [
                "email" => ["Email address is required"]
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::set("errors", [
                "email" => ["Please enter a valid email address"]
            ]);
            Session::set("_old_input", ["email" => $email]);
            $this->redirect("/forgot-password");
            return;
        }

        $sent = $this->resetService->sendResetLink($email);
        if (!$sent) {
            Session::flash("error", "Failed to send reset email. Please try again");
            Session::set("_old_input", ["email" => $email]);
            $this->redirect("/forgot-password");
            return;
        }

        Session::flash("success", "If that email is registered, you will receive a password reset link shortly");

        $this->redirect("/forgot-password");
    }

    public function showResetForm(): void
    {
        if (Session::has("user_id")) {
            $this->redirect("/");
            return;
        }

        $token = $_GET["token"] ?? "";
        $email = $_GET["email"] ?? "";

        if (empty($token) || empty($email)) {
            Session::flash("error", "Invalid or missing reset link. Please request a new one");
            $this->redirect("/forgot-password");
            return;
        }

        $tokenRecord = $this->resetService->validateResetToken($token);
        if ($tokenRecord === null) {
            Session::flash("error", "This reset link has expired or is invalid. Please request a new one");
            $this->redirect("/forgot-password");
            return;
        }

        $this->view("auth.reset-password", [
            "title" => "Reset Password - KartNest",
            "token" => $token,
            "email" => $email,
            "errors" => $this->getErrors()
        ]);
    }

    public function resetPassword(): void
    {
        $this->verifyCsrf();

        $token = $this->input("token");
        $email = $this->input("email");
        $password = $_POST["password"] ?? "";
        $confirm = $_POST["password_confirmation"] ?? "";

        if (empty($token) || empty($email)) {
            Session::flash("error", "Invalid reset request. Please request a new link");
            $this->redirect("/forgot-password");
            return;
        }

        $errors = $this->resetService->validateNewPassword($_POST);

        if (!empty($errors)) {
            Session::set("errors", $errors);

            $base = rtrim($_ENV["APP_URL"] ?? "", "/");
            header("Location: " . $base
                . "/reset-password?token=" . urlencode($token)
                . "&email=" . urlencode($email)
            );
            exit;
        }

        $success = $this->resetService->resetPassword($token, $email, $password);
        if (!$success) {
            Session::flash("error", "This reset link has expired or is invalid. Please request a new one");
            $this->redirect("/forgot-password");
            return;
        }

        Session::remove("errors");
        Session::remove("_old_input");

        Session::flash("success", "Your password has been reset successfully. Please sign in with your new password");
        $this->redirect("/login");
    }
}