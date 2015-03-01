<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
class DistrictService extends BaseService
{
    public function getDistrict($where) {
        foreach($where as $key => $value) {
            $_where[$key] = $key.' = :'.$key;
        }
        $stmt = $this->db->prepare(
            'SELECT * FROM district WHERE '.\implode(' AND ', $_where)
        );
        foreach($where as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        if($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public function save($district) {
        $this->db->insert("district", $district);
        return $this->db->lastInsertId('district_id_seq');
    }
}