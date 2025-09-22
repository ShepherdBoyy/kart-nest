<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotifyController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route("dashboard", absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with("status", "verification-link-sent");
    }
}
