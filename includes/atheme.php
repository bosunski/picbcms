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

		//Sets some of the static parts of the theme. {Header and Footer Varibles}
		private function set_theme_static_var() {
			//$gallery_highlights = $this->get_gallery_highlights();
			//$this->gallery_highlights = $gallery_highlights;
			$birthday = get_option('birthdays');
			$b = ($birthday != '') ? explode(',', $birthday) : 'No birthdays.';
			$birthdays = ' ';
			if($b != 'No birthdays') {
				$birthdays .= ' ';
				foreach ($b as $key => $value) {
					$birthdays .= '<p>'.$value.'</p>';
				}
				$birthdays .= ' ';

			} else { $birthdays .= $b; }
			$this->birthdays = $birthdays;

			$static_vars = array('front_message', 'blog_email', 'blog_phone', 'blogname', 'theme', 'blog_address', 'home', 'twitter_link', 'facebook_link', 'rss_link', 'gplus_link');
			$this->footer_date = date('Y', time());
			foreach ($static_vars as $key => $value) {
				$this->{$value} = get_option($value);
			}
		}

		private function get_gallery_highlights() {
			$dir = ABSPATH . 'el-contents/uploads/gallery/';
			$extentions = array('jpg', 'jpeg', 'png', 'gif');
			$pics = array();
			foreach ($extentions as $key => $value) {
				$p = glob($dir.'*.'.$value);
					foreach($p as $k => $v) {
						list($a, $b) = explode(ABSPATH, $v);
						$pics[] = $b;
					}
			}
			$pics_html = ' ';
			usort($pics, create_function('$a, $b', 'return filemtime($b) - filemtime($a);'));
			if(!empty($pics)) {
				$cnt = 1;
				foreach ($pics as $key => $value) {
					$t = Postm::create_thumb($value, 60, 60);
					$highlight_model = $this->get_theme_model('each_gallery_highlight');
					$highlight_model = str_replace('[@image]', get_option('home').'/'.$value, $highlight_model);
					$highlight_model = str_replace('[@thumb]', $t, $highlight_model);
					$pics_html .= $highlight_model;
					if($cnt == 3)
					break;
					$cnt++;
				}
			} else {
			}
			return $pics_html;
		}


		public function create($page) {
			$this->set_theme_static_var();
			if($this->_reqF($this->_basePath.get_option('theme').'/'.$page.'.php')) {
				return true;
			} else {
				$err = new Error;
				return false;
				//$this->_loadDefaultView(ABSPATH .'el-admin/themes/'.$this->_defTheme.'/index.php');
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

		/* Smart requiring of files */
		private function _reqF($fpath) {
			if(file_exists($fpath) && is_readable($fpath)) {
				require $fpath;
				return true;
			}
			return false;
		}

		/* Smart Including of files */
		private function _incF($fpath) {
			if(file_exists($fpath) && is_readable($fpath)) {
				include $fpath;
				return true;
			}
			return false;
		}

		public function setJs($val) {
			//$this->_js = array();
			$this->_js[] = $val;
		}

		public function getHeader() {
			$this->_reqF($this->_basePath.get_option('theme').'/header.php');
			$this->_reqF($this->_basePath.get_option('theme').'/topnav.php');
		}

		public function getFooter() {
			$this->_reqF($this->_basePath.get_option('theme').'/footer.php');
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

		public function loadDrafts() {
			$p = new Post;
			$len = 5;
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

		/* Gets the model of all parts of the current theme(Those specified) */
		public function get_theme_model($model_key) {
			$fpath = $this->_basePath.get_option('theme').'/data_model.php';
			if(file_exists($fpath) && is_readable($fpath)) {
				include $fpath;
			} else {
				include($this->_basePath.'default/data_model.php');
			}

				if(array_key_exists($model_key, $model)) {
					return $model[$model_key];
				}
			return '';
		}

		function __destruct() {
			//$this->getDashboardFooter();
		}
	}
?>
