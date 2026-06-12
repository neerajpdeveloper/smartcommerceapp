<?php

require_once '../main.php';

$token = $_POST['token'];

$password = $_POST['password'];

$confirmPassword = $_POST['confirm_password'];

if($password != $confirmPassword)
{
    die('Password mismatch');
}

$stmt = (new Config())->db()->prepare("
SELECT *
FROM password_resets
WHERE token = ?
AND expires_at > NOW()
LIMIT 1
");

$stmt->execute([$token]);

$reset = $stmt->fetch(PDO::FETCH_OBJ);

if(!$reset)
{
    die('Invalid Token');
}

$hash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = (new Config())->db()->prepare("
UPDATE admin_users
SET password = ?
WHERE email = ?
");

$stmt->execute([
    $hash,
    $reset->email
]);

$stmt = (new Config())->db()->prepare("
DELETE FROM password_resets
WHERE email = ?
");

$stmt->execute([
    $reset->email
]);

$_SESSION['success'] =
'Password updated successfully';

adminRedirect();