<?php
	class Media extends Elyon_core_controller 	{
		function __construct() {
			parent::__construct();
		}

		public function newupload() {
			$this->theme->create('add_media');
		}

		public function defView() {
			$this->theme->create('library');
		}
	}
?>