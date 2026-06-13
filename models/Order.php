<?php

class Order extends Base
{
    protected $table = 'orders';

    /*
    |--------------------------------------------------------------------------
    | CREATE ORDER
    |--------------------------------------------------------------------------
    */
    public function create(
        $userId,
        $addressId,
        $paymentMethod,
        $cartItems
    )
    {
        $currency = current_currency();

        $grandTotal = 0;

        foreach ($cartItems as $item) {

            $grandTotal +=
                ($item->price * $item->qty);
        }

        $orderNo =
            'ORD'
            . date('YmdHis')
            . rand(100,999);

        $stmt = $this->db->prepare("
            INSERT INTO orders
            (
                order_no,
                user_id,
                address_id,
                payment_method,
                currency_code,
                currency_rate,
                grand_total,
                payment_status,
                order_status
            )
            VALUES
            (
                ?,?,?,?,?,?,?,?,?
            )
        ");

        $stmt->execute([

            $orderNo,
            $userId,
            $addressId,
            $paymentMethod,
            $currency['code'],
            $currency['rate'],
            $grandTotal,
            'pending',
            'pending'

        ]);

        $orderId = $this->db->lastInsertId();

        $this->saveItems(
            $orderId,
            $cartItems
        );

        return $orderId;
    }

    /*
    |--------------------------------------------------------------------------
    | SAVE ORDER ITEMS
    |--------------------------------------------------------------------------
    */
    public function saveItems(
        $orderId,
        $cartItems
    )
    {
        foreach ($cartItems as $item) {

            $stmt = $this->db->prepare("
                INSERT INTO order_items
                (
                    order_id,
                    product_id,
                    qty,
                    price,
                    total
                )
                VALUES
                (
                    ?,?,?,?,?
                )
            ");

            $stmt->execute([

                $orderId,
                $item->product_id,
                $item->qty,
                $item->price,
                ($item->price * $item->qty)

            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | GET ORDER
    |--------------------------------------------------------------------------
    */
    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM orders
            WHERE id = ?
            LIMIT 1
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /*
    |--------------------------------------------------------------------------
    | GET ORDER BY NUMBER
    |--------------------------------------------------------------------------
    */
    public function getByOrderNo($orderNo)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM orders
            WHERE order_no = ?
            LIMIT 1
        ");

        $stmt->execute([$orderNo]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /*
    |--------------------------------------------------------------------------
    | USER ORDERS
    |--------------------------------------------------------------------------
    */
    public function getByUser($userId)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM orders
            WHERE user_id = ?
            ORDER BY id DESC
        ");

        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /*
    |--------------------------------------------------------------------------
    | ORDER ITEMS
    |--------------------------------------------------------------------------
    */
    public function getItems($orderId)
    {
        $stmt = $this->db->prepare("
            SELECT
                oi.*,
                p.name,
                p.slug
            FROM order_items oi

            LEFT JOIN products p
                ON p.id = oi.product_id

            WHERE oi.order_id = ?
        ");

        $stmt->execute([$orderId]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT SUCCESS
    |--------------------------------------------------------------------------
    */
    public function markPaid(
        $orderId,
        $transactionId = null
    )
    {
        $stmt = $this->db->prepare("
            UPDATE orders
            SET
                payment_status = 'paid',
                order_status   = 'processing',
                transaction_id = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $transactionId,
            $orderId
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT FAILED
    |--------------------------------------------------------------------------
    */
    public function markFailed($orderId)
    {
        $stmt = $this->db->prepare("
            UPDATE orders
            SET
                payment_status = 'failed'
            WHERE id = ?
        ");

        return $stmt->execute([$orderId]);
    }

    /*
    |--------------------------------------------------------------------------
    | COD ORDER
    |--------------------------------------------------------------------------
    */
    public function markPending($orderId)
    {
        $stmt = $this->db->prepare("
            UPDATE orders
            SET
                payment_status = 'pending',
                order_status   = 'pending'
            WHERE id = ?
        ");

        return $stmt->execute([$orderId]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE ORDER STATUS
    |--------------------------------------------------------------------------
    */
    public function updateStatus(
        $orderId,
        $status
    )
    {
        $stmt = $this->db->prepare("
            UPDATE orders
            SET order_status = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $status,
            $orderId
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TOTAL ORDERS
    |--------------------------------------------------------------------------
    */
    public function countByUser($userId)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM orders
            WHERE user_id = ?
        ");

        $stmt->execute([$userId]);

        return $stmt->fetchColumn();
    }

    /*
    |--------------------------------------------------------------------------
    | PENDING ORDERS
    |--------------------------------------------------------------------------
    */
    public function pendingByUser($userId)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM orders
            WHERE user_id = ?
            AND order_status = 'pending'
        ");

        $stmt->execute([$userId]);

        return $stmt->fetchColumn();
    }

    /*
    |--------------------------------------------------------------------------
    | TOTAL SALES
    |--------------------------------------------------------------------------
    */
    public function totalSales()
    {
        $stmt = $this->db->query("
            SELECT SUM(grand_total)
            FROM orders
            WHERE payment_status = 'paid'
        ");

        return $stmt->fetchColumn();
    }

public function getOrderWithItems($userId, $orderId)
{
    $query = "
        SELECT 
            o.id AS order_id,
            o.user_id,
            o.order_no,

            o.currency_code,
            o.currency_symbol,
            o.currency_rate,

            o.subtotal,
            o.shipping_charge,
            o.discount,
            o.grand_total,

            o.payment_method,
            o.payment_status,
            o.transaction_id,

            o.order_status,
            o.created_at,

            oi.id AS item_id,
            oi.product_id,
            oi.product_name,
            oi.sku,
            oi.price,
            oi.qty,
            oi.total AS item_total

        FROM orders o
        INNER JOIN order_items oi ON o.id = oi.order_id
        WHERE o.user_id = :user_id 
        AND o.id = :order_id
    ";

    $stmt = $this->db->prepare($query);

    $stmt->execute([
        ':user_id' => $userId,
        ':order_id' => $orderId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}