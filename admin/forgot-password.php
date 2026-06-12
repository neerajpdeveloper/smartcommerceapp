<?php require_once '../main.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Forgot Password | Smart Commerce Platform</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI',sans-serif;
    min-height:100vh;
}

.forgot-wrapper{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;

    background:
    linear-gradient(rgba(0,0,0,.55),rgba(0,0,0,.55)),
    url('https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=1600&q=80');

    background-size:cover;
    background-position:center;
}

.forgot-card{

    width:100%;
    max-width:500px;

    background:rgba(255,255,255,.12);

    backdrop-filter:blur(18px);

    border:1px solid rgba(255,255,255,.15);

    border-radius:25px;

    padding:40px;

    box-shadow:0 15px 45px rgba(0,0,0,.35);

    color:#fff;
}

.logo-box{
    text-align:center;
    margin-bottom:25px;
}

.logo{
    width:90px;
    height:90px;
    border-radius:50%;
    background:#ffc107;

    display:flex;
    align-items:center;
    justify-content:center;

    margin:auto;

    font-size:35px;
    color:#000;
}

.logo-box h2{
    margin-top:15px;
    font-weight:700;
}

.logo-box p{
    color:#ddd;
}

.form-label{
    color:#fff;
    font-weight:500;
}

.form-control{
    height:55px;
    border:none;
    border-radius:12px;
}

.input-group-text{
    border:none;
    background:#fff;
}

.btn-submit{

    height:55px;

    border:none;

    border-radius:12px;

    background:#0d6efd;

    color:#fff;

    font-size:17px;

    font-weight:600;
}

.btn-submit:hover{
    opacity:.9;
}

.back-link{
    color:#fff;
    text-decoration:none;
}

.back-link:hover{
    color:#ffc107;
}

.footer-text{
    text-align:center;
    margin-top:25px;
    color:#ddd;
    font-size:13px;
}

.info-box{
    background:rgba(255,255,255,.08);
    border-radius:12px;
    padding:12px;
    color:#ddd;
    font-size:14px;
    margin-bottom:20px;
}

</style>

</head>
<body>

<div class="forgot-wrapper">

<div class="forgot-card">

<div class="logo-box">

<div class="logo">
<i class="fas fa-key"></i>
</div>

<h2>Forgot Password</h2>

<p>Reset your admin account password</p>

</div>

<?php adminflashMessage(); ?>

<div class="info-box">
    Enter your registered admin email address. We will send you a password reset link.
</div>

<form method="post" action="<?= adminUrl('send-reset-link.php') ?>">

<div class="mb-4">

<label class="form-label">
Email Address
</label>

<div class="input-group">

<span class="input-group-text">
<i class="fa fa-envelope"></i>
</span>

<input
type="email"
name="email"
class="form-control"
placeholder="admin@example.com"
required>

</div>

</div>

<div class="d-grid">

<button type="submit" class="btn-submit">

<i class="fa fa-paper-plane me-2"></i>

Send Reset Link

</button>

</div>

</form>

<div class="text-center mt-4">

<a href="<?= adminUrl() ?>" class="back-link">
<i class="fa fa-arrow-left me-1"></i>
Back To Login
</a>

</div>

<div class="footer-text">
© <?= date('Y') ?> Smart Commerce Platform
</div>

</div>

</div>

</body>
</html>