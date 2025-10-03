<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get("register", [RegisterController::class, "create"])
        ->name("register");
    Route::post("register", [RegisterController::class, "store"]);

    Route::get("login", [LoginController::class, "create"])
        ->name("login");
    Route::post("login", [LoginController::class, "store"]);
});

Route::middleware(["auth"])->group(function () {
    Route::get("verify-email", VerifyEmailController::class)
        ->name("verification.notice");
    
    Route::post("logout", [LoginController::class, "destroy"])
        ->name("logout");
});