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

    $cartItems = $cart->getByUser(user()['id']);

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

        try {

            $gateway =
                PaymentFactory::make(
                    $paymentMethod
                );

            $gateway->pay($orderId);

        } catch (Exception $e) {

            $_SESSION['error'] =
                $e->getMessage();

            header(
                "Location: "
                .siteUrl()
                ."/checkout"
            );

            exit;
        }
}
}