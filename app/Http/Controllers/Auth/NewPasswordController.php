<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class NewPasswordController extends Controller
{
    public function create(Request $request)
    {
        return Inertia::render("Auth/ResetPassword", [
            "email" => $request->email,
            "token" => $request->route("token")
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "token" => "required",
            "password" => ["required", "confirmed", Rules\Password::defaults()]
        ]);

        $status = Password::reset(
            $request->only("email", "password", "password_confirmation", "token"),
            
            function ($user) use ($request) {
                $user->forceFill([
                    "password" => Hash::make($request->password),
                    "remember_token" => Str::random(60)
                ])->save();

                event(new Password($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route("login")->with("status", __($status));
        }

        throw ValidationException::withMessages([
            "email" => [trans($status)]
        ]);
    }
}
