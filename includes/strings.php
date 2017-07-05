<?php
  class Strings {
    private $length;
    private $_isEmail;
    private static $instance;
    private function __construct() {

    }

    public static function gI() {
      if(!isset(self::$instance)) {
        $cls = __CLASS__;
        self::$instance = new $cls;
      }
      return self::$instance;
    }


    public function is_email($data) {
      if(filter_var($data, FILTER_VALIDATE_EMAIL))
        return true;
      return false;
    }
    public function within_range($data, $min, $max) {
      if(strlen($data) >= $min && strlen($data) <= $max)
        return true;
      return false;
    }
    public function pass_strength($data) {}
    public function match($a, $b) {
      if($a == $b)
        return true;
      return false;
    }
    public function isAlphanumeric($data) {
      if(preg_match('/^[a-zA-Z0-9]$/', $data))
        return true;
      return false;
    }
  }

?>
