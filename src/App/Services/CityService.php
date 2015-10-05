<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
class CityService extends BaseService
{
    public function getCity($where) {
        foreach($where as $key => $value) {
            $_where[$key] = $key.' = :'.$key;
        }
        $stmt = $this->db->prepare(
            'SELECT * FROM city WHERE '.\implode(' AND ', $_where)
        );
        foreach($where as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        if($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public function save($city) {
        $this->db->insert("city", $city);
        return $this->db->lastInsertId('city_id_seq');
    }
}