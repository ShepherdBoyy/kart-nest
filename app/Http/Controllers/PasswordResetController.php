<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PasswordResetController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("Auth/ForgotPassword", [
            "status" => session("status")
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "email" => "required|email"
        ]);

        $status = Password::sendResetLink(
            $request->only("email")
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with("status", __($status));
        }

        throw ValidationException::withMessages([
            "email" => [trans($status)]
        ]);
    }
}
