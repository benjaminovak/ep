<?php

require_once 'AbstractDB.php';

class ProductsDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO Izdelki (naziv, cena, opis, aktiven) "
                        . " VALUES (:naziv, :cena, :opis, :aktiven)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE Izdelki SET naziv = :naziv, cena = :cena, "
                        . "opis = :opis, aktiven = :aktiven"
                        . " WHERE id = :id", $params);
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM Izdelki WHERE id = :id", $id);
    }

    public static function get(array $id) {
        $product = parent::query("SELECT *"
                        . " FROM Izdelki"
                        . " WHERE id = :id", $id);
        
        if (count($product) == 1) {
            return $product[0];
        } else {
            throw new InvalidArgumentException("Tak izdelek ne obstaja. ");
        }
    }

    public static function getAllActive() {
        return parent::query("SELECT *"
                        . " FROM Izdelki WHERE aktiven = 'da'"
                        . " ORDER BY id ASC");
    }

    
    public static function getAll() {
        return parent::query("SELECT *"
                        . " FROM Izdelki"
                        . " ORDER BY id ASC");
    }
    
}
