<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/dashboard');

Route::get("/dashboard", function () {
    return Inertia::render("Dashboard");
})->name("dashboard");  

require __DIR__ . "/auth.php";
