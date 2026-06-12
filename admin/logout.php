<?php

require_once '../main.php';

unset($_SESSION['admin_id']);
unset($_SESSION['admin_name']);
unset($_SESSION['admin_email']);
unset($_SESSION['admin_role']);

session_destroy();
adminRedirect();
exit;

?>