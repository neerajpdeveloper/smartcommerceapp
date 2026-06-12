<?php

session_start();

require_once __DIR__ . '/config/Autoload.php';
$settingObj = new Setting();
$GLOBALS['setting'] = $settingObj->get();
?>