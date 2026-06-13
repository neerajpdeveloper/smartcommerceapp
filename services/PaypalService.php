<?php

class PaypalService
extends PaymentGatewayService
implements PaymentGatewayInterface
{
    public function __construct()
    {
        parent::__construct('paypal');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESS TOKEN
    |--------------------------------------------------------------------------
    */

    private function getAccessToken()
    {
        $ch = curl_init();

        curl_setopt_array($ch,[

            CURLOPT_URL =>
                $this->baseUrl()
                . '/v1/oauth2/token',

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_USERPWD =>
                $this->gateway->client_id
                . ':'
                . $this->gateway->secret_key,

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

    /*
    |--------------------------------------------------------------------------
    | PAY
    |--------------------------------------------------------------------------
    */

public function pay($orderId)
{
    try {

        $orderModel = new Order();
        $order = $orderModel->getById($orderId);
        $currency_code = strtoupper($order->currency_code);
        $amount = $order->grand_total * $order->currency_rate;

        if (!$order) {
            ErrorHandler::log('PAYPAL_ERROR', "Order not found: {$orderId}");
            throw new Exception('Order not found.');
        }

        $token = $this->getAccessToken();

        if (!$token) {
            ErrorHandler::log('PAYPAL_ERROR', 'Access token missing');
            throw new Exception('PayPal authentication failed.');
        }

        $payload = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'reference_id' => $order->order_no,
                'amount' => [
                    'currency_code' => $currency_code,
                    'value' => number_format($amount, 2, '.', '')
                ]
            ]],
            'application_context' => [
                'return_url' => siteUrl() . '/paypal-success/' . $orderId,
                'cancel_url' => siteUrl() . '/paypal-cancel/' . $orderId
            ]
        ];

        $response = $this->curl(
            $this->baseUrl() . '/v2/checkout/orders',
            'POST',
            [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ],
            $payload
        );

        // 🔥 DEBUG LOG (VERY IMPORTANT)
        ErrorHandler::log('PAYPAL_RESPONSE', json_encode($response));

        // Validate response
        if (!is_array($response)) {
            ErrorHandler::log('PAYPAL_ERROR', 'Invalid API response');
            throw new Exception('Invalid PayPal response.');
        }

        if (empty($response['links'])) {
            ErrorHandler::log('PAYPAL_ERROR', json_encode($response));
            throw new Exception('PayPal Order Create Failed.');
        }

        // Redirect to approve link
        foreach ($response['links'] as $link) {
            if (isset($link['rel']) && $link['rel'] === 'approve') {
                header("Location: " . $link['href']);
                exit;
            }
        }

        ErrorHandler::log('PAYPAL_ERROR', 'Approve link missing: ' . json_encode($response));

        throw new Exception('PayPal approval link not found.');

    } catch (Throwable $e) {

        ErrorHandler::log('PAYPAL_EXCEPTION', $e->getMessage());

        // Optional: redirect or return error
        $_SESSION['error'] = $e->getMessage();

        header("Location: " . siteUrl() . "/checkout");
        exit;
    }
}

    /*
    |--------------------------------------------------------------------------
    | VERIFY PAYMENT
    |--------------------------------------------------------------------------
    */

    public function verify(
        $orderId,
        $request = []
    )
    {
        $paypalOrderId =
            $request['token'] ?? '';

        if (!$paypalOrderId) {

            return false;
        }

        $token =
            $this->getAccessToken();

        $response =
            $this->curl(

                $this->baseUrl()
                . '/v2/checkout/orders/'
                . $paypalOrderId
                . '/capture',

                'POST',

                [

                    'Content-Type: application/json',

                    'Authorization: Bearer '
                    . $token

                ]
            );

        if (
            isset($response['status'])
            &&
            $response['status']
            == 'COMPLETED'
        ) {

            $order =
                new Order();

            $order->markPaid(
                $orderId,
                $paypalOrderId
            );

            return true;
        }

        return false;
    }
}