<?php
	//The Base Controller
	class Elyon_core_controller {
		function __construct() {
			$this->theme = Atheme::gI();
			$this->string = Strings::gI();
			//$this->user = User::getInstance();
		}

		/* This function gets the model and create a class-wide variable of the instance */
		public function getModel($name, $path = 'includes/mods/') {
			$fpath = $path.$name.'m.php';
			if($this->_reqF($fpath)) {
				$obj = $name.'m';
				// Note: cm stands for Controller Model
				$this->cm = new $obj;
			}
		}

		private function _reqF($fpath) {
			if(file_exists($fpath) && is_readable($fpath)) {
				require $fpath;
				return true;
			}
			return false;
		}

		public function getHome() {
			return get_option('home');
		}

	 	protected function _cerror($text = '' , $code) {
			//require $this->_cPath . $this->_ePath;
			$this->_controller = new Error();
			$this->_controller->getErrorPage($text, $code);
			exit;
		}

	}
?>
