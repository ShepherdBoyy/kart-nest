<?php

declare(strict_types=1);

namespace App\Core;

class NotFoundException extends \RuntimeException
{
    public function __construct(string $message = "Page not found.")
    {
        parent::__construct($message, 404);
    }
}