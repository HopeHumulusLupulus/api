<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
class EmailService extends BaseService
{
    public function get(&$emails) {
        if(!\is_array($emails)) {
            $emails = array(array(
                'email' => $emails
            ));
        } else {
            if(!is_array(\current($emails))) {
                $emails = array($emails);
            }
        }
        $where = $data = array();
        $i = 0;
        foreach($emails as $email) {
            foreach($email as $key => $value) {
                $where[] = 'eua.'.$key.' = :'.$key.'_'.$i;
                $data[$key.'_'.$i] = $value;
                $i++;
            }
        }
        $stmt = $this->db->prepare(
            'SELECT * FROM email_user_account eua WHERE '.implode(' AND ', $where)
        );
        foreach($data as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        if($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public function save($email) {
        $this->db->insert("email_user_account", $email);
        return $this->db->lastInsertId('email_user_account_id_seq');
    }
}