<?php

class PayuController extends Controller
{
    public function success($orderId)
    {
        $gateway =
            PaymentFactory::make('payu');

        $result =
            $gateway->verify(
                $orderId,
                $_POST
            );

        if ($result) {

            (new Cart())->clear(
                user()['id']
            );

            header(
                "Location:" .
                siteUrl() .
                "/order-success/" .
                $orderId
            );

            exit;
        }

        die('Payment Verification Failed');
    }

    public function failure($orderId)
    {
        $_SESSION['error'] =
            'Payment Failed';

        header(
            "Location:" .
            siteUrl() .
            "/checkout"
        );

        exit;
    }
}