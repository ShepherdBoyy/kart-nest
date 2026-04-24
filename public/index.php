<?php

declare(strict_types=1);

define("ROOT_PATH", dirname(__DIR__));

require_once ROOT_PATH . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

App\Core\ErrorHandler::register();
App\Core\Session::start();

$app = new App\Core\App();
$app->run();