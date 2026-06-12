<?php
require_once dirname(__DIR__, 2) . '/main.php';
require_once '../../helpers/admin_helper.php';

if (empty($_SESSION['admin_id'])) {
    adminRedirect();
    exit;
}

$name = trim($_POST['name']);
$category_id = $_POST['category_id'];
$brand_id = $_POST['brand_id'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$description = $_POST['description'];

if (empty($name)) {
    $_SESSION['error'] = "Product name required";
    adminRedirect('products/create.php');
    exit;
}

$db = (new Config())->db();

$slug = createSlug($name);

// duplicate check name
$stmt = $db->prepare("SELECT COUNT(*) FROM products WHERE name = ?");
$stmt->execute([$name]);

if ($stmt->fetchColumn() > 0) {
    $_SESSION['error'] = "Product already exists!";
    adminRedirect('products/create.php');
    exit;
}

$stmt = $db->prepare("
INSERT INTO products 
(name, slug, category_id, brand_id, price, stock, description)
VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $name, $slug, $category_id, $brand_id, $price, $stock, $description
]);

$_SESSION['success'] = "Product created successfully";
adminRedirect('products');
exit;