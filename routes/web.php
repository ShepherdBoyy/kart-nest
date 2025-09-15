<?php

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
});
