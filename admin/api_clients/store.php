<?php

require_once dirname(__DIR__, 2) . '/main.php';

// Auth check
if (empty($_SESSION['admin_id'])) {
    adminRedirect();
    exit;
}


$db = (new Config())->db();

$stmt = $db->prepare("
INSERT INTO api_clients
(
name,
email,
company_name,
status
)
VALUES
(
?,
?,
?,
?
)
");

$stmt->execute([
$_POST['name'],
$_POST['email'],
$_POST['company_name'],
$_POST['status']
]);

 $_SESSION['success'] = 'Client Created';

adminRedirect('api_clients');