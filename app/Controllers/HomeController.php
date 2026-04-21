<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

class HomeController extends Controller
{
    public function index(): void
    {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->query('SELECT "Database connected!" AS message');
        $result = $stmt->fetch();

        $this->view("home.index", [
            "title" => "Welcome to KartNest",
            "message" => "Hello World!",
            "dbTest" => $result["message"]
        ]);
    }
}