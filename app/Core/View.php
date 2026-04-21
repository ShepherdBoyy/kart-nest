<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    public static function render(string $view, array $data = [], string $layout = "layouts.main"): void
    {
        $viewPath = ROOT_PATH . "/app/Views/" . str_replace(".", "/", $view) . ".php";

        if (!file_exists($viewPath)) {
            throw new \Exception("View file not found: {$viewPath}");
        }

        extract($data, EXTR_SKIP);
        
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        $layoutPath = ROOT_PATH . "/app/Views/" . str_replace(".", "/", $layout) . ".php";

        if (!file_exists($layoutPath)) {
            throw new \Exception("Layout file not found: {$layoutPath}");
        }

        require $layoutPath;
    }
}