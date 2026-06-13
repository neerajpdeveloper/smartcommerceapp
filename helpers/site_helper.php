<?php

if (!function_exists('setting'))
{
    function setting()
    {
        static $setting = null;

        if ($setting === null)
        {
            $settingModel = new Setting();
            $setting = $settingModel->get();
        }

        return $setting;
    }
}

function siteUrl(){
     return setting()->site_url;
}

function checkAuth(){
    if(!isset($_SESSION['user_id'])){
        header("Location:".setting()->site_url);
        exit;
    }
}


function cartCount()
{
    if (!isLoggedIn()) {
        return 0;
    }

    static $cart = null;

    if ($cart === null) {
        $cart = new Cart();
    }

    return $cart->totalQty(user()['id']);
}

function flashMessage()
{
    if (!empty($_SESSION['error'])) {
        echo '<div class="alert alert-danger">'
            . $_SESSION['error'] .
        '</div>';
        unset($_SESSION['error']);
    }

    if (!empty($_SESSION['success'])) {
        echo '<div class="alert alert-success">'
            . $_SESSION['success'] .
        '</div>';
        unset($_SESSION['success']);
    }
}

