<?php

require_once dirname(__DIR__, 2) . '/main.php';

// Auth check
if (empty($_SESSION['admin_id'])) {
    adminRedirect();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    adminRedirect('categories');
    exit;
}

$name = trim($_POST['name'] ?? '');

if (empty($name)) {
    $_SESSION['error'] = 'Name is Required.';
    adminRedirect('categories/create.php');
    exit;
}

$db = (new Config())->db();

// slug generate
$slug = createSlug($name);

//
// 1. CHECK DUPLICATE NAME
//
$stmt = $db->prepare("SELECT COUNT(*) FROM categories WHERE name = ?");
$stmt->execute([$name]);

if ($stmt->fetchColumn() > 0) {
    $_SESSION['error'] = "Category name already exists!";
    adminRedirect('categories/create.php');
    exit;
}

//
// INSERT
//
$stmt = $db->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
$stmt->execute([$name, $slug]);

$_SESSION['success'] = "Category added successfully";

adminRedirect('categories');
exit;