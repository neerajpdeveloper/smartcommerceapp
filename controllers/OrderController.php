<?php

class OrderController extends Controller
{
    public function orderSuccess($id = null)
    {
        if (!$id) {

            header("Location: ".siteUrl());
            exit;
        }

        $order = new Order();

        $data = [

            'order' => $order->getById($id)

        ];

        return $this->view(
            'order-success',
            $data
        );
    }
}