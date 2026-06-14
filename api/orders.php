<?php

require '../main.php';

$auth = new ApiAuth();

$auth->authenticate();

$auth->permission(
    'orders'
);

$db = (new Config())->db();

$orders = $db->query("
SELECT *
FROM orders
ORDER BY id DESC
")->fetchAll(PDO::FETCH_ASSOC);

$auth->log(
    '/api/orders',
    'GET',
    200
);

echo json_encode([
    'success' => true,
    'data' => $orders
]);