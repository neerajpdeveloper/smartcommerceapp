<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<style>

body{
    margin:0;
    background:#f5f5f5;
    font-family:Arial;
}

.wrapper{
    width:100%;
    padding:40px 0;
}

.email-box{
    max-width:650px;
    margin:auto;
    background:#fff;
    padding:30px;
    border-radius:10px;
}

.footer{
    margin-top:20px;
    font-size:12px;
    color:#666;
}

</style>

</head>

<body>

<div class="wrapper">

<div class="email-box">

<?= $content ?>

<div class="footer">

© <?= date('Y') ?>

</div>

</div>

</div>

</body>
</html>