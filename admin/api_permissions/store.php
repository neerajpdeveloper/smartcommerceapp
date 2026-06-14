<?php

require_once dirname(__DIR__,2).'/main.php';

if($_SERVER['REQUEST_METHOD']!='POST'){
    adminRedirect('api_permissions/index.php');
}

$db = (new Config())->db();

$stmt = $db->prepare("
INSERT INTO api_permissions
(
permission_key,
description,
created_at
)
VALUES
(
?,
?,
NOW()
)
");

$stmt->execute([
trim($_POST['permission_key']),
trim($_POST['description'])
]);

$_SESSION['success'] =
'Permission Created Successfully';

adminRedirect('api_permissions/index.php');