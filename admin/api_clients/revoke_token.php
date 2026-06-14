<?php

require_once dirname(__DIR__, 2) . '/main.php';

if (empty($_SESSION['admin_id'])) {

    adminRedirect();
    exit;
}

$tokenId  = (int) ($_GET['id'] ?? 0);
$clientId = (int) ($_GET['client_id'] ?? 0);

if (!$tokenId || !$clientId) {

    $_SESSION['error'] = 'Invalid Request';

    adminRedirect('api_clients/index.php');
}

try {

    $db = (new Config())->db();

    /*
    |--------------------------------------------------------------------------
    | Check Token Exists
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare("
        SELECT id
        FROM api_tokens
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->execute([
        $tokenId
    ]);

    if (!$stmt->fetch()) {

        $_SESSION['error'] = 'Token not found';

        adminRedirect(
            'api_clients/tokens.php?id=' . $clientId
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Revoke Token
    |--------------------------------------------------------------------------
    */

    $update = $db->prepare("
        UPDATE api_tokens
        SET
            status = 0
        WHERE id = ?
    ");

    $update->execute([
        $tokenId
    ]);

    $_SESSION['success'] =
        'API Token Revoked Successfully';

    adminRedirect(
        'api_clients/tokens.php?id=' . $clientId
    );

} catch (Exception $e) {

    $_SESSION['error'] =
        $e->getMessage();

    adminRedirect(
        'api_clients/tokens.php?id=' . $clientId
    );
}