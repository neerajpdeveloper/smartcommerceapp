<?php

abstract class PaymentGatewayService
{
    protected $gateway;

    public function __construct($code)
    {
        $payment = new Payment();

        $this->gateway = $payment->getGateway($code);

        if (!$this->gateway) {

            throw new Exception(
                ucfirst($code) . ' configuration not found.'
            );
        }
    }

   protected function baseUrl()
    {
        switch ($this->gateway->code) {

            case 'paypal':
                return $this->gateway->mode == 'live'
                    ? 'https://api-m.paypal.com'
                    : 'https://api-m.sandbox.paypal.com';

            case 'razorpay':
                return 'https://api.razorpay.com';

            case 'stripe':
                return 'https://api.stripe.com';

            case 'payu':
                return $this->gateway->mode == 'live'
                    ? 'https://secure.payu.in/_payment'
                    : 'https://test.payu.in/_payment';

             case 'ccavenue':
                return $this->gateway->mode == 'live'
            ? 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction'
            : 'https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction';

            default:
                throw new Exception("Unsupported gateway");
        }
    }

    protected function curl($url, $method = 'GET', $headers = [], $payload = null,$type = null)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [

            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,

        ]);

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if ($payload) {
        if ($type === 'form') {
            // Stripe case
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        } else {
            // Razorpay + PayPal case
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        }
        }

        $response = curl_exec($ch);

     

        curl_close($ch);

        return json_decode($response, true);
    }
}