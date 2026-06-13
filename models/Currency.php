<?php

class Currency extends Base
{
    protected $table = 'currencies';

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

    public function getAll()
    {
        return $this->fetchAll("
            SELECT * 
            FROM {$this->table}
            ORDER BY id ASC
        ");
    }

    public function getByCode($code)
    {
        return $this->fetchOne("
            SELECT * 
            FROM {$this->table}
            WHERE code = ?
            LIMIT 1
        ", [$code]);
    }

    public function getDefault()
    {
        return $this->fetchOne("
            SELECT * 
            FROM {$this->table}
            WHERE is_default = 1
            LIMIT 1
        ");
    }
}