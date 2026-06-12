<?php
require_once dirname(__DIR__, 2) . '/main.php';
require_once '../../helpers/admin_helper.php';

if (empty($_SESSION['admin_id'])) {
    adminRedirect();
    exit;
}

$code = strtoupper(trim($_POST['code']));
$type = $_POST['type'];
$value = $_POST['value'];
$min_order = $_POST['min_order_amount'];
$limit = $_POST['usage_limit'];
$start = $_POST['start_date'];
$end = $_POST['end_date'];

$db = (new Config())->db();

// duplicate check
$stmt = $db->prepare("SELECT COUNT(*) FROM coupons WHERE code = ?");
$stmt->execute([$code]);

if ($stmt->fetchColumn() > 0) {
    $_SESSION['error'] = "Coupon already exists!";
    adminRedirect('coupons/create.php');
    exit;
}

$stmt = $db->prepare("
INSERT INTO coupons 
(code, type, value, min_order_amount, usage_limit, start_date, end_date)
VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $code, $type, $value, $min_order, $limit, $start, $end
]);

$_SESSION['success'] = "Coupon created successfully";
adminRedirect('coupons');
exit;