<?PHP
	class Dbcore {
		/* The database Handle variable
		 */
		public $dbh;

		/* An instance variable of this class{encapsulation}
		 */
		private static $instance;

		/* The last error of the Database process
		 */
		public $error;

		/* The rows returned by the last select query
		 */
		public $rowsReturned;

		/* The columns returned by the last select query
		 */
		public $columnsReturned;

		/* The status of the last Action True/False
		 */
		public $done;

		/*The last insertId in a table
		 */
		public $lastInsertId;

		/* The Nummbers of rows/colums affected by a Query
		 * like Delete, Update, Alter ....
		 */

		 public $rowsAffected;

		 /* The data returned by a select query
		  */
		  public $data = array();

		  /* The number of rows affected
		   */

		public $libdb;
		private $db_name = DB;
		private $db_user = UNAME;
		private $db_pass = DBPASS;
		private $db_server = DBHOST;

		protected $con;

		public function __construct() {
		}




		function configure($server, $db, $user, $pass) {
			$this->db_server = $server;
			$this->db_name = $db;
			$this->db_user = $user;
			$this->db_pass = $pass;
		}

		private function connect() {
			$dsn = 'mysql:host='.$this->db_server.';dbname='.$this->db_name;
			try {
				$this->con = new PDO($dsn, $this->db_user, $this->db_pass);
			} catch(PDOException $e) {
				header('HTTP/1.1 500 Database Error');
				exit;
			}

			if(!$this->con) {
				die('Could not connect: '. mysql_error());
			} else {
				return true;
			}
		}

		private function disconnect() {
			$this->con = null;
		}

		/**
		 * Quotes String
		 * @param string $args
		 * @return string $args
		*/
		public function quote($arg) {
			$this->connect();
			$arg = $this->con->quote($arg);
			$this->disconnect();
			return $arg;
		}

		/**
		 * prepare a statement
		 * @param string $sql
		 * @param array $args
		 * @return query $q
		*/
		public function prepare($sql, $args) {
			$this->connect();
			$q = $this->con->prepare($sql);
			$q->execute($args);
			$this->rowsAffected = $q->rowCount();
			$this->disconnect();
			if($this->rowsAffected > 0) {
				return $q;
			} else {
				return 'indef';
			}

		}

	    /**
	     * Return array of results
	     * @param string $sql
	     * @param array $args
	     * @return query array $rows
	     */

		public function get_result($sql, $args = array()) {
	        $this->connect();
	        $q = $this->con->prepare($sql);
	        $q->execute($args);
	        $rows = $q->fetchAll();
	        $this->rowsReturned = count($rows);
	        $this->disconnect();
	        return $rows;
    	}

	    /**
	     * Return single result
	     * @param string $sql
	     * @param array $args
	     * @return query $row
	     */
	    public function get_single_result($sql, $args = array()) {
	        $this->connect();
	        $q = $this->con->prepare($sql);
	        $q->execute($args);
	        $row = $q->fetch();
	        $this->rowsReturned = $q->rowCount();
	        $this->disconnect();
	        return $row;

	    }

		public function getRowsReturned() {
			return $this->rowsReturned;
		}
		public static function getInstance() {
			if(!isset(self::$instance)) {
				$object = __CLASS__;
				self::$instance = new $object;
			}
			return self::$instance;
		}


		public function db_connect() {
			$dsn = 'mysql:host='.DBHOST.';dbname='.DB;
			try {
				$this->dbh = new PDO($dsn, UNAME, DBPASS);
				$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return true;
			} catch(PDOException $e) {
				$this->error = $e->getMessage();
				return false;
			}
		}

		public function getFields($table) {
			$sql = 'SELECT * FROM '.PREFIX.$table . ' LIMIT 1';
			$res = $this->get_single_result($sql);
			$fields = array();

			foreach($res as $key => $value) {
				$fields[$key] = '';
			}
			return $fields;
		}
		/**
		 *@description Queries the database base on the $type argments
		 *@package lib_dbcore.php
		 */

		public function query($sql, $type='') {
			switch($type) {
				case '':
					{
						$exe = $this->dbh->query($sql);
						if($exe) {
							return true;
						} else {
							return false;
						}
					}
				break;

				//Performs insertions
				case 'insert':
					{
						$exe = $this->dbh->query($sql);
						if($exe) {
							$this->lastInsertId = $this->dbh->lastInsertId();
							$this->done = true;
						} else {
							$this->error = $this->dbh->errorInfo()[2];
							$this->done = false;
						}
					}
				break;

				//Performs selections
				case 'select':
					{
						$exe = $this->dbh->query($sql);
						if($exe) {
							$this->rowsReturned = $exe->rowCount();

							if($this->rowsReturned > 0 && $this->rowsReturned == 1) {
								$row = $exe->fetch(PDO::FETCH_ASSOC);
								$this->data = $row;
							} else {
								while($row = $exe->fetch(PDO::FETCH_ASSOC)) {
									$this->data[] = $row;
								}
							}
							$this->done = true;
						} else {
							$this->error = $this->dbh->errorInfo()[2];
							$this->done = false;
						}
					}
				break;

				//Performs deletions
				case 'delete':
					{
						$exe = $this->dbh->query($sql);
						if($exe) {
							$this->rowsAffected = $exe->rowCount();
							$this->done = true;
						} else {
							$this->error = $this->dbh->errorInfo()[2];
							$this->done = false;
						}
					}
				break;

				//Performs updates
				case 'update':
					{
						$exe = $this->dbh->query($sql);
						if($exe) {
							$this->rowsAffected = $exe->rowCount();
							$this->done = true;
						} else {
							$this->error = $this->dbh->errorInfo()[2];
							$this->done = false;
						}
					}
				break;
			}
			return false;
		 }

		 /**
		 *@description Gets stuffs from the database using $type[] argument
		 *@package lib_dbcore.php
		 */

		public function _get($key, $type) {

			switch($type) {
				case 'book':
					$sql = 'SELECT * FROM '.PREFIX.'books WHERE acc_no = "'.$key.'"';
					$this->query($sql, 'select');
					if($this->done) {
						return $this->data;
					} else {
						//$arra = $db->_get();
					}
				break;

				case 'conf':
					$sql = 'SELECT * FROM '.PREFIX.'books WHERE acc_no = "'.$key.'"';
					$this->query($sql, 'select');
					if($this->done) {
						return $this->data;
					} else {
						//$arra = $db->_get();
					}
				break;

				#Gets the borrow based on the acc_no
				case 'sBorrow':
					$sql = 'SELECT * FROM '.PREFIX.'borrows WHERE acc_no = "'.$key.'"';
					$this->query($sql, 'select');
					if($this->done) {
						return $this->data;
					} else {
						$arra = $this->_get();
					}
				break;


				#Gets the borrow based on the lib_no and acc_no
				case 'borrow':
					$keyArr = explode('[@]', $key);
					$key1 = $keyArr[0];
					$key2 = $keyArr[1];
					$sql = 'SELECT * FROM '.PREFIX.'borrows LEFT JOIN '
							.PREFIX.'books on '.PREFIX.'books.acc_no = '
							.PREFIX.'borrows.acc_no LEFT JOIN '
							.PREFIX.'admins on '.PREFIX.'admins.admin_id = '
							.PREFIX.'borrows.admin_id WHERE ' .PREFIX.'borrows.acc_no = "'.$key1.'" AND lib_no = "'.$key2.'" LIMIT 1 ';
					//$sql = 'SELECT * FROM '.PREFIX.'borrow' ;
					$this->query($sql, 'select');
					if($this->done) {
						return $this->data;
					} else {
						$arra = $db->_get();
					}
				break;

				#Gets the user based on the ID
				case 'user':
					$sql = 'SELECT * FROM '.PREFIX.'users WHERE uid = '.$key;
					$this->query($sql, 'select');
					if($this->done) {
						return $this->data;
					} else {
						$arra = $this->_get();
					}
				break;

				#Gets the Library user based on the LIB_NO
				case 'userLib_no':
					$sql = "SELECT * FROM ".PREFIX."users WHERE lib_no = \"$key\"";
					$this->query($sql, 'select');
					if($this->done) {
						return $this->data;
					} else {
						$arra = $this->_get();
					}
				break;


				#Gets the Book based on the ACC_NO
				case 'bookAcc_no':
					$sql = "SELECT * FROM ".PREFIX."books WHERE acc_no = \"$key\"";
					$this->query($sql, 'select');
					if($this->done) {
						return $this->data;
					} else {
						$arra = $this->_get();
					}
				break;

				case 'admin':
					$sql = 'SELECT * FROM '.PREFIX.'admins WHERE admin_id = '.$key;
					$this->query($sql, 'select');
					if($this->done) {
						return $this->data;
					} else {

					}
				break;

				case 'admin2':
					$sql = 'SELECT * FROM '.PREFIX.'admins WHERE email = "'.$key.'"';
					$this->query($sql, 'select');
					if($this->done) {
						return $this->data;
					} else {
						$arra = $db->_get();
					}
				break;

				case 'borrow':
					$sql = 'SELECT * FROM '.PREFIX.'borrows WHERE acc_no = '.$key;
					$this->query($sql, 'select');
					if($this->done) {
						return $this->data;
					} else {
						$arra = $db->_get();
					}
				break;
			}
		 }
	}
?>
