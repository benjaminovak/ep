<?php

require_once(dirname(__FILE__)."/../controller/CustomerController.php");
require_once(dirname(__FILE__)."/../model/UsersDB.php");

/**
 * Help methods for api calls
 */
class ApiUtils {
    
    public static function isLoginSuccessful() {
        $data = filter_input_array(INPUT_POST, CustomerController::getLoginRules());
        
        if (CustomerController::checkValues($data)) {
            $username = $data["uname"];            
            $result = UsersDB::getPassword(["uporabnisko_ime" => $username]);
            
            if ($result != null && password_verify($data["password"], $result["geslo"]) && 
                    UsersDB::isCustomer(["uporabnik_id" => $result["id"]]) && UsersDB::isactivate(["id" => $result["id"]])) {
                $_SESSION["active"] = TRUE;
                $_SESSION["role"] = "customer";
                $_SESSION["id"] = $result["id"];
                return true;
            }
        }
        
        return false;
    }
    
    public static function addInCart() {
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        
        if (!isset($_SESSION["CART"][$id])) {
            $_SESSION["CART"][$id] = 1;
        } else {
            $_SESSION["CART"][$id]++;
        }
        echo json_encode($_SESSION["CART"]);
    }
    
}
