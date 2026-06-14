<?php

require_once dirname(__DIR__, 2) . '/main.php';

if (empty($_SESSION['admin_id'])) {

    adminRedirect();
    exit;
}

$clientId = (int) ($_GET['id'] ?? 0);

if (!$clientId) {

    $_SESSION['error'] = 'Invalid Client';

    adminRedirect('api_clients/index.php');
}

try {

    $db = (new Config())->db();

    /*
    |--------------------------------------------------------------------------
    | Check Client
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare("
        SELECT id,name
        FROM api_clients
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->execute([$clientId]);

    $client = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$client) {

        $_SESSION['error'] = 'Client not found';

        adminRedirect('api_clients/index.php');
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Secure Token
    |--------------------------------------------------------------------------
    */

    $token = bin2hex(
        random_bytes(32)
    );

    /*
    |--------------------------------------------------------------------------
    | Expiry Date (1 Year)
    |--------------------------------------------------------------------------
    */

    $expiresAt = date(
        'Y-m-d H:i:s',
        strtotime('+1 year')
    );

    /*
    |--------------------------------------------------------------------------
    | Save Token
    |--------------------------------------------------------------------------
    */

    $insert = $db->prepare("
        INSERT INTO api_tokens
        (
            client_id,
            access_token,
            expires_at,
            status,
            created_at
        )
        VALUES
        (
            ?,
            ?,
            ?,
            1,
            NOW()
        )
    ");

    $insert->execute([
        $clientId,
        $token,
        $expiresAt
    ]);

    $_SESSION['success'] =
        'New API Token Generated Successfully';

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