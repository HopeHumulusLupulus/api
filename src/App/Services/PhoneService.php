<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
class PhoneService extends BaseService
{
    public function get(&$phones) {
        if(!\is_array($phones)) {
            $phones = array(array(
                'number' => $phones
            ));
        } else {
            if(!is_array(\current($phones))) {
                $phones = array($phones);
            }
        }
        $where = $data = array();
        $i = 0;
        foreach($phones as $phone) {
            foreach($phone as $key => $value) {
                $where[] = 'pua.'.$key.' = :'.$key.'_'.$i;
                $data[$key.'_'.$i] = $value;
                $i++;
            }
        }
        $stmt = $this->db->prepare(
            'SELECT * FROM phone_user_account pua WHERE '.implode(' AND ', $where)
        );
        foreach($data as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        if($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public function save($phone) {
        $this->db->insert("phone_user_account", $phone);
        return $this->db->lastInsertId('phone_user_account_id_seq');
    }
}