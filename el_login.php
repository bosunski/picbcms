<?php
	ob_start();
	session_start();
	define('ABSPATH', dirname( __FILE__ ).'/');
	require(ABSPATH . 'el-includes/el_functions.php' );

	$title = "LOGIN to Elyon &raquo;";
	$error = '';
	load_basic_conf();
	if(!chkInstall()) {
		header('location: el-admin/el_install.php');
		exit;
	}
	$auth = new Auth();
	$title = get_option('blogname').' &raquo; Login.';
	if(isset($_GET['p']) && $_GET['p'] == 'logout') {
		@Session::terminate();
	}
	if(Session::check_session()) {
		$auth->el_login(Session::get_var('user_login'), Session::get_var('user_pass'));
		if($auth->is_login()) {
			header('location: '.get_option('home').'/el-admin');
		} else {
			$error = $auth->get_auth_last_error();
			$GLOBALS['login_err'] = '<br/><br/><div><blockquote style="border-left-color:red;"><h4 style="font-weight:1;">'.$error.'</h4></blockquote></div>';
			get_login_admin();
		}
	} else {
		if($_SERVER["REQUEST_METHOD"] == 'POST') {
			$uname = (isset($_POST['uname'])) ? clean(trim($_POST['uname'])) : $_SESSION['uname'];
			$pass = clean(trim($_POST['pass']));
				$auth->el_login($uname, $pass);
				if($auth->is_login()) {
					header('location: '.get_option('home').'/el-admin');
				} else {
					$error = $auth->get_auth_last_error();
					$GLOBALS['login_err'] = '<br/><br/><div><blockquote style="border-left-color:red;"><h4 style="font-weight:1;">'.$error.'</h4></blockquote></div>';
					get_login_admin();
				}
		} else {
			get_login_admin();
		}
}
	ob_flush();
?>
