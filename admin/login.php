<?php

require_once '../main.php';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    adminRedirect();
    exit;
}

$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

if(empty($email) || empty($password))
{
    $_SESSION['error'] = 'Email and Password are required.';
    adminRedirect();
    exit;
}

/*
|--------------------------------------------------------------------------
| Check User
|--------------------------------------------------------------------------
*/

$stmt = (new Config())->db()->prepare("
    SELECT *
    FROM admin_users
    WHERE email = ?
    AND status = 1
    LIMIT 1
");

$stmt->execute([$email]);

$admin = $stmt->fetch(PDO::FETCH_OBJ);

if(!$admin)
{
    $_SESSION['error'] = 'Invalid Email Address';
 adminRedirect();
    exit;
}

/*
|--------------------------------------------------------------------------
| Verify Password
|--------------------------------------------------------------------------
*/

if(!password_verify($password, $admin->password))
{
    $_SESSION['error'] = 'Invalid Password';
   adminRedirect();
    exit;
}

/*
|--------------------------------------------------------------------------
| Create Session
|--------------------------------------------------------------------------
*/

$_SESSION['admin_id']    = $admin->id;
$_SESSION['admin_name']  = $admin->name;
$_SESSION['admin_email'] = $admin->email;
$_SESSION['admin_role']  = $admin->role;

/*
|--------------------------------------------------------------------------
| Redirect Dashboard
|--------------------------------------------------------------------------
*/
adminRedirect('dashboard');
exit;

?>