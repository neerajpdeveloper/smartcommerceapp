<?php

class CustomerAddress extends Base
{
    protected $table = 'customer_addresses';

    public function getByUser($userId)
    {
        return $this->fetchAll("
            SELECT *
            FROM {$this->table}
            WHERE customer_id = ?
            ORDER BY is_default DESC,id DESC
        ", [$userId]);
    }

    public function getById($id)
    {
        return $this->fetchOne("
            SELECT *
            FROM {$this->table}
            WHERE id = ?
            LIMIT 1
        ", [$id]);
    }

    public function countByUser($userId)
    {
        $row = $this->fetchOne("
            SELECT COUNT(*) total
            FROM {$this->table}
            WHERE customer_id = ?
        ", [$userId]);

        return $row->total ?? 0;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table}
            (
                customer_id,
                full_name,
                mobile,
                address_line,
                city,
                state,
                pincode,
                is_default
            )
            VALUES
            (?,?,?,?,?,?,?,?)
        ");

        return $stmt->execute([
            $data['customer_id'],
            $data['full_name'],
            $data['mobile'],
            $data['address_line'],
            $data['city'],
            $data['state'],
            $data['pincode'],
            $data['is_default']
        ]);
    }

    public function updateAddress($id,$data)
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET
                full_name=?,
                mobile=?,
                address_line=?,
                city=?,
                state=?,
                pincode=?
            WHERE id=?
        ");

        return $stmt->execute([
            $data['full_name'],
            $data['mobile'],
            $data['address_line'],
            $data['city'],
            $data['state'],
            $data['pincode'],
            $id
        ]);
    }

    public function deleteAddress($id,$userId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM {$this->table}
            WHERE id=?
            AND customer_id=?
        ");

        return $stmt->execute([
            $id,
            $userId
        ]);
    }

    public function removeDefault($userId)
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET is_default=0
            WHERE customer_id=?
        ");

        return $stmt->execute([$userId]);
    }

    public function setDefault($id,$userId)
    {
        $this->removeDefault($userId);

        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET is_default=1
            WHERE id=?
            AND customer_id=?
        ");

        return $stmt->execute([
            $id,
            $userId
        ]);
    }
}