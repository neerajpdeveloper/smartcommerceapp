<?php

spl_autoload_register(function($class){

    $paths = [
        __DIR__.'/Base.php',
        __DIR__.'/../config/',
        __DIR__.'/../models/',
        __DIR__.'/../services/',
        __DIR__.'/../controllers/',

    ];

    foreach($paths as $path)
    {
        $file = $path.$class.'.php';

        if(file_exists($file))
        {
            require_once $file;
            return;
        }
    }

});

?>?