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
    adminRedirect('categories/edit.php');
    exit;
}

$db = (new Config())->db();

$slug = createSlug($name);

$stmt = $db->prepare("SELECT COUNT(*) FROM categories WHERE name = ? AND id != ?");
$stmt->execute([$name, $id]);

if ($stmt->fetchColumn() > 0) {
    $_SESSION['error'] = "Category name already exists!";
    adminRedirect('categories/edit.php?id='.$id);
    exit;
}


$stmt = $db->prepare("UPDATE categories SET name = ?, slug = ? WHERE id = ?");
$stmt->execute([$name, $slug, $id]);

$_SESSION['success'] = "Category updated successfully";

adminRedirect('categories');
exit;