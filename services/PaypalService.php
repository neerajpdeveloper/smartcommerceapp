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
        $orderModel = new Order();

        $order =
            $orderModel->getById($orderId);

        if (!$order) {

            throw new Exception(
                'Order not found.'
            );
        }

        $token =
            $this->getAccessToken();

        $payload = [

            'intent' => 'CAPTURE',

            'purchase_units' => [[

                'reference_id' =>
                    $order->order_no,

                'amount' => [

                    'currency_code' =>
                        strtoupper(
                            $order->currency_code
                        ),

                    'value' =>
                        number_format(
                            $order->grand_total,
                            2,
                            '.',
                            ''
                        )
                ]
            ]],

            'application_context' => [

                'return_url' =>
                    siteUrl()
                    . '/paypal-success/'
                    . $orderId,

                'cancel_url' =>
                    siteUrl()
                    . '/paypal-cancel/'
                    . $orderId
            ]
        ];

        $response = $this->curl(

            $this->baseUrl()
            . '/v2/checkout/orders',

            'POST',

            [

                'Content-Type: application/json',

                'Authorization: Bearer '
                . $token

            ],

            $payload

        );

        if (!empty($response['links'])) {

            foreach (
                $response['links']
                as $link
            ) {

                if (
                    $link['rel']
                    == 'approve'
                ) {

                    header(
                        "Location: "
                        . $link['href']
                    );

                    exit;
                }
            }
        }

        throw new Exception(
            'PayPal Order Create Failed'
        );
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