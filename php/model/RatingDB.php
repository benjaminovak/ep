<?php

require_once 'AbstractDB.php';

class RatingDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO ocena (ocena, izdelek_id, stranka_uporabnik_id) "
                        . " VALUES (:ocena, :izdelek_id, :stranka_uporabnik_id)", $params);
    }
    
    public static function update(array $params) {
        return parent::modify("UPDATE ocena SET ocena = :ocena "
                        . " WHERE izdelek_id = :izdelek_id AND stranka_uporabnik_id = :stranka_uporabnik_id", $params);
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM ocena WHERE id = :id", $id);
    }

    public static function get(array $params) {
        return parent::query("SELECT * FROM ocena "
                        . " WHERE izdelek_id = :izdelek_id AND stranka_uporabnik_id = :stranka_uporabnik_id", $params);
        
//        if (count($product) == 1) {
//            return $product[0];
//        } else {
//            throw new InvalidArgumentException("Tak izdelek ne obstaja. ");
//        }
    }
    
    public static function getAverage(array $params) {
        $avg = parent::query("SELECT AVG(ocena) FROM ocena WHERE izdelek_id = :izdelek_id", $params);
//        echo count($avg);
//        var_dump($avg);
        if($avg[0]['AVG(ocena)'] == null){
            return number_format((float)0, 2, '.', '');
        } else {
            return number_format((float)$avg[0]['AVG(ocena)'], 2, '.', '');
        }
    }

    public static function getAll() {
        return parent::query("SELECT *"
                        . " FROM ocena"
                        . " ORDER BY id ASC");
    }
    
}
