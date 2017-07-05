<?php
	class Page {
		
		private $page;
		private static $instance;
		private $header;
		private $footer;
		private $content;

		public function __construct() {

		}
		public static function getInstance() {
			if(!isset(self::$instance)) {
				$obj = __CLASS__;
				self::$instance = new $obj;
			}
			return self::$instance;
		}

		public function set_var($var, $val) {
			$this->$var = $val;
		}

		public function get_var($var) {
			return $this->$var;
		}


	}
?>