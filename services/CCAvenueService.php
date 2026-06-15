<?php

class CCAvenueService
extends PaymentGatewayService
implements PaymentGatewayInterface
{
    public function __construct()
    {
        parent::__construct('ccavenue');
    }

    protected function paymentUrl()
    {
        return $this->baseUrl();
    }

    public function pay($orderId)
    {
        try {

            $order = (new Order())->getById($orderId);

            if (!$order) {
                throw new Exception('Order not found');
            }

            $merchantData = [

                'merchant_id' =>
                    $this->gateway->client_id,

                'order_id' =>
                    $order->order_no,

                'currency' =>
                    strtoupper('INR'),

                'amount' =>
                    number_format(
                        $order->grand_total,
                        2,
                        '.',
                        ''
                    ),

                'redirect_url' =>
                    siteUrl() . '/ccavenue-success/' . $orderId,

                'cancel_url' =>
                    siteUrl() . '/ccavenue-cancel/' . $orderId,

                'language' =>
                    'EN',

                'billing_name' =>
                    user()['name'] ?? 'Customer',

                'billing_email' =>
                    user()['email'] ?? '',

                'billing_tel' =>
                    user()['phone'] ?? ''
            ];

            $query = http_build_query($merchantData);

            $encryptedRequest =
                CCAvenueCrypto::encrypt(
                    $query,
                    $this->gateway->secret_key
                );

            include dirname(__DIR__) .'/views/payments/ccavenue.php';

        } catch (Throwable $e) {

            ErrorHandler::log(
                'CCAVENUE_EXCEPTION',
                $e->getMessage()
            );

            $_SESSION['error'] =
                $e->getMessage();

            header(
                "Location:" .
                siteUrl() .
                "/checkout"
            );

            exit;
        }
    }

    public function verify(
        $orderId,
        $request = []
    )
    {
        try {

            $encResp =
                $request['encResp']
                ?? '';

            if (!$encResp) {
                return false;
            }

            $response =
                CCAvenueCrypto::decrypt(
                    $encResp,
                    $this->gateway->secret_key
                );

            parse_str(
                $response,
                $data
            );

            ErrorHandler::log(
                'CCAVENUE_RESPONSE',
                json_encode($data)
            );

            if (
                isset($data['order_status'])
                &&
                $data['order_status']
                === 'Success'
            ) {

                (new Order())->markPaid(
                    $orderId,
                    $data['tracking_id']
                    ?? null
                );

                return true;
            }

            return false;

        } catch (Throwable $e) {

            ErrorHandler::log(
                'CCAVENUE_VERIFY_EXCEPTION',
                $e->getMessage()
            );

            return false;
        }
    }
}