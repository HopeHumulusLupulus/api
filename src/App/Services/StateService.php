<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
class StateService extends BaseService
{
    public function getState($where) {
        foreach($where as $key => $value) {
            $_where[$key] = $key.' = :'.$key;
        }
        $stmt = $this->db->prepare(
            "SELECT *\n".
            "  FROM state\n".
            (count($_where)
                ? " WHERE ".\implode(' AND ', $_where)
                : ''
            )."\n".
            " ORDER BY name"
        );
        foreach($where as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        if($stmt->execute()) {
            if (count($_where)) {
                $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            } else {
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            
            return $result;
        }
    }

    public function save($state) {
        $this->db->insert("state", $state);
        return $this->db->lastInsertId('state_id_seq');
    }
}