<?php
  class Pagem extends Elyon_Model {
    function __construct() {
      parent::__construct();
    }

    public function getPage($pid, $column = null, $type = 'pid') {
            $column = ($column == null) ? '*' : $column;
						$col = ($type == 'pid') ? 'ID' : 'post_name';
            $sql = 'SELECT ' .$column. ' FROM '.PREFIX.'posts WHERE post_type="page" AND post_status="publish" AND ' . $col . ' = ? ';
            $res = isset($pid) ? $this->shareCon()->get_single_result($sql, array($pid)) : null;
            if($res != null) {
                return $res;
            }
            return false;
		}
  }
?>
