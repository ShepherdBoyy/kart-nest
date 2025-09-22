<?php

use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SigninController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/dashboard');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('guest')->group(function () {
    Route::get("signup", [SignupController::class, "create"])->name("signup");
    Route::post("signup", [SignupController::class, "store"]);

    Route::get('signin', [SigninController::class, 'create'])->name('login');
    Route::post('signin', [SigninController::class, 'store']);

    Route::get("forgot-password", [PasswordResetController::class, "create"])->name("password.request");
    Route::post("forgot-password", [PasswordResetController::class, "store"])->name("password.email");

    Route::get("reset-password/{token}", [NewPasswordController::class, "create"])->name("password.reset");
    Route::post("reset-password", [NewPasswordController::class, "store"])->name("password.store");
});

Route::middleware('auth')->group(function () {
    Route::post("logout", [SigninController::class, "destroy"])->name("logout");

    Route::get("verify-email", EmailVerificationController::class)->name("verification.notice");
});
