<?php

interface PaymentGatewayInterface
{
    public function pay($orderId);

    public function verify($orderId, $request = []);
}