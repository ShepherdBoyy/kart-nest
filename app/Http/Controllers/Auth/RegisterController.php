<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function create()
    {
        return Inertia::render("Auth/Register");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:100",
            "email" => "required|string|lowercase|email|max:100|unique:".User::class,
            "password" => ["required", "confirmed", Rules\Password::defaults()]
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        event(new Registered($user));

        return redirect(route("dashboard", absolute: false));
    }
}
