<?php

require '../main.php';

$auth = new ApiAuth();

$client = $auth->authenticate();

$auth->permission(
    'products'
);

$db = (new Config())->db();

$products = $db->query("
SELECT *
FROM products
")->fetchAll(PDO::FETCH_ASSOC);

$auth->log(
    '/api/products',
    'GET',
    200
);

echo json_encode([
    'success' => true,
    'data' => $products
]);