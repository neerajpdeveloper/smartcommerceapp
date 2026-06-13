<?php
require_once dirname(__DIR__, 2) . '/main.php';

if(empty($_SESSION['admin_id']))
{
    adminRedirect();
    exit;
}
?>