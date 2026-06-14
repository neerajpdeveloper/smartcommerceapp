<?php

require_once dirname(__DIR__, 2) . '/main.php';

if (empty($_SESSION['admin_id'])) {

    adminRedirect();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    $_SESSION['error'] = 'Invalid Request';

    adminRedirect('api_clients/index.php');
}

$clientId = (int) ($_POST['client_id'] ?? 0);

$permissions = $_POST['permissions'] ?? [];

if (!$clientId) {

    $_SESSION['error'] = 'Invalid Client';

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

    $check->execute([$clientId]);

    if (!$check->fetch()) {

        $_SESSION['error'] = 'Client not found';

        adminRedirect('api_clients/index.php');
    }

    /*
    |--------------------------------------------------------------------------
    | Remove Old Permissions
    |--------------------------------------------------------------------------
    */

    $delete = $db->prepare("
        DELETE FROM api_client_permissions
        WHERE client_id = ?
    ");

    $delete->execute([$clientId]);

    /*
    |--------------------------------------------------------------------------
    | Insert New Permissions
    |--------------------------------------------------------------------------
    */

    if (!empty($permissions)) {

        $insert = $db->prepare("
            INSERT INTO api_client_permissions
            (
                client_id,
                permission_id,
                created_at
            )
            VALUES
            (
                ?,
                ?,
                NOW()
            )
        ");

        foreach ($permissions as $permissionId) {

            $insert->execute([
                $clientId,
                (int)$permissionId
            ]);
        }
    }

    $_SESSION['success'] =
        'Permissions Updated Successfully';

    adminRedirect(
        'api_clients/permissions.php?id=' . $clientId
    );

} catch (Exception $e) {

    $_SESSION['error'] =
        $e->getMessage();

    adminRedirect(
        'api_clients/permissions.php?id=' . $clientId
    );
}