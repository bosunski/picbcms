<?php
	//controls the main page
	class Dashboard extends Elyon_core_controller {
		function __construct() {
			parent::__construct();
			
		}

		public function load_page() {
			$js= array('owl/owl.carousel.min', 'draft');
			$this->theme->set('_js', $js);
			$this->theme->create('/index');
		}
		
		public function addDraft() {
			$this->getModel('post', 'includes/mods/');
			Dashboardm::addDraft();
		}
		
		public function draft() {
			echo "Hi";
		}
	}
?>