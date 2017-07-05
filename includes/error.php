<?php
	class Error extends Elyon_core_controller {

		function __construct()
		{
			parent::__construct();
		}

		function getErrorPage($errorText = '', $type = '') {
			switch($type) {
				case '404':
					$this->theme->title = 'Page not Found';
					$this->theme->create('404');
					break;
				case '500':
				case '403':
				default:
					$this->theme->set('title', 'Page not Found');
					$this->theme->set('errorInfo', $errorText);
					$this->theme->create('blank');
					exit;
					break;
			}
		}

		public function list_error($data) {
			$err = '<ul>';
				foreach ($data as $key => $value) {
					$err .= '<li>' . $value . '</li>';
				}
			$err .= '</ul>';

			$this->theme->errors = $err;
			$this->theme->title = 'Elyon &raquo Error';
			$this->theme->create('error');
			exit;
		}
	}
?>
