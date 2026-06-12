<?php
session_start();

require_once '../main.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    adminRedirect('change-password.php');
    exit;
}

$current = $_POST['current_password'] ?? '';
$new     = $_POST['new_password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

if ($new !== $confirm) {
    $_SESSION['error'] = "Password mismatch!";
    adminRedirect('change-password.php');
    exit;
}

$userId = $_SESSION['admin_id'] ?? 0;


$db = (new Config())->db();

// get current password
$stmt = $db->prepare("SELECT password, email FROM admin_users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_OBJ);

if (!$user || !password_verify($current, $user->password)) {
    $_SESSION['error'] = "Current password is wrong!";
    adminRedirect('change-password.php');
    exit;
}

// hash new password
$hash = password_hash($new, PASSWORD_DEFAULT);

// update password
$update = $db->prepare("UPDATE admin_users SET password = ? WHERE id = ?");
$update->execute([$hash, $userId]);

$_SESSION['success'] = "Password updated successfully";
    adminRedirect('change-password.php');
exit;