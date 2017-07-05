<?PHP
	/**
	 *LIBRAta 1.0 database
	 *@decription Manages database processes
	 *@package LIBRAta
	 */
	 
	 
	class libdb {
		public $dbh;
		private static $instance;
		private function __construct() {
			$dsn = 'mysql:host='.Config::read('db.host').';dbname='.Config::read('db.basename');
			
			$user = Config::read('db.user');
			
			$password = Config::read('db.password');
			
			$this->dbh= new PDO($dsn, $user, $password);
		}
		
		public static function getInstance() {
			if(! isset(self::$instance)) {
				$object = __CLASS__;
				self::$instance = new $object;
			}
			return self::$instance;
		}
		
	}
	
	class  Config {
		static $confArray;
		
		public static function read($name) {
			return self::$confArray[$name];
		}
		
		public static function write($name, $value) {
			self::$confArray[$name] = $value;
		}
	}
	

?>