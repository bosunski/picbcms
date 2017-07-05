<?php
  class Commentm extends Elyon_model {
    public function __construct() {
      parent::__construct();
    }

    public function count_comments($pid, $field=null) {
      $field = ($field != null) ? $field : '*';
      $sql = 'SELECT COUNT(' . $field  . ') as comments FROM ' . PREFIX . 'comments WHERE comment_post_ID = ?';
      $res = $this->shareCon()->get_single_result($sql, array($pid));
      if($res != null)
        return $res['comments'];

      return false;
    }

    public function get_category($cid, $field = null) {
      $field = ($field != null) ? $field : '*';
      $sql = 'SELECT ' . $field  . ' FROM ' . PREFIX . 'category WHERE id = ?';
      $res = $this->shareCon()->get_single_result($sql, array($cid));
      if($res != null)
        return $res;

      return false;
    }

    public function getCommentsRows($col = null, $filter = null, $page = null) {
			$posts = $this->get_all_comments($col, $filter, $page);
			$post_row = '';
			if(is_array($posts) && $posts != false) {
				foreach ($posts as $key => $value) {
          $comment_status = ($value['comment_approved'] == 1) ? 'Approved' : 'Unapproved';
          $active = ($value['comment_approved'] == 1) ? ' ' : 'active';
					$post_row .= '<tr id="trow_1">
							<td class="text-center"><input type="checkbox" value="'.$value['comment_ID'].'" name="post_id[]" class="post-id" id="post-id"/></td>
							<td class="text-center">'.$value['comment_ID'].'</td>
							<td>'.$value['comment_author'].'</td>
              <td>'.$value['comment_author_email'].'</td>
							<td>'.$comment_status.'</td>
							<td>'.$value['comment_author_IP'].'</td>
							<td>'.$value['comment_content'].'</td>
							<td>'.$value['comment_date'].'</td>
							<td><a class="btn btn-sm btn-danger" href="'.get_option('home').'/el-admin/post/comment/'.$value['comment_post_ID'].'?delete='.$value['comment_ID'].'">Delete</a>
                  <a class="btn btn-sm btn-default" href="'.get_option('home').'/el-admin/post/comment/'.$value['comment_post_ID'].'?approve='.$value['comment_ID'].'">Approve</a>
                  <a class="btn btn-sm btn-default" href="'.get_option('home').'/el-admin/post/comment/'.$value['comment_post_ID'].'?unapprove='.$value['comment_ID'].'">Unapprove</a>
							</td>
					</tr>';
				}
			} else {
				$post_row = '<b style="color:red;">Data is Empty!</b>';
			}
			return $post_row;
		}


    public function get_all_comments($col = null, $filter_array = null, $page = null) {
			if($page == 1 || $page == null) {
				$posts = 0;
			} else {
				$posts = ($page * get_option('admin_post_per_page')) - get_option('admin_post_per_page');
			}
			$query_append = (empty($filter_array)) ? ' ' : ' WHERE ';
			$query_append_last = ' LIMIT ' . $posts . ', ' . get_option('admin_post_per_page');
			$counter = 0;
			if(!empty($filter_array)) {
				foreach($filter_array as $c => $value) {
					$query_append .= $c .'"'. $value.'"' . ' ';
					$counter++;
					$query_append .= ($counter != count($filter_array)) ? 'AND ' : '';
				}
			}
			$sql = 'SELECT * FROM ' . PREFIX . 'comments ' . $query_append . ' ORDER BY comment_date DESC' . $query_append_last;
			$res = $this->shareCon()->get_result($sql);
			if($res != null) {
				return $res;
			} else {
				return false;
			}
		}

    public function get_all_comment_unpaged($filter_array = array(), $limit = null, $bind = 'AND') {
			$counter = 0;
			$query_append = (empty($filter_array)) ? ' WHERE post_type="post" OR post_type="page" ' : ' WHERE ';
			$query_append_last = ($limit == null) ? '' : ' LIMIT ' . $limit;
			if(!empty($filter_array)) {
				foreach($filter_array as $col => $value) {
					$query_append .= $col .'"'. $value.'"' . ' ';
					$counter++;
					$query_append .= ($counter != count($filter_array)) ? $bind. ' ' : '';
				}
			}

			$sql = 'SELECT * FROM ' . PREFIX . 'comments ' . $query_append . ' ORDER BY comment_date DESC' . $query_append_last;
			$res = $this->shareCon()->get_result($sql);
			if($res != null) {
				return $res;
			} else {
				return false;
			}
		}

    public function delete_comment($id) {
      $sql = 'DELETE FROM '.PREFIX.'comments WHERE comment_ID=?';
      $res = $this->shareCon()->prepare($sql, array($id));
      if($res) {
        return true;
      }
      return false;
    }

    public function approve_comment($id) {
        $sql = 'UPDATE '.PREFIX.'comments SET comment_approved=? WHERE comment_ID=?';
      $res = $this->shareCon()->prepare($sql, array('1', $id));
      if($res) {
        return true;
      }
      return false;
    }

    public function unapprove_comment($id) {
      $sql = 'UPDATE '.PREFIX.'comments SET comment_approved=? WHERE comment_ID=?';
      $res = $this->shareCon()->prepare($sql, array('0', $id));
      if($res) {
        return true;
      }
      return false;
    }
  }
?>
