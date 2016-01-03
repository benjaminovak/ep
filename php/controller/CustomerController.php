<?php

require_once("model/UsersDB.php");
require_once("model/ProductsDB.php");
require_once("ViewHelper.php");

class CustomerController {
    
    /*  
    *  P R I J A V A   I N   O D J A V A
    */
    public static function login($data = ["uname" => "", "password" => "", "authorized_users" => ["Admin"]]) {
        
        echo ViewHelper::render("view/customer-login.php", $data);
        
    }
    
    public static function check() {
        $data = filter_input_array(INPUT_POST, self::getLoginRules());
        
        if (self::checkValues($data)) {
            $username = $data["uname"];            
            $result = UsersDB::getPassword(["uporabnisko_ime" => $username]);
            
            if ($result != null && password_verify($data["password"], $result["geslo"]) && UsersDB::isCustomer(["uporabnik_id" => $result["id"]]) == 1) {
                $_SESSION["active"] = TRUE;
                $_SESSION["role"] = "customer";
                $_SESSION["id"] = $result["id"];
                ViewHelper::redirect(BASE_URL);
            }
            else{
                $data["password"] = "";
                self::login($data);
            }
            
        } else {
            $data["password"] = "";
            self::login($data);
        }
    }
    /*  
    *  P R E V E R J A N J E   V H O D O V      
    */
   
    
    /*
    *  
    *  P R E V E R J A N J E   V H O D O V
    *      
    */
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