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
    /**
     *
     * @var EmailService
     */
    private $EmailService;

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
                case 'id':
                    $where[] = 'ua.id = :id';
                    $data['id'] = $value;
            }
        }
        if($data) {
            $stmt = $this->db->prepare(
                "SELECT ua.id AS code, ua.name, ua.gender, ua.birth, count(pc.id) AS total_checkin\n".
                "  FROM user_account ua\n".
                "  LEFT JOIN pin_checkin pc ON pc.id_user_account = ua.id\n".
                implode("\n ", $join)."\n".
                " WHERE ".implode("\n  AND ", $where).
                " GROUP BY ua.id, ua.name"
            );
            foreach($data as $param => $value) {
                $stmt->bindValue($param, $value);
            }
            if($stmt->execute() && $user = $stmt->fetch()) {
                if($emails = $this->getEmailService()->get(array(
                    'id_user_account' => $user['code']
                ))) {
                    foreach($emails as $email) {
                        $user['email'][] = array(
                            'email' => $email['email'],
                            'type'  => $email['type']
                        );
                    }
                }
                if($phones = $this->getPhoneService()->get(array(
                    'id_user_account' => $user['code']
                ))) {
                    foreach($phones as $phone) {
                        $user['phone'][] = array(
                            'number' => $phone['number'],
                            'type'  => $phone['type']
                        );
                    }
                }
                return $user;
            }
        }
    }

    /**
     * Return instance of PhoneService
     * @return \App\Services\PhoneService
     */
    public function getPhoneService() {
        if(!\is_object($this->PhoneService)) {
            $this->PhoneService = new PhoneService($this->db);
        }
        return $this->PhoneService;
    }

    /**
     * Return instance of EmailService
     * @return \App\Services\EmailService
     */
    public function getEmailService() {
        if(!\is_object($this->EmailService)) {
            $this->EmailService = new EmailService($this->db);
        }
        return $this->EmailService;
    }

    private function normalize($user) {
        # phone
        if(array_key_exists('phone', $user)) {
            $user['phones'] = $user['phone'];
            unset($user['phone']);
        }
        if(array_key_exists('phones', $user)) {
            if(!\is_array($user['phones'])) {
                $user['phones'] = array(array(
                    'number' => $user['phones']
                ));
            } else {
                if(!is_array(\current($user['phones']))) {
                    $user['phones'] = array($user['phones']);
                }
            }
        }

        # email
        if(array_key_exists('email', $user)) {
            $user['emails'] = $user['email'];
            unset($user['email']);
        }
        if(array_key_exists('emails', $user)) {
            if(!\is_array($user['emails'])) {
                $user['emails'] = array(array(
                    'email' => $user['emails']
                ));
            } else {
                if(!is_array(\current($user['emails']))) {
                    $user['emails'] = array($user['emails']);
                }
            }
        }

        #gender
        if(array_key_exists('gender', $user)) {
            if(!in_array(strtoupper($user['gender']), array('M', 'F'))) {
                return 'Email already used';
            }
        } else {
        	$user['gender'] = null;
        }

        #birth
        if(!array_key_exists('birth', $user)) {
        	$user['birth'] = null;
        }
        return $user;
    }

    public function save($user)
    {
        $user = $this->normalize($user);
        if(!array_key_exists('emails', $user) && array_key_exists('phones', $user)) {
            return 'Phone or email is necessary for create account';
        }
        # Phone
        if(array_key_exists('phones', $user)) {
            if($this->getPhoneService()->get(array('phones' => $user['phones']))) {
                return 'Phone already used';
            }
        }

        #email
        if(array_key_exists('emails', $user)) {
            if($this->getEmailService()->get(array('emails' => $user['emails']))) {
                return 'Email already used';
            }
        }

        # User Account
        $this->db->insert("user_account", array(
            'name'   => $user['name'],
            'gender' => strtoupper($user['gender']),
            'birth'  => $user['birth']
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

    public function contact($to, $data)
    {
        $ok = mail($to, 'Contato',
            "Nome: {$data['name']}\n".
            "Email: {$data['email']}\n".
            "Mensagem: {$data['message']}"
        );
        $this->db->insert("contact", array(
            'name'    => $data['name'],
            'email'   => $data['email'],
            'message' => $data['message']
        ));
        return $this->db->lastInsertId('contact_id_seq');
    }

    public function update($id, $user)
    {
    }

    public function delete($id)
    {
    }

}
