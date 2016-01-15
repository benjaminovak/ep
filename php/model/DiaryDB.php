<?php

require_once 'AbstractDB.php';
require_once 'PostDB.php';
require_once 'UsersDB.php';

class DiaryDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO uporabnik (ime, priimek, mail, uporabnisko_ime, geslo, aktiven) "
                        . " VALUES (:ime, :priimek, :mail, :uporabnisko_ime, :geslo, :aktiven)", $params);
    }
    
    public static function update(array $params) {
        return parent::modify("UPDATE uporabnik SET ime = :ime, priimek = :priimek, mail = :mail, "
                        . "uporabnisko_ime = :uporabnisko_ime, geslo = :geslo, aktiven = :aktiven"
                        . " WHERE id = :id", $params);
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
                        . " FROM akcija");
    }
    
    public static function insertDiary() {
        return parent::modify("INSERT INTO dnevnik VALUES(default(id))");
    }
    
    public static function addAction($user_id, $msg) {
        $user = null;
        $dnevnik_id = null;
        if (UsersDB::isSalesman(["uporabnik_id" => $user_id])) {
            $user = UsersDB::getSalesman(["id" => $user_id]);
            $dnevnik_id = $user["dnevnik_id"];
            if(!isset($user["dnevnik_id"])) {
//                echo $user_id;
//                echo $msg;
//                a;
                $params["uporabnik_id"] = $user_id;
                $dnevnik_id = $params["dnevnik_id"] = self::insertDiary();
                UsersDB::updateSalesmanDiary($params);
            }
        } else if (UsersDB::isAdmin(["uporabnik_id" => $user_id])) {
            $user = UsersDB::getAdmin(["id" => $user_id]);
            $dnevnik_id = $user["dnevnik_id"];
            if(!isset($user["dnevnik_id"])) {
                $params["uporabnik_id"] = $user_id;
                $dnevnik_id = $params["dnevnik_id"] = self::insertDiary();
                UsersDB::updateAdminDiary($params);
            }
        } else {
            throw new InvalidArgumentException("Le administrator in prodajalec lahko dodajata vnose v dnevnik.");
        }
        $actionParams["dnevnik_id"] = $dnevnik_id;
        $actionParams["opis"] = $msg;
        return parent::modify("INSERT INTO akcija (dnevnik_id, opis) "
                        . " VALUES (:dnevnik_id, :opis)", $actionParams);
    }
    
}