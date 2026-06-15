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

        public function getByID($id)
    {
        return $this->fetchOne("
            SELECT * FROM {$this->table}
            WHERE id = ?
            LIMIT 1
        ", [$id]);
    }

    // 📝 CREATE USER
    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (name, email,mobile, password,google_id,facebook_id,avatar)
            VALUES (?, ?, ?,?,?,?,?)
        ");

        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['mobile'],
            $data['password'],
            $data['google_id'],
            $data['facebook_id'],
            $data['avatar']
        ]);
    }
}