<?php
	class User extends Elyon_core_controller {
		function __construct() {
			parent::__construct();
		}

    public function workers() {
			$msg = ' ';
			$props = array('name' => '', 'office' => '', 'phone' => '', 'email' => '', 'address' => '');
			if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'edit' && $_GET['id'] != '' && !empty($_POST)) {
				$pm = new Postm;
				$post_data = $_POST;
				foreach($post_data as $key => $value) {
					if($key == 'post_content') {
						$post_data[$key] = cleansimple($value);
					} else {$post_data[$key] = clean($value);}
				}
				if($_FILES['f_image']['name'] !== '') {
					$target_dir = ABSPATH.'el-contents/uploads/workers/';
					$res = Files::upload_image($_FILES['f_image'], $target_dir);
					if(is_array($res)) {
						$post_data['f_image'] = $res[0];
					} else {
						$msg .= getBlockquotedMsg('red', $res);
					}
				}
				$data = $pm->createParam('posts', $post_data);
			//$done = $pm->updatePost(clean($_GET['id']), $_POST);
				if(Post::updatePost(clean($_GET['id']), $data, $pm)) {
					$msg = getBlockquotedMsg('green', 'Saved successfully.');
				} else {
					$msg = getBlockquotedMsg('red', 'Error: Cannot save the details');
				}
			}


			if($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_GET['id']) && !empty($_POST)) {
				$post_data = $_POST;
				foreach($post_data as $key => $value) {
					if($key == 'post_content') {
						$post_data[$key] = cleansimple($value);
					} else {$post_data[$key] = clean($value);}
				}
				if($_FILES['f_image']['name'] !== '') {
					$target_dir = ABSPATH.'el-contents/uploads/workers/';
					$res = Files::upload_image($_FILES['f_image'], $target_dir);
					if(is_array($res)) {
						$post_data['f_image'] = $res[0];
					} else {
						$msg .= getBlockquotedMsg('red', $res);
					}
				} else {
					$post_data['f_image'] = 'avatar.png';
				}
				//Data is recieved and Cleaned
				$res = $this->cm->add_worker($post_data);
				if($res) {
					$msg .= getBlockquotedMsg('green', 'Worker added successfully.');
				} else {
					$msg .= getBlockquotedMsg('red', 'Worker not added successfully.');
				}
			}
			if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'edit' && $_GET['id'] != '') {
				$worker = $this->cm->getWorker($_GET['id']);
				$props['name'] = $worker['post_title'];
				$props['office'] = $worker['post_content'];
				$props['phone'] = $worker['post_excerpt'];
				$props['email'] = $worker['post_name'];
				$props['address'] = $worker['post_tag'];
			}

			if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'delete' && $_GET['id'] != '') {
				$worker = $this->cm->deleteWorker($_GET['id']);
				if($worker) {
					$msg .= getBlockquotedMsg('green', 'Worker deleted successfully.');
				}
			}
			$worker_rows = $this->cm->getWorkerRows('post_status', array('post_type=' => 'worker'));
			$props['msg'] = $msg;
			$props['worker_rows'] = $worker_rows;
			$this->theme->set_prop($props);
      $this->theme->create('all_workers');
    }

		private function check_priv() {
			if(Session::get_var('user_level') >= 2) {
				return true;
			}
			return false;
		}
		public function admin() {
				$roles = array('Subscriber', 'Author', 'Administrator');
				$role_html = $this->get_role_html($roles);
				$msg = ' ';
				$props = array('disabled' => '', 'name' => '', 'office' => '', 'phone' => '', 'email' => '', 'address' => '');

				if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['edit']) && $_GET['edit'] != '' && !empty($_POST)) {
					if(Session::get_var('ID') == $_GET['edit'] || $this->check_priv()) {
						$res = $this->cm->update_admin(clean($_GET['edit']), $_POST);
						if($res && !is_array($res)) {
							$msg = getBlockquotedMsg('green', 'Saved successfully.');
						} else {
							$e = new Error;
							$e->list_error($res);
						}
					} else {
						$e = new Error;
						$e->list_error(array('You have no priviledge to carry out this action.'));
					}
				}

				if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && !empty($_POST)) {
					if($this->check_priv()) {
						$post_data = $_POST;

						//Data is recieved and Cleaned
						$res = $this->cm->add_admin($post_data);
						if($res && !is_array($res)) {
							$msg = getBlockquotedMsg('green', 'Admin added successfully.');
						} else {
							$e = new Error;
							$e->list_error($res);
						}
					} else {
						$e = new Error;
						$e->list_error(array('You have no priviledge to carry out this action.'));
					}
				}

				if(isset($_GET['edit']) && $_GET['edit'] != '') {
					if(Session::get_var('ID') == $_GET['edit'] || $this->check_priv()) {
						$admin = $this->cm->getAdmin($_GET['edit']);
						$props['name'] = $admin['user_nicename'];
						$props['email'] = $admin['user_email'];
						$props['username'] = $admin['user_login'];
						$props['password'] = $admin['user_pass'];
						$props['disabled'] = 'disabled';

						$role_html = $this->get_role_html($roles, $admin['user_level']);
					} else {
						$e = new Error;
						$e->list_error(array('You have no priviledge to carry out this action.'));
					}
				}

				if(isset($_GET['delete']) && $_GET['delete'] != '') {
					if(Session::get_var('ID') != $_GET['delete'] && $this->check_priv()) {
						$worker = $this->cm->deleteAdmin($_GET['delete']);
						if($worker) {
							$msg .= getBlockquotedMsg('green', 'Admin deleted successfully.');
						}
					} else {
						$e = new Error;
						$e->list_error(array('You have no priviledge to carry out this action.'));
					}
				}
				$worker_rows = $this->cm->getAdminRows('post_status', array());
				$props['msg'] = $msg;
				$props['worker_rows'] = $worker_rows;
				$props['role_html'] = $role_html;
				$this->theme->set_prop($props);
				$this->theme->create('all_admin');

		}

		private function get_role_html($roles, $select = null) {
			$role_html = '';
			foreach ($roles as $key => $value) {
				if($select == $key) { $role_html .= '<option value="'.$key.'" selected>'.$value.'</option>'; }
				else { $role_html .= '<option value="'.$key.'">'.$value.'</option>'; }
			}
			return $role_html;
		}

		public function __call($a, $b) {
			$e = new Error;
			$e->_cerror('', '404');
		}
	}
