<?php

class CheckoutController extends Controller
{
    public function index()
    {
        if (!isLoggedIn()) {

            header('Location: '.siteUrl().'/login');
            exit;
        }

        $cartModel = new Cart();
        $addressModel = new CustomerAddress();

        $userId = user()['id'];

        $data = [

            'cartItems' => $cartModel->getByUser($userId),

            'cartTotal' => $cartModel->totalAmount($userId),

            'addresses' => $addressModel->getByUser($userId)

        ];

        return $this->view('checkout', $data);
    }

    public function placeOrder()
{
    if (!isLoggedIn()) {

        header("Location: ".siteUrl()."/login");
        exit;
    }

    $addressId = (int)($_POST['address_id'] ?? 0);
    $paymentMethod = trim($_POST['payment_method'] ?? '');

    if (!$addressId || !$paymentMethod) {

        $_SESSION['error'] =
            'Please select address and payment method';

        header("Location: ".siteUrl()."/checkout");
        exit;
    }

    $cart = new Cart();

    $cartItems = $cart->getItems(user()['id']);

    if (empty($cartItems)) {

        $_SESSION['error'] = 'Cart is empty';

        header("Location: ".siteUrl()."/cart");
        exit;
    }

    $order = new Order();

    $orderId = $order->create(
        user()['id'],
        $addressId,
        $paymentMethod,
        $cartItems
    );

    switch ($paymentMethod) {

        case 'cod':

            $order->markPending($orderId);

            $cart->clear(user()['id']);

            header(
                "Location: "
                .siteUrl()
                ."/order-success/".$orderId
            );
            exit;

        case 'paypal':

            (new PaypalService())
                ->pay($orderId);

            exit;

        case 'razorpay':

            (new RazorpayService())
                ->pay($orderId);

            exit;

        case 'stripe':

            (new StripeService())
                ->pay($orderId);

            exit;
    }
}
}