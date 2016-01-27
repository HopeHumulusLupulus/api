<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
class PhoneService extends BaseService
{
    public function get($param) {
        $where = $data = array();
        if(\array_key_exists('phones', $param)) {
            $i = 0;
            foreach($param['phones'] as $phone) {
                foreach($phone as $key => $value) {
                    $where[] = 'pua.'.$key.' = :'.$key.'_'.$i;
                    $data[$key.'_'.$i] = $value;
                    $i++;
                }
            }
        }
        if(\array_key_exists('id_user_account', $param)) {
            if(is_array($param['id_user_account'])) {
                $where[] = 'pua.id_user_account IN('.implode(', ', $param['id_user_account']).')';
            } else {
                $where[] = 'pua.id_user_account = :id_user_account';
                $data['id_user_account'] = $param['id_user_account'];
            }
        }
        if($where) {
            $stmt = $this->db->prepare(
                "SELECT id_user_account,\n".
                "       number,\n".
                "       CASE WHEN pt.id IS NOT NULL THEN pt.type\n".
                "            ELSE pua.other_type\n".
                "        END AS type\n".
                "  FROM phone_user_account pua\n".
                "  JOIN user_account ua\n".
                "    ON ua.id = pua.id_user_account\n".
                "   AND ua.deleted IS NULL\n".
                "  LEFT JOIN phone_type pt ON pt.id = pua.id_phone_type\n".
                ' WHERE '.implode(' AND ', $where)
            );
            foreach($data as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            if($stmt->execute()) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
    }

    public function save($phone) {
        $this->db->insert("phone_user_account", $phone);
        return $this->db->lastInsertId('phone_user_account_id_seq');
    }
}