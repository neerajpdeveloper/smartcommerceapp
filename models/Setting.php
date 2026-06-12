<?php

class Setting extends Base
{
    protected $table = 'settings';

    public function get()
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM {$this->table}
            LIMIT 1
        ");

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}