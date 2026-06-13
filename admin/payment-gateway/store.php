<?php

require_once dirname(__DIR__, 2) . '/main.php';

// Auth Check
if (empty($_SESSION['admin_id'])) {
    adminRedirect();
    exit;
}

// Only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    adminRedirect('payment-gateway');
    exit;
}

$name       = trim($_POST['name'] ?? '');
$code       = trim($_POST['code'] ?? '');
$mode       = trim($_POST['mode'] ?? 'sandbox');
$client_id  = trim($_POST['client_id'] ?? '');
$secret_key = trim($_POST['secret_key'] ?? '');
$extra_key  = trim($_POST['extra_key'] ?? '');
$status     = (int)($_POST['status'] ?? 1);

// Validation
if (empty($name)) {

    $_SESSION['error'] = 'Gateway Name is Required';

    adminRedirect('payment-gateway/create.php');
    exit;
}

if (empty($code)) {

    $_SESSION['error'] = 'Gateway Code is Required';

    adminRedirect('payment-gateway/create.php');
    exit;
}

$db = (new Config())->db();

//
// CHECK DUPLICATE CODE
//
$stmt = $db->prepare("
    SELECT COUNT(*)
    FROM payment_gateways
    WHERE code = ?
");

$stmt->execute([$code]);

if ($stmt->fetchColumn() > 0) {

    $_SESSION['error'] =
        'Gateway code already exists.';

    adminRedirect('payment-gateway/create.php');
    exit;
}

//
// INSERT
//
$stmt = $db->prepare("
    INSERT INTO payment_gateways
    (
        name,
        code,
        mode,
        client_id,
        secret_key,
        extra_key,
        status
    )
    VALUES
    (
        ?,?,?,?,?,?,?
    )
");

$stmt->execute([

    $name,
    strtolower($code),
    $mode,
    $client_id,
    $secret_key,
    $extra_key,
    $status

]);

$_SESSION['success'] =
    'Payment Gateway Added Successfully';

adminRedirect('payment-gateway');
exit;