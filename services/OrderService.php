<?php
class OrderService
{
    protected $orderModel;

    public function __construct($orderModel)
    {
        $this->orderModel = $orderModel;
    }

    public function getOrderDetail($userId, $orderId)
    {
        $rows = $this->orderModel->getOrderWithItems($userId, $orderId);

        if (!$rows) {
            return [];
        }

        $order = [
            'order_id' => $rows[0]['order_id'],
            'user_id'  => $rows[0]['user_id'],
            'order_no' => $rows[0]['order_no'],

            'currency' => [
                'code'   => $rows[0]['currency_code'],
                'symbol' => $rows[0]['currency_symbol'],
                'rate'   => $rows[0]['currency_rate'],
            ],

            'pricing' => [
                'subtotal'        => $rows[0]['subtotal'],
                'shipping_charge' => $rows[0]['shipping_charge'],
                'discount'        => $rows[0]['discount'],
                'grand_total'     => $rows[0]['grand_total'],
            ],

            'payment' => [
                'method'        => $rows[0]['payment_method'],
                'status'        => $rows[0]['payment_status'],
                'transaction_id'=> $rows[0]['transaction_id'],
            ],

            'status' => $rows[0]['order_status'],
            'created_at' => $rows[0]['created_at'],
            'items' => []
        ];

        foreach ($rows as $row) {
            $order['items'][] = [
                'item_id'      => $row['item_id'],
                'product_id'   => $row['product_id'],
                'product_name' => $row['product_name'],
                'sku'          => $row['sku'],
                'price'        => $row['price'],
                'qty'          => $row['qty'],
                'total'        => $row['item_total'],
            ];
        }

        return $order;
    }
}