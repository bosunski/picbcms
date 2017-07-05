<?php
	// The View
	global $el;
	class Atheme {

		private $_defTheme = 'joli';
		private $_js;
		private static $i;
		private $_cI;
		private $_basePath = 'themes/';

		private function __construct() {

		}

		public static function gI() {
			if(!isset(self::$i)) {
				$obj = __CLASS__;
				self::$i = new $obj;
			}
			return self::$i;
		}

		public  function copyI() {
			$this->_cI = self::$i;
			$el = $this->_cI;
			return $el;
		}
		//This function is written in case the file did not exists in the custom theme
		// i.e if create() fails............
		private function _loadDefaultView($file) {
			if(file_exists($file))
				$this->_reqF($file);
			//Else You can Pull some Error here from the error controller
			//$err = new Error; ....etc.
		}

		public function create($page) {
			$this->set_default_vars();
			if($this->_reqF($this->_basePath.get_option('admin-theme').'/'.$page.'.php')) {
				//$this->home = get_option('home');\
				return true;
			} else {
				$err = new Error;
				return false;
				//$this->_loadDefaultView(ABSPATH .'el-admin/themes/'.$this->_defTheme.'/index.php');
			}
		}


		//Set default vars that is required accross the apps
		private function set_default_vars() {
			$this->adminName = Session::get_var('user_login');
			$this->adminFullname = Session::get_var('user_nicename');
			switch (Session::get_var('user_level')) {
				case '1':
					$this->adminLevel = 'Author';
					break;
				case '2':
					$this->adminLevel = 'Administrator';
					break;

				default:
					$this->adminLevel = 'Level Unknown';
					break;
			}
		}

		public  function loadJS() {
			$js = array('jquery/jquery.min', 'jquery/jquery-ui.min',
						'bootstrap/bootstrap.min', 'mcustomscrollbar/jquery.mCustomScrollbar.min',
						'plugins', 'actions');
			$all_js = empty($this->_js) ? $js : array_merge($js, $this->_js);
			if(!empty($all_js)) {
				foreach ((array)$all_js as $key => $js) {
					# code...
					//@$j = get_file($this->_basePath.get_option('admin-theme').'/js/'.$js.'.js');
					_e('<script type="text/javascript" src="'.get_option('home').'/el-admin/themes/'.get_option('admin-theme').'/js/'.$js.'.js"></script>');
				}
			}
		}

		private function _reqF($fpath) {
			if(file_exists($fpath) && is_readable($fpath)) {
				require $fpath;
				return true;
			}
			return false;
		}

		public function setJs($val) {
			//$this->_js = array();
			$this->_js[] = $val;
		}

		public function getDashboardHeader() {
			$this->_reqF($this->_basePath.get_option('admin-theme').'/header.php');
			$this->_reqF($this->_basePath.get_option('admin-theme').'/topnav.php');
		}

		public function getDashboardFooter() {
			$this->_reqF($this->_basePath.get_option('admin-theme').'/end_of_all_pages.php');
		}

		public function set($attr = null, $val = null) {
			if($attr != null && $val != null) {
				$this->{$attr} = $val;
			}
		}
		public function get($attr = null) {
			if($attr != null) {
				return isset($this->{$attr}) ? $this->{$attr} : null;
			}
		}

		public function loadDrafts($len = null) {
			$p = new Post;
			$len = $len == null ? 5 : $len;
			$ui = $p->getDrafts($len);
			_e($ui);
		}

		public function set_prop($array = array()) {
			if(!empty($array)) {
				foreach ($array as $key => $value) {
					$this->set($key, $value);
				}
			}
		}


		function __destruct() {
			//$this->getDashboardFooter();
		}
	}
?>
