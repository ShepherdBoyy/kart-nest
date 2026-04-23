<?php

declare(strict_types=1);

namespace App\Core;

class ErrorHandler
{
    public static function register(): void
    {
        set_exception_handler([static::class, "handleException"]);

        set_error_handler([static::class, "handleError"]);

        register_shutdown_function([static::class, "handleShutdown"]);
    }

    public static function handleException(\Throwable $e): void
    {
        static::log($e);

        $statusCode = 500;
        if ($e instanceof NotFoundException) {
            $statusCode = 404;
        }

        http_response_code($statusCode);

        $debug = ($_ENV["APP_DEBUG"] ?? "false") === "true";
        $message = $debug ? $e->getMessage() : null;

        static::renderErrorPage($statusCode, $message);
    }

    public static function handleError(int $severity, string $message, string $file, int $line): bool
    {
        if (!(error_reporting() & $severity)) {
            return false;
        }

        throw new \ErrorException($message, 0, $severity, $file, $line);
    }

    public static function handleShutdown(): void
    {
        $error = error_get_last();

        if (
            $error !== null && in_array($error["type"], [
                E_ERROR,
                E_PARSE,
                E_CORE_ERROR,
                E_COMPILE_ERROR
            ], true)
        ) {
            $e = new \ErrorException(
                $error["message"],
                0,
                $error["type"],
                $error["file"],
                $error["line"]
            );

            static::handleException($e);
        }
    }

    private static function log(\Throwable $e): void
    {
        $logPath = ROOT_PATH . "/storage/logs/app.log";
        $logDir = dirname($logPath);

        if(!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        $timestamp = date("Y-m-d H:i:s");
        $type = get_class($e);
        $message = $e->getMessage();
        $file = $e->getFile();
        $line = $e->getLine();
        $trace = $e->getTraceAsString();

        $entry = <<<LOG
        [{$timestamp}] {$type}: {$message}
        File: {$file}:{$line}
        Trace:
        {$trace}
        ---------------------------------------------------------
        LOG;

        file_put_contents($logPath, $entry . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    private static function renderErrorPage(int $statusCode, ?string $debugMessage = null): void
    {
        $viewPath = ROOT_PATH . "/app/Views/errors/{$statusCode}.php";

        if (!file_exists($viewPath)) {
            $viewPath = ROOT_PATH . "/app/Views/errors/500.php";
        }

        include $viewPath;
        exit;
    }
}