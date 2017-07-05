<?php
	//controls the main page
	class Post extends Elyon_core_controller {
		function __construct() {
			parent::__construct();
			//Wanna declare a general post model for General Usage
			//$this->pm = new Postm;
		}

		public function load_page() {
			$js= array('owl/owl.carousel.min', 'draft');
			$this->theme->set('_js', $js);
			$this->theme->create('/index');
		}

		private function getBlockquotedMsg($ccode, $msg) {
			return '<div><blockquote style="background:white;border-left-color:'.$ccode.';"><h4 style="font-weight:1;margin-bottom:0px;">'.$msg.'</h4></blockquote></div>';
		}

		public function edit($pid = null) {
			if($_SERVER['REQUEST_METHOD'] == 'POST') {}
			if(isset($_GET['action'])) {
				$action = $_GET['action'];
				$possible_actions = array('trash', 'savePost');
				$props = array();
				if(in_array($action, $possible_actions)) {
					$msg = '';
					switch ($action) {
						case 'trash':
							if($pid == null) {
								//Do something when $pid === null
								//Perhaps raise an error
							}
							if($this->trashPost($pid)) {
								$link = get_option('home') . '/el-admin/post';
								$msg = $this->getBlockquotedMsg('green', 'Post Trashed. <a href="'.$link.'" class="pull-right">&lsaquo; Back to Posts</a>');
								$props = array('msg' => $msg);
								$this->theme->set_prop($props);
								$this->theme->create('err_disp');
							} else {
								//If Unsuccessful
							}
							break;

						case 'savePost':
							$post_data = $_POST;
							//$post_details_to_check = array('post_status', 'post_title', 'post_parent', 'post_content');
							//Empty value error handling
							$chk_err = $this->_checck_errors_in_post($post_data);
							if(is_array($chk_err)) {
								$err_val = '';
								foreach ($chk_err as $key => $value) {
									$err_val .= $value.'<br/>';
								}
								$msg .= $this->getBlockquotedMsg('red', $err_val);
								$props = array('msg' => $msg);
								$this->theme->set_prop($props);
								$this->processGetEdit($pid);
								exit;
							}

							if(!empty($post_data)) {
								foreach($post_data as $key => $value) {
									if($key == 'post_content') {
										$post_data[$key] = cleansimple($value);
									} else {$post_data[$key] = clean($value);}
								}

								// Managing of the featured Image
								if(isset($post_data['removeImg']) && $post_data['removeImg'] === 'remove') {
									$post_data['f_image'] = '';
								} else {
									if($_FILES['f_image']['name'] !== '') {
										$target_dir = ABSPATH.'el-contents/uploads/f_image/';
										$res = Files::upload_image($_FILES['f_image'], $target_dir);
										if(is_array($res)) {
											$post_data['f_image'] = $res[0];
										} else {
											$msg .= $this->getBlockquotedMsg('red', $res);
										}
									}
								}

								//Check for errors in the required stuffs
								//Data is recieved and Cleaned
								$data = $this->cm->createParam('posts', $post_data);

								if(Post::updatePost($pid, $data, $this->cm)) {
									$msg .= $this->getBlockquotedMsg('green', 'Post Updated');
									$props = array('msg' => $msg);
									$this->theme->set_prop($props);
									$this->processGetEdit($pid);
								} else {}
							} else {
								// No Data was sent
								// Process Error
								echo "Empty Data";
							}
						break;

						default:
							echo'adjakdnad';

							break;
					}
				} else {
					$this->_cerror('', '404');
				}
			}
			if($_SERVER['REQUEST_METHOD'] != 'POST' && !isset($_GET['action'])) {
				$this->processGetEdit($pid);
			} else {}
		}

		public function newpost() {
			if(isset($_GET['action'])) {
				$action = $_GET['action'];
				$possible_actions = array('trash', 'savePost');
				if(in_array($action, $possible_actions)) {
					$msg = '';
					switch ($action) {
						case 'savePost':
							$post_data = $_POST;
							//Empty value error handling
							$chk_err = $this->_checck_errors_in_post($post_data);
							if(is_array($chk_err)) {
								$err_val = '';
								foreach ($chk_err as $key => $value) {
									$err_val .= $value.'<br/>';
								}
								$msg .= $this->getBlockquotedMsg('red', $err_val);
								$props = array('msg' => $msg);
								$this->theme->set_prop($props);
								$this->processGetEdit($pid);
								exit;
							}
							if(!empty($post_data)) {
								foreach($post_data as $key => $value) {
									if($key == 'post_content') {
										$post_data[$key] = cleansimple($value);
									} else {$post_data[$key] = clean($value);}
								}
								if($_FILES['f_image']['name'] !== '') {
									$target_dir = ABSPATH.'el-contents/uploads/f_image/';
									$res = Files::upload_image($_FILES['f_image'], $target_dir);
									if(is_array($res)) {
										$post_data['f_image'] = $res[0];
									} else {
										$msg .= $this->getBlockquotedMsg('red', $res);
									}
								}
								//Data is recieved and Cleaned
								$post_data['post_author'] = Session::get_var('ID');
								$post_data['post_name'] = preg_replace('/[\s]+/', '-', $post_data['post_title']);
								$post_data['post_name'] = strtolower(trim(rtrim($post_data['post_name'], '-'), '-'));
								$data = $this->cm->createParam('posts', $post_data);
								$n = new Postm($data);
								if($n) {
									$js = array('admin/all_post.js');
									$msg .= $this->getBlockquotedMsg('green', 'Post created Successfully!');
									$props = array('msg' => $msg, '_js' => $js);
									$this->theme->set_prop($props);
									$this->load_all_post_page();
								} else {}
							} else {
								//My screen is in record model
								//Can u see that, i wanna write mode, but i wrote model up there.. Coooolllll!!!!
								// No Data was sent
								// Process Error
								echo "Empty Data";
							}
						break;

						default:
							echo'adjakdnad';
							break;
					}
				} else {
					$this->_cerror('', '404');
				}
			} else {
				$this->processNewPost();
			}
		}

		private function processNewPost() {
			$js = array('tinymce/tinymce.min', 'tinymce.init','newpost');
			//$js = array('summernote/summernote', 'summernote.init', 'newpost');
			$title = 'Add New Post &lsaquo; ' . get_option('blogname');

			$time = time();
			$d = date('d', $time);$m = date('m', $time);$y = date('y', $time);$h = date('H', $time);$min = date('i', $time);
			$form_url = get_option('home') . '/el-admin/post/newpost/?action=savePost';

			//Processing Ctaegories and Post status
			$posible_status = array('Draft', 'Publish');
			$stat_html = '';
			foreach ($posible_status as $key => $value) {
				$stat_html .= '<option value="'.$value.'">'.$value.'</option>';
			}

			$catm = new Catm;
			$cat = $catm->get_all_categories();
			$cat_html = '';
			foreach ($cat as $key => $value) {
				$cat_html .= '<option value="'.$key.'">'.$value.'</option>';
			}

			$props = array('cat_html' => $cat_html, 'form_url' => $form_url,
										'home' => get_option('home'),
										'title' => $title, '_js' => $js, 'post_status_html' => $stat_html, 'd' => $d, 'm' => $m, 'y' => $y,
										'h' => $h, 'min' => $min);

			//Setting Page Properties and Variables
			$this->theme->set_prop($props);
			$this->theme->create('/new_post');
		}

		private function processGetEdit($pid = null) {
			if($pid == 'getHome') {
				_x($this->getHome());
			}
			$pid = $pid == null ? null : $pid;
			$postData = $this->cm->getPost($pid);

			if(!$postData) {
				$e = new Error;
				$e->getErrorPage('Invalid Post Identity. Please check thouroughly.');
			}

			$permalink = $this->_makePermalink($postData['post_date'], $postData['post_name'], $postData['post_status'], true);
			$plink = $postData['guid']. '&preview=true';
			$name = '<span class="perm-input" style="display:none;">
					<input name="post_names" style="" class="perma-input" type="text"/>
					<span eyedee="'.$postData['ID'].'" class="btn btn-sm btn-default ok-perm">Save</span>
					<a class="a-to-pointer cancel-perm">cancel</a></span><span class="post-name">'.$postData['post_name'].'</span><br/>';

			$permalink = str_replace('%postname%/', $name, $permalink);

			$js = array('tinymce/tinymce.min', 'tinymce.init','newpost');
			//$js = array('summ/summernote', 'summernote.init', 'newpost');
			$title = 'Edit Post &lsaquo; ' . get_option('blogname');

			$time = time();
			$d = date('d', $time);$m = date('m', $time);$y = date('y', $time);$h = date('H', $time);$min = date('i', $time);
			$form_url = get_option('home') . '/el-admin/post/edit/' . $pid . '?action=savePost';
			$trash_url = get_option('home') . '/el-admin/post/edit/' . $pid . '?action=trash';

			//Processing Ctaegories and Post status
			$posible_status = array('Draft', 'Publish', 'Page');
			$stat_html = '<option value="">Select type</option>';
			foreach ($posible_status as $key => $value) {
				if(strtolower($postData['post_status']) == strtolower($value)) { $stat_html .= '<option value="'.$value.'" selected>'.$value.'</option>'; }
				else { $stat_html .= '<option value="'.$value.'">'.$value.'</option>'; }
			}
			$catm = new Catm;
			$cat = $catm->get_all_categories();
			$cat_html = '<option value="">Select type</option>';
			foreach ($cat as $key => $value) {
				if($postData['post_parent'] == $key) { $cat_html .= '<option value="'.$key.'" selected>'.$value.'</option>'; }
				else { $cat_html .= '<option value="'.$key.'">'.$value.'</option>'; }
			}

			$post_types = array('post'=>'Blog Post', 'page'=>'Page', 'video'=>'Video', 'audio'=>'Audio');
			$post_type_html = '<option value="">Select type</option>';
			foreach ($post_types as $key => $value) {
				if($postData['post_type'] == $key) { $post_type_html .= '<option value="'.$key.'" selected>'.$value.'</option>'; }
				else { $post_type_html .= '<option value="'.$key.'">'.$value.'</option>'; }
			}
			$props = array('post_type_html'=>$post_type_html, 'f_image' => $postData['f_image'], 'cat_html' => $cat_html, 'trash_url' => $trash_url, 'form_url' => $form_url, 'plink' => $plink, 'home' => get_option('home'), 'post_tag' => Post::getPostTag($postData['ID'], $this->cm),
							'ID' => $postData['ID'], 'title' => $title, '_js' => $js, 'permalink' => $permalink,
							'post_title' => clean($postData['post_title']), 'post_content' => reverse_simple_clean($postData['post_content']),'post_parent_num' => $postData['post_parent'], 'post_parent' => $cat[$postData['post_parent']],
							'post_status_val' => $postData['post_status'], 'post_status_html' => $stat_html, 'd' => $d, 'm' => $m, 'y' => $y, 'h' => $h, 'min' => $min);
							$props['vlink'] = $this->_makePermalink($postData['post_date'], $postData['post_name'], $postData['post_status'], true);
							$props['vlink'] = str_replace('%postname%/', $postData['post_name'], $props['vlink']);
			//Setting Page Properties and Variables
			$this->theme->set_prop($props);
			$this->theme->create('/edit_post');
		}

		private function get_all_categories() {}

		public function getDrafts($len = null) {
			$this->getModel('post', 'includes/mods/');
			$d = new PostM;
			$len = $len == null ? 5 : $len;
			$drfs = $d->getDrafts($len);
			return $drfs;
		}

		//This function trashes a post based on the ID
		private function trashPost($pid = null) {
			if($pid != null) {
				//Checking if Post Exist
				Post::checkPostId($pid, $this->cm);
				$trashed = $this->cm->trashPost($pid);
				if($trashed) {
					return true;
				}
			}
			return false;
		}

		//This function publishes a post based on the ID
		private function publishPost($pid = null) {
			if($pid != null) {
				// Checking if Post Exist
				Post::checkPostId($pid, $this->cm);
				$published = $this->cm->publishPost($pid);
				if($published) {
					return true;
				}
			}
			return false;
		}

		//This function unpublishes a post based on the ID
		private function unpublishPost($pid = null) {
			if($pid != null) {
				// Checking if Post Exist
				Post::checkPostId($pid, $this->cm);
				$unpublished = $this->cm->unpublishPost($pid);
				if($unpublished) {
					return true;
				}
			}
			return false;
		}

		//This function creates a page from a post based on the ID
		private function convertPostToPage($pid = null) {
			if($pid != null) {
				// Checking if Post Exist
				Post::checkPostId($pid, $this->cm);
				$action = $this->cm->convertPostToPage($pid);
				if($action) {
					return true;
				}
			}
			return false;
		}

		//This function creates a post from a page based on the ID
		private function convertPageToPost($pid = null) {
			if($pid != null) {
				// Checking if Post Exist
				Post::checkPostId($pid, $this->cm);
				$action = $this->cm->convertPageToPost($pid);
				if($action) {
					return true;
				}
			}
			return false;
		}


		private function _makePermalink($date, $name, $post_type, $excludeName = false) {
			if($post_type != 'page') {
				$y = date('Y', strtotime($date));
				$m = date('m', strtotime($date));
				$d = date('d', strtotime($date));
				$format = get_option('permalink_structure');
				$format = str_replace('%monthnum%', $m, $format);
				$format = str_replace('%year%', $y, $format);
				$format = str_replace('%day%', $d, $format);
				$format = $excludeName ? $format : str_replace('%postname%/', $name, $format);
				return get_option('home') . $format;
			} else {
					//$format = $excludeName ? $format : str_replace('%postname%/', $name, $format);
					return get_option('home') . '/%postname%/';
			}
		}

		private function _getPermalink($id, $excludeName = false) {
			$postData = $this->cm->getPost($id);
			$date = $postData['post_date'];
			$name = $postData['post_name'];
			$y = date('Y', strtotime($date));
			$m = date('m', strtotime($date));
			$d = date('d', strtotime($date));
			$format = get_option('permalink_structure');
			$format = str_replace('%monthnum%', $m, $format);
			$format = str_replace('%year%', $y, $format);
			$format = str_replace('%day%', $d, $format);
			$format = $excludeName ? $format : str_replace('%postname%/', $name, $format);
			return get_option('home') . $format;
		}

		public function updatePerm($id = null) {
			$resp = $this->cm->updatePerm($id);
			if($resp == null) {
				ElAjax::respond('undone');
			} else {
				$resp = $resp.'||done';
				$plink = $this->_getPermalink($id, false);
				ElAjax::respond($resp);
			}
		}

		public static function updatePost($id = null, $data = null, $cm) {
			Post::checkPostId($id, $cm);
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				//$data = array(':post_title' => $_POST['post_title'], ':post_content' => $_POST['post_content']);
				if(!$cm->updatePost($id, $data)) {
					//ElAjax::respond('undone');
					return false;
				} else {
					//ElAjax::respond('done');
					return true;
				}
			} else if($_SERVER['REQUEST_METHOD'] == 'GET') {
				if($cm->updatePost($id, $data)) {
					return true;
				}
			}
			return false;
		}

		public static function makeNewPost($data = null, $cm) {
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				//$data = array(':post_title' => $_POST['post_title'], ':post_content' => $_POST['post_content']);
				if(!$cm->updatePost($id, $data)) {
					//ElAjax::respond('undone');
					return false;
				} else {
					//ElAjax::respond('done');
					return true;
				}
			} else if($_SERVER['REQUEST_METHOD'] == 'GET') {
				if($cm->updatePost($id, $data)) {
					return true;
				}
			}
			return false;
		}

		public static function getPostTag($id, $cm) {
			$tags = $cm->getPostTagHtml($id);
			return $tags;
		}

		public static function checkPostId($pid, $cm) {
			$id = clean($pid);
			//Check Post ID
			$postData = $cm->getPost($pid);
			if(!$postData) {
				$e = new Error;
				$e->getErrorPage('Invalid Post Identity. Please check thouroughly.');
			}
		}

		public function defView() {
			//_x($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			$this->handleBatchAction();
			$this->load_all_post_page();
		}

		private function load_all_post_page() {
			$possible_filter = array('draft', 'trashed', 'publish', 'page');
			$defFilter = array('post_type=' => 'audio', '   post_type=' => 'video', '  post_type=' => 'page', ' post_type=' => 'post');
			$all_posts = $this->cm->get_all_post_unpaged($defFilter, null, 'OR');
			$filter = array();
			if(isset($_GET['filter']) && in_array($_GET['filter'], $possible_filter) && $_GET['filter'] != 'page')  {
				$filter['post_status='] = $_GET['filter'];
				$filter['post_type='] = 'post';
			} elseif(isset($_GET['filter']) && $_GET['filter'] == 'page') {
				$filter['post_type='] = 'page';
			}

			$mmm = 'Viewing all Posts.';
			if(isset($_GET['filter']) && in_array($_GET['filter'], $possible_filter) && $_GET['filter'] == 'page') {
				$mmm = 'Viewing all pages.';
			} elseif (isset($_GET['filter']) && in_array($_GET['filter'], $possible_filter) && $_GET['filter'] == 'draft') {
				$mmm = 'Viewing all drafted posts.';
			} elseif(isset($_GET['filter']) && in_array($_GET['filter'], $possible_filter) && $_GET['filter'] == 'trashed') {
				$mmm = 'Viewing all trashed posts.';
			} elseif(isset($_GET['filter']) && in_array($_GET['filter'], $possible_filter) && $_GET['filter'] == 'publish') {
				$mmm = 'Viewing all published posts.';
			}


			$all_post_filtered = $this->cm->get_all_post_unpaged($filter);
			$num_post_filtered = is_array($all_post_filtered) ? count($all_post_filtered) : 0;

			$published_posts = $this->cm->get_all_post_unpaged(array('post_status=' => $possible_filter[2], 'post_type=' => 'post'));

			$trashed_posts = $this->cm->get_all_post_unpaged(array('post_status=' => $possible_filter[1], 'post_type=' => 'post'));
			$drafted_posts = $this->cm->get_all_post_unpaged(array('post_status=' => $possible_filter[0], 'post_type=' => 'post'));
			$paged_posts = $this->cm->get_all_post_unpaged(array('post_type=' => $possible_filter[3]));
			$num_publish = is_array($published_posts) ? count($published_posts) : '0';
			$num_draft = is_array($drafted_posts) ? count($drafted_posts) : '0';
			$num_trash = is_array($trashed_posts) ? count($trashed_posts) : '0';
			$num_page = is_array($paged_posts) ? count($paged_posts) : '0';

			$curr_page = (isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] != null) ? $_GET['page'] : 1;
			$num_pages = ceil($num_post_filtered / get_option('admin_post_per_page'));
			if($curr_page > $num_pages && $num_post_filtered != 0) {
				$this->_cerror('', '404');
			}

			//Getting All Post depending on the $filter Array
			$post_row = $this->cm->getPostRows('post_status', $filter, $curr_page);

			$num_post = is_array($all_posts) ? count($all_posts) : 0;
			$curr_page = (isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] != null) ? $_GET['page'] : 1;

			$pagers = ($num_post_filtered != 0) ? $this->cm->get_pagers($num_post_filtered, get_option('admin_post_per_page'), $curr_page) : ' ';

			$_js = array('admin/allpost');
			$this->theme->set('title', 'Posts &lsaquo; '.get_option('blogname'));
			$form_url = get_option('home') . '/el-admin/post';
			$props = array('num_page' => $num_page, 'num_publish' => $num_publish, 'num_draft' => $num_draft, 'num_trash' => $num_trash, 'pagers' => $pagers, 'form_url' => $form_url, 'post_rows' => $post_row, 'num_post' => $num_post, '_js' => $_js);
			$props['mmm'] = $mmm;
			$this->theme->set_prop($props);
			$this->_getView('view_all_post');
		}



		private function handleBatchAction() {
			if(isset($_POST['batch_action']) && isset($_POST['post_id'])) {
				$nposts = (count($_POST['post_id']) > 1) ? count($_POST['post_id']). ' posts' : count($_POST['post_id']) . ' post';
				switch($_POST['batch_action']) {
					case 'delete':
						//$nposts = (count($_POST['post_id']) > 1) ? count($_POST['post_id']). ' posts' : count($_POST['post_id']) . ' post';
						foreach($_POST['post_id'] as $key => $val) {
							if(!$this->trashPost($val)) {
								$msg = 'Cannot trash some post, please try again.';
								$this->theme->set('msg', $this->getBlockquotedMsg('red', $msg));
								//break;
							} else {
								$msg = $nposts . ' has been moved to trash.';
								$this->theme->set('msg', $this->getBlockquotedMsg('green', $msg));
							}
						}
					break;

					case 'publish':
						foreach($_POST['post_id'] as $key => $val) {
							if(!$this->publishPost($val)) {
								$msg = 'Cannot publish some post, please try again.';
								$this->theme->set('msg', $this->getBlockquotedMsg('red', $msg));
								//break;
							} else {
								$msg = $nposts . ' has been published.';
								$this->theme->set('msg', $this->getBlockquotedMsg('green', $msg));
							}
						}
					break;

					case 'draft':
						foreach($_POST['post_id'] as $key => $val) {
							if(!$this->unpublishPost($val)) {
								$msg = 'Cannot publish some post, please try again.';
								$this->theme->set('msg', $this->getBlockquotedMsg('red', $msg));
								//break;
							} else {
								$msg = $nposts . ' has been published.';
								$this->theme->set('msg', $this->getBlockquotedMsg('green', $msg));
							}
						}
					break;

					case 'page':
						foreach($_POST['post_id'] as $key => $val) {
							if(!$this->convertPostToPage($val)) {
								$msg = 'Cannot convert some post to page, please try again.';
								$this->theme->set('msg', $this->getBlockquotedMsg('red', $msg));
								//break;
							} else {
								$msg = $nposts . ' has been Modified.';
								$this->theme->set('msg', $this->getBlockquotedMsg('green', $msg));
							}
						}
					break;

					case 'pageToPost':
						foreach($_POST['post_id'] as $key => $val) {
							if(!$this->convertPageToPost($val)) {
								$msg = 'Cannot convert some post to page, please try again.';
								$this->theme->set('msg', $this->getBlockquotedMsg('red', $msg));
								//break;
							} else {
								$msg = $nposts . ' has been Modified.';
								$this->theme->set('msg', $this->getBlockquotedMsg('green', $msg));
							}
						}
					break;

					default:
					break;
				}
			}
		}

		private function _getView($view) {
			$this->theme->create($view);
		}


		private function _checck_errors_in_post($data) {
			$err_arr = array();
			$curr_data = $data['post_title'];
			if($curr_data === '') {
				$err_arr[] = 'Post title cannot be empty.';
			} if ($data['post_content'] === '') {
				$err_arr[] = 'Post content cannot be empty.';
			} if ($data['post_status'] === '') {
				$err_arr[] = 'Post status cannot be empty.';
			} if ($data['post_parent'] === '') {
				$err_arr[] = 'Post category cannot be empty.';
			}

			if(!empty($err_arr)) { return $err_arr; }
			else { return true; }
		}


		/*
			handles birthdays adding and editing
			this function will be upgraded by God's grace in the future
			for better implementation.
		*/

		public function birthdays() {
			$msg = ' ';
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$this->cm->add_birthdays($_POST['post_tag']);
				$msg = $this->getBlockquotedMsg('green', 'Birthdays saved.');
			}
			$birthdays = get_option('birthdays');
			$props['birthdays'] = $birthdays;
			$props['msg'] = $msg;
			$this->theme->set_prop($props);
			$this->theme->create('/birthdays');
		}

		public function frontmsg() {
			$js = array('tinymce/tinymce.min', 'tinymce.init');
			$props['_js'] = $js;
			$msg = ' ';
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$this->cm->saveFrontMsg($_POST['post_tag']);
				$msg = $this->getBlockquotedMsg('green', 'Message saved.');
			}
			$fmsg = get_option('front_message');
			$props['fmsg'] = $fmsg;
			$props['msg'] = $msg;
			$this->theme->set_prop($props);
			$this->theme->create('/fmsg');
		}

		public function comment($id) {
			if(!$this->cm->getPost($id)) {
				$this->_cerror('', '404');
			}

			$this->load_all_comment_page($id);
		}

		private function load_all_comment_page($id) {
			$cmm = new Commentm;
			$msg = ' ';
			if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['delete'])) {
				if($cmm->delete_comment($_GET['delete']))
					$msg = $this->getBlockquotedMsg('green', 'Comment deleted successfully.');
			}

			if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['approve'])) {
				if($cmm->approve_comment($_GET['approve']))
					$msg = $this->getBlockquotedMsg('green', 'Comment approved.');
			}

			if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['unapprove'])) {
				if($cmm->unapprove_comment($_GET['unapprove']))
					$msg = $this->getBlockquotedMsg('green', 'Comment disapproved.');
			}

		  $filter = array('comment_post_ID=' => $id);
		  $all_post_filtered = $cmm->get_all_comment_unpaged($filter);
		  $num_comment_filtered = is_array($all_post_filtered) ? count($all_post_filtered) : 0;

		  $curr_page = (isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] != null) ? $_GET['page'] : 1;
		  $num_pages = ceil($num_comment_filtered / get_option('admin_post_per_page'));
		  if($curr_page > $num_pages && $num_comment_filtered != 0) {
		    $this->_cerror('', '404');
		  }

		  $post_row = $cmm->getCommentsRows('post_status', $filter, $curr_page);

			$num_comment = $cmm->count_comments($id);
		  $curr_page = (isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] != null) ? $_GET['page'] : 1;

		  $pagers = ($num_comment_filtered != 0) ? $this->cm->get_pagers($num_comment_filtered, get_option('admin_post_per_page'), $curr_page) : ' ';

		  $_js = array('admin/allpost');
		  $this->theme->set('title', 'Comments &lsaquo; '.get_option('blogname'));
		  $form_url = get_option('home') . '/el-admin/post/comment/';
		  $props = array('msg' => $msg, 'num_comment' => $num_comment, 'pagers' => $pagers, 'form_url' => $form_url, 'post_rows' => $post_row, '_js' => $_js);
		  $this->theme->set_prop($props);
		  $this->_getView('view_all_comment');
		}


		public function category() {
			$msg = ' ';
			$cm = new Catm;

			if(isset($_GET['edit']) && $_GET['edit'] != '0' && $_GET['edit'] != '') {
				$cat = $cm->get_category(clean($_GET['edit']));
				$props['title'] = $cat['cat_name'];
			}

			if(isset($_GET['edit']) && $_GET['edit'] != 0 && $_GET['edit'] != '' && $_SERVER['REQUEST_METHOD'] == 'POST') {
				$cat = $cm->updateCat(clean($_GET['edit']), clean($_POST['title']));
				if($cat) {
					$msg .= $this->getBlockquotedMsg('green', 'Category updated successfully.');
				} else {
					$msg .= $this->getBlockquotedMsg('red', 'Category update was not successfull.');
				}
			}

			if(isset($_GET['delete']) && $_GET['delete'] != 0 && $_GET['delete'] != '') {
				$cat = $cm->delete_cat(clean($_GET['delete']));
				if($cat) {
					$msg .= $this->getBlockquotedMsg('green', 'Category deleted successfully.');
				} else {
					$msg .= $this->getBlockquotedMsg('red', 'Category was not deleted successfully.');
				}
			}

			if($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_GET['edit']) && $_SERVER['REQUEST_METHOD'] != 'GET') {
				$cat = $cm->addCategory(clean($_POST['title']));
				if($cat) {
					$msg .= $this->getBlockquotedMsg('green', 'Category created successfully.');
				} else {
					$msg .= $this->getBlockquotedMsg('red', 'Category cannot be created.');
				}
			}

			$cat_rows = $cm->getCategoryRows('post_status', array('post_type=' => 'worker'));

			$props['msg'] = $msg;
			$props['cat_rows'] = $cat_rows;
			$this->theme->set_prop($props);
      $this->theme->create('category');
		}
	}
?>
