<?php

require_once 'model/AbstractDB.php';

class UsersDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO uporabnik (ime, priimek, mail, uporabnisko_ime, geslo, aktiven) "
                        . " VALUES (:ime, :priimek, :mail, :uporabnisko_ime, :geslo, :aktiven)", $params);
    }

    public static function insertUser(array $params) {
        unset($params["geslo2"]);
        $options = array("cost" => 10);
        $params["geslo"] = password_hash($params["geslo"], PASSWORD_BCRYPT, $options);
        if($params["aktiven"] == 1){
            $params["aktiven"] = "da";
        }
        else {
            $params["aktiven"] = "ne";
        }
        $result = self::insert($params);
        return parent::modify("INSERT INTO prodajalec (uporabnik_id) "
                        . " VALUES (:uporabnik_id)",["uporabnik_id" => $result]);
        
    }
    
    public static function update(array $params) {
        return parent::modify("UPDATE uporabnik SET ime = :ime, priimek = :priimek, mail = :mail, "
                        . "uporabnisko_ime = :uporabnisko_ime, geslo = :geslo, aktiven = :aktiven"
                        . " WHERE id = :id", $params);
    }
    
    public static function updateUser(array $params) {
        unset($params["geslo2"]);
        $options = array("cost" => 10);
        $params["geslo"] = password_hash($params["geslo"], PASSWORD_BCRYPT, $options);
        if($params["aktiven"] == 1){
            $params["aktiven"] = "da";
        }
        else {
            $params["aktiven"] = "ne";
        }
        $params["id"] = $_SESSION["uid"];
        var_dump($params);
        $result = self::update($params);
        return parent::modify("INSERT INTO prodajalec (uporabnik_id) "
                        . " VALUES (:uporabnik_id)",["uporabnik_id" => $result]);
        
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM uporabnik WHERE id = :id", $id);
    }

    public static function get(array $id) {
        $product = parent::query("SELECT *"
                        . " FROM uporabnik"
                        . " WHERE id = :id", $id);
        
        if (count($product) == 1) {
            return $product[0];
        } else {
            throw new InvalidArgumentException("Tak izdelek ne obstaja. ");
        }
    }
        
    public static function getAll() {
        return parent::query("SELECT *"
                        . " FROM uporabnik"
                        . " ORDER BY id ASC");
    }
    
    public static function getAllSalesmans() {
        return parent::query("SELECT *"
                        . " FROM uporabnik, prodajalec"
                        . " WHERE uporabnik.id = prodajalec.uporabnik_id"
                        . " ORDER BY id ASC");
    }
    
    public static function getSalesman(array $id) {
        $uporabnik = parent::query("SELECT *"
                        . " FROM uporabnik, prodajalec"
                        . " WHERE uporabnik.id = prodajalec.uporabnik_id AND uporabnik.id = :id"
                        . " ORDER BY id ASC", $id);
        if (count($uporabnik) == 1) {
            return $uporabnik[0];
        } else {
            throw new InvalidArgumentException("Tak izdelek ne obstaja. ");
        }
    }
    
    public static function getPassword(array $uname) {
        $product = parent::query("SELECT id, geslo"
                        . " FROM uporabnik"
                        . " WHERE uporabnisko_ime = :uporabnisko_ime", $uname);
        
        if (count($product) == 1) {
            return $product[0];
        } else {
            throw new InvalidArgumentException("Tak izdelek ne obstaja. ");
        }
    }
    
    public static function isAdmin(array $id) {
        $product = parent::query("SELECT uporabnik_id"
                        . " FROM administrator"
                        . " WHERE uporabnik_id = :uporabnik_id", $id);
        
        if (count($product) == 1) {
            return 1;
        } else {
            return 0;
        }
    }

}