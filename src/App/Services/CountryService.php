<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
class CountryService extends BaseService
{
    public function getCountry(array $where) {
        foreach($where as $key => $value) {
            $_where[$key] = $key.' = :'.$key;
        }
        $stmt = $this->db->prepare(
            'SELECT * FROM country WHERE '.\implode(' AND ', $_where)
        );
        foreach($where as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        if($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public function save($country) {
        $this->db->insert("country", $country);
        return $this->db->lastInsertId('country_id_seq');
    }
}