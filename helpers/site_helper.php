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

function checkAuth(){
    if(!isset($_SESSION['user_id'])){
        header("Location:".setting()->site_url);
        exit;
    }
}