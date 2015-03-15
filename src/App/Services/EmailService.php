<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
class EmailService extends BaseService
{
    public function get($param) {
        $where = $data = array();
        if(\array_key_exists('emails', $param)) {
            if(!\is_array($param['emails'])) {
                $param['emails'] = array(array(
                    'email' => $param['emails']
                ));
            } else {
                if(!is_array(\current($param['emails']))) {
                    $param['emails'] = array($param['emails']);
                }
            }
            $i = 0;
            foreach($param['emails'] as $email) {
                foreach($email as $key => $value) {
                    $where[] = 'eua.'.$key.' = :'.$key.'_'.$i;
                    $data[$key.'_'.$i] = $value;
                    $i++;
                }
            }
        }
        if(\array_key_exists('id_user_account', $param)) {
            $where[] = 'eua.id_user_account = :id_user_account';
            $data['id_user_account'] = $param['id_user_account'];
        }
        if($where) {
            $stmt = $this->db->prepare(
                "SELECT id_user_account,\n".
                "       email,\n".
                "       CASE WHEN et.id IS NOT NULL THEN et.type\n".
                "            ELSE eua.other_type\n".
                "        END AS type\n".
                "  FROM email_user_account eua\n".
                "  LEFT JOIN email_type et ON et.id = eua.id_email_type\n".
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

    public function save($email) {
        $this->db->insert("email_user_account", $email);
        return $this->db->lastInsertId('email_user_account_id_seq');
    }
}