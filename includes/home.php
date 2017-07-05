<?php
	//controls the main page
	class Home extends Elyon_core_controller {
		function __construct() {
			parent::__construct();
		}

		public function load_page() {
			$blog = new Post;
			$blog->defView();

			/*$props = array();
			$posts = Homem::getRecentPost(null, 6);
			$cm = new Homem;
			$slides = $cm->getSlides();
			$props['slides'] = $slides;
			$props['latest_post'] = $cm->get_the_most_recent_post();
			$props['latest_audios'] = Homem::get_recent_audios(null, 5);
			$props['latest_videos'] = Homem::get_recent_videos(null, 3);
			$props['other_latest_posts'] = $posts;
			$props['title'] = get_option('blogdescription'). ' | '. get_option('blogname');
			$this->theme->set_prop($props);
			$this->theme->create('/index');*/

		}

		public function addDraft() {
			$this->getModel('post', 'includes/mods/');
			Dashboardm::addDraft();
		}

		public function register() {
			$user = new User;
			$user->register;
		}
	}
?>
