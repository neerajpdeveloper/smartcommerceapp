<?php

class PaymentFactory
{
    public static function make($gateway)
    {
        $gateway = strtolower($gateway);

        return match ($gateway) {
            'paypal'   => new PaypalService(),
            'stripe'   => new StripeService(),
            'razorpay' => new RazorpayService(),
            'cod'      => new CodService(),
            default     => throw new \Exception('Invalid Payment Gateway')
        };
    }
}