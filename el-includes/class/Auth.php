<?PHP
	//require_once($_SERVER['DOCUMENT_ROOT'].'class/Core.php');
	define('LIBRATA_KEY', 'with God all things are possible');

class Auth {
	private $_siteKey;
	private $_isAdmin = false;
	private $_isSuper = false;
	private $_isLogin = false;
	private $authErr = '';

	public function __construct() {
		$this->_siteKey = time();
	}

	private function randomString($length = 50) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz~`!@#$%^&*()_+=-]}[{|/?><.,:;';
		$string = '';
		for($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters)-1)];
		}

		return $string;
	}

	public function _getRand($length = 50) {
		return $this->randomString($length);
	}

	public function hashData($data) {
		return hash_hmac('sha512', $data, LIBRATA_KEY);
	}

	public function isAdmin() {
		if($selection['isAdmin'] == 1) {
			return true;
		}
		return false;
	}


	public function el_login($uname, $pass) {
		$dbc = get_instance_of_dbcore();
		//select user from DB on $email
		$sql = 'SELECT * from '.PREFIX.'users WHERE user_level >= 1 AND user_login= ? LIMIT 1';
		$arr = $dbc->get_single_result($sql, array($uname));

		//If the record is found
		if($dbc->getRowsReturned() == 1) {
			//salt and hash password
			$password = $arr['user_salt_key'].$pass;
			$password = $this->hashData($password);
			$password = substr($password, 0, 59);

			if($password == $arr['user_pass']) {
			 		/*This is a weak spot destined for strenghtening*/
				$random = $this->randomString();
				$token = $_SERVER['HTTP_USER_AGENT'].$random;
				$token = $this->hashData($token);
				Session::set_var('user_login', $arr['user_login']);
				Session::set_var('ID', $arr['ID']);
				$_SESSION['status'] = 'online';
				$this->_isSuper = ($arr['user_status'] == 0) ? true : false;
				$_SESSION['token'] = $token;
				Session::set_var('user_email', $arr['user_email']);
				Session::set_var('comment_email', $arr['user_email']);
				$_SESSION['lock'] = false;
				$_SESSION['display_name'] = $arr['display_name'];
				$_SESSION['user_nicename'] = $arr['user_nicename'];
				$_SESSION['comment_name'] = $arr['user_nicename'];
				$_SESSION['user_pass'] = $pass;
				Session::set_var('user_level', $arr['user_level']);
				$sessionID = session_id();
				$this->_isLogin = true;
			} else {
			    //Incorrect password
			 	$this->authErr = 'ERROR: You entered an incorrect password for the username <b>'.$uname.'</b>. <a href="#">Have you Forgoten your password?</A>';
			}
		} else {
			//Invalid username
			$this->authErr = 'ERROR: Invalid Username. Please try again.';
		}
	}

	public function is_login() {
		return $this->_isLogin;
	}

	public function get_auth_last_error() {
		return $this->authErr;
	}
	public function checkSession() {
		$dbh = new libdb();
		//Select the ROW from loggedin member
		if($dbh->db_connect()) {
			$sql = 'SELECT * FROM '.PREFIX.'logged_in_admin WHERE admin_id='._decrypt($_SESSION['admin_id']);
			$dbh->query($sql, 'select');
			if(!$dbh->done) {
					$this->authErr = $dbh->error;
				} else {
					//If the record is not found
					if($dbh->rowsReturned != 0) {
					$arr = $dbh->data;
					//Check ID and token
					if(session_id() == $arr['session_id'] && $_SESSION['token'] == $arr['token']) {
						//ID and token match refresh the session for the next request
						$this->refreshSession();
						return true;
					}
				} else {
					return false;
				}
			}
		}
		return false;
	}

	private function refreshSession() {
		//regenerate id
		session_regenerate_id();
		//regenerate token
		$random = $this->randomString();
		//Build the token
		$token = $_SERVER['HTTP_USER_AGENT'].$random;
		$token = $this->hashData($token);
		$_SESSION['token'] = $token;
	}
	public function logout() {
		$_SESSION = array();
		session_destroy();
		unset($_SESSION);
		return true;
	}

	public function sendVerification($user_id) {
		require_once('functions.php');
		//Get from DB using d $user_id(lastInsertId() will b handy)
		$sql = 'SELECT email, verification_code FROM users WHERE uid='.$user_id;
		$con = Core::getInstance();
		$exe = $con->dbh->query($sql);
		$roe = $exe->fetch(PDO::FETCH_OBJ);
		$email = $roe->email;
		$code = $roe->verification_code;
		$subject = 'DREAM BUILDERS';
		$header = 'Email Verification';
		$message = 'Please click on this link to
										activate your account. http://www.'.$_SERVER['HTTP_HOST'].'/reg2.php?email='.$email.'&verve_code='.$code;
		mail($email, $subject, $message, $header);
	}

  private static function activateUser($email) {
    $con = Core::getInstance();
    $exe = $con->dbh->query("UPDATE users SET confirmation = 1, is_active = 1 WHERE email = \"$email\"");
    if($exe)
       return true;
    else
       return false;
  }

	public static function checkVerificationCode($email, $code) {
		//this function should return a boolean
    if(self::checkDetail($email, 'email', 'users') && self::checkDetail($code, 'verification_code', 'users')) {
       if(self::activateUser($email))
       return true;
    }
    return false;
	}
}
?>
