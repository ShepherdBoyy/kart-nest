<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;

class HomeController extends Controller
{
    public function index(): void
    {   
        if (!Session::has("_flash_tested")) {
            Session::flash("success", "Flash messages are working!");
            Session::flash("info", "CSRF protection is active");
            Session::set("_flash_tested", true);
        }

        $this->view("home.index", [
            "title" => "Welcome to KartNest",
            "message" => "Hello World!",
        ]);
    }
}