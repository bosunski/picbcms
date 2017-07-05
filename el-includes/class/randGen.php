<?PHP
	require_once('Auth.php');
	$auth = new Auth();
	$random = $auth->_getRand(10);
	echo(strtoupper($random));
	$newLibNo = '';
?>