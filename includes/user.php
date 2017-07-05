
<?php
  class User extends Elyon_core_controller {
    private static $_userInstance;
    private $_error;
    private $_auth;
    function __construct() {
      parent::__construct();
      $this->_auth = new Auth;
    }

    public static function getInstance() {
      if(!isset(self::$_userInstance)) {
        $obj = __CLASS__;
        self::$_userInstance = new $obj;
      }
      return self::$_userInstance;
    }
    public function register() {
      if(post_request()) {
        _x('Chaii');
      }
      $props['title'] = 'Register | ' .get_option('blogname');
      $this->theme->set_prop($props);
      $this->theme->create('/register');
    }

    /* Monitors Everything that has to do with login
      * Called from within Links Class
      * Creates login page at the TERMINATION
    */

    public function login() {
      $msg = ' ';
      if(isset($_GET['a']) && $_GET['a'] = 'u')
        $this->log_user_out();

      if(isset($_GET['ref']) && $_GET['ref'] != '')
        $this->referer = $_GET['ref'];

      if(Session::check_session()) {
        if(!$this->session_login()) {
          $props['msg'] = $this->_error;
        } else {
          header('location: '.$this->referer);
        }
      } else {
        if(post_request()) {
          if(!$this->log_user_in($_POST)) {
            $props['msg'] = $this->_error;
          } else {
            header('location: '.$this->referer);
          }
        }
      }
      $props['form_url'] = get_option('home') . '/login?ref='.get_referer();
      $props['title'] = 'Login | ' .get_option('blogname');
      $this->theme->set_prop($props);
      $this->theme->create('/login');
    }

    /* Log user in NORMALLY
      * Called by login()
      * Return boolean and sets the referer
    */
    private function log_user_in($data) {
      $uname = (isset($data['uname'])) ? clean(trim($data['uname'])) : Session::get_var('uname');
			$pass = clean(trim($data['pass']));
      $referer = $this->referer;
				$this->_auth->el_login($uname, $pass);
				if($this->_auth->is_login()) {
          if(!strpos('/login', $this->referer)) {
            $this->referer = $referer;
            return true;
          } else {
            $this->referer = get_option('home');
            return true;
          }
				} else {
					$this->_error = $this->_auth->get_auth_last_error();
				}
        return false;
    }

    /* Log user in based on already existing session
      * Called by login()
      * Return boolean and sets the referer
    */
    private function session_login() {
      $this->_auth->el_login(Session::get_var('user_login'), Session::get_var('user_pass'));
      $referer = $this->referer;
  		if($this->_auth->is_login()) {
        if(!strpos('/login', $this->referer)) {
          $this->referer = $referer;
          return true;
        } else {
          $this->referer = get_option('home');
          return true;
        }
  		} else {
  			$this->_error = $this->_auth->get_auth_last_error();
  		}
      return false;
    }

    /* Log user out
      * Called by login()
      * Redirects to the referer OR Homepage
    */
    private function log_user_out() {
      $referer = get_referer();
      @Session::terminate();
      if(!strpos('/login', $referer)) {
        header('location: '.$referer);
      } else {
        header('location: '.get_option('home'));
      }
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

    function __call($a, $b) {
      $this->_cerror('', '404');
    }
  }
?>
