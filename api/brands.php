<?php

require '../main.php';

$auth = new ApiAuth();

$auth->authenticate();

$auth->permission(
    'brands'
);

$db = (new Config())->db();

$data = $db->query("
SELECT *
FROM brands
")->fetchAll(PDO::FETCH_ASSOC);

$auth->log(
    '/api/brands',
    'GET',
    200
);

echo json_encode([
    'success' => true,
    'data' => $data
]);