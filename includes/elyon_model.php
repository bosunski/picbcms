<?php
	class Elyon_Model {
		private $_con;
		function __construct() {
			$this->_con = Dbcore::getInstance();
			$this->theme = Atheme::gI();
		}

		public function shareCon() {
			return $this->_con;
		}

		public function quote(array $result) {
			foreach ($result as $key => $value) {
				$result[$key] = $this->_con->quote($value);
			}
			return $result;
		}

		public function getTableFields($table) {
			return $this->_con->getFields($table);
		}

		public function createParam($table, $arr) {
			$param = array();
			// Gets all the table fields
			$fields = $this->getTableFields($table);
			//Selects only fields that exists in the get request
			foreach($arr as $key => $val) {
				if(array_key_exists($key, $fields)) {
					$param[':' . $key] = $val;
				}
			}
			return $param;
		}

		protected function getBlockquotedMsg($ccode, $msg) {
			return '<div><blockquote style="background:white;border-left-color:'.$ccode.';"><h4 style="font-weight:1;margin-bottom:0px;">'.$msg.'</h4></blockquote></div>';
		}
	}
?>
