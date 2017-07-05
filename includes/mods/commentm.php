<?php
  class Commentm extends Elyon_model {
    public function __construct() {
      parent::__construct();
    }

    /* Counts the numbers of comment attached to a post ID */
    public function count_comments($pid, $field = null) {
      $field = ($field != null) ? $field : '*';
      $sql = 'SELECT COUNT(' . $field  . ') AS comments FROM ' . PREFIX . 'comments WHERE comment_post_ID = ?';
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

    //Get HTML rows of the comments
    public function getCommentRows($col = null, $filter = null, $page = null) {
			$comments = $this->get_all_comment($col, $filter, $page);
			$comment_row = '';
			if(is_array($comments) && $comments != false) {
				foreach ($comments as $key => $value) {
          $comment = ($value['comment_approved'] == 1) ? $value['comment_content'] : 'Comment disapproved by Administrator.';
					$comment_model = $this->theme->get_theme_model('each_post_comment');
					$comment_model = str_replace('[@comment_author]', $value['comment_author'], $comment_model);
					$comment_model = str_replace('[@comment_content]', clean($comment), $comment_model);
					$comment_model = str_replace('[@comment_date]', date("F d, Y", strtotime($value['comment_date'])), $comment_model);
					$avatar = get_option('home').'/el-contents/avatar.png';
					$comment_model = str_replace('[@avatar]', $avatar, $comment_model);

					$comment_row .= $comment_model;
				}
			} else {
        $comment_row = $this->theme->get_theme_model('no_comment');
			}
			return $comment_row;
		}

    //Gets All comments
    public function get_all_comment($col = null, $filter_array = null, $page = null) {
			if($page == 1 || $page == null) {
				$posts = 0;
			} else {
				$posts = ($page * get_option('comment_per_page')) - get_option('comment_per_page');
			}
			$query_append = (empty($filter_array)) ? '' : ' WHERE ';
			$query_append_last = ' LIMIT ' . $posts . ', ' . get_option('comment_per_page');
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

    //Recives comment data and add to the database
    public function addComment($post_id, $data) {
      $error = array();
      if(empty($data)) {
        $error[] = 'All the fields are empty, please input something.';
      } else {
        if(clean($data['name']) == '') {
          $error[] = 'Please fill the name field, its required.';
        } elseif(!preg_match('/[A-Za-z]$/', clean($data['name']))) {
          $error[] = 'The name can only contain letters and spaces.';
        } elseif(strlen(clean($data['name'])) > 50) {
          $error[] = 'Your name cannot be more than 50 characters';
        }

        if(clean($data['email']) == '') {
          $error[] = 'Please fill the email field, its required.';
        } elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
          $error[] = 'The email you entered is not valid';
        } elseif(strlen(clean($data['email'])) > 100) {
          $error[] = 'Your email cannot be more than 100 characters';
        }

        if(clean($data['comment']) == '') {
          $error[] = 'Please type in your comment, its required.';
        }

        if(empty($error)) {
          $ip = $_SERVER['REMOTE_ADDR'];
          $comment = $this->shareCon()->quote(clean($data['comment']));
          $sqll = 'SELECT * FROM '.PREFIX.'comments WHERE comment_author_email="'.$data['email'].'" AND comment_author="'.$data['name'].'" AND comment_content='.$comment.' ORDER BY comment_date DESC LIMIT 1';
          $res = $this->shareCon()->get_single_result($sqll, array());
          if(!empty($res) && $res != false) {
            $error[] = 'Your comment has been added already.';
            return $error;
          }
          $sql = 'INSERT INTO ' . PREFIX . 'comments (comment_ID, comment_post_ID, comment_author, comment_author_email, comment_author_IP, comment_date, comment_content)
                  VALUES(NULL, '.$post_id.', "'.ucfirst(clean($data['name'])).'", "'.clean($data['email']).'", "'.$ip.'", NOW(), '.$comment.')';
          $res = $this->shareCon()->prepare($sql, array());
          if($res) {
            if(Session::get_var('user_login') != '' && Session::get_var('user_pass') != '') {
              Session::set_var('comment_name', Session::get_var('user_nicename'));
              Session::set_var('comment_email', Session::get_var('user_email'));
            } else {
              Session::set_var('comment_name', $data['name']);
              Session::set_var('comment_email', $data['email']);
            }
            return true;
          } else {
            $error[] = 'Commenting System is down please contact the Admin Quickly.';
          }
        }
      }
      return (empty($error)) ? true : $error;
    }

  }
?>
