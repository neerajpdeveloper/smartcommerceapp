<?php

class Category extends Base
{
    protected $table = 'categories';

    // 📦 ALL CATEGORIES
    public function getAll($limit = null)
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";

        if ($limit) {
            $sql .= " LIMIT " . intval($limit);
        }

        return $this->fetchAll($sql);
    }

    // 🎯 SINGLE CATEGORY BY ID
    public function getById($id)
    {
        return $this->fetchOne(
            "SELECT * FROM {$this->table} WHERE id = ? LIMIT 1",
            [$id]
        );
    }

    // 🔗 CATEGORY BY SLUG (SEO FRIENDLY)
    public function getBySlug($slug)
    {
        return $this->fetchOne(
            "SELECT * FROM {$this->table} WHERE slug = ? LIMIT 1",
            [$slug]
        );
    }

    // 📊 CATEGORY WITH PRODUCT COUNT (VERY USEFUL)
    public function getWithProductCount()
    {
        return $this->fetchAll("
            SELECT c.*, 
                   COUNT(p.id) as total_products
            FROM {$this->table} c
            LEFT JOIN products p ON p.category_id = c.id
            GROUP BY c.id
            ORDER BY c.id DESC
        ");
    }

    // 🏆 FEATURED CATEGORIES (optional future use)
    public function getFeatured($limit = 6)
    {
        return $this->fetchAll("
            SELECT * FROM {$this->table}
            WHERE status = 1
            ORDER BY id DESC
            LIMIT {$limit}
        ");
    }
}