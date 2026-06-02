<?php

declare(strict_types=1);

function csrf_field(): string
{
    $token = App\Core\Session::generateCsrfToken();
    return '<input type="hidden" name="_csrf_token" value="'
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

function slugify(string $text): string
{
    $text = strtolower($text);
    $text = str_replace("&", "and", $text);
    $text = preg_replace("/[^a-z0-9\s-]/", "", $text);
    $text = preg_replace("/[\s-]+/", "-", $text);

    return trim($text, "-");
}

function filterUrl(array $overrides = []): string
{
    $params = array_merge([
        'search'    => $_GET['search']    ?? '',
        'category'  => $_GET['category']  ?? '',
        'sort'      => $_GET['sort']      ?? 'newest',
        'min_price' => $_GET['min_price'] ?? '',
        'max_price' => $_GET['max_price'] ?? '',
        'page'      => 1,
    ], $overrides);
 
    $params = array_filter($params, fn($v) => $v !== '' && $v !== null);
    $base   = rtrim($_ENV['APP_URL'], '/');
    return $base . '/products?' . http_build_query($params);
}