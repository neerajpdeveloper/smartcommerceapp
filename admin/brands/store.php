<?php

require_once dirname(__DIR__, 2) . '/main.php';
require_once '../../helpers/admin_helper.php';

// Auth check
if (empty($_SESSION['admin_id'])) {
    adminRedirect();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    adminRedirect('brands');
    exit;
}

$name = trim($_POST['name'] ?? '');

if (empty($name)) {
    $_SESSION['error'] = 'Name is Required.';
    adminRedirect('brands/create.php');
    exit;
}

$db = (new Config())->db();

// slug generate
$slug = createSlug($name);

//
// 1. CHECK DUPLICATE NAME
//
$stmt = $db->prepare("SELECT COUNT(*) FROM brands WHERE name = ?");
$stmt->execute([$name]);

if ($stmt->fetchColumn() > 0) {
    $_SESSION['error'] = "Brands name already exists!";
    adminRedirect('brands/create.php');
    exit;
}

//
// INSERT
//
$stmt = $db->prepare("INSERT INTO brands (name, slug) VALUES (?, ?)");
$stmt->execute([$name, $slug]);

$_SESSION['success'] = "Brands added successfully";

adminRedirect('brands');
exit;