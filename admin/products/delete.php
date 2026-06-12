<?php
require_once dirname(__DIR__, 2) . '/main.php';
require_once '../../helpers/admin_helper.php';

if (empty($_SESSION['admin_id'])) {
    adminRedirect();
    exit;
}

$id = $_GET['id'];

$db = (new Config())->db();

$stmt = $db->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

$_SESSION['success'] = "Product deleted successfully";
adminRedirect('products');
exit;