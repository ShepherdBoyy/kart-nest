<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        return Inertia::render("Auth/VerifyEmail", [
                "status" => session("status")
            ]);
    }
}
