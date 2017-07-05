<?php
	class Elyon {
		private $_link = null;
		private $_controller = null;
		private $_cPath = 'includes/';
		private $_vPath = 'themes/';
		private $_mPath = 'includes/mods/';
		private $_ePath = 'error.php';
		private $_defFile = 'home.php';

		private static $_eInstance;

		public static function getInstance() {
			if(!isset(self::$_eInstance)) {
				$obj = __CLASS__;
				self::$_eInstance = new $obj;
			}
			return self::$_eInstance;
		}

		public function initialize() {
			Session::start();
			$this->_getLink();
			if(empty($this->_link[0])) {
				$this->_loadDefaultController();
				return false;
			} else {
				//Changes
				if($this->_loadExistingController()) {
					$this->_callControllerMethod();
				} else {
					if(!$this->_loadPostingController()) {
						$this->_error('','404');
					}
				}
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
			$this->_controller = new Home;
			$this->_controller->load_page();
			//$this->_controller->index();
		}

		//Changes
		private function _loadExistingController() {
			$cls = $this->_link[0];
			if($cls === 'blog') {
				$cls = 'post';
			}
			$defCont = array('search', 'tag', 'category', 'register', 'meme', 'workers', 'about', 'donate', 'counsel', 'contact');
			$file = $this->_cPath . $cls. '.php';

			if(file_exists($file)) {
				require $file;
				$this->_controller = new $cls;
				$this->_controller->getModel($cls, $this->_mPath);
				return true;
			} else {
				//Points of Changes
				if($this->processSpecialLink($cls)) {
					return true;
				}
			}
			return false;
		}

		////////////////////Processes special links defined in the App
		private function processSpecialLink($cls) {
			$this->_controller = new Links;
			$this->_controller->getModel('links', $this->_mPath);
			if(count($this->_link) === 2) {
				$this->_controller->{$cls}($this->_link[1]);
			}
			else
				$this->_controller->{$cls}();
			return false;
		}
		//////////////////////////* Sets up the controller for loading posts */
		private function _loadPostingController() {
				/*if(count($this->_link) != 3) {
					$this->_error('', '404');
				}*/
				$file = $this->_cPath . 'post.php';
				require($file);
				$this->_controller = new Post;
				$this->_controller->getModel('post', $this->_mPath);
				$this->_mod = new Postm;
				$postData = $this->_controller->checkPostName($this->_link[0], $this->_mod);
				if(!$postData) {
					return false;
					$this->_error('', '404');
				} else {
					$this->_controller->viewpost($postData);
					return true;
				}
				return false;
		}

		private function _callControllerMethod() {
			$length = count($this->_link);

			if($length > 1) {
				if(!method_exists($this->_controller, $this->_link[1])) {
					$this->_error('', '404');
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
					$this->_controller->defView();
					break;
			}
		}

		private function _error($text = '' , $code) {
			require $this->_cPath . $this->_ePath;
			$this->_controller = new Error();
			$this->_controller->getErrorPage($text, $code);
			exit;
		}

	}
?>
