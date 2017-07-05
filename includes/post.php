<?php
	//controls the main page
	class Post extends Elyon_core_controller {
		private $_basePath = 'themes/';
		function __construct() {
			parent::__construct();
			//Wanna declare a general post model for General Usage
			//$this->pm = new Postm;
		}

		public function load_page() {
			$js= array('owl/owl.carousel.min', 'draft');
			$this->theme->set('_js', $js);
			$this->theme->create('/posts');
		}



		/* Displays post when the postData is loaded */
		public function viewpost($postData) {
			//Session::start();
			$curr_uri = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$theme_path = ABSPATH.'themes/'.get_option('site-theme');
			$props = array();
			$props['theme_path'] = $theme_path;
			$props['title'] = $postData['post_title'] .' | ' . get_option('blogname');
			$permalink = $this->_makePermalink($postData['post_date'], $postData['post_name'], 'post', false);
			$props['form_url'] = $permalink;
			$props['permalink'] = $permalink;
			$cm = new Postm;
			$postTags = $this->cm->getPostTagHtml($postData['ID']);
			$props['post_tags'] = ($postTags != '') ? $postTags : 'No tags available.';

			$recents = $this->cm->get_recent_post_links(array('post_type=' => 'post', 'post_status=' => 'publish', 'ID!=' => $postData['ID']), '5');

			$props['recents'] = $recents;

			$postData['post_date'] = date("F d, Y", strtotime($postData['post_date']));

			$um = new Userm;
			$author_link = $um->get_author_details($postData['post_author']);
			$props['author_link'] = $author_link['link'];
			$props['author_name'] = $author_link['name'];
			$aut = new Author;
			$other_author_posts = $aut->get_other_author_post_links($postData['ID'], $postData['post_author'], 3);
			$props['other_author_posts'] = $other_author_posts;
			$cmm = new Commentm;

			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$res = $cmm->addComment($postData['ID'], $_POST);
				if($res && !is_array($res)) {

				} else {
					$e = new Error;
					$e->list_error($res);
				}
			}
			$comments = $cmm->count_comments($postData['ID']);
			// To page the comments

			$curr_page = (isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] != null) ? $_GET['page'] : 1;
			$num_pages = ceil($comments / get_option('comment_per_page'));
			if($curr_page > $num_pages && $comments != 0) {
				$this->_cerror('', '404');
			}

			$pagers = ($comments != 0 && $num_pages != 1) ? $this->cm->get_pagers($comments, get_option('comment_per_page'), $curr_page) : ' ';
			$props['pagers'] = $pagers;
			//End to page comments
			$comments = ($comments == 1 || $comments == 0) ? $comments .' Comment' : $comments . ' Comments';
			//Geting comment rows
			$comment_rows = $cmm->getCommentRows('post_status', array('comment_post_ID=' => $postData['ID']), $curr_page);
			$props['comment_rows'] = $comment_rows;
			$props['cnts'] = (!$comments) ? 0 : $comments;

			$catm = new Catm;
			$categories = $catm->get_all_categories_link();
			$props['categories'] = $categories;

			$props['comment_name'] = (Session::get_var('comment_name') != '') ? 'value="'.Session::get_var('comment_name').'"' : 'value=""';
			$props['comment_email'] = (Session::get_var('comment_email') != '') ? 'value="'.Session::get_var('comment_email').'"' : 'value=""';

			//Collating OG Data
			$ogData['og_description'] = substr(strip_tags(reverse_simple_clean($postData['post_content'])), 0, 199);
			$ogData['og_description'] = str_replace('"', '\'', $ogData['og_description']);
			$ogData['og_url'] = get_option('home').$_SERVER['REQUEST_URI'];

			$ogData['og_title'] = $props['title'];
			$ogData['og_date'] = date("Y-m-dTH:i:s+00:00", strtotime($postData['post_date']));
			$ogData['category'] = $catm->get_category($postData['post_parent'], 'cat_name')['cat_name'];
			$ogData['og_image'] = get_option('home').'/el-contents/uploads/f_image/'.$postData['f_image'];
			//Getting Seo Stuffs
			$props['seo_stuffs'] = $this->cm->create_seo_stuffs('blog', $ogData);

			$props['post'] = $postData;
			if($postData['f_image'] != '') {
				$props['f_image'] = '<img src="'.get_option('home').'/el-contents/uploads/f_image/'.$postData['f_image'].'" class="margin-bottom-15 img-responsive">';
			} else {
				$props['f_image'] = '';
			}


			$props['bread_crumb'] = '<a href="'. get_option('home') .'"> Home</a> / <a href="'. get_option('home') .'/blog">Blog</a> / '.$postData['post_title'];
			//Getting Audio and video resources
			$props['audios'] = Homem::get_recent_audios(null, 7);
			$props['videos'] = Homem::get_recent_videos(null, 7);
			//Theme initialization
			$this->theme->set_prop($props);
			$this->theme->create('/viewpost');
		}

		/* Displays post when the postData is loaded */
		public function viewresource($postData) {
			//Session::start();
			$curr_uri = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$theme_path = ABSPATH.'themes/'.get_option('site-theme');
			$props = array();
			$props['theme_path'] = $theme_path;
			$props['title'] = $postData['post_title'] .' | ' . get_option('blogname');
			$permalink = $this->_makePermalink($postData['post_date'], $postData['post_name'], 'post', false);
			$props['form_url'] = $permalink;
			$props['permalink'] = $permalink;
			$cm = new Postm;
			$postTags = $this->cm->getPostTagHtml($postData['ID']);
			$props['post_tags'] = ($postTags != '') ? $postTags : 'No tags available.';

			$recents = $this->cm->get_recent_post_links(array('post_type=' => 'post', 'post_status=' => 'publish', 'ID!=' => $postData['ID']), '5');

			$props['recents'] = $recents;

			$postData['post_date'] = date("F d, Y", strtotime($postData['post_date']));

			$um = new Userm;
			$author_link = $um->get_author_details($postData['post_author']);
			$props['author_link'] = $author_link['link'];
			$props['author_name'] = $author_link['name'];
			$aut = new Author;
			$other_author_posts = $aut->get_other_author_post_links($postData['ID'], $postData['post_author'], 3);
			$props['other_author_posts'] = $other_author_posts;
			$cmm = new Commentm;

			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$res = $cmm->addComment($postData['ID'], $_POST);
				if($res && !is_array($res)) {

				} else {
					$e = new Error;
					$e->list_error($res);
				}
			}
			$comments = $cmm->count_comments($postData['ID']);
			// To page the comments

			$curr_page = (isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] != null) ? $_GET['page'] : 1;
			$num_pages = ceil($comments / get_option('comment_per_page'));
			if($curr_page > $num_pages && $comments != 0) {
				$this->_cerror('', '404');
			}

			$pagers = ($comments != 0 && $num_pages != 1) ? $this->cm->get_pagers($comments, get_option('comment_per_page'), $curr_page) : ' ';
			$props['pagers'] = $pagers;
			//End to page comments
			$comments = ($comments == 1 || $comments == 0) ? $comments .' Comment' : $comments . ' Comments';
			//Geting comment rows
			$comment_rows = $cmm->getCommentRows('post_status', array('comment_post_ID=' => $postData['ID']), $curr_page);
			$props['comment_rows'] = $comment_rows;
			$props['cnts'] = (!$comments) ? 0 : $comments;

			$catm = new Catm;
			$categories = $catm->get_all_categories_link();
			$props['categories'] = $categories;

			$props['comment_name'] = (Session::get_var('comment_name') != '') ? 'value="'.Session::get_var('comment_name').'"' : 'value=""';
			$props['comment_email'] = (Session::get_var('comment_email') != '') ? 'value="'.Session::get_var('comment_email').'"' : 'value=""';

			//Getting OG Data
			$props['og_description'] = substr(strip_tags(reverse_simple_clean($postData['post_content'])), 0, 199);
			$props['og_url'] = get_option('home').$_SERVER['REQUEST_URI'];
			$props['og_title'] = $props['title'];

			$js = array('owl/owl.carousel.min', 'draft');
			$props['_js'] = $js;
			$props['post'] = $postData;
			if($postData['f_image'] != '') {
				$props['f_image'] = '<img src="'.get_option('home').'/el-contents/uploads/f_image/'.$postData['f_image'].'" class="margin-bottom-15 img-responsive">';
			} else {
				$props['f_image'] = get_option('home').'/favi.png';
			}
			$props['og_image'] = get_option('home').'/el-contents/uploads/f_image/'.$props['f_image'];
			//Theme initialization
			$this->theme->set_prop($props);
			$this->theme->create('/viewpost');
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
				$format = $excludeName ? $format : str_replace('%postname%/', strtolower($name), $format);
				return strtolower(get_option('home') . $format);
			} else {
					//$format = $excludeName ? $format : str_replace('%postname%/', $name, $format);
					_x(get_option('home') . '/%postname%/');
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




		public static function checkPostName($post_name, $cm) {
			$id = clean($post_name);
			//Check Post ID
			$postData = $cm->getPost($id, null, 'post_name');
			if(!$postData) {
				return false;
			}
			return $postData;
		}

		public function defView() {
			//_x($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			//$this->handleBatchAction();
			if(post_request() && isset($_POST['search_post']) && $_POST['search_post'] !== '') {
				$this->search_post($_POST['search_post']);
				exit;
			}
			$cm = new Postm;
			$this->load_all_post_page(array('post_type=' => 'post', 'post_status=' => 'publish'), $cm);
		}

		private function load_all_post_page($filter = null, $cm = null, $text=null, $key=null) {
			$cm = isset($this->cm) ? $this->cm : $cm;
			$all_post_filtered = $cm->get_all_post_unpaged($filter);
			$num_post_filtered = is_array($all_post_filtered) ? count($all_post_filtered) : 0;

			$curr_page = (isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] != null) ? $_GET['page'] : 1;
			$num_pages = ceil($num_post_filtered / get_option('post_per_page'));
			if($curr_page > $num_pages && $num_post_filtered != 0) {
				$this->_cerror('', '404');
			}

			$post_row = $cm->getPostRows('post_status', $filter, $curr_page);

			$pagers = ($num_post_filtered != 0 && $num_pages != 1) ? $cm->get_pagers($num_post_filtered, get_option('post_per_page'), $curr_page) : ' ';
			$recents = $cm->get_recent_post_links(array('post_type='=> 'post','post_status=' => 'publish'), '5');
			$catm = new Catm;
			$categories = $catm->get_all_categories_link();
			$tagm = new Tagm;
			$tags = $tagm->getRandPostTagHtml(10);

			$this->theme->set('title', get_option('blogdescription').' | '.get_option('blogname'));
			$_js = array('admin/allpost');
			$props = array('post_tags' => $tags, 'recents' => $recents, 'categories' => $categories, 'pagers' => $pagers, 'post_row' => $post_row, '_js' => $_js);
			$props['bread_crumb'] = '<a href="'. get_option('home') .'"> Home</a> / Blog ';
			switch ($text) {
				case 'search':
					$num = ($num_post_filtered === 1) ? $num_post_filtered .' result' : $num_post_filtered . ' results';
					$props['headText'] = 'Showing '.$num.' for "'.$key.'"';
					break;
				case 'tag':
					$props['headText'] = 'Viewing posts with tag "'.$key.'"';
					break;
				case 'category':
					$props['headText'] = 'Viewing posts in '.$key.'';
					break;
				case 'author':
					$props['headText'] = 'Viewing posts by '.$key.'';
					break;
				default:
					$props['headText'] = 'You are viewing all posts.';
					break;
			}

			//Collating OG Data
			$ogData['og_description'] = get_option('blogdescription');
			$ogData['og_url'] = get_option('home');

			$ogData['og_title'] = get_option('blogname');
			//$ogData['og_date'] = date("Y-m-dTH:i:s+00:00", strtotime($postData['post_date']));
			//$ogData['category'] = $catm->get_category($postData['post_parent'], 'cat_name')['cat_name'];
			//$ogData['og_image'] = get_option('home').'/el-contents/uploads/f_image/'.$postData['f_image'];
			//Getting Seo Stuffs
			$props['seo_stuffs'] = $cm->create_seo_stuffs('website', $ogData);

			//Getting Audio and video resources
			$props['audios'] = Homem::get_recent_audios(null, 7);
			$props['videos'] = Homem::get_recent_videos(null, 7);
			//Setting Theme Properties
			$this->theme->set_prop($props);
			$this->_getView('posts');
		}

		//Load posts based on searches
		public function search_post($data) {
			$query = clean($data);
			$filter = array('post_title LIKE "%'.$query.'%" OR post_tag LIKE "%'.$query.'%" OR post_content LIKE "%'.$query.'%" AND post_type=' => 'post', 'post_status=' => 'publish');
			$this->load_all_post_page($filter, null, 'search', $data);
		}

		// Loads posts by categories
		public function category($category) {
			$pm = new Postm;
			$catm = new Catm;
			$cats = $catm->get_all_categories('cat_name');
			$cat = array();
			foreach ($cats as $key => $value) {
				$cat[] = str_replace(' ', '-', strtolower($value['cat_name']));
			}
			if(!in_array($category, $cat))
				$this->_cerror('', '404');

			$cat_name = str_replace('-', ' ', ucfirst($category));
			$cat_id = $catm->get_category_with_name(clean($category), 'id');
			$this->load_all_post_page(array('post_type=' => 'post', 'post_parent=' => $cat_id, 'post_status=' => 'publish'), $pm, 'category', $cat_name);
		}

		public function tag($tag) {
			$pm = new Postm;
			$tm = new Tagm;
			$tagg = $tm->getTag(array('post_tag LIKE ' => '%'.clean($tag).'%'), 'ID');
			if(!$tagg)
				$this->_cerror('', '404');

			$this->load_all_post_page(array('post_type=' => 'post', 'post_tag LIKE ' => '%'.clean($tag).'%', 'post_status=' => 'publish'), $pm, 'tag', $tag);
		}

		public function author($author) {
			$um = new Userm;
			$user = $um->getUser(array('user_login=' => clean($author)), 'ID');
			if(!$user)
				$this->_cerror('', '404');

			$this->load_all_post_page(array('post_type=' => 'post', 'post_author=' => $user['ID'], 'post_status=' => 'publish'), null, 'author', $user['user_nicename']);
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


	}
?>
