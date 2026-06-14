<?php

class RazorpayController extends Controller
{
    public function checkout($orderId)
    {
        $data = $_SESSION['razorpay_order'] ?? null;

        if (!$data || $data['order_id'] != $orderId) {
            die("Invalid session");
        }

            $gatewayModel = new Payment();
            $gateway = $gatewayModel->getGateway('razorpay');

        return $this->view('payments/checkout', [
            'orderId' => $orderId,
            'data' => $data,
            'gateway' => $gateway
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SUCCESS (AFTER PAYMENT)
    |--------------------------------------------------------------------------
    */

    public function success($orderId)
    {
        $gateway = PaymentFactory::make('razorpay');

        // Razorpay sends GET params OR POST (JS handler)
        $request = array_merge($_GET, $_POST);

        $result = $gateway->verify($orderId, $request);

        if ($result) {

            // Clear cart
            (new Cart())->clear(user()['id']);

            // Redirect to success page
            header(
                "Location: " . siteUrl() . "/order-success/" . $orderId
            );
            exit;

        }

        die('Razorpay Payment Verification Failed');
    }

    /*
    |--------------------------------------------------------------------------
    | CANCEL (USER CLOSED / FAILED)
    |--------------------------------------------------------------------------
    */

    public function cancel($orderId)
    {
        $_SESSION['error'] = 'Payment cancelled by user';

        header(
            "Location: " . siteUrl() . "/checkout"
        );
        exit;
    }
}