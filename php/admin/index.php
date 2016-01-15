<?php

// enables sessions for the entire app
session_start();

require_once("controller/AdminController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "../static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "../static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
    "" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "admin"){
            ViewHelper::redirect(BASE_URL . "users");
        } else{
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                AdminController::check(); 
            } else {
                AdminController::login(); 
            }
        }
    },
    "logout" => function(){
        session_unset();
        ViewHelper::redirect(BASE_URL);
    }, 
    "users" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "admin"){
            AdminController::users();
        } else{
            ViewHelper::redirect(BASE_URL);
        }
    },
    "profile" => function() {
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "admin"){
            AdminController::profileForm();
        } else{
            unset($_SESSION["uid"]);
            unset($_SESSION["uname"]);
            ViewHelper::redirect(BASE_URL);
        } 
    },
    "diary" => function() {
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "admin"){
            AdminController::showDiary();
        } else{
            unset($_SESSION["uid"]);
            unset($_SESSION["uname"]);
            ViewHelper::redirect(BASE_URL);
        } 
    },
    "users/edit" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "admin"){
            AdminController::updateUserForm();
        } else{
            unset($_SESSION["uid"]);
            unset($_SESSION["uname"]);
            ViewHelper::redirect(BASE_URL);
        }
    }, 
    "users/add" => function(){
        if(isset($_SESSION["active"]) && $_SESSION["role"] == "admin"){
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
        echo "No controller for '$path'";
    }
} catch (InvalidArgumentException $e) {
    var_dump($urls);
    ViewHelper::error404();
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
} 
