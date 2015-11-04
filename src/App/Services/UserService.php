<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Query\QueryBuilder;
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
                    $data[$field] = strtolower(trim($value));
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
                "SELECT ua.id AS code, ua.name, ua.gender, ua.birth,\n".
                "       count(DISTINCT pc.id) AS total_checkin,\n".
                "       count(DISTINCT pc.id_pin) AS total_visited,\n".
                "       count(DISTINCT pin.id) AS total_created\n".
                "  FROM user_account ua\n".
                "  LEFT JOIN pin_checkin pc ON pc.id_user_account = ua.id\n".
                "  LEFT JOIN email_user_account eua ON eua.id_user_account = ua.id\n".
                "  LEFT JOIN pin ON pin.created_by = eua.email\n".
                implode("\n ", $join)."\n".
                " WHERE ".implode("\n  AND ", $where).
                "   AND ua.deleted IS NULL".
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
    
    public function loginByPassword($post)
    {
        $join = $where = $data = array();
        foreach($post as $field => $value) {
            switch($field) {
                case 'email':
                    $where[] = 'eua.email = :email';
                    $data[$field] = strtolower(trim($value));
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
                "SELECT ua.id,\n".
                "       ua.password\n".
                "  FROM user_account ua\n".
                implode("\n ", $join)."\n".
                " WHERE ".implode("\n  AND ", $where)."\n".
                "   AND deleted IS NULL".
                " GROUP BY ua.id, ua.password"
            );
            foreach($data as $param => $value) {
                $stmt->bindValue($param, $value);
            }
            if($stmt->execute() && $user = $stmt->fetch()) {
                $stmt = $this->db->prepare(
                    "SELECT id,\n".
                    "       access_token\n".
                    "  FROM session_user_account\n".
                    " WHERE id_user_account = :id_user_account\n".
                    "   AND method = :method\n".
                    " ORDER BY created DESC\n".
                    " LIMIT 1"
                );
                $stmt->bindValue('id_user_account', $user['id']);
                $stmt->bindValue('method', 'password');
                $stmt->execute();
                $last = $stmt->fetch();
                $insert = array(
                    'id_user_account' => $user['id'],
                    'method' => 'password',
                    'attempts' => 1
                );
                if(password_verify($post['password'], $user['password'])) {
                    $access_token = bin2hex(openssl_random_pseudo_bytes(20));
                    if(!$last || $last['access_token']) {
                        $insert['access_token'] = $access_token;
                        $insert['authenticated'] = date('Y-m-d H:i:s.u');
                    }
                }
                if($last && !$last['access_token']) {
                    $stmt = $this->db->prepare(
                        'UPDATE session_user_account '.
                        '   SET attempts = attempts +1,'.
                        '       access_token = :access_token,'.
                        '       authenticated = :authenticated'.
                        ' WHERE id = :id'
                    );
                    $stmt->execute(array(
                        'access_token' => $access_token ?: null,
                        'authenticated' => $access_token ? date('Y-m-d H:i:s.u') : null,
                        'id' => $last['id']
                    ));
                } else {
                    $this->db->insert('session_user_account', $insert);
                }
            }
            return $access_token ?: false;
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
        if(!array_key_exists('gender', $user)) {
            $user['gender'] = null;
        }

        #birth
        if(!array_key_exists('birth', $user)) {
            $user['birth'] = null;
        }
        return $user;
    }

    public function save($user, $current_data = array())
    {
        $user = $this->normalize($user);
        
        if(!array_key_exists('id', $current_data)) {
            $current_data['id'] = null;
        }
        
        if(!array_key_exists('emails', $user) && array_key_exists('phones', $user)) {
            throw new \Exception('Phone or email is necessary for create account');
        }
        # Phone
        if(array_key_exists('phones', $user)) {
            if($this->getPhoneService()->get(array('phones' => $user['phones']), $current_data['id'])) {
                throw new \Exception('Phone already used');
            }
        }

        #email
        if(array_key_exists('emails', $user)) {
            if($this->getEmailService()->get(array('emails' => $user['emails']), $current_data['id'])) {
                throw new \Exception('Email already used');
            }
        }
        
        # gender
        if($user['gender']) {
            if(!in_array(strtoupper($user['gender']), array('M', 'F', 'U'))) {
                throw new \Exception('Invalid gender');
            }
        }
        
        # birth
        if($user['birth']) {
            $user['birth'] = \DateTime::createFromFormat('Y-m-d', $user['birth']);
            if(!$user['birth']) {
                throw new \Exception('Invalid birth');
            } else {
                $eighteen = new \DateTime();
                $eighteen->sub(new \DateInterval('P18Y'));
                if($user['birth'] > $eighteen) {
                    throw new \Exception('Only allowed to 18 years');
                }
                $user['birth'] = $user['birth']->format('Y-m-d');
            }
        }
        
        if(array_key_exists('password', $user)) {
            if(!is_string($user['password'])) {
                throw new \Exception('Password must be a string');
            }
            if(strlen($user['password']) < 6) {
                throw new \Exception('Password is not allowed under 6 characters');
            }
            if(isset($current_data['password'])) {
                if(!password_verify($user['password'], $current_data['password'])) {
                    $user['password'] = $open_password = password_hash($user['password'], PASSWORD_DEFAULT);
                } else {
                    $user['password'] = $current_data['password'];
                }
            } else {
                $user['password'] = $open_password = password_hash($user['password'], PASSWORD_DEFAULT);
            }
        }

        # User Account
        if($current_data['id']) {
            $data = [];
            if($user['gender'] != $current_data['gender']) {
                $data['gender'] = $user['gender'];
            }
            if($user['password'] != $current_data['password']) {
                $data['password'] = $user['password'];
            }
            if($user['birth'] != $current_data['birth']) {
                $data['birth'] = $user['birth'];
            }
            if($data) {
                $this->db->update('user_account', $data, array('id' => $current_data['id']));
            }
        } else {
            $this->db->insert("user_account", array(
                'name'   => $user['name'],
                'gender' => strtoupper($user['gender']) ? : null,
                'birth'  => $user['birth'],
                'password' => $user['password'] ? : null
            ));
            $id = $this->db->lastInsertId('user_account_id_seq');
        }
        # Phone
        if(array_key_exists('phones', $user)) {
            if($current_data['id']) {
                $stmt = $this->db->prepare(
                    "SELECT id, id_phone_type, number, other_type\n".
                    "  FROM phone_user_account\n".
                    " WHERE id_user_account = :id"
                );
                if($stmt->execute(array('id' => $current_data['id']))) {
                    while($_number = $stmt->fetch()) {
                        $old[$_number['id']] = $_number;
                        foreach($user['phones'] as $pos => $number) {
                            if($number['number'] == $_number['number']) {
                                if($number['id_phone_type'] == $_number['id_phone_type']) {
                                    if($number['other_type'] == $_number['other_type']) {
                                        unset($user['phones'][$pos]);
                                        array_pop($old);
                                    }
                                }
                            }
                        }
                    }
                    if($old) {
                        $qb = $this->db->createQueryBuilder();
                        $qb->delete('phone_user_account', 'pua')
                            ->where($qb->expr()->in('pua.id', array_keys($old)))
                            ->execute();
                    }
                }
            }
            foreach($user['phones'] as $phone) {
                $phone['id_user_account'] = $id;
                $this->db->insert("phone_user_account", $phone);
            }
        }
        # Email
        if(array_key_exists('emails', $user)) {
            if($current_data['id']) {
                $stmt = $this->db->prepare(
                    "SELECT id, id_email_type, email, other_type\n".
                    "  FROM email_user_account\n".
                    " WHERE id_user_account = :id"
                );
                if($stmt->execute(array('id' => $current_data['id']))) {
                    while($_email = $stmt->fetch()) {
                        $old[$_email['id']] = $_email;
                        foreach($user['emails'] as $pos => $email) {
                            if(strtolower(trim($email['email'])) == $_email['email']) {
                                if($email['id_email_type'] == $_email['id_email_type']) {
                                    if($email['other_type'] == $_email['other_type']) {
                                        unset($user['emails'][$pos]);
                                        array_pop($old);
                                    }
                                }
                            }
                        }
                    }
                    if($old) {
                        $qb = $this->db->createQueryBuilder();
                        $qb->delete('email_user_account', 'eua')
                            ->where($qb->expr()->in('eua.id', array_keys($old)))
                            ->execute();
                    }
                }
            }
            foreach($user['emails'] as $email) {
                $email['id_user_account'] = $id;
                $this->db->insert("email_user_account", $email);
            }
        }
        return $id;
    }

    public function contact($data)
    {
        $this->db->insert("contact", array(
            'name'    => $data['name'],
            'email'   => $data['email'],
            'message' => $data['message']
        ));
        return $this->db->lastInsertId('contact_id_seq');
    }
    
    public function requestToken($data)
    {
        if(!isset($data['authenticated'])) {
            $data['token'] = mt_rand(1000000,9999999);
        }
        $this->db->insert('session_user_account', $data);
        return $data;
    }
    
    public function validateToken($data)
    {
        $stmt = $this->db->prepare(
            "SELECT sua.*\n".
            "  FROM session_user_account sua\n".
            "  JOIN user_account ua\n".
            "    ON ua.id = sua.id_user_account\n".
            "   AND ua.deleted IS NULL\n".
            " WHERE sua.created = (\n".
            "       SELECT max(created) AS created\n".
            "         FROM session_user_account\n".
            "        WHERE id_user_account = :id\n".
            "          AND method = :method\n".
            "       )\n".
            "   AND sua.method = :method\n".
            "   AND sua.id_user_account = :id".
            "   AND sua.authenticated IS NULL;"
        );
        $stmt->bindValue('id', $data['id']);
        $stmt->bindValue('method', $data['method']);
        if($stmt->execute() && $last = $stmt->fetch()) {
            if($last['token'] == $data['token']) {
                $stmt = $this->db->prepare(
                    'UPDATE session_user_account '.
                    '   SET access_token = :access_token, '. 
                    '       authenticated = now(), '. 
                    '       attempts = attempts +1'.
                    ' WHERE id = :id'
                );
                $stmt->execute(array(
                    'id' => $last['id'],
                    'access_token' => $access_token = bin2hex(openssl_random_pseudo_bytes(20))
                ));
                return $access_token;
            } else {
                $stmt = $this->db->prepare('UPDATE session_user_account SET attempts = attempts +1 WHERE id = :id');
                $stmt->execute(array('id' => $last['id']));
                return false;
            }
        }
        return false;
    }
    
    public function validateAccessToken($token)
    {
        $stmt = $this->db->prepare(
            "SELECT ua.*\n".
            "  FROM session_user_account sua\n".
            "  JOIN user_account ua\n".
            "    ON ua.id = sua.id_user_account\n".
            "   AND ua.deleted IS NULL\n".
            " WHERE sua.access_token = :access_token"
        );
        $stmt->execute(array('access_token' => $token));
        return $stmt->fetch() ? : false;
    }
    
    public function update($id, $user)
    {
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare(
            "UPDATE user_account\n".
            "   SET deleted = now()\n".
            " WHERE id = :id"
        );
        $stmt->execute(array('id' => $id));
    }

}
