<?php

class CodService
extends PaymentGatewayService
implements PaymentGatewayInterface
{
    public function __construct()
    {
        parent::__construct('cod');
    }

    public function pay($orderId)
    {
        $order = new Order();

        $order->markPending(
            $orderId
        );

        (new Cart())
            ->clear(
                user()['id']
            );

        header(
            "Location: "
            .siteUrl()
            ."/order-success/"
            .$orderId
        );

        exit;
    }

    public function verify(
        $orderId,
        $request = []
    )
    {
        return true;
    }
}