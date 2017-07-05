<?php
	class ElAjax extends Elyon_core_controller {
		private $model;

		public static function respond($response) {
			_e($response);
		}

		public function updateTag() {
			$data = array();

			// Needs a registry of classes
			$this->getModel('post');
			$pm = new Postm;

			if($_SERVER['REQUEST_METHOD'] == 'POST') {

			} elseif($_SERVER['REQUEST_METHOD'] == 'GET') {

				//Getting the previous tags
				$ftags = $pm->getPostTag($_GET['id']);
				$ntags = explode_var(',', str_replace(' ', '', clean($_GET['post_tag'])));
				$ntags = remove_empty_values($ntags);
				$all_tags = ($ftags[0] != '') ? array_merge($ftags, $ntags) : $ntags;
				$all_tags = fix_duplicate($all_tags);
				$_GET['post_tag'] = implode_var(',', $all_tags);
				$data = $pm->createParam('posts', $_GET);

				if(!empty($data)) {
					$post = $pm->getPost($_GET['id']);
					if($post) {
						if(Post::updatePost($_GET['id'], $data, $this->cm)) {
							$html_tag = Post::getPostTag($_GET['id'], $this->cm);
							self::respond($html_tag);
						}
					}
				}
			}
		}

		public function delTag() {
			$id = $_GET['id'];
			$this->getModel('post');
			$pm = new Postm;
			//Get all the tags into an array
			$ftags = $pm->getPostTag($_GET['id']);
			//Look for the Tag to be delete inside the Tags
			if(in_array($_GET['tag_val'], $ftags)) {
				foreach ($ftags as $key => $value) {
					if($value == $_GET['tag_val'])
						unset($ftags[$key]);
				}
				$post = $pm->getPost($_GET['id']);
				if($post) {
					$_GET['post_tag'] = implode(',', $ftags);
					//
					$data = $pm->createParam('posts', $_GET);
					if(Post::updatePost($id, $data, $this->cm)) {
						self::respond('done');
					}
				}
			} else {
				header('location: HTTP 404 Not Found');
			}
			//Delete if there and save the rest and return to update
			//If not there ----------
		}
	}
?>
