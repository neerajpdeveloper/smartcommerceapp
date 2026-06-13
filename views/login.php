<style>
body{
    background:#f4f6f9;
    font-family:Arial, sans-serif;
}

.auth-wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.auth-card{
    width:380px;
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 5px 25px rgba(0,0,0,0.1);
}

.auth-card h2{
    text-align:center;
    margin-bottom:20px;
}

.form-group{
    margin-bottom:15px;
}

.form-group input{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
    outline:none;
    transition:0.3s;
}

.form-group input:focus{
    border-color:#000;
}

.btn{
    width:100%;
    padding:12px;
    background:#000;
    color:#fff;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:15px;
}

.btn:hover{
    background:#333;
}

.footer-text{
    text-align:center;
    margin-top:15px;
    font-size:13px;
}

.footer-text a{
    color:#000;
    text-decoration:none;
}

.error{
    color:red;
    font-size:13px;
    margin-bottom:10px;
}
</style>

<div class="auth-wrapper">

    <div class="auth-card">

        <h2>Welcome Back</h2>

        <form method="POST" action="<?=siteUrl()?>/login-post">

            <div class="form-group">
                <input type="email" name="email" placeholder="Email Address" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button class="btn" type="submit">Login</button>

        </form>

        <div class="footer-text">
            Don't have an account?
            <a href="<?=siteUrl()?>/register">Register</a>
        </div>

    </div>

</div>