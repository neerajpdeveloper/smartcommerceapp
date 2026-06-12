<?php
require_once dirname(__DIR__, 2) . '/main.php';
require_once '../../helpers/admin_helper.php';

if (empty($_SESSION['admin_id'])) {
    adminRedirect();
    exit;
}

$id = $_POST['id'];
$code = strtoupper(trim($_POST['code']));
$type = $_POST['type'];
$value = $_POST['value'];
$min_order = $_POST['min_order_amount'];

$db = (new Config())->db();

// duplicate check (exclude self)
$stmt = $db->prepare("SELECT COUNT(*) FROM coupons WHERE code = ? AND id != ?");
$stmt->execute([$code, $id]);

if ($stmt->fetchColumn() > 0) {
    $_SESSION['error'] = "Coupon already exists!";
    adminRedirect("coupons/edit.php?id=$id");
    exit;
}

$stmt = $db->prepare("
UPDATE coupons 
SET code=?, type=?, value=?, min_order_amount=?
WHERE id=?
");

$stmt->execute([$code, $type, $value, $min_order, $id]);

$_SESSION['success'] = "Coupon updated successfully";
adminRedirect('coupons');
exit;