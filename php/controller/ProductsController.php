<?php

require_once("model/ProductsDB.php");
require_once("ViewHelper.php");

class ProductsController {
    
    public static function index() {
        $rules = [
            "id" => [   // id je celo stevilo, ki je vecje od ena
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];
 
        $data = filter_input_array(INPUT_GET, $rules);

        if (self::checkValues($data)) {
            echo ViewHelper::render("view/product-detail.php", [
                "product" => ProductsDB::get($data)
            ]);
        } else {
            echo ViewHelper::render("view/product-list.php", [
                "products" => ProductsDB::getAllActive()
            ]);
        }
    }

    public static function addForm($values = ["author" => "", "title" => "",
        "price" => "", "year" => "", "description" => ""]) {
        echo ViewHelper::render("view/product-add.php", $values);
    }

    public static function add() {
        // prebere podatke, ki smo jih poslali s postom in jih očisti
        $data = filter_input_array(INPUT_POST, self::getRules());
        
        // če je vse ok ga shrani v bazo in prikažemo odnost
        if (self::checkValues($data)) {
            $id = BookDB::insert($data);
            echo ViewHelper::redirect(BASE_URL . "products?id=" . $id);
        } else {
            //sicer prikažemo obrazec, ki ni uspel
            self::addForm($data);
        }
    }

    public static function editForm($product = []) {
        if (empty($product)) {
            $rules = [
                "id" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => ['min_range' => 1]
                ]
            ];

            $data = filter_input_array(INPUT_GET, $rules);
            $product = BookDB::get($data);
        }

        echo ViewHelper::render("view/product-edit.php", ["product" => $product]);
    }

    public static function edit() {
        $rules = self::getRules();
        $rules["id"] = [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range' => 1]
        ];
        $data = filter_input_array(INPUT_POST, $rules);

        if (self::checkValues($data)) {
            BookDB::update($data);
            ViewHelper::redirect(BASE_URL . "products?id=" . $data["id"]);
        } else {
            self::editForm($data);
        }
    }

    public static function delete() {
        $rules = [
            'delete_confirmation' => FILTER_REQUIRE_SCALAR,
            'id' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];
        $data = filter_input_array(INPUT_POST, $rules);

        if (self::checkValues($data)) {
            BookDB::delete($data);
            $url = BASE_URL . "products";
        } else {
            if (isset($data["id"])) {
                $url = BASE_URL . "products/edit?id=" . $data["id"];
            } else {
                $url = BASE_URL . "products";
            }
        }

        ViewHelper::redirect($url);
    }

    /**
     * Returns TRUE if given $input array contains no FALSE values
     * @param type $input
     * @return type
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

    /**
     * Returns an array of filtering rules for manipulation products
     * @return type
     */
    private static function getRules() {
        return [
            'title' => FILTER_SANITIZE_SPECIAL_CHARS,
            'author' => FILTER_SANITIZE_SPECIAL_CHARS,
            'description' => FILTER_SANITIZE_SPECIAL_CHARS,
            'price' => FILTER_VALIDATE_FLOAT,
            'year' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1800,
                    'max_range' => date("Y")
                ]
            ]
        ];
    }

}
