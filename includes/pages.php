<?php
	class Pages extends Elyon_core_controller {
		public $a;
		function __construct() {
			parent::__construct();
		}

		public function newpage() {
			$this->_js = array('summernote/summernote', 'newpost');
			$this->theme->set('_js', $this->_js);
			$this->theme->set('title', 'New Page &raquo; '.get_option('blogname'));
			$this->_getView('new_page');
		}

		public function defView() {
			$home = get_option('home');
			header('location: ' . $home . '/el-admin/post?filter=page');
		}

		private function _getView($view) {
			$this->theme->create($view);
		}

		public function deletePage() {
			_e('DEleted!');
		}

		private function _getDefView() {

		}
	}
?>
