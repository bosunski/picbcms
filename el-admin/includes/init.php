<?php
	class Elyon {
		private $_link = null;
		private $_controller = null;
		private $_cPath = 'includes/';
		private $_vPath = 'themes/';
		private $_mPath = 'm/';
		private $_ePath = 'error.php';
		private $_defFile = 'dashboard.php';

		public function initialize() 
		{
			$this->_getLink();

			if ( empty($this->_link[0]) ) {
				$this->_loadDefaultController();
				return false;
			}

			if($this->_loadExistingController()) {
				$this->_callControllerMethod();
			}
			
		}

		public function setControllerPath($path)
		{
			$this->_cPath = trim($path, '/'). '/';
		}	

		public function setDefaultFile($path) 
		{
			$this->_defFile = trim($path, '/');
		}

		public function _getLink()
		{
			$url = isset($_GET['link']) ? $_GET['link'] : null;
			$url = rtrim($url, '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$this->_link = explode('/', $url);
		}

		private function _loadDefaultController() {
			require $this->_cPath . $this->_defFile;
			$this->_controller = new Dashboard;
			$this->_controller->load_page();
			//$this->_controller->index();
		}

		private function _loadExistingController()
		{
			$file = $this->_cPath . $this->_link[0]. '.php';

			if(file_exists($file)) {
				require $file;
				$this->_controller = new $this->_link[0];
				$this->_controller->loadModel($this->_link[0], $this->_mPath);
			} else {
				$this->_error('404');
				return false;
			}
		}

		private function _callControllerMethod()
		{
			$length = count($this->_link);

			if($length > 1) {
				if(!method_exists($this->_controller, $this->_link[1])) {
					$this->_error('404');
				}
			}

			switch($length) {
				case 5:
					$this->_controller->{$this->_link[1]}($this->_link[2], $this->_link[3], $this->_link[4]);
					break;
				case 4:
					$this->_controller->{$this->_link[1]}($this->_link[2], $this->_link[3]);
					break;
				case 3:
					$this->_controller->{$this->_link[1]}($this->_link[2]);
					break;
				case 2:
					$this->_controller->{$this->_link[1]}();
					break;
				default:
					$this->_controller->index();
					break;
			}
		}

		private function _error($code) {
			require $this->_cPath . $this->_ePath;
			$this->_controller = new Error();
			$this->_controller->getErrorPage($code);
			exit;
		}

	}
?>