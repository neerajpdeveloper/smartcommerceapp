<?php
require_once dirname(__DIR__, 2) . '/main.php';

if (empty($_SESSION['admin_id'])) {
    adminRedirect();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    adminSetFlashMessage(
        'error',
        'Invalid Request'
    );
      $_SESSION['error'] = 'Invalid Request';
    

    adminRedirect('api_clients/index.php');
}

$id = (int) ($_POST['id'] ?? 0);

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$company_name = trim($_POST['company_name'] ?? '');
$status = (int) ($_POST['status'] ?? 0);

if (
    empty($id) ||
    empty($name) ||
    empty($email)
) {

     $_SESSION['error'] = 'Name and Email are required';

    adminRedirect(
        'api_clients/edit.php?id=' . $id
    );
}

try {

    $db = (new Config())->db();

    /*
    |--------------------------------------------------------------------------
    | Check Email Exists
    |--------------------------------------------------------------------------
    */

    $check = $db->prepare("
        SELECT id
        FROM api_clients
        WHERE email = ?
        AND id != ?
        LIMIT 1
    ");

    $check->execute([
        $email,
        $id
    ]);

    if ($check->fetch()) {

         $_SESSION['error'] = 'Email already exists';

        adminRedirect(
            'api_clients/edit.php?id=' . $id
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update Client
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare("
        UPDATE api_clients
        SET
            name = ?,
            email = ?,
            company_name = ?,
            status = ?,
            updated_at = NOW()
        WHERE id = ?
    ");

    $stmt->execute([
        $name,
        $email,
        $company_name,
        $status,
        $id
    ]);


     $_SESSION['success'] = 'API Client Updated Successfully';

    adminRedirect('api_clients/index.php');

} catch (Exception $e) {

$_SESSION['success'] = $e->getMessage();
 

    adminRedirect(
        'api_clients/edit.php?id=' . $id
    );
}