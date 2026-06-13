<?php

require_once __DIR__ . '/Config.php';

class Base extends Config
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = parent::db();
    }

    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function fetchOne($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}