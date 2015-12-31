<?php

require_once 'model/AbstractDB.php';

class ImagesDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO slika (ime, slika, izdelek_id) "
                        . " VALUES (:ime, :slika, :izdelek_id)", $params);
    }

    public static function update();
    
    public static function delete(array $id) {
        return parent::modify("DELETE FROM slika WHERE id = :id", $id);
    }

    public static function get(array $id) {
        $image = parent::query("SELECT id, ime, slika"
                        . " FROM slika"
                        . " WHERE id = :id", $id);
        
        if (count($image) == 1) {
            return $image[0];
        } else {
            throw new InvalidArgumentException("Slika ne obstaja. ");
        }
    }

    public static function getAll(array $id) {
        return parent::query("SELECT id, ime, slika"
                        . " FROM slika"
                        . " WHERE id = :id", $id);
    }

}