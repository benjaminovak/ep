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
                ViewHelper::redirect(BASE_URL."customer");
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
    *  P R I K A Z   I Z D E L K O V     
    */
    
    public static function products() {
        
        $products = ProductsDB::getAllActive();
        foreach ($products as $value) {
            $images[$value["id"]] = ImagesDB::getProdutFirst(["izdelek_id" => $value["id"]]);
        }
        echo ViewHelper::render("view/customer-products-list.php", [
            "products" => $products, "images" => $images
        ]);
        
    }
    
    public static function productsDetail() {
        
        $data = filter_input_array(INPUT_GET, self::getIdRules());
     
        if (self::checkValues($data)) {
            $product = ProductsDB::get($data);
            $images = ImagesDB::getProdutAll(["izdelek_id" => $product["id"]]);
            echo ViewHelper::render("view/customer-products-detail.php", [
                "product" => $product, "images" => $images
            ]);
        } else {
            ViewHelper::redirect(BASE_URL);
        }
        
    }
   
    public static function addToCart($where = "detail") {
        
        $action = filter_input(INPUT_POST, "do", FILTER_SANITIZE_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        
        if ($action == "add_into_cart") {
            if (!isset($_SESSION["CART"][$id])) {
                $_SESSION["CART"][$id] = 1;
            } else {
                $_SESSION["CART"][$id]++;
            }
        }
        
        if ($where == "detail") {
            ViewHelper::redirect(BASE_URL."customer/product/detail?id=".$id);
        }
        else{
            ViewHelper::redirect(BASE_URL."customer");
        }
    }
    
    public static function cart() {
        
        $action = filter_input(INPUT_POST, "do", FILTER_SANITIZE_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        
        foreach($_SESSION["CART"] as $id => $value){
            $izdelki[$id] = ProductsDB::get(["id" => $id]);
            $izdelki[$id]["skupaj"] = $value;
        }
        echo ViewHelper::render("view/customer-cart.php", [
            "products" => $izdelki
        ]);
        
    }
    
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
    
    private static function getIdRules() {
        return [
                "id" => [   
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => ['min_range' => 1]
                    ]
                ];
    }
    
}