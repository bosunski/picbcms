<?php
  /**
   *
   */
  class catm extends Elyon_model
  {

    function __construct()
    {
      parent::__construct();
    }

    //Gets all the Categories that exists
    public function get_all_categories() {
      $sql ="SELECT * FROM " . PREFIX . "category ";
      $res = $this->shareCon()->get_result($sql, array());
      $cats = array();
      if($res) {
        foreach ($res as $key => $value) {
          $cat[$value['id']] = $value['cat_name'];
        }
        return $cat;
      } else {
      }
    }

    public function get_category($cid, $field = null) {
      $field = ($field != null) ? $field : '*';
      $sql = 'SELECT ' . $field  . ' FROM ' . PREFIX . 'category WHERE id = ?';
      $res = $this->shareCon()->get_single_result($sql, array($cid));
      if($res != null)
        return $res;

      return false;
    }

    public function getCategoryRows($col = null, $filter = null, $page = null) {
			$categories = $this->get_all_categories();
			$cat_row = '';
			if(is_array($categories) && $categories != false) {
				foreach ($categories as $key => $value) {
					$cat_row .= '<tr id="trow_1">
          <td class="text-center">'.$key.'</td>
							<td class="text-center">'.$value.'</td>
							<td><a class="btn btn-sm btn-danger" href="'.get_option('home').'/el-admin/post/category?delete='.$key.'">Delete</a>
							<a class="btn btn-sm btn-default" href="'.get_option('home').'/el-admin/post/category?edit='.$key.'">Edit</a></td>
					</tr>';
				}
			} else {
				$cat_row = '<b style="color:red;">Data is Empty!</b>';
			}
			return $cat_row;
		}

    public function delete_cat($id) {
      if($id != 0) {
        $q = 'UPDATE '.PREFIX.'posts SET post_parent=? WHERE post_parent=?';
        $exe = $this->shareCon()->prepare($q, array(0, $id));
        if($exe) {
          $sql = 'DELETE FROM '.PREFIX.'category WHERE id=?';
          $res = $this->shareCon()->prepare($sql, array($id));
          if($res) { return true; }
        }
      } else {}
      return false;
    }

    public function addCategory($name) {
      $sql = 'INSERT INTO '.PREFIX.'category VALUES(null, ?)';
      $res = $this->shareCon()->prepare($sql, array($name));
      if($res) { return true; }
      return false;
    }

    public function updateCat($id, $name) {
      if($id != 0) {
        $sql = 'UPDATE '.PREFIX.'category SET cat_name=? WHERE id=?';
        $res = $this->shareCon()->prepare($sql, array($name, $id));
        if($res) { return true; }
      }
      return false;
    }

  }

?>
