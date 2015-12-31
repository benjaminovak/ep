<?php

require_once("model/UsersDB.php");
require_once("model/OsebaForm.php");
require_once("ViewHelper.php");

class AdminController {
    
    public static function login($data = ["uname" => "", "password" => ""]) {
        echo ViewHelper::render("view/admin-login.php", $data);
    }
    
    public static function check() {
        $data = filter_input_array(INPUT_POST, self::getLoginRules());
        
        if (self::checkValues($data)) {
            $username = $data["uname"];
            
            
            $result = UsersDB::getPassword(["uporabnisko_ime" => $username]);
            if (password_verify($data["password"], $result["geslo"]) && UsersDB::isAdmin(["uporabnik_id" => $result["id"]]) == 1) {
                $_SESSION["active"] = TRUE;
                $_SESSION["role"] = "admin";
                $_SESSION["id"] = $result["id"];
                ViewHelper::redirect(BASE_URL."admin");
            }
            else{
                $data["password"] = "";
                self::login($data);
            }
            
        } else {
            //sicer prikažemo obrazec, ki ni uspel
            $data["password"] = "";
            self::login($data);
        }
    }
    
    public static function users() {
        
        echo ViewHelper::render("view/admin-users-list.php", [
            "users" => UsersDB::getAllSalesmans()
        ]);
        
    }
    
    public static function updateUserForm($values = ["ime" => "", "priimek" => "",
        "mail" => "", "uporabnisko_ime" => "", "geslo" => "", "aktiven" => ""]){
        
        $rules = [
            "id" => [   
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];
 
        $data = filter_input_array(INPUT_POST, $rules);
        

        if (self::checkValues($data)) { 
            $result = UsersDB::getSalesman($data);
            $result["geslo2"] = $result["geslo"];
            $_SESSION["uid"] = $data["id"];
            $form = new OsebaForm('registracija', $result);
            echo ViewHelper::render("view/admin-user-edit.php", ["form" => $form]);
        }
        else {
            $values["geslo2"] = $values["geslo"];
            $form = new OsebaForm('registracija', $values);
            echo ViewHelper::render("view/admin-user-edit.php", ["form" => $form]);
        }
    }
    
    public static function updateUser($data = []) {

        if (self::checkValues($data)) {
            UsersDB::updateUser($data);
        }
        echo ViewHelper::redirect(BASE_URL . "admin/users");
         
    }
    
    public static function addUserForm($values = ["ime" => "", "priimek" => "",
        "mail" => "", "uporabnisko_ime" => "", "geslo" => "", "aktiven" => ""]) {
        $values["geslo"] = "";
        $values["geslo2"] = "";
        $form = new OsebaForm('registracija', $values);
        echo ViewHelper::render("view/admin-user-add.php", ["form" => $form]);
    }
    
    public static function addUser($data = []) {
        
        // potrebno je dodati še preverjanje, če je slučajno user z enakim uporabniškim imenom že v bazi
        // enako je treba če urejamo podatke
        if (self::checkValues($data)) {
            UsersDB::insertUser($data);
            echo ViewHelper::redirect(BASE_URL . "admin/users");
        } else {
            //sicer prikažemo obrazec, ki ni uspel
            self::addUserForm();
        }
    }
    
    private static function checkValues($input) {
        if (empty($input)) {
            return FALSE;
        }

        $result = TRUE;
        foreach ($input as $value) {
            $result = $result && $value != false;
        }

        return $result;
    }
    
    private static function getLoginRules() {
        return [
            'uname' => FILTER_SANITIZE_STRING,
            'password' => FILTER_SANITIZE_STRING
        ];
    }
    
}