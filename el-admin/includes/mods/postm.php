<?php
	class PostM extends Elyon_model {
		private $_draftData = null;
		private $_draftTpl;

		function __construct(array $draftData = null) {
			parent::__construct();
			$this->_draftData = $draftData;
			if($draftData != null) {
				//exit;
				$guid = $this->_getGuid();
				$f = $this->shareCon()->getFields('posts');
				foreach ($f as $key => $value) {

				}
				$this->_draftTpl = 'INSERT INTO '.PREFIX.'posts VALUES (
					null, :post_author, NOW(), :now_zero, :post_content,
					:post_title, :post_excerpt, :post_status,
					:comment_status, :ping_status, :post_password,
					:post_name, :to_ping, :pinged, NOW(), NOW(), :post_content_filtered, :post_parent,
					:guid, :menu_order, :post_type, :post_mime_type, :comment_count, :post_tag, :post_visibility, :f_image)';

				$this->_defParam = array(
					':post_author' => '', ':now_zero' => '0000-00-00 00:00:00', ':post_content' => '',
					':post_title' => '', ':post_excerpt' => '', ':post_status' => 'draft',
					':comment_status' => '', ':ping_status' => '' , ':post_password' => '' ,
					':post_name' => '' , ':to_ping' => '' , ':pinged' => '' , ':post_content_filtered' => '' , ':post_parent' => 0,
					':guid' => $guid , ':menu_order' => '' , ':post_type' => 'post' , ':post_mime_type' => '' ,
					':comment_count' => '', ':post_tag' => '', ':post_visibility' => '', ':f_image' => '');

				$this->_draftData = array_merge($this->_defParam, $draftData);
				$this->_createDraft();
				return true;
			}
			return false;
		}

		private function _createDraft() {
			$d = $this->shareCon()->prepare($this->_draftTpl, $this->_draftData);
			if($d) {
				return $this->getDrafts(5);
			}
		}

		private function _createDraftx() {
			$d = $this->shareCon()->prepare($this->_draftTpl, $this->_draftData);
		}

		private function _getLastPostID() {
			$sql = 'SELECT ID FROM '.PREFIX.'posts ORDER by post_date DESC LIMIT 1';
			$res = $this->shareCon()->get_single_result($sql);
			return $res['ID'];
		}

		private function _getGuid() {
			$last_id = $this->_getLastPostID();
			$last_id++;
			$guid = get_option('home').'/?p='.$last_id;
			return $guid;
		}

		private function _loadPost($type = 'post', $length = '0') {
			$length = $length == 0 ? '' : ' LIMIT ' . $length;
			$sql = 'SELECT * FROM '.PREFIX.'posts WHERE post_type="post" AND post_status = ? ORDER BY post_date DESC ';
			$res = $this->shareCon()->get_result($sql, array($type));
			return $res;
		}

		public function getDrafts($len = 0) {
			$len = $len == 0 ? '' : $len;
			$drafts = $this->_loadPost('draft', $len);
			$ui = '';
			$ui .= empty($drafts) ? '' : '<HEAD><h5><b>Drafts</b><a class="pull-right" href="">View All</a></h5></HEAD>';
			foreach ((array) $drafts as $key => $draft) {
				$content = substr(strip_tags(reverse_simple_clean($draft['post_content'])), 0, 200). '...';
				$ui .= '<p><a href="'. get_option('home').'/el-admin/post/edit/'.$draft['ID'] . '">' . $draft['post_title'] . '</a> on ' . date('M d, Y', strtotime($draft['post_date'])) . '<br/>' . $content . '</p>';
			}
			$ui .= '';
			return $ui;
		}

		public function getPost($pid, $column = null) {
            $column = ($column == null) ? '*' : $column;
            $sql = 'SELECT ' .$column. ' FROM '.PREFIX.'posts WHERE ID = ? ';
            $res = isset($pid) ? $this->shareCon()->get_single_result($sql, array($pid)) : null;
            if($res != null) {
                return $res;
            }
            return false;
		}

		public function get_all_post($col = null, $filter_array = null, $page = null) {
			if($page == 1 || $page == null) {
				$posts = 0;
			} else {
				$posts = ($page * get_option('admin_post_per_page')) - get_option('admin_post_per_page');
			}
			$query_append = (empty($filter_array)) ? ' WHERE post_type="audio" OR post_type="video" OR post_type="post" OR post_type="page" ' : ' WHERE ';
			$query_append_last = ' LIMIT ' . $posts . ', ' . get_option('admin_post_per_page');
			$counter = 0;
			if(!empty($filter_array)) {
				foreach($filter_array as $c => $value) {
					$query_append .= $c .'"'. $value.'"' . ' ';
					$counter++;
					$query_append .= ($counter != count($filter_array)) ? 'AND ' : '';
				}
			}
			$sql = 'SELECT * FROM ' . PREFIX . 'posts ' . $query_append . ' ORDER BY post_date DESC' . $query_append_last;
			$res = $this->shareCon()->get_result($sql);
			if($res != null) {
				return $res;
			} else {
				return false;
			}
		}


		public function get_all_post_unpaged($filter_array = array(), $limit = null, $bind = 'AND') {
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
			$sql = 'SELECT * FROM ' . PREFIX . 'posts ' . $query_append . ' ORDER BY post_date DESC' . $query_append_last;
			$res = $this->shareCon()->get_result($sql);
			if($res != null) {
				return $res;
			} else {
				return false;
			}
		}

		public function getPostRows($col = null, $filter = null, $page = null) {
			$posts = $this->get_all_post($col, $filter, $page);
			$post_row = '';
			if(is_array($posts) && $posts != false) {
				foreach($posts as $key => $value) {
					$author = $value['post_author'];
					$n = new Userm;$c = new Catm;$cmm = new Commentm;
					$comm = $cmm->count_comments($value['ID']);
					$comments = (!$comm) ? 0 : $comm;
					$author_name = $n->get_user_field($author, 'user_login');
					$cat_name = $c->get_category($value['post_parent'], 'cat_name');
					$f_image = $value['f_image'] == '' ? 'No Image' : '<img width="100px" height="50px" src="'.get_option('home').'/el-contents/uploads/f_image/'.$value['f_image'].'"/>';
					$post_row .= '<tr id="trow_1">
							<td class="text-center"><input type="checkbox" value="'.$value['ID'].'" name="post_id[]" class="post-id" id="post-id"/></td>
							<td class="text-center">'.$value['ID'].'</td>
							<td>'.ucfirst($author_name['user_login']).'</td>
							<td>'.$value['post_title'].'</td>
							<td>'.$cat_name['cat_name'].'</td>
							<td>'.$value['post_status'].'</td>
							<td>'.$f_image.'</td>
							<td>'.$value['post_tag'].'</td>
							<td><a href="'.get_option('home').'/el-admin/post/comment/'.$value['ID'].'">'.$comments.'</a></td>
							<td>'.$value['post_date'].'</td>
							<td><a href="'.get_option('home').'/el-admin/post/edit/'.$value['ID'].'?action=trash">Delete</a>
							<a href="'.get_option('home').'/el-admin/post/edit/'.$value['ID'].'">Edit</a></td>
					</tr>';
				}
			} else {
				$post_row = '<b style="color:red;">Data is Empty!</b>';
			}
			return $post_row;
		}


		public function get_pagers($data_length, $per_page, $curr_page) {
			$each_page = ceil($data_length / $per_page);
			if($curr_page > $each_page) {

			}
			$curr_uri = explode('&', $_SERVER['REQUEST_URI']);
			$a = str_replace('/newpost', '', str_replace('action=savePost', '', $curr_uri[0]));
			//_x($a);
			$prev_page = ($curr_page <= 1) ? 0 :  $curr_page - 1;
			$prev_page = $prev_page == 0 ? '<li class="disabled"><a>&laquo;</a></li>' :
																		'<li class=""><a href="'.$a.'&page='. $prev_page.'">&laquo;</a></li>';
			$next_page = ($curr_page > $each_page) ? $each_page : $curr_page + 1;
			$next_page = $next_page > $each_page ? '<li class="disabled"><a>&raquo;</a></li>' :
																		'<li class=""><a href="'.$a.'&page='. $next_page.'">&raquo;</a></li>';

			$pagers = $prev_page;
			for($i = 1; $i <= $each_page; $i++) {
				if($i == $curr_page) {
					$pagers .= '<li class="active"><a>'.$i.'</a></li>';
				} else {
					$pagers .= '<li><a href="'.$a.'&page='.$i.'">'.$i.'</a></li>';
				}
			}
			$pagers .= $next_page;
			return $pagers;
		}

		public function getPostTagHtml($id) {
            $html = '';
            $tags = $this->getPostTag($id);
            if($tags[0] != '') {
            	foreach($tags as $key => $tag) {
                    $html .= ($tag == '') ? '' : '<li><a class="btn"><span  style="color:red;" class="each-tag fa fa-thumb-tack"></span><span>' . $tag .'</span></a></li>';
            	}
            }
            //var_dump($tags);
            return $html;
		}

		public function getPostTag($id) {
        $post = $this->getPost($id, 'post_tag');
        $tags = explode(',', $post['post_tag']);
        return $tags;
		}

		/* Updates and set @post_name */
		public function updatePerm($id) {
			if($id != null) {
				$sql = 'UPDATE ' . PREFIX . 'posts SET post_name = ? WHERE ID = ?';
				$post_name = $_POST['post_names'];
				if(preg_match('/[^0-9a-zA-Z\b\s-]+/', $post_name)) {
					_x('Post name can only contain Letters, Numbers and minuses.');
				}
				$post_name = preg_replace('/[\s]+/', '-', $post_name);
				$post_name = preg_replace('/[-]+/', '-', $post_name);
				$post_name = strtolower(trim(rtrim($post_name, '-'), '-'));
				//Checking for duplicate
				$dupStat = $this->_checkNameDuplicate($post_name, $id);
				if($dupStat > 0) {
					$post_name = $post_name . '-' .($dupStat + 1);
				}
				$a = $this->shareCon()->prepare($sql, array($post_name, (int) $id));
				if($a) {
					return $post_name;
				}
			}
			return null;
		}

		private function _checkNameDuplicate($post_name, $id) {
			$sql = 'SELECT COUNT(*) AS post_names FROM ' . PREFIX . 'posts WHERE post_name="'.$post_name.'" AND ID != ' . $id;
			$dupStat = $this->shareCon()->get_single_result($sql);
			return $dupStat['post_names'];
		}
		public function updatePost($id, $data = array()) {
			$sql = 'UPDATE ' . PREFIX . 'posts SET ';
			$len = count($data);
			$count = 0;
			foreach($data as $field => $value) {
				$sql .= str_replace(':', '', $field) . ' = ' . $field . ' ';
				$count++;
				$sql .= ($len > 1 && $count != $len) ? ', ' : '';
			}
			$sql .= 'WHERE ID = ' . $id;
			$res = $this->shareCon()->prepare($sql, $data);
			if($res) {
				return true;
			} elseif($res === 'indef') {
				return $res;
			}
			return false;
		}

		public function makeNewPost($data = array()) {
			$sql = 'UPDATE ' . PREFIX . 'posts SET ';
			$len = count($data);
			$count = 0;
			foreach($data as $field => $value) {
				$sql .= str_replace(':', '', $field) . ' = ' . $field . ' ';
				$count++;
				$sql .= ($len > 1 && $count != $len) ? ', ' : '';
			}
			$sql .= 'WHERE ID = ' . $id;
			$res = $this->shareCon()->prepare($sql, $data);
			if($res) {
				return true;
			} elseif($res === 'indef') {
				return $res;
			}
			return false;
		}

		public function trashPost($pid = null) {
			$data = array(':post_status' => 'trashed');
			$done = $this->updatePost($pid, $data);
			if($done) {return true;}
			return false;
		}

		public function publishPost($pid = null) {
			$data = array(':post_status' => 'publish');
			$done = $this->updatePost($pid, $data);
			if($done) {return true;}
			return false;
		}

		public function unpublishPost($pid = null) {
			$data = array(':post_status' => 'draft');
			$done = $this->updatePost($pid, $data);
			if($done) {return true;}
			return false;
		}

		//Converts a post to a page
		public function convertPostToPage($pid = null) {
			$data = array(':post_type' => 'page');
			$done = $this->updatePost($pid, $data);
			if($done) {return true;}
			return false;
		}

		//Converts page to post
		public function convertPageToPost($pid = null) {
			$data = array(':post_type' => 'post');
			$done = $this->updatePost($pid, $data);
			if($done) {return true;}
			return false;
		}


		/* handles birthdays adding and editing
			this function will be upgraded by God's grace in the future
			for better implementation.
		*/

		public function get_birthdays() {
			$sql = 'SELECT post_tag FROM '.PREFIX.'posts WHERE post_type=? LIMIT 1';
			$res = $this->shareCon()->prepare($sql, array('birthdays'));
			if(!$res) {
				return false;
			}
			return $b;
		}


		/* handles birthdays adding and editing
			this function will be upgraded by God's grace in the future
			for better implementation.
		*/

		public function add_birthdays($b) {
			$sql = 'UPDATE ' . PREFIX . 'options SET option_value="'.$b.'" WHERE option_name=?';
			$res = $this->shareCon()->prepare($sql, array('birthdays'));
			if(!$res) {
				return false;
			}
			return $b;
		}

		public function saveFrontMsg($b) {
			$sql = 'UPDATE ' . PREFIX . 'options SET option_value="'.$b.'" WHERE option_name=?';
			$res = $this->shareCon()->prepare($sql, array('front_message'));
			if(!$res) {
				return false;
			}
			return $b;
		}
	}
?>
