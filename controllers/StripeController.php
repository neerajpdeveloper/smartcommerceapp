<?php

class StripeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SUCCESS
    |--------------------------------------------------------------------------
    */

    public function success($orderId)
    {
        $gateway = PaymentFactory::make('stripe');

        $result = $gateway->verify($orderId, $_GET);

        if ($result) {

            (new Cart())->clear(user()['id']);

            header(
                "Location: " . siteUrl() . "/order-success/" . $orderId
            );
            exit;
        }

        die("Stripe Payment Verification Failed");
    }

    /*
    |--------------------------------------------------------------------------
    | CANCEL
    |--------------------------------------------------------------------------
    */

    public function cancel($orderId)
    {
        $_SESSION['error'] = "Payment cancelled";

        header(
            "Location: " . siteUrl() . "/checkout"
        );
        exit;
    }
}