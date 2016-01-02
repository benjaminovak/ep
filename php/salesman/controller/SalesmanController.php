<?php

require_once("../model/UsersDB.php");
require_once("../model/OrdersDB.php");
require_once("../model/ProductsDB.php");
require_once("../model/OsebaForm.php");
require_once("../ViewHelper.php");

class SalesmanController {
    
    public static function login($data = ["uname" => "", "password" => "", "authorized_users" => []]) {
        
        $data["authorized_users"] = [];
        $result = UsersDB::getSalesmansName();
        foreach ($result as $value) {
            array_push($data["authorized_users"], $value["ime"]);
        }
        echo ViewHelper::render("view/salesman-login.php", $data);
    }
    
    public static function check() {
        $data = filter_input_array(INPUT_POST, self::getLoginRules());
        
        if (self::checkValues($data)) {
            $username = $data["uname"];            
            $result = UsersDB::getPassword(["uporabnisko_ime" => $username]);
            
            if ($result != null && password_verify($data["password"], $result["geslo"]) && UsersDB::isSalesman(["uporabnik_id" => $result["id"]]) == 1) {
                $_SESSION["active"] = TRUE;
                $_SESSION["role"] = "salesman";
                $_SESSION["id"] = $result["id"];
                ViewHelper::redirect(BASE_URL);
            }
            else{
                unset($data["password"]);
                self::login($data);
            }
            
        } else {
            unset($data["password"]);
            self::login($data);
        }
    }
    
    public static function orders() {
        
        echo ViewHelper::render("view/salesman-orders-list.php", [
            "orders" => OrdersDB::getAllNonPresent()
        ]);
        
    }
    
    public static function orderDetail() {
        
        $rules = [
            "id" => [   
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];
 
        $data = filter_input_array(INPUT_POST, $rules);
        
        if (self::checkValues($data)) {
            $order = OrdersDB::get($data);
            echo ViewHelper::render("view/salesman-order-detail.php", [
                "order" => $order, 
                "products" => OrdersDB::getOrderProducts(["narocilo_id" => $data["id"]]),
                "user" => UsersDB::get(["id" => $order["uporabnik_id"]])
            ]);
        }
        else {
            echo ViewHelper::render("view/salesman-orders-list.php");
        }
        
    }
    
    public static function orderHandling() {
        
        $rules = [
            "id" => [   
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];
 
        $data = filter_input_array(INPUT_GET, $rules);

        if (self::checkValues($data)) {
            OrdersDB::update(["obdelano" => "da", "id" => $data["id"]]);
            ViewHelper::redirect(BASE_URL);
           
        }
        else {
            ViewHelper::redirect(BASE_URL);
        }
        
    }
    
    public static function ordersPresent() {
        
        echo ViewHelper::render("view/salesman-orders-list-present.php", [
            "orders" => OrdersDB::getAllPresent()
        ]);
       
    }
    

    public static function orderPresentDetail() {
        
        $rules = [
            "id" => [   
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];
        
        $data = filter_input_array(INPUT_POST, $rules);
        if($data == null) {
            $data["id"] = $_SESSION["id"];
        }
        if (self::checkValues($data)) {
            $order = OrdersDB::get($data);
            echo ViewHelper::render("view/salesman-order-detail-present.php", [
                "order" => $order, 
                "products" => OrdersDB::getOrderProducts(["narocilo_id" => $data["id"]]),
                "user" => UsersDB::get(["id" => $order["uporabnik_id"]])
            ]);
        }
        else {
            ViewHelper::redirect(BASE_URL);
        }
        
    }
   
    public static function orderConfirmation($insert) {
        
        $rules = [
            "id" => [   
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];
 
        $data = filter_input_array(INPUT_GET, $rules);

        if (self::checkValues($data)) {
            OrdersDB::updateConfirmation(["potrjeno" => $insert, "id" => $data["id"]]);
            $_SESSION["id"] = $data["id"];
            ViewHelper::redirect(BASE_URL."orders/present/detail");
           
        }
        else {
            ViewHelper::redirect(BASE_URL);
        }
        
    }
    
    public static function ordersProven() {
        
        $rules = [
            "sort" => FILTER_SANITIZE_SPECIAL_CHARS
        ];
 
        $sort = filter_input_array(INPUT_GET, $rules);
        
        if (self::checkValues($sort)) {
            echo ViewHelper::render("view/salesman-orders-list-proven.php", [
                "orders" => OrdersDB::getAllProven($sort)
            ]);
        } else {
            ViewHelper::redirect(BASE_URL. "orders/proven?sort=id");
        }
       
    }
    

    public static function orderProvenDetail() {
        
        $rules = [
            "id" => [   
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];
        
        $data = filter_input_array(INPUT_POST, $rules);
        if($data == null) {
            $data["id"] = $_SESSION["id"];
        }
        
        if (self::checkValues($data)) {
            $order = OrdersDB::get($data);
            echo ViewHelper::render("view/salesman-order-detail-proven.php", [
                "order" => $order, 
                "products" => OrdersDB::getOrderProducts(["narocilo_id" => $data["id"]]),
                "user" => UsersDB::get(["id" => $order["uporabnik_id"]])
            ]);
        } else {
            ViewHelper::redirect(BASE_URL);
        }
    }
    
    public static function products() {
        
        echo ViewHelper::render("view/salesman-products-list.php", [
            "products" => ProductsDB::getAll()
        ]);
        
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