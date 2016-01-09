<?php

require_once(dirname(__FILE__)."/../controller/CustomerController.php");
require_once(dirname(__FILE__)."/../model/UsersDB.php");
require_once(dirname(__FILE__)."/../model/OrdersDB.php");

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
                session_start();
                $_SESSION["active"] = TRUE;
                $_SESSION["role"] = "customer";
                $_SESSION["id"] = $result["id"];
                return true;
            }
        }
        
        return false;
    }
    
    public static function addInCart($id) {
        if (!isset($_SESSION["CART"][$id])) {
            $_SESSION["CART"][$id] = 1;
        } else {
            $_SESSION["CART"][$id]++;
        }
        http_response_code(200);
        echo json_encode($_SESSION["CART"]);
    }
    
    public static function removeFromCart($id) {
        if (isset($_SESSION["CART"][$id])) {
            unset($_SESSION["CART"][$id]);
        }
        http_response_code(200);
        echo json_encode($_SESSION["CART"]);
    }
    
    public static function getCartProducts() {
        $izdelki = [];
        if (isset($_SESSION["CART"])){
            foreach($_SESSION["CART"] as $id => $value){
                $izdelek = ProductsDB::get(["id" => $id]);
                $izdelek["vseh"] = $value;
                $izdelki[] = $izdelek;
            }
            http_response_code(200);
            echo json_encode($izdelki);
        } else {
            http_response_code(204);
        }

        
    }
    
    public static function editCart($id) {
        $inputParams = null;
        $kolicina = parse_str(file_get_contents("php://input"), $inputParams);
//        $kolicina = filter_input(INPUT_PUT, "kolicina", FILTER_VALIDATE_INT);
        $filteredInput = filter_var_array($inputParams, FILTER_VALIDATE_INT);
        $kolicina = $filteredInput["kolicina"];
        
        if ($kolicina > 0) {
            $_SESSION["CART"][$id] = $kolicina;
        } else {
            unset($_SESSION["CART"][$id]);
            if (empty($_SESSION["CART"])) {
                unset($_SESSION["CART"]);
            }
        }
        http_response_code(204);
    }
    
    public static function saveOrder() {
        $t=time();
        $timestamp = date("Y-m-d, H:i:s",$t);
        $narocil_id = OrdersDB::insert(["uporabnik_id" => $_SESSION["id"], "datum" => $timestamp]);
        foreach($_SESSION["CART"] as $id => $value){
            OrdersDB::insertOrderProduct(["kolicina" => $value, "narocilo_id" => $narocil_id, "izdelek_id" => $id]);
        }
        if(isset($_SESSION["CART"])) {
            unset($_SESSION["CART"]);
        }
        http_response_code(204);
    }
    
    public static function orders() {
        $narocila = OrdersDB::getAllUserOrders(["uporabnik_id" => $_SESSION["id"]]);
        http_response_code(200);
        echo json_encode($narocila);
    }
    
    public static function ordersProven() {
        $sort["sort"] = "id";
        $narocila = OrdersDB::getUserAllProven($sort, ["uporabnik_id" => $_SESSION["id"]]);
        http_response_code(200);
        echo json_encode($narocila);
    }
    
    public static function ordersCancelled() {
        $narocila = OrdersDB::getUserAllCancelled(["uporabnik_id" => $_SESSION["id"]]);
        http_response_code(200);
        echo json_encode($narocila);
    }
    
    public static function getOrderProducts($narocilo_id) {
        $izdelki = OrdersDB::getOrderProducts(["narocilo_id" => $narocilo_id]);
        http_response_code(200);
        echo json_encode($izdelki);
    }
    
}
