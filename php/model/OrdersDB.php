<?php

require_once 'AbstractDB.php';

class OrdersDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO narocilo (uporabnik_id, obdelano, datum) "
                        . " VALUES (:uporabnik_id, 'ne', :datum)", $params);
    }

    public static function update(array $params){
        return parent::modify("UPDATE narocilo SET obdelano = :obdelano"
                        . " WHERE id = :id", $params);
    }
    
    public static function updateConfirmation(array $params){
        return parent::modify("UPDATE narocilo SET potrjeno = :potrjeno"
                        . " WHERE id = :id", $params);
    }
    
    public static function delete(array $id){
        return parent::modify("DELETE FROM narocilo WHERE id = :id", $id);
    }

    public static function get(array $id) {
        $order = parent::query("SELECT *"
                        . " FROM narocilo"
                        . " WHERE id = :id", $id);
        if (count($order) == 1) {
            return $order[0];
        } else {
            throw new InvalidArgumentException("Naročilo ne obstaja. ");
        }
    }

    public static function getAllNonPresent() {
        // --- vsi neobdelani -----
        return parent::query("SELECT *"
                        . " FROM narocilo"
                        . " WHERE obdelano = 'ne'"
                        . " ORDER BY datum ASC");
    }
    
    public static function getOrderProducts($narocilo_id) {
        // --- vsi izdelki narocila -----
        return parent::query("SELECT *"
                        . " FROM izdelek_narocilo, izdelek"
                        . " WHERE izdelek_narocilo.izdelek_id = izdelek.id"
                        . " AND izdelek_narocilo.narocilo_id = :narocilo_id", $narocilo_id);
    }
    
    public static function getAll() {
        return parent::query("SELECT *"
                        . " FROM narocilo"
                        . " ORDER BY id ASC");
    }
    
    public static function getAllPresent() {
        // ---- vsi obdelani - sortirani -----
        return parent::query("SELECT *"
                        . " FROM narocilo"
                        . " WHERE obdelano = 'da'");
    }
    
    public static function getAllProven($sort) {
        // ---- vsi obdelani - sortirani -----
        $values = ["id", "uporabnik_id", "datum"];
        if(!in_array($sort["sort"], $values)){
            $sort["sort"] = "id";
        }
        $orders = parent::query("SELECT *"
                        . " FROM narocilo"
                        . " WHERE obdelano = 'da' AND potrjeno = 'da'"
                        . " ORDER BY ".  $sort["sort"] ." ASC");
        return $orders;
    }

}