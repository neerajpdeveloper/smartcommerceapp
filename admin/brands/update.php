<?php
require_once dirname(__DIR__, 2) . '/main.php';
require_once '../../helpers/admin_helper.php';

if (empty($_SESSION['admin_id'])) {
    adminRedirect();
    exit;
}

$id   = $_POST['id'] ?? 0;
$name = trim($_POST['name'] ?? '');

if (empty($id) || empty($name)) {
    $_SESSION['error'] = "Invalid request!";
    adminRedirect('brands/edit.php');
    exit;
}

$db = (new Config())->db();

$slug = createSlug($name);

$stmt = $db->prepare("SELECT COUNT(*) FROM brands WHERE name = ? AND id != ?");
$stmt->execute([$name, $id]);

if ($stmt->fetchColumn() > 0) {
    $_SESSION['error'] = "Brands name already exists!";
    adminRedirect('brands/edit.php?id='.$id);
    exit;
}


$stmt = $db->prepare("UPDATE brands SET name = ?, slug = ? WHERE id = ?");
$stmt->execute([$name, $slug, $id]);

$_SESSION['success'] = "Brands updated successfully";

adminRedirect('brands');
exit;