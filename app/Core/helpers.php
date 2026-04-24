<?php

declare(strict_types=1);

function csrf_field(): string
{
    $token = App\Core\Session::generateCsrfToken();
    return '<input type"hidden" name="_csrf_token" value="'
        . htmlspecialchars($token)
        . '" />';
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}

function old(string $key, string $default = ""): string
{
    return htmlspecialchars(
        App\Core\Session::get("_old_input")[$key] ?? $default,
        ENT_QUOTES,
        "UTF-8"
    );
}