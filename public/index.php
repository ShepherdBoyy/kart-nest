<?php

declare(strict_types=1);

use App\Core\ErrorHandler;

define("ROOT_PATH", dirname(__DIR__));

require_once ROOT_PATH . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

ErrorHandler::register();

$app = new App\Core\App();
$app->run();