<!DOCTYPE html>
<html>

<head lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @viteReactRefresh
    @vite('resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx")
    @inertiaHead

    <title inertia>{{ config('app.name', 'Laravel') }}</title>
</head>

<body>
    @inertia
</body>

</html>
