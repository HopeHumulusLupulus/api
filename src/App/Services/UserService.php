<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Response;
class UserService extends BaseService
{
    /**
     * 
     * @var PhoneService
     */
    private $PhoneService;

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
                'SELECT ua.id AS code, ua.name, '.implode(",\n", array_keys($data))."\n".
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
        # Phone
        $this->PhoneService = new PhoneService($this->db);
        if(array_key_exists('phone', $user)) {
            $user['phones'] = $user['phone'];
            unset($user['phone']);
        }
        if(array_key_exists('phones', $user)) {
            if($this->PhoneService->get($user['phones'])) {
                return 'Phone already used';
            }
        }

        #email
        $this->EmailService = new EmailService($this->db);
        if(array_key_exists('email', $user)) {
            $user['emails'] = $user['email'];
            unset($user['email']);
        }
        if(array_key_exists('emails', $user)) {
            if($this->EmailService->get($user['emails'])) {
                return 'Email already used';
            }
        }

        # User Account
        $this->db->insert("user_account", array(
            'name' => $user['name']
        ));
        $id = $this->db->lastInsertId('user_account_id_seq');
        # Phone
        if(array_key_exists('phones', $user)) {
            foreach($user['phones'] as $phone) {
                $phone['id_user_account'] = $id;
                $this->db->insert("phone_user_account", $phone);
            }
        }
        # Email
        if(array_key_exists('emails', $user)) {
            foreach($user['emails'] as $email) {
                $email['id_user_account'] = $id;
                $this->db->insert("email_user_account", $email);
            }
        }
        return $id;
    }

    public function update($id, $user)
    {
    }

    public function delete($id)
    {
    }

}
