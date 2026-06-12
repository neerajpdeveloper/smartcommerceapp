<?php

require_once dirname(__DIR__, 2) . '/main.php';
require_once '../../helpers/admin_helper.php';

if (empty($_SESSION['admin_id'])) {
    adminRedirect();
    exit;
}

$db = (new Config())->db();

// YOUR API KEY
$apiKey = "6ad8e214dcc6c69b14b32118";

// API URL (IMPORTANT)
$url = "https://v6.exchangerate-api.com/v6/$apiKey/latest/INR";

// cURL request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// check response
if ($httpCode != 200 || !$response) {
    $_SESSION['error'] = "API request failed!";
    adminRedirect('currencies');
    exit;
}

$data = json_decode($response, true);

// IMPORTANT: API structure check
if (empty($data['conversion_rates'])) {
    $_SESSION['error'] = "Invalid API response!";
    adminRedirect('currencies');
    exit;
}

$rates = $data['conversion_rates'];

// update DB
$stmt = $db->prepare("
    UPDATE currencies 
    SET rate = ? 
    WHERE code = ?
");

foreach ($rates as $code => $rate) {
    $stmt->execute([$rate, $code]);
}

$_SESSION['success'] = "Currency rates updated successfully!";
adminRedirect('currencies');
exit;