<?php

require_once dirname(__DIR__, 2) . '/main.php';
require_once '../../helpers/admin_helper.php';

if(empty($_SESSION['admin_id']))
{
    adminRedirect();
    exit;
}
?>