<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResendEmailVerificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get("login", [LoginController::class, "create"])
        ->name("login");
    Route::post("login", [LoginController::class, "store"]);

    Route::get("register", [RegisterController::class, "create"])
        ->name("register");
    Route::post('register', [RegisterController::class, "store"]);
});

Route::middleware("auth")->group(function () {
    Route::post("logout", [LoginController::class, "destroy"])
        ->name("logout");
    
    Route::get("verify-email", VerifyEmailController::class)->name("verification.notice");

    Route::post("email/verification-notification", [ResendEmailVerificationController::class, "store"])
        ->middleware("throttle:6,1")
        ->name("verification.send");

    Route::get("verify-email/{id}/{hash}", EmailVerificationController::class)
        ->middleware(["signed", "throttle:6,1"])
        ->name("verification.verify");
});