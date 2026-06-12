<?php
require_once dirname(__DIR__, 2) . '/main.php';
require_once '../../helpers/admin_helper.php';

if (empty($_SESSION['admin_id'])) {
    adminRedirect();
    exit;
}

$id = $_POST['id'];

$name = trim($_POST['name']);
$category_id = $_POST['category_id'];
$brand_id = $_POST['brand_id'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$description = $_POST['description'];

$db = (new Config())->db();

$slug = createSlug($name);

// duplicate check (exclude self)
$stmt = $db->prepare("SELECT COUNT(*) FROM products WHERE name = ? AND id != ?");
$stmt->execute([$name, $id]);

if ($stmt->fetchColumn() > 0) {
    $_SESSION['error'] = "Product already exists!";
    adminRedirect("products/edit.php?id=$id");
    exit;
}

// slug check
$stmt = $db->prepare("SELECT COUNT(*) FROM products WHERE slug = ? AND id != ?");
$stmt->execute([$slug, $id]);

if ($stmt->fetchColumn() > 0) {
    $slug .= '-' . time();
}

$stmt = $db->prepare("
UPDATE products 
SET name=?, slug=?, category_id=?, brand_id=?, price=?, stock=?, description=?
WHERE id=?
");

$stmt->execute([
    $name, $slug, $category_id, $brand_id,
    $price, $stock, $description, $id
]);

$_SESSION['success'] = "Product updated successfully";
adminRedirect('products');
exit;