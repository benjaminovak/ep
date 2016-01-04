<?php

require_once("model/UsersDB.php");
require_once("model/ProductsDB.php");
require_once("model/ImagesDB.php");
require_once("ViewHelper.php");

class AnonymousController {
    
    /*  
    *  P R I K A Z   I Z D E L K O V     
    */
    
    public static function products() {
        
        $products = ProductsDB::getAllActive();
        foreach ($products as $value) {
            $images[$value["id"]] = ImagesDB::getProdutFirst(["izdelek_id" => $value["id"]]);
        }
        echo ViewHelper::render("view/anonymous-products-list.php", [
            "products" => $products, "images" => $images
        ]);
        
    }
    
    public static function productsDetail() {
        
        $data = filter_input_array(INPUT_GET, self::getIdRules());
     
        if (self::checkValues($data)) {
            $product = ProductsDB::get($data);
            $images = ImagesDB::getProdutAll(["izdelek_id" => $product["id"]]);
            echo ViewHelper::render("view/anonymous-products-detail.php", [
                "product" => $product, "images" => $images
            ]);
        } else {
            ViewHelper::redirect(BASE_URL);
        }
        
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