<?php

require_once '../main.php';

$email = trim($_POST['email'] ?? '');

$stmt = (new Config())->db()->prepare("
SELECT id,email
FROM admin_users
WHERE email = ?
LIMIT 1
");

$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_OBJ);

if(!$user)
{
    $_SESSION['error'] = 'Email not found';
    adminRedirect('forgot-password.php');
}

$token = bin2hex(random_bytes(32));

$expiry = date(
    'Y-m-d H:i:s',
    strtotime('+2 hour')
);

$stmt = (new Config())->db()->prepare("
INSERT INTO password_resets
(email,token,expires_at)
VALUES(?,?,?)
");

$stmt->execute([
    $email,
    $token,
    $expiry
]);

$link = adminUrl(
    'reset-password.php?token='.$token
);

/*
Mail Send Here
*/

echo $link;