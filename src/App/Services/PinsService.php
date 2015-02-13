<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
use Cocur\Slugify\Slugify;
class PinsService extends BaseService
{

    public function getAll($minLat, $minLng, $maxLat, $maxLng)
    {
        $stmt = $this->db->prepare(
            "
SELECT p.id, co.name AS country, s.name AS state, c.name AS city, d.name AS district, p.name, p.lat, p.lng, p.address, p.link
  FROM pin p
  JOIN district d ON d.id = p.id_district
  JOIN city c ON c.id = d.id_city
  JOIN state s ON s.id = c.id_state
  JOIN country co ON co.id = s.id_country
 WHERE p.lat BETWEEN :minLat AND :maxLat
       AND p.lng BETWEEN :minLng AND :maxLng
       AND p.enabled IS NOT NULL
       AND p.deleted IS NULL
  ORDER BY p.name"
            );
        $stmt->bindValue(':minLat', $minLat);
        $stmt->bindValue(':minLng', $minLng);
        $stmt->bindValue(':maxLat', $maxLat);
        $stmt->bindValue(':maxLng', $maxLng);

        $return = array();
        if($stmt->execute()) {
            $pin_ids = array();
            foreach($stmt->fetchAll() as $row) {
                $pin_ids[] = $row['id'];
                $return[$row['id']] = $row;
            }
            $stmt = $this->db->executeQuery("
SELECT pin.id AS id_pin,
       p.number,
       CASE WHEN pt.id <> 3 THEN pt.type
            WHEN pt.id = 3 AND p.other_type IS NOT NULL THEN p.other_type
            ELSE pt.type
        END AS type
  FROM phone p
  JOIN phone_type pt ON pt.id = p.id_phone_type
  JOIN pin ON pin.id = p.id_entity AND p.entity = 'pin'
 WHERE pin.id IN (?)",
                array($pin_ids),
                array(Connection::PARAM_INT_ARRAY)
            );
            if($stmt->execute()) {
                while($row = $stmt->fetch()) {
                    $return[$row['id_pin']]['phones'][] = array(
                        'number' => $row['number'],
                        'type'   => $row['type']
                    );
                }
            }
            $lugify = new Slugify();
            foreach($return as $key => $value) {
                unset($return[$key]);
                $return['B_'.$value['id']] = $value;
            }
        }
        return $return;
    }

    public function getOne($id)
    {
        $stmt = $this->db->prepare(
            "
SELECT p.id, co.name AS country, s.name AS state, c.name AS city, d.name AS district, p.name, p.lat, p.lng, p.address, p.link
  FROM pin p
  JOIN district d ON d.id = p.id_district
  JOIN city c ON c.id = d.id_city
  JOIN state s ON s.id = c.id_state
  JOIN country co ON co.id = s.id_country
 WHERE p.id = :id"
            );
        $stmt->bindValue(':id', $id);

        $return = array();
        if($stmt->execute()) {
            $pin = $stmt->fetch();
            $stmt = $this->db->executeQuery("
SELECT pin.id AS id_pin,
       p.number,
       CASE WHEN pt.id <> 3 THEN pt.type
            WHEN pt.id = 3 AND p.other_type IS NOT NULL THEN p.other_type
            ELSE pt.type
        END AS type
  FROM phone p
  JOIN phone_type pt ON pt.id = p.id_phone_type
  JOIN pin ON pin.id = p.id_entity AND p.entity = 'pin'
 WHERE pin.id IN (?)",
                array(array($pin['id'])),
                array(Connection::PARAM_INT_ARRAY)
            );
            if($stmt->execute()) {
                $row = $stmt->fetch();
                if($row) {
                    $pin['phones'][] = array(
                        'number' => $row['number'],
                        'type'   => $row['type']
                    );
                }
            }
        }
        return $pin;
    }

    function save($pin)
    {
        if(array_key_exists('phones', $pin)){
            $phones = $pin['phones'];
            unset($pin['phones']);
        }
        $this->db->insert("pin", $pin);
        $id = $this->db->lastInsertId();
        foreach($phones as $phone) {
            $phone['entity'] = 'pin';
            $phone['id_entity'] = $id;
            $this->db->insert("phone", $phone);
        }
        return $id;
    }

    function update($id, $pin)
    {
        if(array_key_exists('phones', $pin)){
            $phones = $pin['phones'];
            unset($pin['phones']);
            $this->db->delete("phone", array(
                'id_entity' => $id,
                'entity' => 'pin'
            ));
            foreach($phones as $phone) {
                $phone['entity'] = 'pin';
                $phone['id_entity'] = $id;
                $this->db->insert("phone", $phone);
            }
        }
        if($pin['enabled_by']) {
            $stmt = $this->db->prepare("SELECT enabled FROM pin WHERE id = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $current_data = $stmt->fetch();
            if(!$current_data['enabled']) {
                $pin['enabled'] = date('Y-m-d H:i:s');
            }
        }
        $this->db->update('pin', $pin, array('id' => $id));
        return $id;
    }

    function delete($id)
    {
        return $this->db->update(
            'pin',
            array('deleted' => date('Y-m-d H:i:s')),
            array('id' => $id)
        );
    }

}
