<?php
class StripeService extends PaymentGatewayService implements PaymentGatewayInterface
{
    public function __construct()
    {
        parent::__construct('stripe');
    }

    private function key()
    {
        return $this->gateway->secret_key;
    }

public function pay($orderId)
{
    $order = (new Order())->getById($orderId);

    if (!$order) {
        throw new Exception("Order not found");
    }

    $amount = (int) round($order->grand_total*100);
    $currency = strtolower($order->currency_code);

    // 1. Keep the clean, nested array structure
    $payload = [
        "success_url" => siteUrl() . "/stripe-success/$orderId?session_id={CHECKOUT_SESSION_ID}",
        "cancel_url"  => siteUrl() . "/stripe-cancel/$orderId",
        "mode"        => "payment",
        "payment_method_types" => ["card"],
        "line_items" => [
            [
                "quantity"   => 1,
                "price_data" => [
                    "currency"     => strtolower('INR'),
                    "unit_amount"  => $amount,
                    "product_data" => [
                        "name" => "Order #{$order->order_no}"
                    ]
                ]
            ]
        ]
    ];
    // 2. Send it using x-www-form-urlencoded
   $response = $this->curl(
    $this->baseUrl() . "/v1/checkout/sessions",
    "POST",
    [
        "Authorization: Bearer " . $this->key(),
        "Content-Type: application/x-www-form-urlencoded"
    ],
    $payload,
    'form'
);

    $result = is_string($response) ? json_decode($response, true) : $response;
    
    if (!isset($result['url'])) {
        $msg = $result['error']['message'] ?? 'Unknown error';
        throw new Exception("Stripe session failed: " . $msg);
    }

    header("Location: " . $result['url']);
    exit;
}

    public function verify($orderId, $request = [])
    {
        $session_id = $request['session_id'] ?? null;
        if (!$session_id) return false;

        $response = $this->curl(
            $this->baseUrl() . "/v1/checkout/sessions/$session_id",
            "GET",
            ["Authorization: Bearer " . $this->key()]
        );

        $session = is_string($response) ? json_decode($response, true) : $response;

        if (($session['payment_status'] ?? '') === 'paid') {
            (new Order())->markPaid($orderId, $session_id);
            return true;
        }

        return false;
    }
}