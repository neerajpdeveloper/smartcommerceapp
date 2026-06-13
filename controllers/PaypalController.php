<?php

class PaypalController extends Controller
{
    public function success($orderId)
    {
        $gateway = PaymentFactory::make('paypal');

        $result = $gateway->verify(
            $orderId,
            $_GET
        );

        if($result){

            (new Cart())->clear(
                user()['id']
            );

            header(
                "Location:"
                .siteUrl()
                ."/order-success/"
                .$orderId
            );

            exit;
        }

        die('Payment Verification Failed');
    }

    public function cancel($orderId)
    {
        $_SESSION['error'] =
            'Payment cancelled';

        header(
            "Location:"
            .siteUrl()
            ."/checkout"
        );

        exit;
    }
}