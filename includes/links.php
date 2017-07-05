<?php
	//controls the main page
	class Links extends Elyon_core_controller {
		function __construct() {
			parent::__construct();
		}

    // /gallery
    public function meme() {
      $file_path = ABSPATH . 'el-contents/uploads/gallery/';
      $pm = new Postm;
			$extentions = array('jpg', 'jpeg', 'png', 'gif');
			$pics = array();
			foreach ($extentions as $key => $value) {
				$p = glob($file_path.'*.'.$value);
				foreach($p as $k => $v) {
					$pics[] = $v;
				}
			}
			usort($pics, create_function('$a, $b', 'return filemtime($b) - filemtime($a);'));
			$chunk = array();
			$per_page = 12;
			$total = count($pics);
			$num_pages = ceil($total / $per_page);
			$curr_page = (isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] != null) ? $_GET['page'] : 1;
			$pagers = ($total != 0 && $num_pages != 1) ? $pm->get_pagers($total, $per_page, $curr_page) : ' ';
			$start = ($per_page * $curr_page) - $per_page;
				if($per_page < $total) {
					for($i=0;$i<($total-$start);$i++) {
						$chunk[] = $pics[$start];
						$start++;
					}
				} else {
					$chunk = $pics;
				}
			if($curr_page > $num_pages && $total != 0) {
				$this->_cerror('', '404');
			}



			$pics_row = $this->cm->getPicRows($chunk);
			$props['pagers'] = $pagers;
			$props['pics_row'] = $pics_row;
      $props['title'] = 'Gallery | ' .get_option('blogname');
$props['bread_crumb'] = '<a href="'.get_option('home').'">Home</a> / Shareable Memes';
      $this->theme->set_prop($props);
      $this->theme->create('/gallery');
    }
    public function contact() {
			$msg = ' ';
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$res = $this->cm->addData('contact', $_POST);
				if(!is_array($res)) {
					$msg .= $res;
				}
				else {
					$e = new Error;
					$e->list_error($res);
				}
			}
			$props['msg'] = $msg;
      $props['title'] = 'Contact Us | ' .get_option('blogname');
			$props['bread_crumb'] = '<a href="'.get_option('home').'">Home</a> / Contact Us';
			//Collating OG Data
			$pm = new Postm;
			$ogData['og_description'] = 'Contact';
			$ogData['og_url'] = get_option('home');
			$ogData['og_title'] = get_option('blogname');
			//Getting Seo Stuffs
			$props['seo_stuffs'] = $pm->create_seo_stuffs('website', $ogData);
      $this->theme->set_prop($props);
      $this->theme->create('/contact');
    }

    public function about() {
			$pm = new Postm;
      $props['title'] = 'About Me | ' .get_option('blogname');
			$about = $this->cm->get_about_data();
			$props['about'] = $about;
			$props['bread_crumb'] = '<a href="'.get_option('home').'">Home</a> / About Me';
			//Collating OG Data
			$ogData['og_description'] = 'About';
			$ogData['og_url'] = get_option('home');
			$ogData['og_title'] = get_option('blogname');
			//Getting Seo Stuffs
			$props['seo_stuffs'] = $pm->create_seo_stuffs('website', $ogData);
      $this->theme->set_prop($props);
      $this->theme->create('/about');
    }
    public function donate() {}
    public function counsel() {
			$msg = ' ';
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$res = $this->cm->addData('counsel', $_POST);
				if(!is_array($res)) {
					$msg .= $res;
				}
				else {
					$e = new Error;
					$e->list_error($res);
				}
			}
			$props['msg'] = $msg;
      $props['title'] = 'Counselling | ' .get_option('blogname');
$props['bread_crumb'] = '<a href="'.get_option('home').'">Home</a> / Counsel';
      $this->theme->set_prop($props);
      $this->theme->create('/counsel');
    }
    public function workers() {
			$props['workers'] = $this->cm->get_workers();
      $props['title'] = 'Workers | ' .get_option('blogname');
$props['bread_crumb'] = '<a href="'.get_option('home').'">Home</a> / Workers';
      $this->theme->set_prop($props);
      $this->theme->create('/workers');
    }

		public function register() {
			$user = User::getInstance();
			$user->register();
		}

		public function login() {
			$user = User::getInstance();
			$user->login();
		}

		public function category($cat) {
			$post = new Post;
			$post->category($cat);
		}

		public function tag($tag) {
			$post = new Post;
			$post->tag($tag);
		}

		public function search($tag) {
			$post = new Post;
			$post->tag($tag);
		}

		function __call($a, $b) {
			//$this->_cerror('', '404');
		}

  }
