<?php

require '../main.php';

$auth = new ApiAuth();

$auth->authenticate();

$auth->permission(
    'categories'
);

$db = (new Config())->db();

$data = $db->query("
SELECT *
FROM categories
")->fetchAll(PDO::FETCH_ASSOC);

$auth->log(
    '/api/categories',
    'GET',
    200
);

echo json_encode([
    'success' => true,
    'data' => $data
]);