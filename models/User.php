<?php
class User extends Base
{
    protected $table = 'customers';

    // 🔐 FIND BY EMAIL
    public function getByEmail($email)
    {
        return $this->fetchOne("
            SELECT * FROM {$this->table}
            WHERE email = ?
            LIMIT 1
        ", [$email]);
    }

    // 📝 CREATE USER
    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (name, email,mobile, password)
            VALUES (?, ?, ?,?)
        ");

        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['mobile'],
            $data['password']
        ]);
    }
}