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