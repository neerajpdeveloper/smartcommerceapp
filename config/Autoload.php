<?php

spl_autoload_register(function ($class) {

    $baseDir = __DIR__ . '/../';

    $paths = [
        'models/',
        'controllers/',
        'services/',
        'core/',
        'exports/',
        'imports/',
    ];

    foreach ($paths as $path) {

        $file = $baseDir . $path . $class . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});