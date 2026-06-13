<?php

class RazorpayService
extends PaymentGatewayService
implements PaymentGatewayInterface
{
    public function __construct()
    {
        parent::__construct('razorpay');
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE ORDER (RAZORPAY)
    |--------------------------------------------------------------------------
    */

    public function pay($orderId)
    {
        try {

            $orderModel = new Order();
            $order = $orderModel->getById($orderId);

            if (!$order) {
                ErrorHandler::log('RAZORPAY_ERROR', "Order not found: {$orderId}");
                throw new Exception('Order not found.');
            }

            // ALWAYS convert to INR first
            $baseAmountINR = $order->grand_total;

            // Razorpay needs paise
            $amount = (int) round($baseAmountINR * 100);

            $payload = [
                'receipt' => $order->order_no,
                'amount' => $amount,
                'currency' => 'INR',
                'payment_capture' => 1
            ];

            // Basic Auth (key_id:secret)
            $auth = base64_encode(
                $this->gateway->client_id . ':' . $this->gateway->secret_key
            );

            $response = $this->curl(
                $this->baseUrl() . '/v1/orders',
                'POST',
                [
                    'Content-Type: application/json',
                    'Authorization: Basic ' . $auth
                ],
                $payload
            );

            ErrorHandler::log('RAZORPAY_RESPONSE', json_encode($response));

            if (!is_array($response) || empty($response['id'])) {
                throw new Exception('Razorpay order creation failed.');
            }

            // Redirect to checkout page (frontend handle karega)
            $_SESSION['razorpay_order'] = [
                'order_id' => $orderId,
                'razorpay_order_id' => $response['id'],
                'amount' => $amount,
                'currency' => 'INR'
            ];

            header("Location: " . siteUrl() . "/razorpay-checkout/" . $orderId);
            exit;

        } catch (Throwable $e) {

            ErrorHandler::log('RAZORPAY_EXCEPTION', $e->getMessage());

            $_SESSION['error'] = $e->getMessage();

            header("Location: " . siteUrl() . "/checkout");
            exit;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFY PAYMENT
    |--------------------------------------------------------------------------
    */

    public function verify($orderId, $request = [])
    {
        try {

            $razorpay_payment_id = $request['razorpay_payment_id'] ?? null;
            $razorpay_order_id   = $request['razorpay_order_id'] ?? null;
            $razorpay_signature   = $request['razorpay_signature'] ?? null;

            if (!$razorpay_payment_id || !$razorpay_order_id || !$razorpay_signature) {
                return false;
            }

            // Signature verification
            $generated_signature = hash_hmac(
                'sha256',
                $razorpay_order_id . '|' . $razorpay_payment_id,
                $this->gateway->secret_key
            );

            if ($generated_signature !== $razorpay_signature) {
                ErrorHandler::log('RAZORPAY_ERROR', 'Signature mismatch');
                return false;
            }

            // Mark order paid
            $order = new Order();

            $order->markPaid(
                $orderId,
                $razorpay_payment_id
            );

            return true;

        } catch (Throwable $e) {

            ErrorHandler::log('RAZORPAY_VERIFY_EXCEPTION', $e->getMessage());

            return false;
        }
    }
}