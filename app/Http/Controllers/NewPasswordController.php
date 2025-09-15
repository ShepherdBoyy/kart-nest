<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class NewPasswordController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return Inertia::render("Auth/ResetPassword", [
            "email" => $request->email,
            "token" => $request->route("token")
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
}
