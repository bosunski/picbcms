<?php
	ob_start();
	session_start();
	define('ABSPATH', dirname(dirname( __FILE__ )).'/');
	require(ABSPATH . 'el-includes/el_functions.php' );
	load_basic_conf();
	_e(get_option('home'));
?>