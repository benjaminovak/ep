<?php

require_once 'AbstractDB.php';

class ProductsDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO izdelek (naziv, cena, opis, aktiven) "
                        . " VALUES (:naziv, :cena, :opis, :aktiven)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE izdelek SET naziv = :naziv, cena = :cena, "
                        . "opis = :opis, aktiven = :aktiven"
                        . " WHERE id = :id", $params);
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM izdelek WHERE id = :id", $id);
    }

    public static function get(array $id) {
        $product = parent::query("SELECT *"
                        . " FROM izdelek"
                        . " WHERE id = :id", $id);
        
        if (count($product) == 1) {
            return $product[0];
        } else {
            throw new InvalidArgumentException("Tak izdelek ne obstaja. ");
        }
    }

    public static function getAllActive() {
        return parent::query("SELECT *"
                        . " FROM izdelek WHERE aktiven = 'da'"
                        . " ORDER BY id ASC");
    }

    
    public static function getAll() {
        return parent::query("SELECT *"
                        . " FROM izdelek"
                        . " ORDER BY id ASC");
    }
    
}
