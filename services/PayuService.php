<?php

class PayuService
extends PaymentGatewayService
implements PaymentGatewayInterface
{
    public function __construct()
    {
        parent::__construct('payu');
    }

    public function pay($orderId)
    {
        try {

            $order = (new Order())->getById($orderId);

            if (!$order) {
                throw new Exception('Order not found');
            }

            $txnid = $order->order_no;

            $amount = number_format(
                $order->grand_total,
                2,
                '.',
                ''
            );

            $productInfo = 'Order #' . $order->order_no;

            $firstname = user()['name'] ?? 'Customer';
            $email = user()['email'] ?? 'customer@test.com';

            $key  = $this->gateway->client_id;
            $salt = $this->gateway->secret_key;

            $successUrl =
                siteUrl() . '/payu-success/' . $orderId;

            $failureUrl =
                siteUrl() . '/payu-failure/' . $orderId;

            $hashString =
                $key . '|' .
                $txnid . '|' .
                $amount . '|' .
                $productInfo . '|' .
                $firstname . '|' .
                $email .
                '|||||||||||' .
                $salt;

            $hash = strtolower(
                hash('sha512', $hashString)
            );

            $action = $this->baseUrl();

            include VIEW_PATH . '/payments/payu.php';

        } catch (Throwable $e) {

            ErrorHandler::log(
                'PAYU_EXCEPTION',
                $e->getMessage()
            );

            $_SESSION['error'] = $e->getMessage();

            header(
                'Location:' .
                siteUrl() .
                '/checkout'
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

            if (
                empty($request['status'])
            ) {
                return false;
            }

            if (
                $request['status']
                !== 'success'
            ) {
                return false;
            }

            (new Order())->markPaid(
                $orderId,
                $request['mihpayid']
            );

            return true;

        } catch (Throwable $e) {

            ErrorHandler::log(
                'PAYU_VERIFY_EXCEPTION',
                $e->getMessage()
            );

            return false;
        }
    }
}