<?php

function adminRedirect($path = '')
{
    $url = rtrim(setting()->admin_url, '/').'/'.ltrim($path, '/');

    header('Location: '.$url);
    exit;
}


function adminUrl($path = '')
{
    return rtrim(setting()->admin_url,'/').'/'.ltrim($path,'/');
}

function createSlug($string)
{
    $slug = strtolower($string);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}



function adminflashMessage()
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