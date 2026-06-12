<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login | Smart Commerce Platform</title>

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
    overflow:hidden;
}

.login-wrapper{
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

.login-card{

    width:100%;
    max-width:460px;

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
    margin-bottom:30px;
}

.logo-box .logo{
    width:90px;
    height:90px;
    border-radius:50%;
    background:#0d6efd;
    color:#fff;

    display:flex;
    align-items:center;
    justify-content:center;

    margin:auto;

    font-size:38px;
}

.logo-box h2{
    margin-top:15px;
    font-weight:700;
}

.logo-box p{
    color:#ddd;
    margin-bottom:0;
}

.form-label{
    color:#fff;
    font-weight:500;
}

.form-control{
    height:55px;
    border:none;
    background:#fff;
    border-radius:12px;
}

.input-group-text{
    border:none;
    background:#fff;
}

.password-toggle{
    cursor:pointer;
}

.form-check-label{
    color:#ddd;
}

.forgot-link{
    color:#fff;
    text-decoration:none;
}

.forgot-link:hover{
    color:#ffc107;
}

.btn-login{

    height:55px;

    border:none;

    border-radius:12px;

    background:#0d6efd;

    font-size:18px;

    font-weight:600;

    transition:.3s;
}

.btn-login:hover{
    transform:translateY(-2px);
}

.footer-text{
    text-align:center;
    margin-top:25px;
    color:#ddd;
    font-size:13px;
}

.secure-box{
    text-align:center;
    margin-top:15px;
    color:#9cffb1;
    font-size:13px;
}

</style>

</head>
<body>

<div class="login-wrapper">

<div class="login-card">

<div class="logo-box">

<div class="logo">
<i class="fas fa-user-shield"></i>
</div>

<h2>Admin Login</h2>

<p>Smart Commerce Platform</p>

</div>

<form method="post" action="login.php">

<div class="mb-3">

<label class="form-label">
Email Address
</label>

<div class="input-group">

<span class="input-group-text">
<i class="fa fa-envelope"></i>
</span>

<input type="email"
name="email"
class="form-control"
placeholder="admin@example.com"
required>

</div>

</div>

<div class="mb-3">

<label class="form-label">
Password
</label>

<div class="input-group">

<span class="input-group-text">
<i class="fa fa-lock"></i>
</span>

<input type="password"
name="password"
id="password"
class="form-control"
placeholder="Enter Password"
required>

<span class="input-group-text password-toggle"
onclick="togglePassword()">

<i class="fa fa-eye" id="eyeIcon"></i>

</span>

</div>

</div>

<div class="d-flex justify-content-between mb-4">

<div class="form-check">

<input class="form-check-input"
type="checkbox"
name="remember_me">

<label class="form-check-label">
Remember Me
</label>

</div>

<a href="#" class="forgot-link">
Forgot Password?
</a>

</div>

<div class="d-grid">

<button type="submit"
class="btn btn-primary btn-login">

<i class="fa fa-sign-in-alt me-2"></i>

Login To Dashboard

</button>

</div>

</form>

<div class="secure-box">
🔒 Secure Admin Access
</div>

<div class="footer-text">
© <?php echo date('Y'); ?> Smart Commerce Platform
</div>

</div>

</div>

<script>

function togglePassword()
{
    let password =
    document.getElementById('password');

    let eye =
    document.getElementById('eyeIcon');

    if(password.type === 'password')
    {
        password.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    }
    else
    {
        password.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}

</script>

</body>
</html>