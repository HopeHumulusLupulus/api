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
                $row['lat'] = (float)$row['lat'];
                $row['lng'] = (float)$row['lng'];
                $pin_ids[] = $row['id'];
                $return['B_'.$row['id']] = $row;
            }
            $stmt = $this->db->executeQuery("
SELECT pin.id AS id_pin,
       p.number,
       CASE WHEN pt.id <> 3 THEN pt.type
            WHEN pt.id = 3 AND p.other_type IS NOT NULL THEN p.other_type
            ELSE pt.type
        END AS type
  FROM phone_pin p
  JOIN phone_type pt ON pt.id = p.id_phone_type
  JOIN pin ON pin.id = p.id_entity AND p.entity = 'pin'
 WHERE pin.id IN (?)",
                array($pin_ids),
                array(Connection::PARAM_INT_ARRAY)
            );
            if($stmt->execute()) {
                while($row = $stmt->fetch()) {
                    $return['B_'.$row['id_pin']]['phones'][] = array(
                        'number' => $row['number'],
                        'type'   => $row['type']
                    );
                }
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

        if($stmt->execute()) {
            $pin = $stmt->fetch();
            $pin['lat'] = (float)$pin['lat'];
            $pin['lng'] = (float)$pin['lng'];
            $stmt = $this->db->executeQuery("
SELECT pin.id AS id_pin,
       p.number,
       CASE WHEN pt.id <> 3 THEN pt.type
            WHEN pt.id = 3 AND p.other_type IS NOT NULL THEN p.other_type
            ELSE pt.type
        END AS type
  FROM phone_pin p
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

    public function getAddressData($lat, $lng) {
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?'.
            'latlng='.$lat.','.$lng.'&sensor=false&language=pt';
        $response = \file_get_contents($url);
        if($response) {
            $google = json_decode($response, true);
            if(\strtoupper($google['status']) == 'OK') {
                if (isset($google['results'][0]['address_components'])) {
                    foreach($google['results'][0]['address_components'] as $component) {
                        $types = is_array($component['types']) ? $component['types'] : array($componenxt['types']);
                        if (in_array('locality', $types) || in_array('administrative_area_level_2', $types)) {
                            $address['city'] = $component['long_name'];
                        } elseif (in_array('administrative_area_level_1', $types)) {
                            $address['state'] = $component['long_name'];
                        } elseif (in_array('country', $types)) {
                            $address['country'] = $component['long_name'];
                        } elseif (in_array('neighborhood', $types)) {
                            $address['district'] = $component['long_name'];
                        }
                    }
                    $address['full'] = $google['results'][0]['formatted_address'];
                    return $address;
                }
            }
        }
    }

    public function save($pin)
    {
        if(array_key_exists('phones', $pin)){
            $phones = $pin['phones'];
            unset($pin['phones']);
        }
        if(!isset($pin['id_district']) || !$pin['id_district']) {
            $address = $this->getAddressData($pin['lat'], $pin['lng']);
            if(!$pin['address']) {
                $pin['address'] = $address['full'];
            }
            # Country
            $this->country = new CountryService($this->db);
            $country = $this->country->getCountry(array(
                'name' => $address['country']
            ));
            if(!$country) {
                $country = array(
                    'name' => $address['country']
                );
                $country['id'] = $this->country->save($country);
            }
            # State
            $this->state = new StateService($this->db);
            $state = $this->state->getState(array(
                'name' => $address['state'],
                'id_country' => $country['id']
            ));
            if(!$state) {
                $state = array(
                    'name' => $address['state'],
                    'id_country' => $country['id']
                );
                $state['id'] = $this->state->save($state);
            }
            # City
            $this->city = new CityService($this->db);
            $city = $this->city->getCity(array(
                'name' => $address['city'],
                'id_state' => $state['id']
            ));
            if(!$city) {
                $city = array(
                    'name' => $address['city'],
                    'id_state' => $state['id']
                );
                $city['id'] = $this->city->save($city);
            }
            # District
            $this->district = new DistrictService($this->db);
            $district = $this->district->getDistrict(array(
                'name' => $address['district'],
                'id_city' => $city['id']
            ));
            if(!$district) {
                $district = array(
                    'name' => $address['district'],
                    'id_city' => $city['id']
                );
                $district['id'] = $this->district->save($district);
            }
            $pin['id_district'] = $district['id'];
        }
        $this->db->insert("pin", $pin);
        $id = $this->db->lastInsertId('pin_id_seq');
        foreach($phones as $phone) {
            $phone['entity'] = 'pin';
            $phone['id_entity'] = $id;
            $this->db->insert("phone_pin", $phone);
        }
        return $id;
    }

    public function update($id, $pin)
    {
        if(array_key_exists('phones', $pin)){
            $phones = $pin['phones'];
            unset($pin['phones']);
            $this->db->delete("phone_pin", array(
                'id_entity' => $id,
                'entity' => 'pin'
            ));
            foreach($phones as $phone) {
                $phone['entity'] = 'pin';
                $phone['id_entity'] = $id;
                $this->db->insert("phone_pin", $phone);
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

    public function delete($id)
    {
        return $this->db->update(
            'pin',
            array('deleted' => date('Y-m-d H:i:s')),
            array('id' => $id)
        );
    }

}
