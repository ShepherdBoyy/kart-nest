<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function create()
    {
        return Inertia::render("Auth/Login", [
            "status" => session("status")
        ]);
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route("dashboard", absolute: false));
    }

    public function destroy(Request $request)
    {
        Auth::guard("web")->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route("login"));
    }
}
