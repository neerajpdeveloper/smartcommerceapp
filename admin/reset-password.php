<?php

require_once '../main.php';

$token = $_GET['token'] ?? '';

if(empty($token))
{
    $_SESSION['error'] = 'Invalid Reset Link';
    adminRedirect('forgot-password.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reset Password | Smart Commerce Platform</title>

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

.reset-wrapper{
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

.reset-card{

    width:100%;
    max-width:520px;

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

    background:#28a745;

    display:flex;
    align-items:center;
    justify-content:center;

    margin:auto;

    font-size:35px;
    color:#fff;
}

.logo-box h2{
    margin-top:15px;
    font-weight:700;
}

.logo-box p{
    color:#ddd;
}

.info-box{

    background:rgba(255,255,255,.08);

    padding:12px 15px;

    border-radius:12px;

    margin-bottom:25px;

    color:#ddd;

    font-size:14px;
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

.password-toggle{
    cursor:pointer;
}

.btn-reset{

    height:55px;

    border:none;

    border-radius:12px;

    background:#28a745;

    color:#fff;

    font-size:18px;

    font-weight:600;

    transition:.3s;
}

.btn-reset:hover{
    transform:translateY(-2px);
}

.footer-text{
    text-align:center;
    margin-top:25px;
    color:#ddd;
    font-size:13px;
}

.back-link{
    color:#fff;
    text-decoration:none;
}

.back-link:hover{
    color:#ffc107;
}

</style>

</head>

<body>

<div class="reset-wrapper">

<div class="reset-card">

<div class="logo-box">

<div class="logo">
<i class="fas fa-lock"></i>
</div>

<h2>Reset Password</h2>

<p>Create a new secure password</p>

</div>

<?php adminflashMessage(); ?>

<div class="info-box">
    Your new password should be strong and different from previously used passwords.
</div>

<form method="post" action="<?= adminUrl('update-password.php') ?>">

<input
type="hidden"
name="token"
value="<?= htmlspecialchars($token) ?>"
>

<div class="mb-3">

<label class="form-label">
New Password
</label>

<div class="input-group">

<span class="input-group-text">
<i class="fa fa-lock"></i>
</span>

<input
type="password"
name="password"
id="password"
class="form-control"
placeholder="Enter New Password"
required>

<span
class="input-group-text password-toggle"
onclick="togglePassword('password','eye1')">

<i class="fa fa-eye" id="eye1"></i>

</span>

</div>

</div>

<div class="mb-4">

<label class="form-label">
Confirm Password
</label>

<div class="input-group">

<span class="input-group-text">
<i class="fa fa-shield-alt"></i>
</span>

<input
type="password"
name="confirm_password"
id="confirm_password"
class="form-control"
placeholder="Confirm Password"
required>

<span
class="input-group-text password-toggle"
onclick="togglePassword('confirm_password','eye2')">

<i class="fa fa-eye" id="eye2"></i>

</span>

</div>

</div>

<div class="d-grid">

<button
type="submit"
class="btn btn-reset">

<i class="fa fa-key me-2"></i>

Reset Password

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

<script>

function togglePassword(fieldId, iconId)
{
    let field = document.getElementById(fieldId);
    let icon  = document.getElementById(iconId);

    if(field.type === 'password')
    {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
    else
    {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

</script>

</body>
</html>