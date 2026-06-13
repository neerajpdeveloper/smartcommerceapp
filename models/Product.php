<?php

class Product extends Base
{
    protected $table = 'products';

    // 🔥 CORE REUSABLE METHOD (IMPORTANT)
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

    // 📦 ALL PRODUCTS
public function getAll($limit = null)
{
    $sql = "
        SELECT 
            p.*,
            c.name AS category_name,
            c.slug AS category_slug,
            b.name AS brand_name
        FROM {$this->table} p
        LEFT JOIN categories c ON c.id = p.category_id
        LEFT JOIN brands b ON b.id = p.brand_id
        ORDER BY p.id DESC
    ";

    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }

    return $this->fetchAll($sql);
}

    // 🎯 SINGLE PRODUCT
    public function getById($id)
    {
        return $this->fetchOne(
            "SELECT * FROM {$this->table} WHERE id = ? LIMIT 1",
            [$id]
        );
    }

    // ⭐ FEATURED PRODUCTS
    public function getFeatured($limit = 8)
    {
        return $this->fetchAll(
            "SELECT * FROM {$this->table} WHERE status = 1 ORDER BY id DESC LIMIT {$limit}"
        );
    }

    // 🆕 NEW PRODUCTS
    public function getNew($limit = 8)
    {
        return $this->fetchAll(
            "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT {$limit}"
        );
    }

public function getByCategory($categoryId, $limit = null)
{
    $sql = "
        SELECT 
            p.*,
            b.name AS brand_name
        FROM {$this->table} p
        LEFT JOIN brands b ON b.id = p.brand_id
        WHERE p.category_id = ?
        ORDER BY p.id DESC
    ";

    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$categoryId]);

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

public function getByBrand($brandId, $limit = null)
{
    $sql = "
        SELECT 
            p.*,
            c.name AS cat_name
        FROM {$this->table} p
        LEFT JOIN categories c ON c.id = p.category_id
        WHERE p.brand_id = ?
        ORDER BY p.id DESC
    ";

    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$brandId]);

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

    public function getBySlug($slug)
{
    return $this->fetchOne("
        SELECT 
            p.*,
            c.name AS category_name,
            c.slug AS category_slug,
            b.name AS brand_name
        FROM {$this->table} p
        LEFT JOIN categories c ON c.id = p.category_id
        LEFT JOIN brands b ON b.id = p.brand_id
        WHERE p.slug = ?
        LIMIT 1
    ", [$slug]);
}

}