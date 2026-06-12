<?php

require_once __DIR__ . '/Config.php';

class Base extends Config
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = parent::db();
    }
}