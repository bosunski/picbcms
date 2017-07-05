<?php
  class Userm extends Elyon_model {
    public function __construct() {
      parent::__construct();
      $this->theme = Atheme::gI();
    }
    public function get_user_field($uid, $field = null) {
      $field = ($field != null) ? $field : '*';
      $sql = 'SELECT ' .$field. ' FROM ' .PREFIX. 'users WHERE ID = ?';
      $res = $this->shareCon()->get_single_result($sql, array($uid));
      if($res != null)
        return $res;

      return false;
    }

    public function get_author_details($uid) {
      $author_model = $this->theme->get_theme_model('author_link_viewpost');
      $author_det = array();
      $author = $this->get_user_field($uid, 'user_nicename, user_login');
      $author_det['name'] = $author['user_nicename'];
      $author_model = str_replace('[@author_link]', get_option('home').'/'.$author['user_login'], $author_model);
      $author_model = str_replace('[@author_name]', $author['user_nicename'], $author_model);
      $author_det['link'] = $author_model;
      return $author_det;
    }

    public function getUser($filter_array, $column = null) {
            $column = ($column == null) ? '*' : $column;
						//$col = ($type == 'pid') ? 'ID' : 'post_name';
            $query_append = (empty($filter_array)) ? '' : ' WHERE ';
      			//$query_append_last = ' LIMIT ' . $posts . ', ' . get_option('post_per_page');
      			$counter = 0;
      			if(!empty($filter_array)) {
      				foreach($filter_array as $c => $value) {
      					$query_append .= $c .'"'. $value.'"' . ' ';
      					$counter++;
      					$query_append .= ($counter != count($filter_array)) ? 'AND ' : '';
      				}
      			}
            $sql = 'SELECT ' .$column. ' FROM '.PREFIX.'users ' . $query_append;
            $res = $this->shareCon()->get_single_result($sql);
            if($res != null) {
                return $res;
            }
            return false;
		}

    public function addUser() {
      if(preg_match('/[a-zA-z]/${20}', $rfname)) {

      }
      $sql = 'INSERT INTO '.PREFIX.'users user_login, user_pass, user_nicename, user_email, user_registered, user_salt_key, display_name
              VALUES(?, ?, ?, ?, ?, ?, ?)';
    }
  }
?>
