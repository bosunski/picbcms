<?PHP
	function __autoload($class) {
		if(file_exists(ABSPATH.'el-admin/includes/'.strtolower($class).'.php')) {
			require(ABSPATH.'el-admin/includes/'.strtolower($class).'.php');
		} elseif(file_exists(ABSPATH.'el-admin/includes/mods/'.strtolower($class).'.php')) {
			require(ABSPATH.'el-admin/includes/mods/'.strtolower($class).'.php');
		} elseif(file_exists(ABSPATH.'includes/mods/'.strtolower($class).'.php')) {
			require(ABSPATH.'includes/mods/'.strtolower($class).'.php');
		} elseif(file_exists(ABSPATH.'includes/'.strtolower($class).'.php')) {
			require(ABSPATH.'includes/'.strtolower($class).'.php');
		}
	}
	/**
	*Elyon 1.0 Functions
	*@Description functions
	*@Package LIBRAta
	*/
	$now = time();
	//define( 'ABSPATH', dirname(dirname(__FILE__)).'/' );
	/*A function that just echo things */
	function _e($stream) {
		echo $stream;
	}

	function getBlockquotedMsg($ccode, $msg) {
		return '<div><blockquote style="background:white;border-left-color:'.$ccode.';"><h4 style="font-weight:1;margin-bottom:0px;">'.$msg.'</h4></blockquote></div>';
	}

	function _x($stream) {
		 exit($stream);
	}

	/*This function do basic cleaning for data
	*/
	function clean($data) {
		$data = strip_tags(stripslashes(stripcslashes($data)));
		return $data;
	}

	function cleansimple($data) {
		$data = htmlspecialchars(stripslashes(stripcslashes($data)));
		return $data;
	}
	function reverse_simple_clean($data) {
		return html_entity_decode($data);
	}

	/* This function loads the Database core Handler for
	 *LIBRAta
	 */
	function load_el_db() {
		if(file_exists(ABSPATH.'/el-includes/class/database/el_dbcore.php'))
			require_once('class/database/el_dbcore.php');
	}

	/* This function loads the Config file for
	 *LIBRAta
	 */
	function load_config() {
		if(file_exists(ABSPATH.'/el_config.php'))
			require_once(ABSPATH.'/el_config.php');
	}

	/* This function loads the Auth class for
	 *LIBRAta
	 */
	function load_auth() {
		if(file_exists(ABSPATH.'/el-includes/class/Auth.php'))
			require_once(ABSPATH.'/el-includes/class/Auth.php');
	}

	/* This function loads the Database core Handler for
	 *LIBRAta
	 */
	function load_el_config() {
		if(file_exists(ABSPATH.'/el_config.php'))
			require_once(ABSPATH.'/el_config.php');
	}

	/* This function loads the Template engine for
	 *LIBRAta
	 */
	function load_el_template() {
		if(file_exists(ABSPATH.'/el-includes/class/template.php'))
			require_once(ABSPATH.'/el-includes/class/template.php');
	}

	/* This function loads the install script for
	 *LIBRAta
	 */
	function load_install() {
		if(file_exists(ABSPATH.'/el-admin/el_installl.php'))
			require_once(ABSPATH.'/el-admin/el_installl.php');
	}

	/* This function encrypts the $data
	 */
	function _crypt($data) {
		load_config();
		return base64_encode(AUTH_KEY.$data);
	}

	/* This function decrypts the $data
	 */
	function _decrypt($data) {
		load_config();
		$data = base64_decode($data);
		$data = explode(AUTH_KEY, $data);
		return $data[1];
	}

	function abbrev($text) {
			$expl = explode(' ', $text);
			$abbr = '';
			foreach($expl as $key => $value) {
				$abbr .= substr($value, 0, 1);
			}
			return $abbr;
	}

	function getUserSpecificStatus() {
		$section = _crypt($_SESSION['section']);
		return $section;
	}

	function chkInstall() {
		//Runtime check
		if(file_exists(ABSPATH.'el_config.php')) {
			return true;
		}
		return false;
	}


	function load_basic_conf() {
		load_config();load_el_db();load_auth();
	}

	function get_theme_css() {
		return INSTALL_DIR.'/el-admin/themes/joli/css/theme-brown.css';
	}
	function get_theme_font() {
		return INSTALL_DIR.'/el-admin/themes/joli/css/font.css';
	}

	function load_jquery() {
		return INSTALL_DIR.'/el-admin/themes/joli/js/plugins/jquery/jquery.min.js';
	}

	function load_login() {
		return INSTALL_DIR.'/el-admin/themes/joli/js/login.js';
	}

	function get_el_options($key) {
		$db = new Dbcore;
		$sql = 'SELECT option_value FROM '.PREFIX.'options WHERE option_name="'.$key.'"';
		$op = $db->get_single_result($sql);
		if($op && is_array($op)) {
			return $op['option_value'];
		}
		return ' ';
	}

	function get_option($key) {
		$options = get_el_options($key);
			return $options;
	}

	function get_date($format = '', $time) {
		return date($format, $time);
	}

	function get_instance_of_dbcore() {
		return Dbcore::getInstance();
	}

	function get_login_admin($error = '') {
		require_once(ABSPATH.'/ellogin_form.php');
	}

	function set_login_error($error) {
		$load_file = file_get_contents(ABSPATH.'/login_form.php');
		$load_file = str_replace('[@error]',$error, $load_file);
		$new_file = fopen(ABSPATH.'/ellogin_form.php', 'w');
		fwrite($new_file, $load_file);
		fclose($new_file);
	}

	function get_file($fpath) {
		if(file_exists($fpath)) {
			if(is_readable($fpath)) {
				return file_get_contents($fpath);
			} else {
				return '';
			}
		}
	}

	function reqF($fpath) {
		if(file_exists($fpath) && is_readable($fpath)) {
			require $fpath;
			return true;
		}
		return false;
	}

	/* Array functions */

	function explode_var($separation, $data) {
		return explode($separation, $data);
	}

	function implode_var($separation, $data) {
		return implode($separation, $data);
	}

	function arr_key_to_val($arr) {
		$new_arr = array();
		foreach($arr as $key => $val) {
			$new_arr[$val] = $key;
		}
		return $new_arr;
	}

	function remove_empty_values($arr) {
		foreach($arr as $key => $val) {
			if($val == '') {
				unset($arr[$key]);
			}
		}
		return $arr;
	}

	function fix_duplicate($arr) {
		return array_unique($arr);
	}
?>
