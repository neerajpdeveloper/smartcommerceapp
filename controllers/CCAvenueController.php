<?php

class CCAvenueController
extends Controller
{
    public function success($orderId)
    {
        $gateway =
            PaymentFactory::make(
                'ccavenue'
            );

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

        die(
            'CCAvenue verification failed'
        );
    }

    public function cancel($orderId)
    {
        $_SESSION['error'] =
            'Payment cancelled';

        header(
            "Location:" .
            siteUrl() .
            "/checkout"
        );

        exit;
    }
}