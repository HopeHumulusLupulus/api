<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
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
            foreach($return as $key => $value) {
                unset($return[$key]);
                $return[$value['name'].'_'.$value['id']] = $value;
            }
        }
        return $return;
    }

    public function getOne()
    {
        return $this->db->fetchAll("SELECT * FROM pin");
    }

    function save($pin)
    {
        $this->db->insert("pin", $pin);
        return $this->db->lastInsertId();
    }

    function update($id, $pin)
    {
        return $this->db->update('pin', $pin, ['id' => $id]);
    }

    function delete($id)
    {
        return $this->db->delete("pin", array("id" => $id));
    }

}
