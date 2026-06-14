<?php

require_once dirname(__DIR__,2).'/main.php';

$db=(new Config())->db();

$stmt=$db->prepare("
UPDATE api_permissions
SET
permission_key=?,
description=?
WHERE id=?
");

$stmt->execute([
trim($_POST['permission_key']),
trim($_POST['description']),
(int)$_POST['id']
]);

$_SESSION['success'] =
'Permission Updated Successfully';

adminRedirect('api_permissions/index.php');