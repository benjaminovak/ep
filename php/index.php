<?php

// enables sessions for the entire app
session_start();

require_once("controller/CustomerController.php");
require_once("controller/AnonymousController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "../static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "../static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
    "" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            ViewHelper::redirect(BASE_URL . "customer");
        } else{
            AnonymousController::products(); 
        }
    },
    "customer/login" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            ViewHelper::redirect(BASE_URL . "customer");
        }
        elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            CustomerController::check(); 
        } else {
            CustomerController::login(); 
        }
    }, 
    "customer/logout" => function(){
        session_unset();
        ViewHelper::redirect(BASE_URL);
    }, 
    "product/detail" => function(){
        
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            ViewHelper::redirect(BASE_URL . "customer");
        } else{
            AnonymousController::productsDetail();
        }
    },
    "orders" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            CustomerController::orders();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "orders/detail" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            CustomerController::orderDetail();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    }, 
    "orders/canceled" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
           CustomerController::ordersCancelled();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "orders/canceled/detail" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            CustomerController::orderCancelledDetail();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "orders/proven" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            CustomerController::ordersProven();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "orders/proven/detail" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            CustomerController::orderProvenDetail();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "customer" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                CustomerController::addToCart("list"); 
            } else {
                CustomerController::products();
            } 
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "customer/profil" => function() {
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            CustomerController::profileForm();
        } else{
            unset($_SESSION["uid"]);
            unset($_SESSION["uname"]);
            ViewHelper::redirect(BASE_URL);
        } 
    },
    "customer/product/detail" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                CustomerController::addToCart(); 
            } else {
                CustomerController::productsDetail();
            }
        } else{
 
            ViewHelper::redirect(BASE_URL);
        }
    },
    "customer/cart"  => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                CustomerController::addToCart(); 
            } else {
                CustomerController::cart();
            }
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "customer/cart/edit" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                CustomerController::edit(); 
            } else {
                ViewHelper::redirect(BASE_URL);
            }
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "customer/cart/delete" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                CustomerController::delete(); 
            } else {
                ViewHelper::redirect(BASE_URL);
            }
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "customer/checkout" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                CustomerController::order();
            } else {
                ViewHelper::redirect(BASE_URL."customer/cart");
            }
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "customer/checkout/order" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "customer"){
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                CustomerController::saveOrder();
            } else {
                ViewHelper::redirect(BASE_URL."customer/cart");
            }
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
];


try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (InvalidArgumentException $e) {
    var_dump($urls, $path);
    ViewHelper::error404();
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
} 
