<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
class UserService extends BaseService
{

    public function get($args)
    {
        $join = $where = $data = array();
        foreach($args as $field => $value) {
            switch($field) {
                case 'email':
                    $where[] = 'eua.email = :email';
                    $data[$field] = $value;
                    $join[] = 'JOIN email_user_account eua ON eua.id_user_account = ua.id';
                    break;
                case 'phone':
                    $where[] = 'pua.number = :number';
                    $data['number'] = $value;
                    $join[] = 'JOIN phone_user_account pua ON pua.id_user_account = ua.id';
                    break;
            } 
        }
        if($data) {
            $stmt = $this->db->prepare(
                'SELECT '.implode(",\n", array_keys($data))."\n".
                "  FROM user_account ua\n".
                implode("\n ", $join)."\n".
                " WHERE ".implode("\n  AND ", $where)
            );
            foreach($data as $param => $value) {
                $stmt->bindValue($param, $value);
            }
            if($stmt->execute()) {
                return $stmt->fetchAll();
            }
        }
    }

    public function save($user)
    {
        if(array_key_exists('phone', $user)){
            if(!\is_array($user['phone'])) {
                $phones[] = array(
                    'number' => $user['phone']
                );
                unset($user['phone']);
            }
        }
        $this->db->insert("user_account", $user);
        $id = $this->db->lastInsertId('user_account_id_seq');
        if($phones){
            foreach($phones as $phone) {
                $phone['id_user_account'] = $id;
                $this->db->insert("phone_pin", $phone);
            }
        }
    }

    public function update($id, $user)
    {
    }

    public function delete($id)
    {
    }

}
