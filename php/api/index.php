<?php

require_once(dirname(__FILE__).'/../model/ProductsDB.php');
require_once(dirname(__FILE__).'/ApiUtils.php');

header('Content-Type: application/json');

$http_method = filter_input(INPUT_SERVER, "REQUEST_METHOD", FILTER_SANITIZE_SPECIAL_CHARS); #preberemo katera je http metoda
//$server_addr = filter_input(INPUT_SERVER, "SERVER_ADDR", FILTER_SANITIZE_SPECIAL_CHARS);
$server_addr = "10.0.2.2"; // kadar dostopamo preko Android emulatorja, ce damo virtualko na bridge interface ali preko telefona tega ne rabimo
$php_self = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);
$script_uri = substr($php_self, 0, strripos($php_self, "/")); # naslov skripte, ki se izvaja
$request = filter_input(INPUT_GET, "request", FILTER_SANITIZE_SPECIAL_CHARS); 

$rules = array(
    'naziv' => FILTER_SANITIZE_SPECIAL_CHARS,
    'opis' => FILTER_SANITIZE_SPECIAL_CHARS,
    'cena' => FILTER_VALIDATE_FLOAT,
    'id' => array(
        'filter' => FILTER_VALIDATE_INT,
        'options' => array('min_range' => 1)
    ),
    'aktiven' => FILTER_SANITIZE_SPECIAL_CHARS
);


function returnError($code, $message) {
    http_response_code($code);
    echo json_encode($message);
    exit();
}

if ($request != null) {
    $path = explode("/", $request);
} else {
    returnError(400, "Missing request path.");
}

if (isset($path[0])) {
    $resource = $path[0];
} else {
    returnError(400, "Missing resource.");
}

if (isset($path[1])) {
    $param = $path[1];
} else {
    $param = null;
}

switch ($resource) {
    case "vsiIzdelki": // za prodajalce, saj prikaže tudi neaktivne
        if ($http_method == "GET" && $param == null) {
            $products = ProductsDB::getAll();
            foreach ($products as $_ => & $product) {
                $product["uri"] = "http://" . $server_addr .
                        $script_uri . "/izdelki/" . $product["id"];
            }
            echo json_encode($products);
        }
        else {
            echo returnError(404, "Unknown request: [$http_method $resource]");
        }
        break; 
    case "izdelki":
        if ($http_method == "GET" && $param == null) {
            // getAll
            $products = ProductsDB::getAllActive();
            foreach ($products as $_ => & $product) {
                $product["uri"] = "http://" . $server_addr .
                        $script_uri . "/izdelki/" . $product["id"];
            }

            echo json_encode($products);
        } else if ($http_method == "GET" && $param != null) {

            $product = ProductsDB::get(["id" => $param]);
            if ($product != null) {
                $product["uri"] = "http://" . $server_addr . $script_uri . "/izdelki/" . $product["id"];
                echo json_encode($product);
            } else {
                returnError(404, "No entry for id: " . $param);
            }
        } else if ($http_method == "POST" && $param == null) {

            $filteredInput = filter_input_array(INPUT_POST, $rules); 
            $product = array_filter($filteredInput); 

            try {
                $id = ProductsDB::insert($product);
                http_response_code(201);
                header("Location: http://$server_addr" . "$script_uri/izdelki/$id");
            } catch (Exception $exc) {
                echo returnError(400, $exc->getMessage());
            }
        } else if ($http_method == "PUT" && $param != null) {
            // update
            $inputParams = null;
            parse_str(file_get_contents("php://input"), $inputParams);

            $filteredInput = filter_var_array($inputParams, $rules);
            $filteredInput["id"] = $param;
            $product = array_filter($filteredInput);
            //var_dump($product);
            try {
                ProductsDB::update($product);
                http_response_code(204); // vračamo prazen odgovor
            } catch (Exception $exc) {
                echo returnError(400, $exc->getMessage());
            }
        } else if ($http_method == "DELETE" && $param != null) {
            try {
                $product = ProductsDB::get(["id" => $param]);
                if($product != null){
                    ProductsDB::delete(["id" => $param]);
                    http_response_code(204);
                }
                else{
                    returnError(404, "No book with id $param");
                }
            } catch (Exception $exc) {
                echo returnError(400, $exc->getMessage());
            }
            
        } else {
            // error
            echo returnError(404, "Unknown request: [$http_method $resource]");
        }
        break;
    case "login":
        if ($http_method == "POST" && $param == null) {
            if(ApiUtils::isLoginSuccessful()) {
                $returnJson = array('loginSuccess' => true, 'active' => $_SESSION["active"], 'role' => $_SESSION["role"], 'id' => $_SESSION["id"]);
            } else {
                $returnJson = array('loginSuccess' => false);
            }
            http_response_code(200);
            echo json_encode($returnJson);
        } else {
            // error
            echo returnError(404, "Unknown request: [$http_method $resource]");
        }
        break;
    case "profile":
        //TODO: sanitize
        session_start();
        if ($http_method == "GET" && $param == null) {
            $user_data = UsersDB::getCustomer(["id" => $_SESSION["id"]]);
            unset($user_data["aktiven"]);
            echo json_encode($user_data);
        } else if ($http_method == "POST" && $param == null) {
            $filtered_input  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
//            echo $filtered_input["ime"];
            UsersDB::updateCustomer($filtered_input);
            $status = array('status' => 'OK');
            echo json_encode($status);
        } else {
            // error
            echo returnError(404, "Unknown request: [$http_method $resource]");
        }
        break;
    case "addincart":
        if ($http_method == "POST" && $param == null) {
            ApiUtils::addInCart();
        } else {
            // error
            echo returnError(404, "Unknown request: [$http_method $resource]");
        }
        break;
    default:
        returnError(404, "Invalid resource: " . $resource);
        break;
}

