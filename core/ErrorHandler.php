<?php

class ErrorHandler
{
    public static function register()
    {
        error_reporting(E_ALL);

        ini_set('display_errors', 0);

        set_error_handler(
            [self::class, 'handleError']
        );

        set_exception_handler(
            [self::class, 'handleException']
        );

        register_shutdown_function(
            [self::class, 'handleFatal']
        );
    }

    public static function log(
        $type,
        $message,
        $file = '',
        $line = ''
    ) {

        $logDir =
            dirname(__DIR__)
            . '/logs';

        if (!is_dir($logDir)) {

            mkdir(
                $logDir,
                0777,
                true
            );
        }

        $logFile =
            $logDir
            . '/error-'
            . date('Y-m-d')
            . '.log';

        $content =
            "[" . date('Y-m-d H:i:s') . "] "
            . $type
            . " : "
            . $message
            . PHP_EOL
            . "File : "
            . $file
            . PHP_EOL
            . "Line : "
            . $line
            . PHP_EOL
            . str_repeat('-', 80)
            . PHP_EOL;

        file_put_contents(
            $logFile,
            $content,
            FILE_APPEND
        );
    }

    public static function handleError(
        $severity,
        $message,
        $file,
        $line
    ) {

        self::log(
            'ERROR',
            $message,
            $file,
            $line
        );

        return true;
    }

    public static function handleException(
        Throwable $e
    ) {

        self::log(
            'EXCEPTION',
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        );

        http_response_code(500);

        include dirname(__DIR__)
            . '/views/errors/500.php';

        exit;
    }

    public static function handleFatal()
    {
        $error = error_get_last();

        if (
            $error &&
            in_array(
                $error['type'],
                [
                    E_ERROR,
                    E_PARSE,
                    E_CORE_ERROR,
                    E_COMPILE_ERROR
                ]
            )
        ) {

            self::log(
                'FATAL',
                $error['message'],
                $error['file'],
                $error['line']
            );
        }
    }
}