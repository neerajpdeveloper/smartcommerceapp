<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<title><?= $page_title ?> | Admin Panel</title>

<link rel="stylesheet" href="<?=adminUrl()?>assets/css/admin.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="admin-wrapper">

<header class="topbar">

    <div class="logo">
        Smart Commerce
    </div>

    <div class="admin-info">

        Welcome,
        <?= $_SESSION['admin_name'] ?>

        <a href="<?=adminUrl()?>logout.php" class="logout-btn">
            Logout
        </a>

    </div>

</header>