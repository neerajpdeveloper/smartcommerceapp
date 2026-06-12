<?php

session_start();

require_once __DIR__.'/config/Config.php';
require_once __DIR__.'/config/Base.php';
require_once __DIR__.'/config/Autoload.php';
require_once __DIR__.'/helpers/site_helper.php';

// now system ready
$router = new Router();
$router->handle();