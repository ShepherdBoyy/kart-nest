<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResendEmailVerificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get("register", [RegisterController::class, "create"])
        ->name("register");
    Route::post("register", [RegisterController::class, "store"]);

    Route::get("login", [LoginController::class, "create"])
        ->name("login");
    Route::post("login", [LoginController::class, "store"]);

    Route::get("forgot-password", [ForgotPasswordController::class, "create"])
        ->name("password.request");
    Route::post("forgot-password", [ForgotPasswordController::class, "store"])
        ->name("password.email");

    Route::get("reset-password/{token}", [NewPasswordController::class, "create"])
        ->name("password.reset");
    Route::get("reset-password", [NewPasswordController::class, "store"])
        ->name("password.store");
});

Route::middleware(["auth"])->group(function () {
    Route::get("verify-email", VerifyEmailController::class)
        ->name("verification.notice");
    
    Route::post("email/verification-notification", ResendEmailVerificationController::class)
        ->middleware("throttle:6,1")
        ->name("verification.send");

    Route::get("verify-email/{id}/{hash}", EmailVerificationController::class)
        ->middleware(["signed", "throttle:6,1"])
        ->name("verification.verify");
    
    Route::post("logout", [LoginController::class, "destroy"])
        ->name("logout");
});