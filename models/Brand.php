<?php

class Brand extends Base
{
    protected $table = 'brands';

    private function fetchAll($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

        private function fetchOne($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

      public function getAll($limit = null)
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";

        if ($limit) {
            $sql .= " LIMIT " . intval($limit);
        }

        return $this->fetchAll($sql);
    }

        public function getBySlug($slug)
    {
        return $this->fetchOne(
            "SELECT * FROM {$this->table} WHERE slug = ? LIMIT 1",
            [$slug]
        );
    }

   public function getWithProductCount()
    {
        return $this->fetchAll("
            SELECT 
                b.*,
                COUNT(p.id) AS total_products
            FROM {$this->table} b
            LEFT JOIN products p ON p.brand_id = b.id
            GROUP BY b.id
            ORDER BY b.id DESC
        ");
    }
}