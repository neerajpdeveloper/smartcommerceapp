<?php

// 💰 Get Currency Service (single instance)
function currencyService()
{
    static $service = null;

    if ($service === null) {
        $service = new CurrencyService();
    }

    return $service;
}

// 💱 Convert price helper
function price($amount)
{
    return currencyService()->symbol() . currencyService()->convert($amount);
}

// 📦 Get all currencies (MODEL WRAPPER)
function currencies()
{
    static $model = null;

    if ($model === null) {
        $model = new Currency();
    }

    return $model->getAll();
}

// 🎯 Get current currency
function current_currency()
{
    return currencyService()->getCurrency();
}
