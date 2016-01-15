<?php

require_once 'AbstractDB.php';
require_once 'PostDB.php';

class UsersDB extends AbstractDB {

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
                        . " FROM uporabnik"
                        . " ORDER BY id ASC");
    }
    
    // pogleda če uporabnik aktiven
    public static function isActivate(array $id) {
        $product = parent::query("SELECT aktiven"
                        . " FROM uporabnik"
                        . " WHERE id = :id", $id);
        return $product[0]["aktiven"] == "da";
    }
    
    
    /*
    *  P O I Z V E D O V A N J E   P O   P R O D A J A L C I H
    */
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
            throw new InvalidArgumentException("Tak uporabnik ne obstaja. ");
        }
    }
    
    public static function isSalesman(array $id) {
        $product = parent::query("SELECT uporabnik_id"
                        . " FROM prodajalec"
                        . " WHERE uporabnik_id = :uporabnik_id", $id);
        return count($product) == 1;
    }
    
    public static function getSalesmansName() {
        return parent::query("SELECT ime"
                        . " FROM uporabnik, prodajalec"
                        . " WHERE uporabnik.id = prodajalec.uporabnik_id"
                        . " ORDER BY id ASC");
    }
    
    //Posodabljanje prodajalca
    public static function updateUser(array $params) {
        unset($params["geslo2"]);
        if(strlen($params["geslo"]) != 60) {
            $options = array("cost" => 10);
            $params["geslo"] = password_hash($params["geslo"], PASSWORD_BCRYPT, $options);
        }
        if($params["aktiven"] == 1){
            $params["aktiven"] = "da";
        }
        else {
            $params["aktiven"] = "ne";
        }
        $params["id"] = $_SESSION["uid"];
        $result = self::update($params);
        return $result;
    }
    
    //Posodabljanje dnevnika prodajalca
    public static function updateSalesmanDiary(array $params) {
        return parent::modify("UPDATE prodajalec SET dnevnik_id = :dnevnik_id "
                        . " WHERE uporabnik_id = :uporabnik_id", $params);
    }
    
    //Ustvarjanje prodajalca
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
        if(isset($params["dnevnik_id"])) {
            return parent::modify("INSERT INTO prodajalec (uporabnik_id, dnevnik_id) "
                        . " VALUES (:uporabnik_id, :dnevnik_id)",["uporabnik_id" => $result, "dnevnik_id" => $params["dnevnik_id"]]);
        } else {
            return parent::modify("INSERT INTO prodajalec (uporabnik_id) "
                        . " VALUES (:uporabnik_id)",["uporabnik_id" => $result]);
        }
        
    }
    
    /*
    *  P O I Z V E D O V A N J E   P O   S T R A N K I
    */ 
    public static function getAllCustomers() {
        return parent::query("SELECT *"
                        . " FROM uporabnik, stranka"
                        . " WHERE uporabnik.id = stranka.uporabnik_id"
                        . " ORDER BY id ASC");
    }
    
    public static function getCustomer(array $id) {
        $uporabnik = parent::query("SELECT *"
                        . " FROM uporabnik, stranka, posta"
                        . " WHERE uporabnik.id = stranka.uporabnik_id AND stranka.posta_id = posta.posta"
                        ." AND uporabnik.id = :id ORDER BY id ASC", $id);
        if (count($uporabnik) == 1) {
            return $uporabnik[0];
        } else {
            throw new InvalidArgumentException("Tak uporabnik ne obstaja. ");
        }
    }
    
    public static function isCustomer(array $id) {
        $product = parent::query("SELECT uporabnik_id"
                        . " FROM stranka"
                        . " WHERE uporabnik_id = :uporabnik_id", $id);
        return count($product) == 1;
    }
    
    //Posodabljanje stranke
    public static function updateCustomer(array $params) {
        unset($params["geslo2"]);
        if(strlen($params["geslo"]) != 60) {
            $options = array("cost" => 10);
            $params["geslo"] = password_hash($params["geslo"], PASSWORD_BCRYPT, $options);
        }
        if($params["aktiven"] == 1){
            $params["aktiven"] = "da";
        } else {
            $params["aktiven"] = "ne";
        } if(PostDB::get(["posta" => $params["posta"]]) == null) {
            PostDB::insert(["posta" => $params["posta"], "kraj" => $params["kraj"]]);
        } 
        if(isset($_SESSION["uid"])){
            $params["uporabnik_id"] = $_SESSION["uid"];
        }
        self::update(["ime" => $params["ime"], "priimek" => $params["priimek"], 
            "mail" => $params["mail"], "uporabnisko_ime" => $params["uporabnisko_ime"], 
            "geslo" => $params["geslo"], "aktiven" => $params["aktiven"], "id" => $params["uporabnik_id"]]); 
        return parent::modify("UPDATE stranka SET uporabnik_id = :uporabnik_id, telefon = :telefon, "
                        ."ulica = :ulica, stevilka = :stevilka, posta_id = :posta_id"
                        . " WHERE uporabnik_id = :id", ["uporabnik_id" => $params["uporabnik_id"], "telefon" => $params["telefon"],
                                "ulica" => $params["ulica"], "stevilka"=> $params["stevilka"], "posta_id" => $params["posta"], "id" =>  $params["uporabnik_id"]]);
    }
    
    //Ustavljanje stranke
    public static function insertCustomer(array $params) {
        $options = array("cost" => 10);
        $params["geslo"] = password_hash($params["geslo"], PASSWORD_BCRYPT, $options);
        if(isset($params["aktiven"]) && $params["aktiven"] == 1){
            $params["aktiven"] = "da";
        } else {
            $params["aktiven"] = "ne";
        }
        if(PostDB::get(["posta" => $params["posta"]]) == null) {
            $posta = PostDB::insert(["posta" => $params["posta"], "kraj" => $params["kraj"]]);
        } else {
            $posta = $params["posta"];
        }
        $result = self::insert(["ime" => $params["ime"], "priimek" => $params["priimek"], 
            "mail" => $params["mail"], "uporabnisko_ime" => $params["uporabnisko_ime"], 
            "geslo" => $params["geslo"], "aktiven" => $params["aktiven"]]);
        //var_dump($result, $params, ["uporabnik_id" => $result, "telefon" => $params["telefon"], "ulica" => $params["ulica"], "stevilka"=> $params["stevilka"], "posta_id" => $posta]);
        return parent::modify("INSERT INTO stranka (uporabnik_id, telefon, ulica, stevilka, posta_id) "
                        . " VALUES (:uporabnik_id, :telefon, :ulica, :stevilka, :posta_id)",
                            ["uporabnik_id" => $result, "telefon" => $params["telefon"], "ulica" => $params["ulica"], 
                                "stevilka"=> $params["stevilka"], "posta_id" => $posta]);
        
    }
    /*
    *  P O I Z V E D O V A N J E   P O   A D M I N I S T R A T O R J U
    */
    public static function getPassword(array $uname) {
        $product = parent::query("SELECT id, geslo"
                        . " FROM uporabnik"
                        . " WHERE uporabnisko_ime = :uporabnisko_ime", $uname);
        if (count($product) == 1) {
            return $product[0];
        } else {
            return null;
        }
    }
    
    public static function getAdmin(array $id) {
        $admin = parent::query("SELECT *"
                        . " FROM uporabnik, administrator"
                        . " WHERE uporabnik.id = administrator.uporabnik_id AND uporabnik.id = :id", $id);
        if (count($admin) == 1) {
            return $admin[0];
        } else {
            throw new InvalidArgumentException("Tak uporabnik ne obstaja. ");
        }
    }
    
    public static function isAdmin(array $id) {
        $product = parent::query("SELECT uporabnik_id"
                        . " FROM administrator"
                        . " WHERE uporabnik_id = :uporabnik_id", $id);
        return count($product) == 1;
    }
    
     //Posodabljanje dnevnika administratorja
    public static function updateAdminDiary(array $params) {
        return parent::modify("UPDATE administrator SET dnevnik_id = :dnevnik_id "
                        . " WHERE uporabnik_id = :uporabnik_id", $params);
    }
    
    /*
    *  P O I Z V E D O V A N J E   P O   I M E N U
    *    I N   U P O R A B .   I M E N U
    */
    public static function preveriUpodabniskoImeDodajanje($uime) {
        
        $result = parent::query("SELECT COUNT(id)"
                ."FROM uporabnik WHERE uporabnisko_ime = :uporabnisko_ime", ["uporabnisko_ime" => $uime]);
        return $result[0]["COUNT(id)"] == '0';
    }
    
    public static function preveriUpodabniskoImeSpreminjanje($ime, $vnesenoIme) {
        if($ime != $vnesenoIme){
            return self::preveriUpodabniskoImeDodajanje($ime);
        }
        return 1;
    }

}