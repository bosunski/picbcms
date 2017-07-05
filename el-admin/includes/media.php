<?php
	class Media extends Elyon_core_controller 	{
		function __construct() {
			parent::__construct();
		}

		public function newupload() {
			$this->theme->create('add_media');
		}
		public function getHome() {
			_e(get_option('home'));
		}

		private function processMediaView($feature, $file_path) {
			$form_url = ($feature == 'gallery') ? get_option('home').'/el-admin/media' : get_option('home').'/el-admin/media/slides';
			if(isset($_GET['id'])) {
				$res = $this->deletePics($file_path, array('images' => array($_GET['id'])));
				exit;
			}
			$msg = ' ';
			if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES)) {
				$res = $this->saveMedia($file_path);
				if(is_array($res) && !empty($res)) {
					$txt = '';
					foreach ($res as $key => $value) {
						$txt .= $value . '<br/>';
					}
					$msg = getBlockquotedMsg('red', $txt);
				} else {
					$txt = 'Upload successful.';
					$msg = getBlockquotedMsg('green', $txt);
				}
			}
			if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_FILES)) {
				$res = $this->deletePics($file_path, $_POST);
				if(is_array($res) && !empty($res)) {
					$txt = '';
					foreach ($res as $key => $value) {
						$txt .= $value . '<br/>';
					}
					$msg = getBlockquotedMsg('red', $txt);
				} else {
					$txt = 'Delete Successful.';
					$msg = getBlockquotedMsg('green', $txt);
				}
			}
			$props['form_url'] = $form_url;
			$props['msg'] = $msg;
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
			$this->theme->set_prop($props);
			$this->theme->setJs('blueimp/jquery.blueimp-gallery.min');
			$this->theme->setJs('icheck/icheck.min');
			$this->theme->create('gallery');
		}
		public function defView() {
			$this->processMediaView('gallery', ABSPATH."el-contents/uploads/gallery/");
		}

		public function slides() {
			$this->processMediaView('slides', ABSPATH."el-contents/uploads/slides/");
		}
		public function deletePics($dir, $data = array()) {
			if(!empty($data)) {
				$error = array();
				foreach ($data['images'] as $key => $value) {
					if(!unlink(ABSPATH.$value)) {
						$error[] = 'Cannot delete ' . basename($value);
					}
				}
				return (empty($error)) ? true : $error;
			}
		}
		public function saveMedia($dir) {
			$error = array();
			foreach ($_FILES['gal_pic']['tmp_name'] as $key => $value) {
				if($_FILES['gal_pic']['name'][$key] != '') {
					$target_dir = $dir;
					$target_file = $target_dir . basename($_FILES['gal_pic']['name'][$key]);
					$uploadOk = 1;
					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					// Check if image file is a actual image or fake image
					if(isset($_POST["upl_gallery"])) {
							$check = getimagesize($_FILES['gal_pic']['tmp_name'][$key]);
							if($check !== false) {
									//_x("File is an image - " . $check["mime"] . ".");
									$uploadOk = 1;
							} else {
									$error[] = "File ".basename($_FILES['gal_pic']['name'][$key])." is not an image.";
									$uploadOk = 0;
							}
					}
					// Check if file already exists
					if(file_exists($target_file)) {
							$error[] = "Sorry, file ".basename($_FILES['gal_pic']['name'][$key])." already exists.";
							$uploadOk = 0;
					}
					// Check file size
					if ($_FILES['gal_pic']['size'][$key] > 2000000) {
							$error[] = "Sorry, your file ".basename($_FILES['gal_pic']['name'][$key])." cannot be larger than 2MB.";
							$uploadOk = 0;
					}
					// Allow certain file formats
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
							$error[] = "Your file is a ".pathinfo(basename($_FILES['gal_pic']['name'][$key]), PATHINFO_EXTENSION). " file, only JPG, JPEG, PNG & GIF files are allowed.";
							$uploadOk = 0;
					}
					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
							$error[] = "Sorry, your file ".basename($_FILES['gal_pic']['name'][$key])." was not uploaded.";
					// if everything is ok, try to upload file
					} else {
							if(move_uploaded_file($_FILES['gal_pic']['tmp_name'][$key], $target_file)) {
									//return true;
							} else {
									$error[] = "Sorry, there was an error uploading your file.";
							}
					}
				}
			}
			return (!empty($error)) ? $error : true;
		}
	}
?>
