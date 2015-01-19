<?php

namespace App\Services;

class PinsService extends BaseService
{

    public function getAll()
    {
        $pins = $this->db->fetchAll(
            "SELECT p.id, co.name AS country, s.name AS state, c.name AS city, d.name AS district, p.name, p.lat, p.lng, p.address, p.link
  FROM pin p
  JOIN district d ON d.id = p.id_district
  JOIN city c ON c.id = d.id_city
  JOIN state s ON s.id = c.id_state
  JOIN country co ON co.id = s.id_country"
        );
        foreach($pins as $row) {
            $return[$row['name'].'_'.$row['id']] = $row;
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
