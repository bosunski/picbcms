<?php
	class Linksm extends Elyon_Model {
		function __construct() {
			parent::__construct();
		}

    public function getPicRows($data) {
      if(!is_array($data) || empty($data)) {
        return '<h1>No Images Uploaded Yet.</h1>';
      }
      $pic_row = '';
      foreach ($data as $key => $value) {
        $pic_model = $this->theme->get_theme_model('each_gallery_image');
        list($a, $value) = explode(ABSPATH, $value);
        $type = pathinfo(basename($value), PATHINFO_EXTENSION);
        $title = basename(str_replace('.'.$type, '', $value));
        //list($c, $d) = explode('___', $title);
        $name = $title;
        $description = $title;
        $pic_model = str_replace('[@name]', $name, $pic_model);
        $pic_model = str_replace('[@image]', get_option('home').'/'.$value, $pic_model);
        $pic_model = str_replace('[@description]', $description, $pic_model);
        $pic_row  .= $pic_model;
      }
      return $pic_row;
    }

		public function get_about_data() {
			$page = get_option('about_page');
			if($page !== '') {
				$cm = new Pagem;
				$data = $cm->getPage($page, 'post_content', 'post_name');
				if(is_array($data)) {
					return reverse_simple_clean($data['post_content']);
				} else {return '<h1>Your About page is not set. If you are an admin, you can login to do this.</h1>';}
			} else {
				return '<h1>Your About page is not set.</h1>';
			}
		}

		//Recives comment data and add to the database
    public function addData($type, $data) {
			$p = ($type !== 'counsel') ? ' if need be.' : ' very soon.';
      $error = array();
      if(empty($data)) {
        $error[] = 'All the fields are empty, please input something.';
      } else {
        if(clean($data['name']) == '') {
          $error[] = 'Please fill the name field, its required.';
        } elseif(!preg_match('/[A-Za-z]$/', clean($data['name']))) {
          $error[] = 'The name can only contain letters and spaces.';
        } elseif(strlen(clean($data['name'])) > 50) {
          $error[] = 'Your name cannot be more than 50 characters';
        }

        if(clean($data['email']) == '') {
          $error[] = 'Please fill the email field, its required.';
        } elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
          $error[] = 'The email you entered is not valid';
        } elseif(strlen(clean($data['email'])) > 100) {
          $error[] = 'Your email cannot be more than 100 characters';
        }

        if(clean($data['message']) == '') {
          $error[] = 'Please type in your message, its required.';
        }

        if(empty($error)) {
          $ip = $_SERVER['REMOTE_ADDR'];
          $comment = $this->shareCon()->quote(clean($data['message']));
          $sqll = 'SELECT * FROM '.PREFIX.'posts WHERE post_type="'.$type.'" AND post_title="'.$data['email'].'" AND post_name="'.$data['name'].'" AND post_content='.$comment.' ORDER BY post_date DESC LIMIT 1';
          $res = $this->shareCon()->get_single_result($sqll, array());
          if(!empty($res) && $res != false) {
            $error[] = 'Your message has been added already.';
            return $error;
          }
          $sql = 'INSERT INTO ' . PREFIX . 'posts (post_type, post_title, post_name, post_content, post_date)
                  VALUES("'.$type.'", "'.clean($data['email']).'", "'.clean($data['name']).'", '.$comment.', NOW())';
          $res = $this->shareCon()->prepare($sql, array());
          if($res) {
            return $this->getBlockquotedMsg('green', 'Your message has been sent successfuly, we\'ll get back to you'.$p);
          } else {
            $error[] = 'Messaging System is down please contact the Admin Quickly.';
          }
        }
      }
			$a = $this->getBlockquotedMsg('green', 'Your message has been sent successfuly, we\'ll get back to you'. $p);
      return (empty($error)) ? $a : $error;
    }

		public function get_workers() {
			$workers = ' ';
			$sql = 'SELECT * FROM '.PREFIX.'posts WHERE post_type=?';
			$res = $this->shareCon()->get_result($sql, array('worker'));
			if(!$res) {
				$workers .= '<h1>No worker has been added yet. If you are an admin, you can login to do this.</h1>';
			} else {
				foreach ($res as $key => $value) {
					$worker_model = $this->theme->get_theme_model('each_worker');
					$worker_model = str_replace('[@name]', $value['post_title'], $worker_model);
					$worker_model = str_replace('[@office]', $value['post_content'], $worker_model);
					$worker_model = str_replace('[@mobile]', $value['post_excerpt'], $worker_model);
					$worker_model = str_replace('[@email]', $value['post_name'], $worker_model);
					$worker_model = str_replace('[@image]', get_option('home').'/el-contents/uploads/workers/'.$value['f_image'], $worker_model);
					$worker_model = str_replace('[@address]', $value['post_tag'], $worker_model);
					$workers .= $worker_model;
				}
			}
			return $workers;
		}
}
