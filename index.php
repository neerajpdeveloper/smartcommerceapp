<?php
require_once 'main.php';
ErrorHandler::register();
// now system ready
$router = new Router();
$router->handle();

