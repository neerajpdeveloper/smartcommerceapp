<?php

class Cart extends Base
{
    protected $table = 'carts';

    public function getByUser($userId)
    {
        return $this->fetchAll("
            SELECT
                c.*,
                p.name,
                p.slug,
                p.price
            FROM carts c
            INNER JOIN products p ON p.id = c.product_id
            WHERE c.user_id = ?
            ORDER BY c.id DESC
        ", [$userId]);
    }

    public function countByUser($userId)
    {
        $row = $this->fetchOne("
            SELECT SUM(qty) total
            FROM carts
            WHERE user_id = ?
        ", [$userId]);

        return (int)($row->total ?? 0);
    }

public function totalAmount($userId)
{
    $row = $this->fetchOne("
        SELECT
            SUM(c.qty * p.price) total
        FROM carts c
        INNER JOIN products p
            ON p.id = c.product_id
        WHERE c.user_id = ?
    ", [$userId]);

    return $row->total ?? 0;
}

    public function findItem($userId, $productId)
    {
        return $this->fetchOne("
            SELECT *
            FROM carts
            WHERE user_id = ?
            AND product_id = ?
            LIMIT 1
        ", [$userId, $productId]);
    }

    public function add($userId, $productId, $qty)
    {
        $item = $this->findItem($userId, $productId);

        if ($item) {

            $stmt = $this->db->prepare("
                UPDATE carts
                SET qty = qty + ?
                WHERE id = ?
            ");

            return $stmt->execute([$qty, $item->id]);
        }

        $stmt = $this->db->prepare("
            INSERT INTO carts
            (user_id, product_id, qty)
            VALUES (?, ?, ?)
        ");

        return $stmt->execute([
            $userId,
            $productId,
            $qty
        ]);
    }

    public function updateQty($cartId,$type)
{
    if($type == 'plus'){

        $stmt = $this->db->prepare("
            UPDATE carts
            SET qty = qty + 1
            WHERE id = ?
        ");

        return $stmt->execute([$cartId]);
    }

    $stmt = $this->db->prepare("
        UPDATE carts
        SET qty = IF(qty > 1, qty - 1, 1)
        WHERE id = ?
    ");

    return $stmt->execute([$cartId]);
}

    public function totalQty($userId)
{
    $row = $this->fetchOne("
        SELECT SUM(qty) AS total_qty
        FROM carts
        WHERE user_id = ?
    ", [$userId]);

    return (int)($row->total_qty ?? 0);
}

public function remove($cartId, $userId)
{
    $stmt = $this->db->prepare("
        DELETE FROM carts
        WHERE id = ?
        AND user_id = ?
    ");

    return $stmt->execute([
        $cartId,
        $userId
    ]);
}

public function clear($userId)
{
    $stmt = $this->db->prepare("
        DELETE FROM {$this->table}
        WHERE user_id = ?
    ");

    return $stmt->execute([$userId]);
}
}