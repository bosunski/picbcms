<?php
  class Userm extends Elyon_model {
    public function __construct() {
      parent::__construct();
    }
    public function get_user_field($uid, $field = null) {
      $field = ($field != null) ? $field : '*';
      $sql = 'SELECT ' .$field. ' FROM ' .PREFIX. 'users WHERE ID = ?';
      $res = $this->shareCon()->get_single_result($sql, array($uid));
      if($res != null)
        return $res;

      return false;
    }

    public function getWorkerRows($col = null, $filter = null, $page = null) {
			$workers = $this->get_all_worker($col, $filter, $page);
			$post_row = '';
			if(is_array($workers) && $workers != false) {
				foreach ($workers as $key => $value) {
					$f_image = $value['f_image'] == '' ? 'No Image' : '<img width="100px" height="50px" src="'.get_option('home').'/el-contents/uploads/workers/'.$value['f_image'].'"/>';
					$post_row .= '<tr id="trow_1">
          <td class="text-center">'.$value['post_title'].'</td>
							<td class="text-center">'.$f_image.'</td>
							<td><a href="'.get_option('home').'/el-admin/user/workers?action=delete&id='.$value['ID'].'?action=trash">Delete</a>
							<a href="'.get_option('home').'/el-admin/user/workers?action=edit&id='.$value['ID'].'">Edit</a></td>
					</tr>';
				}
			} else {


        $post_row = '<b style="color:red;">Workers list is Empty!</b>';
			}
			return $post_row;
		}

    public function getAdminRows($col = null, $filter = null, $page = null) {
			$workers = $this->get_all_admin($col, $filter, $page);
			$post_row = '';
			if(is_array($workers) && $workers != false) {
        $count = 1;
				foreach ($workers as $key => $value) {
					//$f_image = $value['f_image'] == '' ? 'No Image' : '<img width="100px" height="50px" src="'.get_option('home').'/el-contents/uploads/workers/'.$value['f_image'].'"/>';
          $delete = (Session::get_var('ID') == $value['ID']) ? ' ' : '<a href="'.get_option('home').'/el-admin/user/admin?delete='.$value['ID'].'">Delete</a>';
          $post_row .= '<tr id="trow_1">
          <td class="text-center">'.$count.'</td>
							<td class="text-center">'.$value['user_nicename'].'</td>
							<td>'.$delete.'
							<a href="'.get_option('home').'/el-admin/user/admin?edit='.$value['ID'].'">Edit</a></td>
					</tr>';
          $count++;
				}
			} else {
				$post_row = '<b style="color:red;">Admin list is Empty!</b>';
			}
			return $post_row;
		}


    public function get_all_worker($col = null, $filter_array = null, $page = null) {
			$query_append = (empty($filter_array)) ? ' WHERE post_type="worker" ' : ' WHERE ';
			$counter = 0;
			if(!empty($filter_array)) {
				foreach($filter_array as $c => $value) {
					$query_append .= $c .'"'. $value.'"' . ' ';
					$counter++;
					$query_append .= ($counter != count($filter_array)) ? 'AND ' : '';
				}
			}
			$sql = 'SELECT * FROM ' . PREFIX . 'posts ' . $query_append . ' ORDER BY post_date DESC';
			$res = $this->shareCon()->get_result($sql);
			if($res != null) {
				return $res;
			} else {
				return false;
			}
		}

    public function get_all_admin($col = null, $filter_array = null, $page = null) {
      $query_append = (empty($filter_array)) ? ' ' : ' WHERE ';
      $counter = 0;
      if(!empty($filter_array)) {
        foreach($filter_array as $c => $value) {
          $query_append .= $c .'"'. $value.'"' . ' ';
          $counter++;
          $query_append .= ($counter != count($filter_array)) ? 'AND ' : '';
        }
      }
      $sql = 'SELECT * FROM ' . PREFIX . 'users ' . $query_append . ' ';
      $res = $this->shareCon()->get_result($sql);
      if($res != null) {
        return $res;
      } else {
        return false;
      }
    }

    public function getWorker($id, $column = null) {
            $column = ($column == null) ? '*' : $column;
            $sql = 'SELECT ' .$column. ' FROM '.PREFIX.'posts WHERE post_type=? AND ID = ? ';
            $res = isset($id) ? $this->shareCon()->get_single_result($sql, array('worker', $id)) : null;
            if($res != null) {
                return $res;
            }
            return false;
    }

    public function getAdmin($id, $column = null) {
      $column = ($column == null) ? '*' : $column;
      $sql = 'SELECT ' .$column. ' FROM '.PREFIX.'users WHERE ID = ? ';
      $res = isset($id) ? $this->shareCon()->get_single_result($sql, array($id)) : null;
      if($res != null) {
          return $res;
      }
      return false;
    }

    public function getAdminData($col, $val = null) {
      $sql = 'SELECT * FROM '.PREFIX.'users WHERE '.$col.' = ? ';
      $res = $this->shareCon()->get_single_result($sql, array($val));
      if($res != null) {
          return $res;
      }
      return false;
    }

    public function deleteWorker($id) {
      $sql = 'DELETE FROM '.PREFIX.'posts WHERE ID=?';
      $res = $this->shareCon()->prepare($sql, array($id));
			if($res) {return true;}
			return false;
    }

    public function deleteAdmin($id) {
      $currAdminID = Session::get_var('ID');
      $sql = 'DELETE FROM '.PREFIX.'users WHERE ID=?';
      $sqll = 'UPDATE '.PREFIX.'posts SET post_author=? WHERE post_author=?';
      $res = $this->shareCon()->prepare($sqll, array($currAdminID, $id));
      if($res) {
        $res = $this->shareCon()->prepare($sql, array($id));
        if($res) {return true;}
      }
			return false;
    }

    public function add_worker($data) {
      $sql = 'INSERT INTO '.PREFIX.'posts (post_content, post_title, post_excerpt, post_name, post_tag, f_image, post_type) VALUE(?, ?, ?, ?, ?, ?, ?)';
      $res = $this->shareCon()->prepare($sql, array($data['post_content'], $data['post_title'], $data['post_excerpt'], $data['post_name'], $data['post_tag'], $data['f_image'], 'worker'));
      if($res) {
        return true;
      }
      return false;
    }

    public function add_admin($data) {
      $error = array();
      $auth = new Auth();
			$salt = $auth->_getRand();

      if($data['name'] == '') {
        $error[] = 'Name cannot be empty.';
      }

      if($data['email'] == '') {
        $error[] = 'Email cannot be empty.';
      }

      if($data['username'] == '') {
        $error[] = 'Username cannot be empty.';
      }

      if($data['password'] == '') {
        $error[] = 'Password cannot be empty.';
      }

      if(is_array($this->getAdminData('user_login', $data['username']))) {
        $error[] = 'Username already exist, choose another.';
      }

			$password = $salt.$data['password'];
			$password = $auth->hashData($password);
			$password = substr($password, 0, 59);

      $data = $this->clean_data($data);


      $sql = 'INSERT INTO '.PREFIX.'users (user_login, user_pass, user_nicename, user_email, user_salt_key, display_name, user_level) VALUE(?, ?, ?, ?, ?, ?, ?)';
      $bind = array($data['username'], $password, $data['name'], $data['email'], $salt, $data['username'], $data['role']);
      if(empty($error)) {
        $res = $this->shareCon()->prepare($sql, $bind);
        if($res) {
          return true;
        }
      } else {
        return $error;
      }
      return false;
    }

    public function update_admin($id, $data) {
      $error = array();
      $auth = new Auth;
      $sqlAppend = ' ';
      $password = $data['password'];
      if($password != '') {
        $code = $this->getAdmin($id, 'user_salt_key')['user_salt_key'];
        $password = $code.$password;
  			$password = $auth->hashData($password);
  			$password = substr($password, 0, 59);
        $sqlAppend = ', user_pass="'.$password.'"';
      }

      $data = $this->clean_data($data);

      if($data['name'] == '') {
        $error[] = 'Name cannot be empty.';
      }

      if($data['email'] == '') {
        $error[] = 'Name cannot be empty.';
      }

      $sql = 'UPDATE '.PREFIX.'users SET user_nicename=?, user_email=?, user_level=?'.$sqlAppend.' WHERE ID=?';
      $bind = array($data['name'], $data['email'], (int)$data['role'], $id);
      if(!empty($error)) {
        return $error;
      } else {
        $res = $this->shareCon()->prepare($sql, $bind);
        if($res) return true;
      }

      return false;
    }

    private function clean_data($array) {
      foreach ($array as $key => $value) {
        $array[$key] = clean($value);
      }
      return $array;
    }
  }
?>
