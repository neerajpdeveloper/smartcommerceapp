<?php

require_once dirname(__DIR__, 2) . '/main.php';

// Auth Check
if (empty($_SESSION['admin_id'])) {
    adminRedirect();
    exit;
}

// Validate Request
$id = (int)($_POST['id'] ?? 0);

$name       = trim($_POST['name'] ?? '');
$mode       = trim($_POST['mode'] ?? 'sandbox');
$client_id  = trim($_POST['client_id'] ?? '');
$secret_key = trim($_POST['secret_key'] ?? '');
$extra_key  = trim($_POST['extra_key'] ?? '');
$status     = (int)($_POST['status'] ?? 1);

if (empty($id) || empty($name)) {

    $_SESSION['error'] = 'Invalid Request';

    adminRedirect(
        'payment-gateway/edit.php?id='.$id
    );

    exit;
}

$db = (new Config())->db();

//
// CHECK RECORD EXISTS
//
$stmt = $db->prepare("
    SELECT *
    FROM payment_gateways
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$gateway = $stmt->fetch(PDO::FETCH_OBJ);

if (!$gateway) {

    $_SESSION['error'] =
        'Payment Gateway Not Found';

    adminRedirect('payment-gateway');

    exit;
}

//
// UPDATE
//
$stmt = $db->prepare("
    UPDATE payment_gateways
    SET

        name        = ?,
        mode        = ?,
        client_id   = ?,
        secret_key  = ?,
        extra_key   = ?,
        status      = ?

    WHERE id = ?
");

$stmt->execute([

    $name,
    $mode,
    $client_id,
    $secret_key,
    $extra_key,
    $status,
    $id

]);

$_SESSION['success'] =
    'Payment Gateway Updated Successfully';

adminRedirect('payment-gateway');

exit;