<?PHP
	if(!isset($su_check)) {
		echo "Unauthorised access of file";
		exit();
	}

	class Dbcore {
		private $db_name = DB;
		private $db_user = UNAME;
		private $db_pass = DBPASS;
		private $db_server = DBHOST;

		protected $con;

		function configure($server, $db, $user, $pass) {
			$this->db_server = $server;
			$this->db_name = $db;
			$this->db_user = $user;
			$this->db_pass = $pass;
		}

		private function connect() {
			$dsn = 'mysql:host='.$this->db_server.';dbname='.$this->dbname;
			try {
				$this->con = new PDO(dsn, $this->db_user, $this->db_pass);
			} catch(PDOException $e) {
				header('HTTP/1.1 500 Database Error');
				exit;
			}

			if(!$this->con) {
				die('Could not connect: '. mysql_error());
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
		function quote($arg) {
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
		function prepare($sql, $args) {
			$this->connect();
			$q = $this->con->prepare($sql);
			$q->execute($args);
			$this->disconnect();
			return $q;
		}
	}
?>