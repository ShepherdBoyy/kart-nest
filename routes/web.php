<?php

use App\Http\Controllers\SigninController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/dashboard');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('guest')->group(function () {
    Route::get('signin', [SigninController::class, 'create'])->name('login');
    Route::post('signin', [SigninController::class, 'store']);
});
