<?php

// enables sessions for the entire app
session_start();

require_once("controller/SalesmanController.php");
require_once("../admin/controller/AdminController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "../static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "../static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

/* Uncomment to see the contents of variables
  var_dump(BASE_URL);
  var_dump(IMAGES_URL);
  var_dump(CSS_URL);
  var_dump($path);
  exit(); */

// ROUTER: defines mapping between URLS and controllers
$urls = [
    "" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "salesman"){
            ViewHelper::redirect(BASE_URL . "orders"); 
        } else{
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                SalesmanController::check(); 
            } else {
                SalesmanController::login(); 
            }
        }
    },
    "logout" => function(){
        session_unset();
        ViewHelper::redirect(BASE_URL);
    }, 
    "orders" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "salesman"){
            SalesmanController::orders();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "orders/detail" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "salesman"){
            SalesmanController::orderDetail();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    }, 
    "order/handling" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "salesman"){
            SalesmanController::orderHandling();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "orders/present" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "salesman"){
           SalesmanController::ordersPresent();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "orders/present/detail" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "salesman"){
            SalesmanController::orderPresentDetail();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "order/confirmation" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "salesman"){
            SalesmanController::orderConfirmation("da");
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "order/cancellation" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "salesman"){
            SalesmanController::orderConfirmation("ne");
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "orders/proven" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "salesman"){
           SalesmanController::ordersProven();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "orders/proven/detail" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "salesman"){
            SalesmanController::orderProvenDetail();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "products" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "salesman"){
            SalesmanController::products();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },    
    "products/edit" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "salesman"){
            SalesmanController::updateProductForm();
        } else{
            unset($_SESSION["uid"]);
            unset($_SESSION["uname"]);
            ViewHelper::redirect(BASE_URL);
        }
    }, 
    "products/add" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "salesman"){
            SalesmanController::addProductForm();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "profile" => function() {
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "salesman"){
            AdminController::profileForm();
        } else{
            unset($_SESSION["uid"]);
            unset($_SESSION["uname"]);
            ViewHelper::redirect(BASE_URL);
        } 
    },
    "users/add" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "salesman"){
            AdminController::addUserForm();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
];


try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        var_dump($urls, $path);
        echo "No controller for '$path'";
    }
} catch (InvalidArgumentException $e) {
    var_dump($urls, $path);
    ViewHelper::error404();
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
} 
