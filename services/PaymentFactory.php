<?php

class PaymentFactory
{
    public static function make($gateway)
    {
        switch($gateway){

            case 'paypal':
                return new PaypalService();

            case 'stripe':
                return new StripeService();

            case 'razorpay':
                return new RazorpayService();

            case 'cod':
                return new CodService();

            default:

                throw new Exception(
                    'Invalid Payment Gateway'
                );
        }
    }
}