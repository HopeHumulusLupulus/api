<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
class EmailService extends BaseService
{
    public function get($param) {
        $queryBuilder = $this->db->createQueryBuilder();
        $i = 0;
        if(\array_key_exists('emails', $param)) {
            foreach($param['emails'] as $email) {
                foreach($email as $key => $value) {
                    $queryBuilder
                        ->andWhere(
                            $queryBuilder->expr()->andX('eua.'.$key.' = :'.$key.'_'.$i)
                        )
                        ->setParameter($key.'_'.$i, strtolower($value));
                    $i++;
                }
            }
        }
        if(\array_key_exists('id_user_account', $param)) {
            if(is_array($param)) {
                $queryBuilder
                    ->andWhere(
                        $queryBuilder->expr()->in('eua.id_user_account', $param['id_user_account'])
                    );
                $i++;
            } else {
                $queryBuilder
                    ->andWhere(
                        $queryBuilder->expr()->andX('eua.id_user_account = :id_user_account')
                    )
                    ->setParameter('id_user_account', $param['id_user_account']);
                $i++;
            }
        }
        if($i) {
            $queryBuilder
                ->select([
                    'id_user_account',
                    'email',
                    "CASE WHEN et.id IS NOT NULL THEN et.type\n".
                    "     ELSE eua.other_type\n".
                    " END AS type"
                ])
                ->from('email_user_account', 'eua')
                ->join('eua', 'user_account', 'ua', 'ua.id = eua.id_user_account AND ua.deleted IS NULL')
                ->leftJoin('eua', 'email_type', 'et', 'et.id = eua.id_email_type');
            if($stmt = $queryBuilder->execute()) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
    }

    public function save($email) {
        $email['email'] = strtolower(trim($email['email']));
        $this->db->insert("email_user_account", $email);
        return $this->db->lastInsertId('email_user_account_id_seq');
    }
}
