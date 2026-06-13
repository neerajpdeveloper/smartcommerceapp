<?php
class CurrencyService
{
    protected $currencyModel;

    public function __construct()
    {
        $this->currencyModel = new Currency();
    }

    // 📌 CURRENT SELECTED CURRENCY
    public function getCurrency()
    {
        if (!empty($_SESSION['currency'])) {
            return $_SESSION['currency'];
        }

        // fallback default DB currency
        $default = $this->currencyModel->getDefault();

        return [
            'code' => $default->code,
            'symbol' => $default->symbol,
            'rate' => $default->rate
        ];
    }

    // 💰 SET CURRENCY
    public function setCurrency($code)
    {
        $currency = $this->currencyModel->getByCode($code);

        if ($currency) {
            $_SESSION['currency'] = [
                'code' => $currency->code,
                'symbol' => $currency->symbol,
                'rate' => $currency->rate
            ];
        }
    }

    // 🔄 CONVERT PRICE
    public function convert($price)
    {
        $currency = $this->getCurrency();
        return round($price * $currency['rate'], 2);
    }

    // 💱 SYMBOL
    public function symbol()
    {
        return $this->getCurrency()['symbol'];
    }
}