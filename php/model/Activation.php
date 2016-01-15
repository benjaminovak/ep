<?php 

class Activation {

    private static $skrivnost = "ng3454";

    private function __construct() {
        
    }

    private function __clone() {
        
    }

    public function checkActivationCode($mail, $activation_code) {
        $mail .= self::$skrivnost;
        $calculated_code = sha1($mail);
        if($calculated_code == $activation_code) {
            return true;
        }
        return false;
    }
    
    public function hashMail($mail) {
        $mail .= self::$skrivnost;
        return sha1($mail);
    }
    
}