<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ForgotPasswordController extends Controller
{
    public function create()
    {
        return Inertia::render("Auth/ForgotPassword", [
            "status" => session("status")
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "email" => "required|email"
        ]);

        $status = Password::sendResetLink(
            $request->only("email")
        );

        if ($status == PASSWORD::RESET_LINK_SENT) {
            return back()->with("status", __($status));
        }

        throw ValidationException::withMessages([
            "email" => [trans($status)]
        ]);
    }
}
