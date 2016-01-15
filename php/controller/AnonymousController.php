<?php

require_once("model/UsersDB.php");
require_once("model/ProductsDB.php");
require_once("model/ImagesDB.php");
require_once("model/Activation.php");
require_once("ViewHelper.php");

class AnonymousController {
    
    /*  
    *  R E G I S T R A C I J A   S T R A N K E 
    */
    /*Registracija stranke forma*/
    public static function registration($values = ["ime" => "", "priimek" => "",
        "mail" => "", "uporabnisko_ime" => "", "geslo" => "", "aktiven" => "",
        "telefon" => "", "ulica" => "", "stevilka" => "", "posta" => "", "kraj" => ""]) {
        $values["geslo"] = "";
        $values["geslo2"] = "";
        $values["stranka"] = true;
        $values["vloga"] = "stranka";
        $form = new OsebaForm('registracija', $values, "dodajanje");
        echo ViewHelper::render("view/customer-registration.php", ["form" => $form]);
        
    }
    
    /*Registracija stranke*/
    public static function register($data = []) {
        
        if (self::checkValues($data)) {
            UsersDB::insertCustomer($data);
        } else {
            self::registration();
        }
        
    }
    
    public static function sendConfirmationEmail($mail) {
        $message = " Da bi aktivirali vaš račun pritisnite na naslednjo povezavo:\n\n";
        $message .= "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        $activation = Activation::hashMail($mail);
        $message .= "?email=" . urlencode($mail) . "&key=" . urlencode($activation);
        $sentmail = mail($mail, "Potrditev registracije na spletno trgovino", $message);
        if($sentmail == true) {
            ViewHelper::redirect(BASE_URL."customer/registration/mailsent");
        } else {
            ViewHelper::redirect(BASE_URL."customer/registration/mailfailed");
        }
    }
    
    public static function checkRegistration() {
        $rules = [
            'email' => FILTER_SANITIZE_STRING,
            'key' => FILTER_SANITIZE_STRING,
        ];
        
        $data = filter_input_array(INPUT_GET, self::getLoginRules());
        $mail = urldecode($_GET['email']);
        $activation_key = urldecode($_GET['key']);
        return Activation::checkActivationCode($mail, $activation_key);
    }
    
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