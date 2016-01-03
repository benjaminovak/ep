<?php

require_once("../model/UsersDB.php");
require_once("../model/OrdersDB.php");
require_once("../model/ProductsDB.php");
require_once("../model/OsebaForm.php");
require_once("../model/ProductForm.php");
require_once("../ViewHelper.php");

class SalesmanController {
    
    /*
     *  
     *  P R I J A V A
     * 
     *      
     */
    
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
    
    /*
     *  
     *  D E L O  Z  N A R O Č I L I
     * 
     *      
     */
    /*Prikaz vseh neobdelanih naročil*/
    public static function orders() {
        
        echo ViewHelper::render("view/salesman-orders-list.php", [
            "orders" => OrdersDB::getAllNonPresent()
        ]);
        
    }
    
    /*Prikaz naročila*/
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
    
    /*Prestavitev naročila med obdelane*/
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
    
    /*Vsa obdelana naročila*/
    public static function ordersPresent() {
        
        echo ViewHelper::render("view/salesman-orders-list-present.php", [
            "orders" => OrdersDB::getAllPresent()
        ]);
       
    }
    
    /*Eno obdelano naročilo*/
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
   
    /*Potrjevanje ali preklic naročila*/
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
    
    /*Vsa potrjena naročila*/
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
    
    /*Eno potrjeno naročila*/
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
    
    /*
     *  
     *  D E L O  Z  I Z D E L K I
     * 
     *      
     */
    /*Vsi izdelki*/
    public static function products() {
        
        echo ViewHelper::render("view/salesman-products-list.php", [
            "products" => ProductsDB::getAll()
        ]);
        
    }
    
    /*Posodabljanje izdelka -forma*/
    public static function updateProductForm($values = ["naziv" => "", "cena" => "",
        "opis" => "", "ektiven" => ""]){
        
        $rules = [
            "id" => [   
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];
 
        $data = filter_input_array(INPUT_POST, $rules);
        

        if (self::checkValues($data)) { 
            $result = ProductsDB::get($data);
            $_SESSION["pid"] = $data["id"];
            $_SESSION["pname"] = $result["naziv"];
            $form = new ProductForm('registracija', $result, "spreminjanje");
            echo ViewHelper::render("view/salesman-product-edit.php", ["form" => $form]);
        }
        else {
            $form = new ProductForm('registracija', $values, "spreminjanje");
            echo ViewHelper::render("view/salesman-product-edit.php", ["form" => $form]);
        }
    }
    
    /*Posodabljanje izdelka*/
    public static function updateProduct($data = []) {

        if (self::checkValues($data)) {
            ProductsDB::updateProduct($data);
        }
        echo ViewHelper::redirect(BASE_URL . "products");
         
    }
    
    /*Dodajanje izdelka -forma*/
    public static function addProductForm($values = ["naziv" => "", "cena" => "",
        "opis" => "", "ektiven" => ""]) {
        $form = new ProductForm('registracija', $values, "dodajanje");
        echo ViewHelper::render("view/salesman-product-add.php", ["form" => $form]);
    }
    
    /*Dodajanje izdelka*/
    public static function addProduct($data = []) {
        
        if (self::checkValues($data)) {
            ProductsDB::addProduct($data);
            echo ViewHelper::redirect(BASE_URL . "products");
        } else {
            self::addUserForm();
        }
    }
    
    /*
     *  
     *  D E L O   Z   S T R A N K A M I
     *      
     */
    /*Vsi uporabniki*/
    public static function users() {
        
        echo ViewHelper::render("view/salesman-users-list.php", [
            "users" => UsersDB::getAllCustomers()
        ]);
        
    }
    
    /*Posodabljanje profila - forma*/
    public static function profileForm() {
        $result = UsersDB::getSalesman(["id" => $_SESSION["id"]]);
        $result["geslo2"] = $result["geslo"];
        $_SESSION["uid"] = $_SESSION["id"];
        $_SESSION["uname"] = $result["uporabnisko_ime"];
        $form = new OsebaForm('registracija', $result, "profil");
        echo ViewHelper::render("view/salesman-profile.php", ["form" => $form]);
    }
    
    /*Posodabljanje profila*/
    public static function profile($data = []) {
        
        if (self::checkValues($data)) {
            $data["aktiven"] = "da";
            UsersDB::updateUser($data);
        }
        echo("Uspešno posodobljen profil.");
        
    }
    
    /*Posodabljanje uporabnika Stranka - forma*/
    public static function updateUserForm($values = ["ime" => "", "priimek" => "",
        "mail" => "", "uporabnisko_ime" => "", "geslo" => "", "aktiven" => "",
        "telefon" => "", "ulica" => "", "stevilka" => "", "posta" => "", "kraj" => ""]){
        
        $rules = [
            "id" => [   
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];
 
        $data = filter_input_array(INPUT_POST, $rules);

        if (self::checkValues($data)) {
            $result = UsersDB::getCustomer($data);
            $_SESSION["uid"] = $data["id"];
            $_SESSION["uname"] = $result["uporabnisko_ime"];
        } else {
            $result = UsersDB::getCustomer(["id" => $_SESSION["uid"]]);
        }
       
        $result["geslo2"] = $result["geslo"];
        $result["stranka"] = true;
        
        $form = new OsebaForm('registracija', $result, "spreminjanje");
        echo ViewHelper::render("view/salesman-user-edit.php", ["form" => $form]);
        
    }
    
    /*Posodabljanje uporabnika Stranka*/
    public static function updateUser($data = []) {

        if (self::checkValues($data)) {
            UsersDB::updateCustomer($data);
            echo ViewHelper::redirect(BASE_URL . "users");
        } else {
            self::updateUserForm();
        }
        
    }
    
    /*Dodajanje uporabnika Stranka - forma*/
    public static function addUserForm($values = ["ime" => "", "priimek" => "",
        "mail" => "", "uporabnisko_ime" => "", "geslo" => "", "aktiven" => "",
        "telefon" => "", "ulica" => "", "stevilka" => "", "posta" => "", "kraj" => ""]) {
        $values["geslo"] = "";
        $values["geslo2"] = "";
        $values["stranka"] = true;
        $form = new OsebaForm('registracija', $values, "dodajanje");
        echo ViewHelper::render("view/salesman-user-add.php", ["form" => $form]);
    }
    
    /*Dodajanje uporabnika Stranka*/
    public static function addUser($data = []) {
        
        if (self::checkValues($data)) {
            UsersDB::insertCustomer($data);
            echo ViewHelper::redirect(BASE_URL . "users");
        } else {
            self::addUserForm();
        }
        
    }
    
    
    
    /*
    *  
    *  P R E V E R J A N J E   V H O D O V 
    * 
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