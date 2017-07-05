<?php
	class Dashboardm extends Elyon_Model {
		function __construct() {
			parent::__construct();
		}

		public static function addDraft() {
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$dtitle = isset($_POST['dtitle']) ? $_POST['dtitle'] : '';
				$post_name = str_replace(' ', '-', $dtitle);
				$dbody = isset($_POST['dbody']) ? $_POST['dbody'] : '';
				$draftData = array(':post_name' => $post_name, ':post_title' => $dtitle, ':post_content' => $dbody, ':post_author' => Session::get_var('ID'), ':post_status' => 'draft');
				$d = new Postm($draftData);
			} else {

			}

		}
	}
?>
