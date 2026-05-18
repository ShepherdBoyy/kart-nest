<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Services\UserService;

class LoginController extends Controller
{
    private UserService $userService;
    private const REMEMBER_COOKIE = "kart_nest_remember";
    private const REMEMBER_DURATION = 60 * 60 * 24 * 30;

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

        if ($this->attemptRememberLogin()) {
            $this->redirect("/");
            return;
        }

        $this->view("auth.login", [
            "title" => "Sign in - KartNest",
            "errors" => $this->getErrors()
        ]);
    }

    public function login(): void
    {
        $this->verifyCsrf();
        $validator = $this->userService->validateLogin($_POST);

        if ($validator->fails()) {
            Session::set("errors", $validator->errors());
            Session::set("_old_input", [
                "email" => $this->input("email")
            ]);
            $this->redirect("/login");
            return;
        }

        $email = $this->input("email");
        $password = $this->input("password");
        $user = $this->userService->attemptLogin($email, $password);

        if ($user === null) {
            Session::flash("error", "Invalid user email or password");
            Session::set("_old_input", [
                "email" => $this->input("email")
            ]);
            $this->redirect("/login");
            return;
        }

        session_regenerate_id(true);
        $this->storeUserInSession($user);

        $rememberMe = isset($_POST["remember_me"]) && $_POST["remember_me"] === "1";
        if ($rememberMe) {
            $this->setRememberMeCookie($user["id"]);
        }

        Session::regenerateCsrfToken();
        Session::flash("success", "Welcome back, " . $user["name"] . "!");

        $this->redirect("/");
    }

    public function logout(): void
    {
        $this->deleteRememberMeCookie();

        Session::destroy();
        Session::start();
        Session::flash("success", "You have been logged out");

        $this->redirect("/login");
    }

    private function storeUserInSession(array $user): void
    {
        $userId = isset($user["id"])
            ? (int) $user["id"]
            : (int) ($user["user_id"] ?? 0);

        Session::set("user_id", $userId);
        Session::set("user_name", $user["name"]);
        Session::set("user_email", $user["email"]);
        Session::set("user_role", $user["role"]);
    }

    private function setRememberMeCookie(int $userId): void
    {
        $rawToken = $this->userService->createRememberToken($userId);

        setcookie(
            self::REMEMBER_COOKIE,
            $rawToken,
            [
                "expires" => time() + self::REMEMBER_DURATION,
                "path" => "/",
                "domain" => "",
                "secure" => ($_ENV["APP_ENV"] ?? "") === "production",
                "httponly" => true,
                "samesite" => "Lax"
            ]
        );
    }

    private function attemptRememberLogin(): bool
    {
        $rawToken = $_COOKIE[self::REMEMBER_COOKIE] ?? null;

        if ($rawToken === null) {
            return false;
        }

        $tokenData = $this->userService->validateRememberToken($rawToken);

        if ($tokenData === null) {
            $this->clearRememberCookieFromBrowser();
            return false;
        }

        session_regenerate_id(true);
        $this->storeUserInSession($tokenData);
        Session::regenerateCsrfToken();

        return true;
    }

    private function deleteRememberMeCookie(): void
    {
        $rawToken = $_COOKIE[self::REMEMBER_COOKIE] ?? null;

        if ($rawToken !== null) {
            $this->userService->deleteRememberToken($rawToken);
            $this->clearRememberCookieFromBrowser();
        }
    }

    private function clearRememberCookieFromBrowser(): void
    {
        setcookie(
            self::REMEMBER_COOKIE,
            "",
            [
                "expires" => time() - 3600,
                "path" => "/",
                "domain" => "",
                "secure" => ($_ENV["APP_ENV"] ?? "") === "production",
                "httponly" => true,
                "samesite" => "Lax"
            ]
        );
    }
}