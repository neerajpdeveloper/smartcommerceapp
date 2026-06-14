<?php

require_once dirname(__DIR__, 2) . '/main.php';

if (empty($_SESSION['admin_id'])) {
    adminRedirect();
    exit;
}

$id = (int) ($_GET['id'] ?? 0);

if (empty($id)) {

    $_SESSION['error'] = 'Invalid Client ID';

    adminRedirect('api_clients/index.php');
}

try {

    $db = (new Config())->db();

    /*
    |--------------------------------------------------------------------------
    | Check Client Exists
    |--------------------------------------------------------------------------
    */

    $check = $db->prepare("
        SELECT id
        FROM api_clients
        WHERE id = ?
        LIMIT 1
    ");

    $check->execute([$id]);

    if (!$check->fetch()) {

        $_SESSION['error'] = 'Client not found';

        adminRedirect('api_clients/index.php');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Client Permissions
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare("
        DELETE FROM api_client_permissions
        WHERE client_id = ?
    ");

    $stmt->execute([$id]);

    /*
    |--------------------------------------------------------------------------
    | Delete Client Tokens
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare("
        DELETE FROM api_tokens
        WHERE client_id = ?
    ");

    $stmt->execute([$id]);

    /*
    |--------------------------------------------------------------------------
    | Delete Client Logs
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare("
        DELETE FROM api_logs
        WHERE client_id = ?
    ");

    $stmt->execute([$id]);

    /*
    |--------------------------------------------------------------------------
    | Delete Client
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare("
        DELETE FROM api_clients
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    $_SESSION['success'] =
        'API Client Deleted Successfully';

    adminRedirect('api_clients/index.php');

} catch (Exception $e) {

    $_SESSION['error'] =
        $e->getMessage();

    adminRedirect('api_clients/index.php');
}