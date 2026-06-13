<?php

class PaypalService
{
    protected $gateway;

    public function __construct()
    {
        $payment = new Payment();

        $this->gateway =
            $payment->getGateway('paypal');

        if(!$this->gateway){
            throw new Exception(
                'PayPal configuration not found.'
            );
        }
    }

    private function baseUrl()
    {
        return $this->gateway->mode == 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';
    }

    public function getAccessToken()
    {
        $ch = curl_init();

        curl_setopt_array($ch,[

            CURLOPT_URL =>
                $this->baseUrl().
                '/v1/oauth2/token',

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_USERPWD =>
                $this->gateway->client_id .
                ':' .
                $this->gateway->secret_key,

            CURLOPT_POST => true,

            CURLOPT_POSTFIELDS =>
                'grant_type=client_credentials'
        ]);

        $response = json_decode(
            curl_exec($ch),
            true
        );

        curl_close($ch);

        return $response['access_token'];
    }
}