<?php

function auth()
{
    return $_SESSION['user'] ?? null;
}

function isLoggedIn()
{
    return !empty($_SESSION['user']);
}

function user()
{
    return $_SESSION['user'] ?? null;
}

function defaultAddress()
{
    static $model = null;

    if ($model === null) {
        $model = new CustomerAddress();
    }

    return $model->getDefault(
        user()['id']
    );
}