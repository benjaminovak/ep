<?php

require_once 'AbstractDB.php';

class PostDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO posta (posta, kraj) "
                        . " VALUES (:posta, :kraj)", $params);
    }

    public static function update(array $params){
        return parent::modify("UPDATE posta SET kraj = :kraj"
                        . " WHERE posta = :posta", $params);
    }
    
    public static function delete(array $id){
        return parent::modify("DELETE FROM posta WHERE posta = :posta", $id);
    }

    public static function get(array $id) {
        $post = parent::query("SELECT *"
                        . " FROM posta"
                        . " WHERE posta = :posta", $id);
        if (count($post) == 1) {
            return $post[0];
        } else {
            return null;
        }
    }
    
    public static function getAll() {
        return parent::query("SELECT *"
                        . " FROM posta"
                        . " ORDER BY id ASC");
    }

}