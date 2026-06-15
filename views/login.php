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

.social-login{
    margin-top:25px;
}

.divider{
    text-align:center;
    position:relative;
    margin-bottom:20px;
}

.divider::before{
    content:'';
    position:absolute;
    top:50%;
    left:0;
    width:100%;
    height:1px;
    background:#e5e7eb;
}

.divider span{
    background:#fff;
    padding:0 15px;
    position:relative;
    color:#6b7280;
    font-size:14px;
}

.social-buttons{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.social-btn{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:12px;
    padding:14px 18px;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
    transition:all .3s ease;
}

.google-btn{
    background:#fff;
    border:1px solid #e5e7eb;
    color:#111827;
}

.google-btn:hover{
    background:#f9fafb;
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.facebook-btn{
    background:#1877f2;
    color:#fff;
    border:1px solid #1877f2;
}

.facebook-btn:hover{
    background:#1666d8;
    color:#fff;
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(24,119,242,.25);
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

        <div class="social-login">

    <div class="divider">
        <span>Or continue with</span>
    </div>

    <div class="social-buttons">

        <a href="<?= siteUrl() ?>/google-login"
           class="social-btn google-btn">

            <svg width="20" height="20" viewBox="0 0 48 48">
                <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.6 32.7 29.2 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3 0 5.7 1.1 7.8 3l5.7-5.7C34.1 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.4-.4-3.5z"/>
                <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15 19 12 24 12c3 0 5.7 1.1 7.8 3l5.7-5.7C34.1 6.1 29.3 4 24 4 16.3 4 9.6 8.3 6.3 14.7z"/>
                <path fill="#4CAF50" d="M24 44c5.2 0 10-2 13.5-5.2l-6.2-5.2c-2 1.5-4.5 2.4-7.3 2.4-5.2 0-9.6-3.3-11.2-8l-6.5 5C9.5 39.6 16.2 44 24 44z"/>
                <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-1.1 3.2-3.3 5.7-6 7.3l6.2 5.2C39.1 37.2 44 31.2 44 24c0-1.3-.1-2.4-.4-3.5z"/>
            </svg>

            <span>Continue with Google</span>

        </a>

        <a href="<?= siteUrl() ?>/facebook-login"
           class="social-btn facebook-btn">

            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                <path d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.09 0 2.24.2 2.24.2v2.46H15.2c-1.24 0-1.63.77-1.63 1.56V12h2.77l-.44 2.89h-2.33v6.99A10 10 0 0 0 22 12z"/>
            </svg>

            <span>Continue with Facebook</span>

        </a>

    </div>

</div>

        <div class="footer-text">
            Don't have an account?
            <a href="<?=siteUrl()?>/register">Register</a>
        </div>

    </div>

</div>