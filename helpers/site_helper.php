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

