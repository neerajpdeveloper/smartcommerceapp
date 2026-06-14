<?php

require_once dirname(__DIR__,2).'/main.php';

$id=(int)($_GET['id'] ?? 0);

$db=(new Config())->db();

/*
|--------------------------------------------------------------------------
| Remove Assignments First
|--------------------------------------------------------------------------
*/

$stmt=$db->prepare("
DELETE FROM api_client_permissions
WHERE permission_id=?
");

$stmt->execute([$id]);

/*
|--------------------------------------------------------------------------
| Delete Permission
|--------------------------------------------------------------------------
*/

$stmt=$db->prepare("
DELETE FROM api_permissions
WHERE id=?
");

$stmt->execute([$id]);

$_SESSION['success'] =
'Permission Deleted Successfully';

adminRedirect('api_permissions/index.php');