<?php

// enables sessions for the entire app
session_start();

require_once("controller/ProductsController.php");
require_once("controller/AdminController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

/* Uncomment to see the contents of variables
  var_dump(BASE_URL);
  var_dump(IMAGES_URL);
  var_dump(CSS_URL);
  var_dump($path);
  exit(); */

// ROUTER: defines mapping between URLS and controllers
$urls = [
    "admin" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "admin"){
            ViewHelper::redirect(BASE_URL . "admin/users");
        } else{
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                AdminController::check(); 
            } else {
                AdminController::login(); 
            }
        }
    },
    "admin/users" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "admin"){
            AdminController::users();
        } else{
            ViewHelper::redirect(BASE_URL . "admin");
        }
    },
    "admin/users/edit" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "admin"){
            AdminController::users();
        } else{
            ViewHelper::redirect(BASE_URL . "admin");
        }
    },
    "admin/logout" => function(){
        $_SESSION["active"] = "";
        $_SESSION["role"] = "";
        $_SESSION["id"] = "";
        ViewHelper::redirect(BASE_URL . "admin");
    },  
    "admin/users/add" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "admin"){
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                AdminController::addUser();
            } else {
                AdminController::addUserForm();
            }
        } else{
            ViewHelper::redirect(BASE_URL . "admin");
        }
    },
    "books" => function () {
        BooksController::index(); 
    },
    "books/add" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            BooksController::add();
        } else {
            BooksController::addForm();
        }
    },
    "books/edit" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            BooksController::edit();
        } else {
            BooksController::editForm();
        }
    },
    "books/delete" => function () {
        BooksController::delete();
    },
    "" => function () {
        //ViewHelper::redirect(BASE_URL . "books");
        
    },
];

//sparsamo funkcijo in jo skusamo poklicat, ce ne ulovimo napako
try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (InvalidArgumentException $e) {
    ViewHelper::error404();
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
} 