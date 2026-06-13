<?php

class Payment extends Base
{
    protected $table = 'payment_gateways';

    public function getGateway($code)
    {
        return $this->fetchOne("
            SELECT *
            FROM {$this->table}
            WHERE code = ?
            AND status = 1
            LIMIT 1
        ", [$code]);
    }

    public function getActiveGateways()
    {
        return $this->fetchAll("
            SELECT *
            FROM {$this->table}
            WHERE status = 1
            ORDER BY id ASC
        ");
    }
}