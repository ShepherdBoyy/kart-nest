<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\User;

class HomeController extends Controller
{
    public function index(): void
    {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->query('SELECT "Database connected!" AS message');
        $result = $stmt->fetch();

        // Test
        $userCount = User::count();
        $emailExists = User::exists("email", "jheymarc@gmail.com");

        $this->view("home.index", [
            "title" => "Welcome to KartNest",
            "message" => "Hello World!",
            "dbTest" => $result["message"],
            "userCount" => $userCount,
            "emailExists" => $emailExists
        ]);
    }
}